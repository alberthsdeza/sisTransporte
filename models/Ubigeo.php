<?php
class Ubigeo extends Conectar
{

    public function llenar_provincia(
        $depa_id,
    ) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM public.fn_buscarprovinciaporiddepartamento(?);";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $depa_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function llenar_distrito(
        $prov_id,
    ) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM public.fn_buscardistritoporidprovincia(?);";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $prov_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

}