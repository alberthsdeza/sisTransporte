<?php
require_once("../config/conexion.php");
require_once("../models/SituacionEmpresa.php");

$situacion_empresa = new SituacionEmpresa();

switch ($_GET["op"]) {

    case "verificar_expediente":
        $datos = $situacion_empresa->verificar_expediente_empresa(
            $_POST["expediente"]
        );
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["id_emtr"] = $row["id_emtr"];
                $output["expediente"] = $row["expediente"];
                $output["tipo_resolucion"] = $row["tipo_resolucion"];
                $output["resolucion"] = $row["resolucion"];
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

    case "insertar_situacion_empresa":
        $datos = $situacion_empresa->insertar_expediente_empresa(
            $_POST["usuario"],
            $_POST["empresa_transporte"],
            $_POST["expediente"],
            $_POST["tipo_resolucion"],
            $_POST["resolucion"],
            $_POST["observacion"],
        );
        if($datos){
            $output['mensaje'] = 'Operación exitosa';
            echo json_encode($output);
        }else{
            $error = array('mensaje' => 'Operación fallida');
        }
    break;

    case "listar_expedientes_x_empresa":
        $datos = $situacion_empresa->visualizar_expedientes_emtr(
            $_POST["empresa_id"],
            $_POST["empresa_estado"],
        );
        $data = array();
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $sub_array = array();
                $sub_array[] = $row["_id"];
                $sub_array[] = $row["expediente"];
                $sub_array[] = $row["tipo_res"];
                $sub_array[] = $row["resolucion"];
                $sub_array[] = $row["estado"];
                $sub_array[] = '<div class="btn-group">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="Opciones_siem" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-ellipsis-h"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="Opciones_siem" style="padding: 10px;">
                                        <div style="margin-bottom: 5px;"><button type="button" onClick="actualiza_rep(\'' . $row["_id"] . '\');" class="btn btn-warning btn-icon btn-block" style="padding: 5px 0px 5px 0px;">a <i class="fa fa-edit"></i></button></div>
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
        }else {
             
            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => 0,
                "iTotalDisplayRecords" => 0,
                "aaData" => array()
            );
        }
        echo json_encode($results);
    break;

}
