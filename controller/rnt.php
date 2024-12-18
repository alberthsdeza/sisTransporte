<?php
require_once("../config/conexion.php");
require_once("../models/RNT.php");
require_once("../models/Bitacora.php");
$rnt = new RNT();
$bitacora = new Bitacora();

switch ($_GET["op"]) {
    case "verificar_codigo_infraccion":
        $datos = $rnt->get_verificar_infraccion($_POST["codigo_infraccion"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["id_"] = $row["_id"];
                $output["codigo"] = $row["codigo_infraccion"];
            }
            $output['mensaje'] = 'Operación exitosa';
            echo json_encode($output);
        } else {
            // Crear un mensaje de error en formato JSON
            $error = array('mensaje' => 'No existe');
            echo json_encode($error);
        }
        break;

    case "insertar_rnt":
        $rntd_monto_x_mes_venc = isset($_POST["rntd_monto_x_mes_venc"]) && $_POST["rntd_monto_x_mes_venc"] !== '' ? $_POST["rntd_monto_x_mes_venc"] : 0;
        $rntd_sancion = isset($_POST["rntd_sancion"]) ? preg_replace('/\s*%\s*/', '', preg_replace('/\s*,\s*/', ',', $_POST["rntd_sancion"])) : '';

        $datos = $rnt->insertar_rnt(
            $_POST["norma_decreto"],
            $_POST["calificacion_inf"],
            $_POST["codigo_inf"],
            $_POST["rnt_descripcion"],
            $_POST["usua"],
            $_POST["usua_nombre"],
            $_POST["rnt_observacion"],
            $rntd_sancion,
            $_POST["rntd_puntos"],
            $_POST["rntd_medida_preventiva"],
            $_POST["rntd_retencion_lic"],
            $_POST["rntd_descuento"],
            $_POST["rnt_dosaje_etilico"],
            $rntd_monto_x_mes_venc,
            $_POST["rntd_respo_solidaria"]
        );
        if ($datos) {
            $output['mensaje'] = 'Operación exitosa';
            echo json_encode($output);
        } else {
            $error = array('mensaje' => 'Operación fallida');
        }
        break;

    case "listar_rnt":
        $datos = $rnt->get_listar_rnt();
        $data = array();
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $sub_array = array();
                $calificacion = '';
                $color = '';
                $color_barra = '';

                switch ($row["calif"]) {
                    case '3':
                        $calificacion = "MUY GRAVES";
                        $color = "#dc3545";
                        $color_barra = 'danger';
                        break;
                    default:
                        $calificacion = "No encontrado";
                        $color = "#000000"; // Negro
                        $color_barra = 'warning';
                        break;
                }

                $estado = '';
                $color_est = '';
                $color_barra_est = '';

                switch ($row["estado"]) {
                    case 'A':
                        $estado = "ACTIVO";
                        $color_est = "#28a745";
                        $color_barra_est = 'success';
                        break;
                    case 'I':
                        $estado = "Inactivo";
                        $color_est = "#ffc107";
                        $color_barra_est = 'warning';
                        break;
                    case 'E':
                        $estado = "Anulado";
                        $color_est = "#dc3545";
                        $color_barra_est = 'danger';
                        break;
                    default:
                        $estado = "No encontrado";
                        $color_est = "#000000"; // Negro
                        $color_barra_est = 'warning';
                        break;
                }

                $sub_array[] = $row["_id"];
                $sub_array[] = $row["codigo"];
                $sub_array[] = $row["descripcion"];
                $sub_array[] = $row["observacion"];
                $calif_html = '<div style="background-color: ' . $color . '; display: flex; align-items: center; justify-content: center; height: 6px; text-align: center; color: white; border-radius: 11px; box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1); padding: 20px 5px; font-size:smaller;">' . $calificacion . ' </div>';
                $sub_array[] = $calif_html;
                $estado_html = '<div style="background-color: ' . $color_est . '; display: flex; align-items: center; justify-content: center; height: 6px; text-align: center; color: white; border-radius: 11px; box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1); padding: 15px 10px; font-size:smaller;">' . $estado . ' </div>';
                $sub_array[] = $estado_html;
                $dropdown_menu = '';
                if ($row["estado"] !== 'E') {
                    $dropdown_menu = '<div class="btn-group">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="Opciones_rnt_' . $row["_id"] . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="display: flex; align-items: center; justify-content: center; height: 6px; text-align: center; color: white; border-radius: 11px; box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1); padding: 15px 10px;">
                                        <i class="fa fa-cog"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="Opciones_rnt_' . $row["_id"] . '" style="padding: 10px;">';

                    // Botón siempre presente
                    $dropdown_menu .= '<div style="margin-bottom: 5px;"><button type="button" onClick="actualizar_rnt(\'' . $row["_id"] . '\', \'' . $row["codigo"] . '\');" class="btn btn-primary btn-icon btn-block" style="padding: 5px 0px 5px 0px;">Actualizar RNT <i class="fa fa-edit"></i></button></div>';

                    // Añadir botones condicionalmente basado en el estado
                    if ($row["estado"] !== 'A') {
                        $dropdown_menu .= '<div style="margin-bottom: 5px;"><button type="button" onClick="activar_rnt(\'' . $row["_id"] . '\', \'' . $row["codigo"] . '\');" class="btn btn-success btn-icon btn-block" style="padding: 5px 0px 5px 0px;">Activar RNT <i class="fa fa-check"></i></button></div>';
                    }

                    if ($row["estado"] !== 'I') {
                        $dropdown_menu .= '<div style="margin-bottom: 5px;"><button type="button" onClick="inactivo_rnt(\'' . $row["_id"] . '\', \'' . $row["codigo"] . '\');" class="btn btn-warning btn-icon btn-block" style="padding: 5px 0px 5px 0px;">Inactivar RNT <i class="fa fa-times"></i></button></div>';
                    }

                    if ($row["estado"] !== 'E') {
                        $dropdown_menu .= '<div style="margin-bottom: 5px;"><button type="button" onClick="anulado(\'' . $row["_id"] . '\', \'' . $row["codigo"] . '\');" class="btn btn-danger btn-icon btn-block" style="padding: 5px 0px 5px 0px;">Anular RNT <i class="fa fa-ban"></i></button></div>';
                    }

                    // Cerrar el menú desplegable
                    $dropdown_menu .= '</div>
                                   <button class="btn btn-info" type="button" onClick="visualizar_rnt(\'' . $row["_id"] . '\', \'' . $row["codigo"] . '\');" style="display: flex; align-items: center; justify-content: center; height: 6px; text-align: center; color: white; border-radius: 11px; box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1); padding: 15px 10px; margin-left: 5px">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>';
                }

                $sub_array[] = $dropdown_menu;
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho" => 1,
                //Información para el datatables
                "iTotalRecords" => count($data),
                //enviamos el total registros al datatable
                "iTotalDisplayRecords" => count($data),
                //enviamos el total registros a visualizar
                "aaData" => $data
            );
            echo json_encode($results);
        } else {
            // Si no hay datos disponibles, envía un mensaje al frontend
            echo json_encode(array("error" => "No hay rnt disponible"));
        }
        break;

    case "obtener_rnt":
        $datos = $rnt->get_listar_rnt_completo($_POST["rntid"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["id_"] = $row["_id"];
                $output["codigo_norma"] = $row["codigo_norma"];
                $output["codigo_calif"] = $row["codigo_calif"];
                $output["descripcion"] = $row["descripcion"];
                $output["observacion"] = $row["observacion"];
                $output["id_de"] = $row["_iddetalle"];
                $output["sancion"] = $row["sancion_uit"];
                $output["puntos"] = $row["puntos"];
                $output["medida_prev"] = $row["medida_prev"];
                $output["retencion_lic"] = $row["retencion_lic"];
                $output["descuento"] = $row["descuento"];
                $output["dosaje_etilico"] = $row["dosaje_etilico"];
                $output["monto_mes_venc"] = $row["monto_mes_venc"];
                $output["responsable_solidaria"] = $row["responsable_solidaria"];
            }
            $output['mensaje'] = 'Operación exitosa';
            echo json_encode($output);
        } else {
            // Crear un mensaje de error en formato JSON
            $error = array('mensaje' => 'No existe');
            echo json_encode($error);
        }
        break;

    case "visualizar_rnt":
        $datos = $rnt->get_visualizar_rnt($_POST["ident_rnt"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["id_"] = $row["_id"];
                $output["norma"] = $row["norma"];
                $output["calif"] = $row["calif"];
                $output["codigo"] = $row["codigo"];
                $output["descripcion"] = $row["descripcion"];
                $output["observacion"] = $row["observacion"];
                $output["_iddetalle"] = $row["_iddetalle"];
                $output["sancion_uit"] = $row["sancion_uit"];
                $output["puntos"] = $row["puntos"];
                $output["medida_prev"] = $row["medida_prev"];
                $output["retencion_lic"] = $row["retencion_lic"];
                $output["descuento"] = $row["descuento"];
                $output["dosaje_etilico"] = $row["dosaje_etilico"];
                $output["monto_mes_venc"] = $row["monto_mes_venc"];
                $output["responsable_solidaria"] = $row["responsable_solidaria"];
            }
            $output['mensaje'] = 'Operación exitosa';
            echo json_encode($output);
        } else {
            // Crear un mensaje de error en formato JSON
            $error = array('mensaje' => 'No existe');
            echo json_encode($error);
        }
        break;

    case "desactivar_rnt":
        $motivo = "Motivo: " . $_POST["motivo"] . " (Responsable: " . $_POST["usua_nombre"] . "/" . $_POST["pers_id"] . ")";
        $datos = $rnt->update_rnt_desactivar(
            $_POST["identificador"],
            $motivo
        );
        if ($datos['status'] === 'success') {
            $output = array(
                'status' => 'success',
                'mensaje' => $datos['message'],
            );
        } else {
            $output = array(
                'status' => 'error',
                'mensaje' => $datos['message'],
                'code' => $datos['code'],
                'line' => $datos['line'],
                'error_info' => $datos['error_info'],
            );
        }

        echo json_encode($output);
        break;

    case "activar_rnt":
        $motivo = "Motivo: " . $_POST["motivo"] . " (Responsable: " . $_POST["usua_nombre"] . "/" . $_POST["pers_id"] . ")";
        $datos = $rnt->update_rnt_activar(
            $_POST["identificador"],
            $motivo
        );
        if ($datos['status'] === 'success') {
            $output = array(
                'status' => 'success',
                'mensaje' => $datos['message'],
            );
        } else {
            $output = array(
                'status' => 'error',
                'mensaje' => $datos['message'],
                'code' => $datos['code'],
                'line' => $datos['line'],
                'error_info' => $datos['error_info'],
            );
        }

        echo json_encode($output);
        break;

    case "anular_rnt":
        $motivo = "Motivo: " . $_POST["motivo"] . " (Responsable: " . $_POST["usua_nombre"] . "/" . $_POST["pers_id"] . ")";
        $datos = $rnt->update_rnt_anular(
            $_POST["identificador"],
            $motivo
        );
        if ($datos['status'] === 'success') {
            $output = array(
                'status' => 'success',
                'mensaje' => $datos['message'],
            );
        } else {
            $output = array(
                'status' => 'error',
                'mensaje' => $datos['message'],
                'code' => $datos['code'],
                'line' => $datos['line'],
                'error_info' => $datos['error_info'],
            );
        }

        echo json_encode($output);
        break;

    case "actualizar_rnt":
        $rntd_monto_x_mes_venc = isset($_POST["rntd_monto_x_mes_venc"]) && $_POST["rntd_monto_x_mes_venc"] !== '' ? $_POST["rntd_monto_x_mes_venc"] : 0;
        $rntd_sancion = isset($_POST["rntd_sancion"]) ? preg_replace('/\s*%\s*/', '', preg_replace('/\s*,\s*/', ',', $_POST["rntd_sancion"])) : '';
        $motivo = "Motivo: " . $_POST["motivo"] . " (Responsable: " . $_POST["usua_nombre"] . ")";

        $datos = $rnt->update_rnt_rntd(
            $_POST["_id"],
            $_POST["_iddetalle"],
            $_POST["rnt_descripcion"],
            $_POST["rnt_observacion"],
            $rntd_sancion,
            $_POST["rntd_puntos"],
            $_POST["rntd_medida_preventiva"],
            $_POST["rntd_retencion_lic"],
            $_POST["rntd_descuento"],
            $_POST["rnt_dosaje_etilico"],
            $rntd_monto_x_mes_venc,
            $_POST["rntd_respo_solidaria"],
            $motivo
        );

        if ($datos['status'] === 'success') {
            $output = array(
                'status' => 'success',
                'mensaje' => $datos['message'],
            );
        } else {
            $output = array(
                'status' => 'error',
                'mensaje' => $datos['message'],
                'code' => $datos['code'],
                'line' => $datos['line'],
                'error_info' => $datos['error_info'],
            );
        }

        echo json_encode($output);
        break;

    case "listar_codigo_infraccion":
        $datos = $rnt->get_listar_codigoinfraccion();
        $data = array();
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $sub_array = array();
                $sub_array[] = $row["rnt"];
                $sub_array[] = $row["codigo_infraccion"];
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho" => 1,
                //Información para el datatables
                "iTotalRecords" => count($data),
                //enviamos el total registros al datatable
                "iTotalDisplayRecords" => count($data),
                //enviamos el total registros a visualizar
                "aaData" => $data
            );
            echo json_encode($results);
        } else {
            // Si no hay datos disponibles, envía un mensaje al frontend
            echo json_encode(array("error" => "No hay norma disponible"));
        }
        break;
}
