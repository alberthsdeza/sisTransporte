<?php
require '\var\www\html\sisTransporte\vendor\autoload.php';

use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\DomCrawler\Crawler;

// Establece el tipo de contenido como JSON
header('Content-Type: application/json');

// Verifica si el parámetro 'nropap' y 'placa' están presentes en la solicitud GET
if (!isset($_GET['nropap']) || empty($_GET['nropap']) || !isset($_GET['placa']) || empty($_GET['placa'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Número de papeleta y placa son requeridos.'
    ]);
    exit;
}

// Obtiene los parámetros y valida su longitud
$nropap = $_GET['nropap'];
$placa = $_GET['placa'];
if (!preg_match('/^[A-Za-z0-9]{1,12}$/', $nropap) || !preg_match('/^[A-Za-z0-9]{1,9}$/', $placa)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Número de papeleta (máximo 11 caracteres) y placa (máximo 9 caracteres)'
    ]);
    exit;
}

function buscarPapeletaYPlaca($nropap, $placa) {
    $client = new HttpBrowser(HttpClient::create());

    // Realiza una solicitud POST con los parámetros
    $client->request('POST', 'https://virtualsatch.satch.gob.pe/pagospapeletasenlinea/papeleta/transito', [
        'nropap' => $nropap,
        'placa' => $placa
    ]);

    // Obtiene el contenido de la respuesta
    $html = $client->getResponse()->getContent();

    $crawler = new Crawler($html);

    // Array para almacenar los datos
    $data = [];

    // Filtra la primera tabla y extrae los datos de las columnas relevantes
    $tables = $crawler->filter('table');
    if ($tables->count() > 0) {
        // Primera tabla
        $firstTable = $tables->eq(0);
        $firstTable->filter('tbody tr')->each(function (Crawler $row) use (&$data) {
            $cells = $row->filter('td');
            if ($cells->count() >= 10) { // Asegúrate de que hay al menos 10 celdas
                $data[] = [
                    'tipo' => $cells->eq(8)->text(),
                    'nro_papeleta' => $cells->eq(9)->text(),
                    'fecimp' => $cells->eq(10)->text(),
                    'infrac' => $cells->eq(11)->text(),
                    'placa' => $cells->eq(12)->text(),
                    'deuda_total' => $cells->eq(13)->text(),
                    'desc' => $cells->eq(14)->text(),
                    'deuda_pagar' => $cells->eq(15)->text(),
                    'det' => []  // Inicializa el campo DET como un array vacío
                ];
            }
        });

        // Segunda tabla
        $secondTable = $tables->eq(1);
        $secondTable->filter('tbody tr')->each(function (Crawler $row, $index) use (&$data) {
            $cells = $row->filter('th');
            if ($cells->count() > 0) { // Asegúrate de que hay al menos una celda
                $detail = [
                    'tributo' => $cells->eq(0)->text(),
                    'infractor' => $cells->eq(1)->text(),
                    'propietario' => $cells->eq(2)->text(),
                    'rs' => $cells->eq(3)->text(),
                    'rir' => $cells->eq(4)->text(),
                    'exp_rs' => $cells->eq(5)->text(),
                    'exp_rir' => $cells->eq(6)->text(),
                    'insoluto' => $cells->eq(7)->text(),
                    'gastos' => $cells->eq(8)->text(),
                    'total_deuda' => $cells->eq(9)->text(),
                    'desc' => $cells->eq(10)->text(),
                    'total_pagar' => $cells->eq(11)->text()
                ];

                // Añade los detalles a la primera tabla
                $lastIndex = count($data) - 1; // Obtiene el índice de la última entrada en $data
                if ($lastIndex >= 0) {
                    $data[$lastIndex]['det'][] = $detail;
                }
            }
        });
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'No se encontró la tabla en el contenido HTML.'
        ]);
        exit;
    }

    return $data;
}



// Llama a la función con los parámetros proporcionados y obtiene los datos
$data = buscarPapeletaYPlaca($nropap, $placa);

// Verifica si se encontraron datos y ajusta la respuesta
if (empty($data)) {
    echo json_encode([
        'status' => 'success',
        'message' => 'No se encontraron datos para el número de papeleta y placa proporcionados.',
        'data' => []
    ]);
} else {
    echo json_encode([
        'status' => 'success',
        'message' => 'Datos encontrados exitosamente.',
        'data' => $data
    ], JSON_PRETTY_PRINT);
}
