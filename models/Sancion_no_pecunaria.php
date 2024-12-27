<?php
class Sancion_no_pecunaria extends Conectar
{
    public function get_sancion_no_pecunaria()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM sc_transporte.fn_sancion_no_pecunaria()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    
}