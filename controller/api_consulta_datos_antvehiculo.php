<?php
// Establece la zona horaria
date_default_timezone_set("America/Lima");

try {
    // Verifica si el método de la solicitud es POST
    if (isset($_POST['numplaca'])) {
        $numplaca = $_POST['numplaca'];

        // Configura la URL (sin parámetros)
        $ws_url = "https://www.munichiclayo.gob.pe/sisTransporte/ws/sistra_antiguo_vehiculo/consulta_datos.php";

        // Configura cURL para hacer la solicitud a la API externa
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ws_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);

        // Define los datos POST que se enviarán en la solicitud
        $post_fields = http_build_query([
            'numplaca' => $numplaca
        ]);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);

        // Ejecuta la solicitud cURL
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            http_response_code(500);
            echo json_encode([
                'timestamp' => date("Y-m-d H:i:s"),
                'status' => 500,
                'success' => false,
                'message' => 'Error al conectarse al servicio: ' . $error_msg,
                'data' => []
            ]);
        } else {
            curl_close($ch);

            $data = json_decode($response, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                http_response_code(200);
                echo json_encode([
                    'timestamp' => date("Y-m-d H:i:s"),
                    'status' => 200,
                    'success' => true,
                    'message' => 'Consulta realizada correctamente',
                    'data' => $data
                ], JSON_UNESCAPED_UNICODE);
            } else {
                http_response_code(500);
                echo json_encode([
                    'timestamp' => date("Y-m-d H:i:s"),
                    'status' => 500,
                    'success' => false,
                    'message' => 'Error al procesar la respuesta del servicio',
                    'data' => []
                ]);
            }
        }
    } else {
        http_response_code(400);
        echo json_encode([
            'timestamp' => date("Y-m-d H:i:s"),
            'status' => 400,
            'success' => false,
            'message' => 'Faltan parámetros requeridos: rucempresa',
            'data' => []
        ]);
    }
} catch (Exception $e) {
    // Manejo de cualquier otro error
    http_response_code(500);
    echo json_encode([
        'timestamp' => date("Y-m-d H:i:s"),
        'status' => 500,
        'success' => false,
        'message' => 'Error inesperado: ' . $e->getMessage(),
        'data' => []
    ]);
}
