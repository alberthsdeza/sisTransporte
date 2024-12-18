<?php
class Vehiculo_adicional extends Conectar
{
    public function get_verificar_soat_tecn(
        $placa
    )
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM sc_transporte.fn_visualizasoatrevtec_id(:placa)";
        $sql = $conectar->prepare($sql);
        $sql->bindParam(":placa", $placa, PDO::PARAM_STR);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function get_verificar_contador_tuc(
        $placa
    )
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM sc_transporte.fn_visualizarcontador_impresion(:placa)";
        $sql = $conectar->prepare($sql);
        $sql->bindParam(":placa", $placa, PDO::PARAM_STR);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function insertar_soatrevtec_vehiculo(
        $placa,
        $soat_fechvenc,
        $revtec_fechavenc,
        $usua_id,
    )
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL sc_transporte.pa_insertar_soatrevtect_vehiculo(:placa,:soat,:revtec,:usua)";
        $sql = $conectar->prepare($sql);
        $sql->bindParam(":placa", $placa, PDO::PARAM_STR);
        $sql->bindParam(":soat", $soat_fechvenc, PDO::PARAM_STR);
        $sql->bindParam(":revtec", $revtec_fechavenc, PDO::PARAM_STR);
        $sql->bindParam(":usua", $usua_id, PDO::PARAM_INT);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function modificar_soatrevtec_vehiculo(
        $placa,
        $soat_fechvenc,
        $revtec_fechavenc,
        $usua_id,
    )
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL sc_transporte.pa_updated_soatrevtect_vehiculo(:placa,:soat,:revtec,:usua)";
        $sql = $conectar->prepare($sql);
        $sql->bindParam(":placa", $placa, PDO::PARAM_STR);
        $sql->bindParam(":soat", $soat_fechvenc, PDO::PARAM_STR);
        $sql->bindParam(":revtec", $revtec_fechavenc, PDO::PARAM_STR);
        $sql->bindParam(":usua", $usua_id, PDO::PARAM_INT);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function contador_impresion_tuc(
        $placa,
        $tuc,
        $usua_id,
        $duplicado
    ) {
        $duplicado_actualizado = (int)($duplicado === "" ? 0 : $duplicado) + 1;
        $conectar = parent::conexion();
        parent::set_names();
        
        $sql = "CALL sc_transporte.pa_contador_tucimpresion(:placa, :tuc, :duplicado, :usua)";
        $sql = $conectar->prepare($sql);
        
        $sql->bindParam(":placa", $placa, PDO::PARAM_STR);
        $sql->bindParam(":tuc", $tuc, PDO::PARAM_STR);
        $sql->bindParam(":duplicado", $duplicado_actualizado, PDO::PARAM_INT);
        $sql->bindParam(":usua", $usua_id, PDO::PARAM_INT);
        
        $sql->execute();
        
        return $resultado = $sql->fetchAll();
    }


}