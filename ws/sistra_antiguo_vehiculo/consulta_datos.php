<?php
// Incluye el archivo de configuración
require_once '../config.php';

try {
    // Crea una instancia de la conexión
    $db = new Connect();

    // Verifica el método de la solicitud
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $numplaca = isset($_POST['numplaca']) ? $_POST['numplaca'] : null;
    } else {
        throw new Exception("Método HTTP no soportado", 405);
    }

    if (is_null($numplaca)) {
        throw new Exception("Faltan parámetros requeridos", 400);
    }

    // Prepara y ejecuta la consulta
    $sql = "SELECT placa, nummotor, num_asientos, anno_fabricacion, num_serie, combustible, carroceria, ejes, cilindros, ruedas, peso_seco, peso_bruto, longitud, altura, ancho, carga_util, num_pasajeros, idmarca_veh, marca, idclase_veh, clase, nro_tarjeta, fecha_propiedad, reparticion, idexpediente, placa_anterior, id_color, color, id_modelo, modelo, v_estado, csituacion, rucempresa, sv_tipmovimiento, tipomovimiento, dnipropietario, propietario, fechaproceso, fechainicio, fechatermino, nresolucion, nexpediente, observacion, svehi_estado, modalidad, modalida, fechaemision, fechacaducidad, razonsocial, tiposervicios, tp_servicio, nroregistro, nrotarjeta, categoria, codsit, abreviatura
	        FROM public.vista_vehiculo
            WHERE svehi_estado='1'  AND  placa ILIKE :numplaca ORDER BY fechaproceso DESC LIMIT 1;";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':numplaca', $numplaca);
    $stmt->execute();

    // Obtén los resultados
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($results, JSON_UNESCAPED_UNICODE);
} catch (PDOException $e) {
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Error de base de datos: ' . $e->getMessage()]);
} catch (Exception $e) {
    http_response_code($e->getCode() ?: 400);
    header('Content-Type: application/json');
    echo json_encode(['error' => $e->getMessage()]);
}
