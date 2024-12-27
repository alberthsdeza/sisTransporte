<?php
require '\var\www\html\sisTransporte\vendor\autoload.php';

use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\DomCrawler\Crawler;

// Establece el tipo de contenido como JSON
header('Content-Type: application/json');

// Verifica si el parámetro 'placa' está presente en la solicitud GET
if (!isset($_GET['placa']) || empty($_GET['placa'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Número de placa es requerido.'
    ]);
    exit;
}

// Obtiene el parámetro de placa y valida su longitud
$placa = $_GET['placa'];
if (!preg_match('/^[A-Za-z0-9]{1,9}$/', $placa)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Número de placa debe tener un máximo de 9 caracteres alfanuméricos.'
    ]);
    exit;
}

function buscarPlaca($placa) {
    $client = new HttpBrowser(HttpClient::create());

    // Realiza una solicitud POST con el número de placa
    $crawler = $client->request('POST', 'https://virtualsatch.satch.gob.pe/virtualsatch/record_infracciones/buscar_placa', [
        'search' => $placa
    ]);

    // Array para almacenar los datos
    $data = [];

    // Filtra la tabla y extrae los datos
    $crawler->filter('table')->each(function (Crawler $table) use (&$data) {
        $table->filter('tr')->each(function (Crawler $row) use (&$data) {
            $cells = $row->filter('td');

            if ($cells->count() > 0) {

                $data[] = [
                    'placa' => $cells->eq(0)->text(),
                    'nro_papeleta' => $cells->eq(1)->text(),
                    'fecha_imp' => $cells->eq(2)->text(), // Muestra la fecha depurada
                    'infractor' => $cells->eq(3)->text(),
                    'propietario' => $cells->eq(4)->text(),
                    'infraccion' => $cells->eq(5)->text(),
                    'estado' => $cells->eq(6)->text(),
                ];
            }
        });
    });

    return $data;
}

// Llama a la función con el número de placa proporcionado y obtiene los datos
$data = buscarPlaca($placa);

// Verifica si se encontraron datos y ajusta la respuesta
if (empty($data)) {
    echo json_encode([
        'status' => 'success',
        'message' => 'No se encontraron datos para la placa proporcionada.',
        'data' => []
    ]);
} else {
    echo json_encode([
        'status' => 'success',
        'message' => 'Datos encontrados exitosamente.',
        'data' => $data
    ], JSON_PRETTY_PRINT);
}
