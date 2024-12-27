<?php
require_once '../config.php';

class Validar_vehiculo extends Connect
{
    public function validar_vehiculo($numplaca) {
        $sql = "SELECT placa, marca, clase, modelo, tp_servicio, fechaproceso, rucempresa, dnipropietario, propietario, modalida, fechaemision, fechacaducidad, razonsocial, nrotarjeta, abreviatura, estado_vencimiento
	        FROM public.validador_vehiculo
            WHERE svehi_estado='1' AND placa ILIKE :numplaca 
            ORDER BY fechaproceso DESC LIMIT 1;";

        $stmt = $this->prepare($sql);
        $stmt->bindParam(':numplaca', $numplaca);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}