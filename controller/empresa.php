<?php
require_once("../config/conexion.php");
require_once("../models/Empresa.php");

$empresa = new Empresa();

switch ($_GET["op"]) {

    case "verificar_empresa":
        $datos = $empresa->verificar_empresa(
            $_POST["empr_ruc"]
        );
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["empr_id"] = $row["empr_id"];
                $output["empr_ruc"] = $row["empr_ruc"];
                $output["empr_razon_social"] = $row["empr_razon_social"];
            }
            $output['mensaje'] = 'Operación exitosa';
            echo json_encode($output);
        } else {
            // Crear un mensaje de error en formato JSON
            $error = array('mensaje' => 'No existe');
            echo json_encode($error);
        }
    break;

    case "insertar_empresa":
        $datos = $empresa->insertar_emtr(
            $_POST["empr_ruc"],
            $_POST["empr_razon_social"],
            $_POST["ubigeo"],
            $_POST["empr_direccion"],
            $_POST["empr_categoria"],
            $_POST["sunat_estado"],
            $_POST["sunat_condicion"],
            $_POST["tipo_doc"],
            $_POST["num_doc"],
            $_POST["nombres"],
            $_POST["primer_ap"],
            $_POST["segundo_ap"],
            $_POST["celular"],
            $_POST["correo"],
            $_POST["direccion"],
            $_POST["foto"],
        );
        $emtr = $empresa->insertar_emtr1(
            $_POST["pe_idx"],
            $_POST["pe_nomx"],
            $_POST["empr_ruc"],
            $_POST["num_doc"],
            $_POST["tipo_servicio"],
        );
        if($datos && $emtr){
            $output['mensaje'] = 'Operación exitosa';
            echo json_encode($output);
        }else{
            $error = array('mensaje' => 'Operación fallida');
        }
    break;

    case "insertar_empresa1":
        $datos = $empresa->insertar_emtr(
            $_POST["empr_ruc"],
            $_POST["empr_razon_social"],
            $_POST["ubigeo"],
            $_POST["empr_direccion"],
            $_POST["empr_categoria"],
            $_POST["sunat_estado"],
            $_POST["sunat_condicion"],
            $_POST["tipo_doc"],
            $_POST["num_doc"],
            $_POST["nombres"],
            $_POST["primer_ap"],
            $_POST["segundo_ap"],
            $_POST["celular"],
            $_POST["correo"],
            $_POST["direccion"],
            $_POST["foto"],
        );
        $emtr = $empresa->insertar_emtr1(
            $_POST["pe_idx"],
            $_POST["pe_nomx"],
            $_POST["empr_ruc"],
            $_POST["num_doc"],
            $_POST["tipo_servicio"],
        );
        if($datos && $emtr){
            $output['mensaje'] = 'Operación exitosa';
            echo json_encode($output);
        }else{
            $error = array('mensaje' => 'Operación fallida');
        }
    break;

}
