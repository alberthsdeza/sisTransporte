<?php
require_once("../config/conexion.php");
require_once("../models/Empresa_transporte.php");

$empresa_transporte = new Empresa_transporte();

switch ($_GET["op"]) {

    case "listar_empresas_transporte":
        $datos = $empresa_transporte->get_empresa_transporte(
        );
        $data = array();
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $sub_array = array();
                $sub_array[] = $row["emtr_id"];
                $sub_array[] = $row["empr_ruc"];
                $sub_array[] = $row["empr_razon_social"];
                $sub_array[] = $row["empr_direccion"];
                $sub_array[] = $row["telef"];
                $sub_array[] = $row["tise_servicio"];
                $sub_array[] = $row["representante"];
                $sub_array[] = '<div class="btn-group">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="Opciones_emtr" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-ellipsis-h"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="Opciones_emtr" style="padding: 10px;">
                                        <div style="margin-bottom: 5px;"><button type="button" onClick="actualizar_rep(\'' . $row["emtr_id"] . '\');" class="btn btn-warning btn-icon btn-block" style="padding: 5px 0px 5px 0px;">Actualizar representante <i class="fa fa-edit"></i></button></div>
                                        <div style="margin-bottom: 5px;"><button type="button" onClick="actualizar_tise(\'' . $row["emtr_id"] . '\');" class="btn btn-warning btn-icon btn-block" style="padding: 5px 0px 5px 0px;">Actualizar tipo de servicio <i class="fa fa-edit"></i></button></div>
                                        <hr style="background-color: #0a0a0a;">
                                        <div style="margin-bottom: 5px;"><button type="button" onClick="ingresar_expediente(\'' . $row["emtr_id"] . '\', \'' . $row["empr_ruc"] . '\', \'' . $row["empr_razon_social"] . '\' );" class="btn btn-primary btn-icon btn-block" style="padding: 5px 0px 5px 0px;">Nuevo expediente <i class="fa fa-plus"></i></button></div>
                                        <div style="margin-bottom: 5px;"><button type="button" onClick="ver_expedientes(\'' . $row["emtr_id"] . '\', \'' . $row["empr_ruc"] . '\', \'' . $row["empr_razon_social"] . '\' );" class="btn btn-primary btn-icon btn-block" style="padding: 5px 0px 5px 0px;">Ver expedientes <i class="fa fa-eye"></i></button></div>
                                        <hr style="background-color: #0a0a0a;">
                                        <div style="margin-bottom: 5px;"><button type="button" onClick="Eliminar_registro(\'' . $row["emtr_id"] . '\');" class="btn btn-danger btn-icon btn-block" style="padding: 5px 0px 5px 0px;">Eliminar registro <i class="fa fa-trash"></i></button></div>
                                        <div style="margin-bottom: 5px;"><button type="button" onClick="dar_baja(\'' . $row["emtr_id"] . '\');" class="btn btn-danger btn-icon btn-block" style="padding: 5px 0px 5px 0px;">Dar de baja <i class="fa fa-close"></i></button></div>
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