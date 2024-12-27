<?php
date_default_timezone_set("America/Lima");

// Configurar encabezado para JSON
header("Content-Type: application/json");

// Función para realizar la consulta a un servicio externo
function consultarServicio($tipo, $valor) {
    $endpoints = [
        'dni' => "https://www.munichiclayo.gob.pe/Pide/Reniec/",
        'ce'  => "https://www.munichiclayo.gob.pe/Pide/Migraciones/",
        'ruc' => "https://www.munichiclayo.gob.pe/Pide/Sunat/"
    ];

    if (!isset($endpoints[$tipo])) {
        return ['error' => 'Tipo de documento no válido'];
    }

    $url = $endpoints[$tipo] . $valor;
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        curl_close($ch);
        return ['error' => 'Error al conectarse al servicio'];
    }

    curl_close($ch);

    // Decodificar la respuesta si es JSON válido
    $decodedResponse = json_decode($response, true);
    return $decodedResponse ?? ['error' => 'Respuesta inválida del servicio'];
}

// Validar y procesar la solicitud
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = $_POST['tipo'] ?? null;
    $doc = $_POST['doc'] ?? null;

    if (!$tipo || !$doc) {
        echo json_encode(['error' => 'Parámetros incompletos']);
        exit;
    }

    // Llama a la función y devuelve la respuesta
    echo json_encode(consultarServicio($tipo, $doc));
} else {
    echo json_encode(['error' => 'Método no permitido']);
}
