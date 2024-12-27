<?php
require_once("../config/conexion.php");
require_once("../models/TipoResolucion.php");

$tiporesolucion = new TipoResolucion();

switch ($_GET["op"]) {

    case "llenar_tire":
        $datos = $tiporesolucion->llenar_tiporesolucion();
        $data = array();
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $sub_array = array();
                $sub_array[] = $row["resolucion_id"];
                $sub_array[] = $row["nombre_resolucion"];
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
        }else {
            // Si no hay datos disponibles, envía un mensaje al frontend
            echo json_encode(array("error" => "No hay tipo de servicio disponible"));
        }
    break;

}
