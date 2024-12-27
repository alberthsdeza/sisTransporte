<?php
class CalificacionInfraccion extends Conectar
{
    public function get_califinfraccion()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM sc_transporte.fn_listarcalifinfraccion()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

}