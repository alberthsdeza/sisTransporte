<?php
class TipoServicio extends Conectar
{

    public function llenar_tiposervicio() {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM sc_transporte.fn_llenartiposervicio();";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }


}