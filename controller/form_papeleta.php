<?php
require_once("../config/conexion.php");
require_once("../models/FormPapeleta.php");
require_once("../models/RNT.php");
require_once("../models/Bitacora.php");
$formpapeleta = new FormPapeleta();
$bitacora = new Bitacora();

function validar_campos($data)
{
    if (isset($data["txtvisto"]) && empty($data["txtvisto"])) {
        return "El campo 'Visto' es obligatorio.";
    }

    if (isset($data["numpapeleta"])) {
        if (empty($data["numpapeleta"])) {
            return "El campo 'Número de Papeleta' es obligatorio.";
        }
        if (!preg_match("/^\d{11}$/", $data["numpapeleta"])) {
            return "El campo 'Número de Papeleta' debe contener exactamente 11 números.";
        }
    }

    if (isset($data["numplaca"])) {
        if (empty($data["numplaca"])) {
            return "El campo 'Placa' es obligatorio.";
        }
        // Verificar que tenga exactamente 6 caracteres alfanuméricos con al menos una letra
        if (!preg_match('/^(?=.*[A-Za-z])[A-Za-z0-9]{6}$/', $data["numplaca"])) {
            return "La placa debe tener exactamente 6 caracteres alfanuméricos (al menos una letra).";
        }
    }

    if (isset($data["fecha_inicio"])) {
        if (empty($data["fecha_inicio"])) {
            return "El campo 'Fecha de inicio' es obligatorio.";
        }
        if (!preg_match('/^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/\d{4} ([01]?[0-9]|2[0-3]):[0-5][0-9]$/', $data["fecha_inicio"])) {
            return "El formato de la fecha y hora es incorrecto. Debe ser DD/MM/YYYY HH:MM.";
        }
        $fecha_partes = DateTime::createFromFormat('d/m/Y H:i', $data["fecha_inicio"]);
        if (!$fecha_partes) {
            return "La fecha y hora proporcionada no es válida.";
        }
    }

    // Validación de 'Tipo de documento Infractor'
    if (isset($data["select_tipodoc_infractor"])) {
        if (empty($data["select_tipodoc_infractor"])) {
            return "El campo 'Tipo de documento' es obligatorio.";
        }
        $errorTipoDocInfrac = validarTipoDocumento($data["select_tipodoc_infractor"], "infractor");
        if ($errorTipoDocInfrac) {
            return $errorTipoDocInfrac;
        }

        if (isset($data["infdni"])) {
            $infnumero = $data["infdni"];
            $tipoDocumentoInfrac = $data["select_tipodoc_infractor"];

            if ($tipoDocumentoInfrac == 1) {  // DNI
                if (!preg_match("/^\d{8}$/", $infnumero)) {
                    return "El número de DNI del infractor debe tener exactamente 8 dígitos.";
                }
            } elseif ($tipoDocumentoInfrac == 2) {  // CE
                if (!preg_match("/^\d{7,12}$/", $infnumero)) {
                    return "El número de CE del infractor debe tener entre 7 y 12 dígitos.";
                }
            }
        }
    }

    if (isset($data["infapellidopat"]) && empty($data["infapellidopat"])) {
        return "El campo 'Inf. Apel. Pat' es obligatorio.";
    }

    if (isset($data["infapellidomat"]) && empty($data["infapellidomat"])) {
        return "El campo 'Inf. Apel. Mat' es obligatorio.";
    }

    if (isset($data["infnombre"]) && empty($data["infnombre"])) {
        return "El campo 'Inf. Nombre' es obligatorio.";
    }

    if (isset($data["infdomicilio"]) && empty($data["infdomicilio"])) {
        return "El campo 'Inf. Domicilio 1°' es obligatorio.";
    }

    if (isset($data["infdomicilio_papeleta"]) && empty($data["infdomicilio_papeleta"])) {
        return "El campo 'Inf. Domicilio 2°' es obligatorio.";
    }

    // Validación de 'Tipo de documento Solidario'
    if (isset($data["select_tipodoc_solidario"])) {
        if (empty($data["select_tipodoc_solidario"])) {
            return "El campo 'Tipo de documento Solidario' es obligatorio.";
        }
        $errorTipoDocSolidario = validarTipoDocumento($data["select_tipodoc_solidario"], "solidario");
        if ($errorTipoDocSolidario) {
            return $errorTipoDocSolidario;
        }

        if (isset($data["soldni"])) {
            $solnumero = $data["soldni"];
            $tipoDocumentoSolidario = $data["select_tipodoc_solidario"];

            if ($tipoDocumentoSolidario == 1) {  // DNI
                if (!preg_match("/^\d{8}$/", $solnumero)) {
                    return "El número de DNI del solidario debe tener exactamente 8 dígitos.";
                }
            } elseif ($tipoDocumentoSolidario == 2) {  // CE
                if (!preg_match("/^\d{7,9}$/", $solnumero)) {
                    return "El número de CE del solidario debe tener entre 7 y 9 dígitos.";
                }
            } elseif ($tipoDocumentoSolidario == 3) {  // RUC
                if (!preg_match("/^\d{11}$/", $solnumero)) {
                    return "El número de RUC del solidario debe tener exactamente 11 dígitos.";
                }
            }
        }

        if ($tipoDocumentoSolidario != 3) { // Si el tipo no es RUC (3)
            if (isset($data["solapellidopat"]) && empty($data["solapellidopat"])) {
                return "El campo 'Sol. Apel. Pat' es obligatorio.";
            }

            if (isset($data["solapellidomat"]) && empty($data["solapellidomat"])) {
                return "El campo 'Sol. Apel. Mat' es obligatorio.";
            }

            if (isset($data["solnombre"]) && empty($data["solnombre"])) {
                return "El campo 'Sol. Nombre' es obligatorio.";
            }
        } else { // Si es RUC, no validamos 'solapellidopat', solo 'razon_social'
            if (isset($data["razon_social"]) && empty($data["razon_social"])) {
                return "El campo 'Razón Social' es obligatorio para RUC.";
            }
        }
    }

    if (isset($data["soldomicilio"]) && empty($data["soldomicilio"])) {
        return "El campo 'Sol. Domicilio 1°' es obligatorio.";
    }

    if (isset($data["soldomicilio_segundo"]) && empty($data["soldomicilio_segundo"])) {
        return "El campo 'Sol. Domicilio 2°' es obligatorio.";
    }

    if (isset($data["select_tipoinf"]) && empty($data["select_tipoinf"])) {
        return "El campo 'Infracción' es obligatorio.";
    }

    // Validar Sanción
    if (isset($data["sancion_uit"])) {
        if (empty($data["sancion_uit"])) {
            return "El campo 'Sanción' es obligatorio.";
        }

        $rnt = new RNT();
        $datos = $rnt->get_visualizar_rnt($data["select_tipoinf"]);
        $sancion_uit = str_replace('%', '', $data["sancion_uit"]); // Remover el símbolo %

        if (is_array($datos) && count($datos) > 0) {
            foreach ($datos as $row) {
                $sancion_db = $row["sancion_uit"];
                if (is_string($sancion_db)) {
                    $sancion_db = str_replace(['{', '}'], '', $sancion_db); // Remueve llaves
                    $sancion_db = explode(',', $sancion_db); // Convierte a array
                }

                // Verificar si $sancion_uit está dentro de $sancion_db
                if (!in_array($sancion_uit, $sancion_db)) {
                    return "La sanción de la infracción ha sido alterada porque no coincide: " .
                        $sancion_uit . " no está en " . implode(", ", $sancion_db);
                }
            }
        } else {
            return "Infracción no encontrada en el servidor.";
        }
    }

    if (isset($data["evaluacion"])) {
        $valor = strtoupper($data["evaluacion"]); // Convertir a mayúsculas para comparar
        if (!in_array($valor, ["S", "N", "C"])) {
            return "El campo 'Evaluación' solo puede contener los valores 'S', 'N' o 'C'.";
        }
    }

    if (isset($data["n_vez"])) {
        if (filter_var($data["n_vez"], FILTER_VALIDATE_INT) === false || $data["n_vez"] < 0) {
            return "El campo 'n_vez' debe ser un número entero.";
        }
    }

    if (isset($data["monto"])) {
        $monto = filter_var($data["monto"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        if (!filter_var($monto, FILTER_VALIDATE_FLOAT) || $monto <= 0) {
            return "El campo 'Monto' debe ser un número positivo con o sin decimales.";
        }
    }

    if (isset($data["pe_idx"])) {
        $pers = filter_var($data["pe_idx"], FILTER_SANITIZE_NUMBER_INT);

        if (!filter_var($pers, FILTER_VALIDATE_INT) || $pers <= 0) {
            return "El campo 'pe_idx' debe ser un número entero positivo.";
        }
    }

    return null;
}

function validarTipoDocumento($tipoDocumento, $tipo)
{
    $tiposValidosInfractor = [1, 3]; // 1 = DNI, 3 = CE
    $tiposValidosSolidario = [1, 3, 5]; // 1 = DNI, 3 = CE, 5 = RUC

    if ($tipo === "infractor" && !in_array($tipoDocumento, $tiposValidosInfractor)) {
        return "Tipo de documento de infractor no válido.";
    }

    if ($tipo === "solidario" && !in_array($tipoDocumento, $tiposValidosSolidario)) {
        return "Tipo de documento de solidario no válido.";
    }

    return null;
}

switch ($_GET["op"]) {
    case "insertar_papeleta":
        $error = validar_campos($_POST);
        if ($error) {
            echo json_encode(['status' => 'error', 'mensaje' => $error]);
            exit();
        }
        $visto = filter_var($_POST["txtvisto"], FILTER_SANITIZE_SPECIAL_CHARS);
        $numpapeleta = filter_var($_POST["numpapeleta"], FILTER_SANITIZE_SPECIAL_CHARS);
        $placa = filter_var($_POST["numplaca"], FILTER_SANITIZE_SPECIAL_CHARS);
        $fecha_impuesta = filter_var($_POST["fecha_incio"], FILTER_SANITIZE_SPECIAL_CHARS);
        $select_tipodoc_infrac = filter_var($_POST["select_tipodoc_infractor"], FILTER_SANITIZE_NUMBER_INT);
        $infdni = filter_var($_POST["infdni"], FILTER_SANITIZE_NUMBER_INT);
        $infapellidopat = filter_var($_POST["infapellidopat"], FILTER_SANITIZE_SPECIAL_CHARS);
        $infapellidomat = filter_var($_POST["infapellidomat"], FILTER_SANITIZE_SPECIAL_CHARS);
        $infnombre = filter_var($_POST["infnombre"], FILTER_SANITIZE_SPECIAL_CHARS);
        $infdomicilio = filter_var($_POST["infdomicilio"], FILTER_SANITIZE_SPECIAL_CHARS);
        $infdomicilio_papeleta = filter_var($_POST["infdomicilio_papeleta"], FILTER_SANITIZE_SPECIAL_CHARS);
        $select_tipodoc_solidario = filter_var($_POST["select_tipodoc_solidario"], FILTER_SANITIZE_NUMBER_INT);
        $soldni = filter_var($_POST["soldni"], FILTER_SANITIZE_NUMBER_INT);
        $solapellidopat = isset($_POST["solapellidopat"]) && !empty($_POST["solapellidopat"]) ? filter_var($_POST["solapellidopat"], FILTER_SANITIZE_SPECIAL_CHARS) : "-";
        $solapellidomat = isset($_POST["solapellidomat"]) && !empty($_POST["solapellidomat"]) ? filter_var($_POST["solapellidomat"], FILTER_SANITIZE_SPECIAL_CHARS) : "-";
        $solnombre = isset($_POST["solnombre"]) && !empty($_POST["solnombre"]) ? filter_var($_POST["solnombre"], FILTER_SANITIZE_SPECIAL_CHARS) : "-";
        $razon_social = isset($_POST["razon_social"]) && !empty($_POST["razon_social"]) ? filter_var($_POST["razon_social"], FILTER_SANITIZE_SPECIAL_CHARS) : "-";
        $soldomicilio = filter_var($_POST["soldomicilio"], FILTER_SANITIZE_SPECIAL_CHARS);
        $soldomicilio_segundo = filter_var($_POST["soldomicilio_segundo"], FILTER_SANITIZE_SPECIAL_CHARS);
        $select_tipoinf = filter_var($_POST["select_tipoinf"], FILTER_SANITIZE_NUMBER_INT);
        $sancion_uit = filter_var($_POST["sancion_uit"], FILTER_SANITIZE_NUMBER_INT);
        $evaluacion = filter_var($_POST["evaluacion"], FILTER_SANITIZE_SPECIAL_CHARS);
        $n_vez = filter_var($_POST["n_vez"], FILTER_SANITIZE_NUMBER_INT);
        $monto = filter_var($_POST["monto"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $pers = filter_var($_POST["pe_idx"], FILTER_SANITIZE_NUMBER_INT);

        // Llamar al método del modelo para insertar
        $datos = $formpapeleta->insertar_papeleta(
            $visto,
            $numpapeleta,
            $placa,
            $fecha_impuesta,
            $select_tipodoc_infrac,
            $infdni,
            $infapellidopat,
            $infapellidomat,
            $infnombre,
            $infdomicilio,
            $infdomicilio_papeleta,
            $select_tipodoc_solidario,
            $soldni,
            $solapellidopat,
            $solapellidomat,
            $solnombre,
            $razon_social,
            $soldomicilio,
            $soldomicilio_segundo,
            $select_tipoinf,
            $sancion_uit,
            $evaluacion,
            $n_vez,
            $monto,
            $pers
        );

        echo json_encode($datos);

        break;

    case "listar_papeleta":
        $visualicion_total = [9]; // visualizar todas las papeletas por rol
        if (!in_array($_POST["pe_rolx"], $visualicion_total)) {
            return "Tipo de documento de infractor no válido.";
        }
        $datos = $formpapeleta->get_listar_papeletas();
        $data = array();
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $sub_array = array();
                $estado = '';
                $color_est = '';
                $color_barra_est = '';

                switch ($row["estado"]) {
                    case 'R':
                        $estado = "REGISTRADO";
                        $color_est = "#28a745";
                        $color_barra_est = 'success';
                        break;
                    case 'E':
                        $estado = "ANULADO";
                        $color_est = "#E74C3C";
                        $color_barra_est = 'success';
                        break;
                    default:
                        $estado = "No encontrado";
                        $color_est = "#000000"; // Negro
                        $color_barra_est = 'warning';
                        break;
                }

                $sub_array[] = $row["_id"];
                $sub_array[] = $row["fech_intervencion"];
                $sub_array[] = $row["papeleta"];
                $sub_array[] = $row["placa"];
                $sub_array[] = $row["infractor"];
                $sub_array[] = $row["doc_infractor"] . ' - ' . $row["doc_num_infractor"];
                $sub_array[] = $row["codigo_infraccion"];
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
                    $dropdown_menu .= '<div style="margin-bottom: 5px;"><button type="button" onClick="actualizar_rnt(\'' . $row["_id"] . '\');" class="btn btn-primary btn-icon btn-block" style="padding: 5px 0px 5px 0px;">Editar papeleta <i class="fa fa-edit"></i></button></div>';

                    if ($row["estado"] !== 'E') {
                        $dropdown_menu .= '<div style="margin-bottom: 5px;"><button type="button" onClick="anulado(\'' . $row["_id"] . '\');" class="btn btn-danger btn-icon btn-block" style="padding: 5px 0px 5px 0px;">Anular papeleta <i class="fa fa-ban"></i></button></div>';
                    }

                    // Cerrar el menú desplegable
                    $dropdown_menu .= '</div>
                                   <button class="btn btn-info" type="button" onClick="visualizar_rnt(\'' . $row["_id"] . '\');" style="display: flex; align-items: center; justify-content: center; height: 6px; text-align: center; color: white; border-radius: 11px; box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1); padding: 15px 10px; margin-left: 5px">
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

    case "anular_papeleta":
        $motivo = "Motivo: " . $_POST["motivo"] . " (Responsable: " . $_POST["usua_nombre"] . "/" . $_POST["pers_id"] . ")";
        $datos = $formpapeleta->update_papeleta_anular(
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
}
