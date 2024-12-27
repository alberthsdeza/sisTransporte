<?php
require_once("../config/conexion.php");
require_once("../models/Ubigeo.php");

$ubigeo = new Ubigeo();

switch ($_GET["op"]) {

    case "llenar_provincias":
        $datos = $ubigeo->llenar_provincia(
            $_POST["depa_id"],
        );
        $data = array();
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $sub_array = array();
                $sub_array[] = $row["provincia_id"];
                $sub_array[] = $row["provincia_descripcion"];
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
            echo json_encode(array("error" => "No hay provincias disponibles"));
        }
    break;

    case "llenar_distrito":
        $datos = $ubigeo->llenar_distrito(
            $_POST["prov_id"],
        );
        $data = array();
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $sub_array = array();
                $sub_array[] = $row["distrito_id"];
                $sub_array[] = $row["distrito_descripcion"];
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
            echo json_encode(array("error" => "No hay provincias disponibles"));
        }
    break;

}
