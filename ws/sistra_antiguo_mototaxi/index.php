<?php
// Incluye el archivo de configuración
require_once '../config.php';

try {
    // Crea una instancia de la conexión
    $db = new Connect();

    // Verifica el método de la solicitud
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $rucempresa = isset($_POST['rucempresa']) ? $_POST['rucempresa'] : null;
        $modalidad = isset($_POST['modalidad']) ? $_POST['modalidad'] : null;
        $estado = isset($_POST['estado']) ? $_POST['estado'] : null;
    } else {
        throw new Exception("Método HTTP no soportado", 405); 
    }

    if (is_null($rucempresa) || is_null($modalidad) || is_null($estado)) {
        throw new Exception("Faltan parámetros requeridos", 400);
    }

    // Prepara y ejecuta la consulta
    $sql = "SELECT * FROM public.vista_datos_mototaxista
            WHERE ruc = :rucempresa AND modalidad_id = :modalidad AND estado = :estado;";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':rucempresa', $rucempresa);
    $stmt->bindParam(':modalidad', $modalidad, PDO::PARAM_INT);
    $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
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
