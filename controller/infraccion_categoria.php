<?php
require_once ("../config/conexion.php");
require_once ("../models/Infraccion_categoria.php");

$infraccion_categoria = new Infraccion_categoria();

switch ($_GET["op"]) {

    case "listar_infraccion_categoria":
        $datos = $infraccion_categoria->get_infraccion_categoria(
        );
        $data = array();
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $sub_array = array();
                $sub_array[] = $row["id_"];
                $sub_array[] = $row["codigo"];
                $sub_array[] = $row["categoria"];
                $sub_array[] = ($row["estado"] === "A") ? "Activo" : "Inactivo";
                $sub_array[] = '<div class="btn-group">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="Opciones_emtr" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-ellipsis-h"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="Opciones_emtr" style="padding: 10px;">
                                        <div style="margin-bottom: 5px;"><button type="button" onClick="actualizar_cat(\'' . $row["id_"] . '\', \'' . $row["codigo"] . '\', \'' . $row["categoria"] . '\' );" class="btn btn-warning btn-icon btn-block" style="padding: 5px 0px 5px 0px;">Actualizar categoría <i class="fa fa-edit"></i></button></div>
                                        <div style="margin-bottom: 5px;"><button type="button" onClick="activar_cat(\'' . $row["id_"] . '\');" class="btn btn-primary btn-icon btn-block" style="padding: 5px 0px 5px 0px;">Activar categoría <i class="fa fa-check"></i></button></div>
                                        <div style="margin-bottom: 5px;"><button type="button" onClick="dar_baja(\'' . $row["id_"] . '\');" class="btn btn-danger btn-icon btn-block" style="padding: 5px 0px 5px 0px;">Dar de baja <i class="fa fa-close"></i></button></div>
                                    </div>
                                </div>';
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
        } else {

            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => 0,
                "iTotalDisplayRecords" => 0,
                "aaData" => array()
            );
        }
        echo json_encode($results);
        break;

    case "verificar_cod_categoria":
        $datos = $infraccion_categoria->verificar_categoria_infraccion(
            $_POST["cat_codigo"]
        );
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["id_"] = $row["id_"];
                $output["codigo"] = $row["codigo"];
                $output["categoria"] = $row["categoria"];
                $output["estado"] = $row["estado"];
            }
            $output['mensaje'] = 'Operación exitosa';
            echo json_encode($output);
        } else {
            // Crear un mensaje de error en formato JSON
            $error = array('mensaje' => 'No existe');
            echo json_encode($error);
        }
        break;

    case "insertar_categoria_infraccion":
        $datos = $infraccion_categoria->insertar_categoria_infraccion(
            $_POST["cat_codigo"],
            $_POST["cat_categoria"],
        );
        if ($datos) {
            $output['mensaje'] = 'Operación exitosa';
            echo json_encode($output);
        } else {
            $error = array('mensaje' => 'Operación fallida');
        }
        break;

    case "verificar_categoria_id":
        $datos = $infraccion_categoria->verificar_categoria_infraccion_id(
            $_POST["cat_id"]
        );
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["id_"] = $row["id_"];
                $output["codigo"] = $row["codigo"];
                $output["categoria"] = $row["categoria"];
                $output["estado"] = $row["estado"];
            }
            $output['mensaje'] = 'Operación exitosa';
            echo json_encode($output);
        } else {
            // Crear un mensaje de error en formato JSON
            $error = array('mensaje' => 'No existe');
            echo json_encode($error);
        }
        break;

    case "actualizar_categoria_infraccion":
        $datos = $infraccion_categoria->update_categoria_infraccion(
            $_POST["cat_id"],
            $_POST["cat_codigo"],
            $_POST["cat_categoria"],
        );
        if ($datos) {
            $output['mensaje'] = 'Operación exitosa';
            echo json_encode($output);
        } else {
            $error = array('mensaje' => 'Operación fallida');
        }
        break;

    case "activar_categoria_infraccion":
        $datos = $infraccion_categoria->update_categoria_infraccion_activar($_POST["cat_id"]);

        if ($datos['status'] === 'success') {
            $output = array(
                'status' => 'success',
                'mensaje' => $datos['message'],
            );
        } else {
            $output = array(
                'status' => 'error',
                'mensaje' => $datos['message'],
            );
        }

        echo json_encode($output);
        break;

    case "desactivar_categoria_infraccion":
        $datos = $infraccion_categoria->update_categoria_infraccion_desactivar(
            $_POST["cat_id"],
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
            );
        }

        echo json_encode($output);
        break;

}