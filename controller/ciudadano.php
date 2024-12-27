<?php
require_once("../config/conexion.php");
require_once("../models/Ciudadano.php");

$ciudadano = new Ciudadano();

switch ($_GET["op"]) {

    case "verificar_representante":
        $datos = $ciudadano->verificar_representante(
            $_POST["tipodoc"],
            $_POST["numdoc"]
        );
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["rep_id"] = $row["ciud_id"];
                $output["numero_doc"] = $row["ciud_numero_documento"];
                $output["nombre_completo"] = $row["ciud_nombre"]." ". $row["ciud_primer_apellido"]." ".$row["ciud_segundo_apellido"];
            }
            $output['mensaje'] = 'Operación exitosa';
            echo json_encode($output);
        } else {
            // Crear un mensaje de error en formato JSON
            $error = array('mensaje' => 'No existe');
            echo json_encode($error);
        }
        break;

}
