<?php
class Empresa_transporte extends Conectar
{
    public function get_empresa_transporte()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM sc_transporte.fn_empresa_transporte()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

}