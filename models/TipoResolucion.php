<?php
class TipoResolucion extends Conectar
{

    public function llenar_tiporesolucion() {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM sc_transporte.fn_llenartiporesolucion();";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }


}