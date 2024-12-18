<?php
require_once ("../config/conexion.php");
require_once ("../models/Sancion_no_pecunaria.php");

$tipo_infraccion = new TipoInfraccion();

switch ($_GET["op"]) {

    case "listar_infraccion_tipo":
        $datos = $tipo_infraccion->get_infraccion_tipo(
        );
        $data = array();
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $sub_array = array();
                $sub_array[] = $row["id_"];
                $sub_array[] = $row["codigo"];
                $sub_array[] = $row["tipo"];
                $sub_array[] = ($row["estado"] === "A") ? "Activo" : "Inactivo";
                $sub_array[] = '<div class="btn-group">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="Opciones_emtr" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-ellipsis-h"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="Opciones_emtr" style="padding: 10px;">
                                        <div style="margin-bottom: 5px;"><button type="button" onClick="actualizar_tip(\'' . $row["id_"] . '\', \'' . $row["codigo"] . '\', \'' . $row["tipo"] . '\' );" class="btn btn-warning btn-icon btn-block" style="padding: 5px 0px 5px 0px;">Actualizar tipo <i class="fa fa-edit"></i></button></div>
                                        <div style="margin-bottom: 5px;"><button type="button" onClick="activar_tip(\'' . $row["id_"] . '\');" class="btn btn-primary btn-icon btn-block" style="padding: 5px 0px 5px 0px;">Activar tipo <i class="fa fa-check"></i></button></div>
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

}