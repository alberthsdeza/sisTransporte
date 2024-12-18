<?php
class SituacionEmpresa extends Conectar
{

    public function verificar_expediente_empresa(
        $expediente
    ) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM sc_transporte.fn_verificar_exp_empresa(:exp);";
        $sql = $conectar->prepare($sql);
        $sql->bindParam(":exp", $expediente, PDO::PARAM_STR);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function insertar_expediente_empresa(
        $usuario,
        $empresa_transporte,
        $expediente,
        $tipo_resolucion,
        $resolucion,
        $observacion
    ) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL sc_transporte.pa_insertar_siem(:usuario,:emtr,:exp,:tire,:re,:obse);";
        $sql = $conectar->prepare($sql);
        $sql->bindParam(":usuario", $usuario, PDO::PARAM_INT);
        $sql->bindParam(":emtr", $empresa_transporte, PDO::PARAM_STR);
        $sql->bindParam(":exp", $expediente, PDO::PARAM_STR);
        $sql->bindParam(":tire", $tipo_resolucion, PDO::PARAM_INT);
        $sql->bindParam(":re", $resolucion, PDO::PARAM_INT);
        $sql->bindParam(":obse", $observacion, PDO::PARAM_INT);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function visualizar_expedientes_emtr(
        $id_emtr,
        $estado
    ) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM sc_transporte.fn_visualizar_expedientes(:empresa,:estado);";
        $sql = $conectar->prepare($sql);
        $sql->bindParam(":empresa", $id_emtr, PDO::PARAM_STR);
        $sql->bindParam(":estado", $estado, PDO::PARAM_STR);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }



}