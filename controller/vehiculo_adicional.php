<?php
require_once("../config/conexion.php");
require_once("../models/Vehiculo_adicional.php");
require_once("../models/Bitacora.php");
$veh_adic = new Vehiculo_adicional();
$bitacora = new Bitacora();

switch ($_GET["op"]) {
    case "verificar_placa_vehiculo":
        $datos = $veh_adic->get_verificar_soat_tecn($_POST["numplaca"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["id_"] = $row["inve_id"];
                $output["placa"] = $row["inve_placa"];
                $output["soat"] = $row["inve_soat_fecha"];
                $output["reviciontec"] = $row["inve_revtecnica"];
                $output["responsable"] = $row["responsable"];
            }
            $output['mensaje'] = 'Operación exitosa';
            echo json_encode($output);
        } else {
            // Crear un mensaje de error en formato JSON
            $error = array('mensaje' => 'No existe');
            echo json_encode($error);
        }
        break;

    case "verificar_tuc_contador":
        $datos = $veh_adic->get_verificar_contador_tuc($_POST["numplaca"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["id_"] = $row["imtu_id"];
                $output["placa"] = $row["imtu_placa"];
                $output["tuc"] = $row["imtu_tuc"];
                $output["primeraimpresion"] = $row["imtu_primeraimpresion"];
                $output["duplicado"] = $row["imtu_duplicado"];
                $output["usuario"] = $row["imtu_usua"];
                $output["fecha_creacion"] = $row["imtu_created_at"];
                $output["fecha_modificacion"] = $row["imtu_updated_at"];
            }
            $output['mensaje'] = 'Operación exitosa';
            echo json_encode($output);
        } else {
            // Crear un mensaje de error en formato JSON
            $error = array('mensaje' => 'No existe');
            echo json_encode($error);
        }
        break;

    case "insertar_soatrevtec_vehiculo":
        $bita_id_min = $bitacora->get_max_id();

        $soat_fecha = !empty($_POST["soat_fecha"]) ? $_POST["soat_fecha"] : NULL;
        $fecha_revtec = !empty($_POST["fecha_revtec"]) ? $_POST["fecha_revtec"] : NULL;

        $datos = $veh_adic->insertar_soatrevtec_vehiculo(
            $_POST["placa"],
            $soat_fecha,
            $fecha_revtec,
            $_POST["usua"]
        );
        $bitacora->update_bitacora_varios($_POST["usua"], $bita_id_min);
        if ($datos) {
            $output['mensaje'] = 'Operación exitosa';
            
            echo json_encode($output);
        } else {
            $error = array('mensaje' => 'Operación fallida');
        }
        break;

    case "modificar_soatrevtec_vehiculo":
        $bita_id_min = $bitacora->get_max_id();

        $soat_fecha = !empty($_POST["soat_fecha"]) ? $_POST["soat_fecha"] : NULL;
        $fecha_revtec = !empty($_POST["fecha_revtec"]) ? $_POST["fecha_revtec"] : NULL;

        $datos = $veh_adic->modificar_soatrevtec_vehiculo(
            $_POST["placa"],
            $soat_fecha,
            $fecha_revtec,
            $_POST["usua"]
        );
        $bitacora->update_bitacora_varios($_POST["usua"], $bita_id_min);
        if ($datos) {
            $output['mensaje'] = 'Operación exitosa';
            
            echo json_encode($output);
        } else {
            $error = array('mensaje' => 'Operación fallida');
        }
        break;

    case "contador_tuc_impresion":
        $bita_id_min = $bitacora->get_max_id();
        $datos = $veh_adic->contador_impresion_tuc(
            $_POST["placa"],
            $_POST["tuc"],
            $_POST["usua_id"],
            $_POST["duplicado"]
        );
        $bitacora->update_bitacora_varios($_POST["usua_id"], $bita_id_min);
        if ($datos) {
            $output['mensaje'] = 'Operación exitosa';
            
            echo json_encode($output);
        } else {
            $error = array('mensaje' => 'Operación fallida');
        }
        break;

}
