<?php
require_once("../config/conexion.php");
require_once("../models/UIT.php");

$uit = new UIT();

switch ($_GET["op"]) {

    case "vista_uit":
        $datos = $uit->vista_uit();
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["_id"] = $row["_id"];
                $output["valor"] = $row["valor"];
            }
            $output['mensaje'] = 'Operación exitosa';
            echo json_encode($output);
        } else {
            $error = array('mensaje' => 'No existe');
            echo json_encode($error);
        }
        break;
}
