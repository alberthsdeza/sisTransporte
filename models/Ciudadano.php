<?php
class Ciudadano extends Conectar
{

    public function verificar_representante(
        $tipodoc,
        $numdoc
    ) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM public.fn_consultar_ciudadano(:tipo,:num);";
        $sql = $conectar->prepare($sql);
        $sql->bindParam(":tipo", $tipodoc, PDO::PARAM_INT);
        $sql->bindParam(":num", $numdoc, PDO::PARAM_STR);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }


}