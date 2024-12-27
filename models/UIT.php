<?php
class UIT extends Conectar
{
    public function vista_uit(
    ) {
        try {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT * FROM public.fn_vista_uit();";
            $sql = $conectar->prepare($sql);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        } catch (PDOException $e) {
            // Manejo de errores
            return array("mensaje" => "Error en la consulta: " . $e->getMessage());
        }
    }

}