<?php
require_once ("../config/conexion.php");
require_once ("../models/CalificacionInfraccion.php");

$calificacion_infraccion = new CalificacionInfraccion();

switch ($_GET["op"]) {
    case "listar_califinfraccion":
        $datos = $calificacion_infraccion->get_califinfraccion();
        $data = array();
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $sub_array = array();
                $sub_array[] = $row["cain_id"];
                $sub_array[] = $row["cain_nombre"];
                $sub_array[] = $row["cain_estado"];
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($data),
                "iTotalDisplayRecords" => count($data),
                "aaData" => $data
            );
            echo json_encode($results);
        }else {
            echo json_encode(array("error" => "No hay tipo de calificacion infraccion disponible"));
        }
    break;
    
}