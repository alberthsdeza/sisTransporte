<?php
require('../Libreria_tcpdf/TCPDF/tcpdf.php');
require_once("../config/conexion.php");
require "../PHPQR/phpqrcode/qrlib.php";

class PDF extends TCPDF
{
    function AddDesignFrame($posX, $posY, $imgY, $razonSocial, $placa)
    {
        // Fondo de color para el cuadro (opcional)
        $this->SetFillColor(197, 234, 252);
        $this->Rect($posX, $posY, 102, 146, 'F'); // Tamaño aproximado A6 (102 x 146 mm)

        $this->Image('../Libreria_tcpdf/logo_mototaxi.png', $posX, $posY, 102, 35); // Ajusta la posición y tamaño según sea necesario

        // Imagen seguridad.png en la parte inferior del cuadro, ajustada para reducir el espacio inferior
        $this->Image('../Libreria_tcpdf/seguridad.png', $posX + 6, $imgY, 90, 16); // Ajusta la posición para que se alinee mejor con el borde inferior

        $this->SetLineWidth(1);
        $radius = 5; // Radio del borde redondeado
        $this->RoundedRect($posX + 10, $posY + 36, 80, 90, $radius, '1111', 'DF', array(0, 0, 0), array(255, 255, 0)); // Dibuja el rectángulo redondeado amarillo

        // Bordes de cada cuadro
        $this->SetLineWidth(1);
        $this->Rect($posX, $posY, 102, 146, 'D');

        // Contenido central (razón social) debajo del rectángulo amarillo
        $this->ContenidoCentral($posX + 10, $posY + 103, $razonSocial); // Colocamos el contenido debajo del rectángulo amarillo

        // Código QR dentro del rectángulo amarillo
        $this->SetFont('helvetica', 'B', 24);
        $this->SetTextColor(255, 0, 0); // Texto negro para la placa
        $this->Text($posX + 32, $posY + 112, $placa); // Coloca la placa dentro del rectángulo
    }

    function ContenidoCentral($posX, $posY, $razonSocial)
    {
        $this->SetTextColor(44, 49, 141); // Azul
        $this->SetFont('helvetica', 'B', 11);
        
        // Define el contenido HTML
        $textoCentral = "<p style='text-align: center;'><b>$razonSocial</b></p>";

        // Define el ancho y alto de la celda
        $anchoCelda = 81;
        $altoCelda = 6;

        // Escribe el HTML en una celda con un control más fino
        $this->writeHTMLCell($anchoCelda, $altoCelda, $posX, $posY, $textoCentral, 0, 0, 0, true, 'C', true);
    }
}

function generarQR($datos, $correccion, $tamanio = 4)
{
    try {
        // Configura la ruta para almacenar temporalmente el código QR
        $tempDir = "../PHPQR/temp";

        // Si el directorio no existe, créalo
        if (!file_exists($tempDir)) {
            mkdir($tempDir);
        }

        // Nombre del archivo QR temporal
        $archivoQR = $tempDir . uniqid() . ".png";

        // Genera el código QR con parámetros personalizados y guarda la imagen
        QRcode::png($datos, $archivoQR, $correccion, $tamanio, 2);

        // Lee la imagen como una cadena binaria
        $imagenBinaria = file_get_contents($archivoQR);
        // Convierte la imagen a base64
        $imagenBase64 = base64_encode($imagenBinaria);
        // Elimina el archivo temporal
        unlink($archivoQR);

        return $imagenBase64;
    } catch (Exception $e) {
        // Manejar errores al generar el código QR
        return "Error al generar el código QR: " . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el JSON enviado en la solicitud
    $jsonData = isset($_POST['id']) ? $_POST['id'] : '[]';

    // Decodificar el JSON
    $data = json_decode($jsonData, true);

    if ($data && is_array($data)) {
        // Crear PDF
        $pdf = new PDF('P', 'mm', 'A4');
        $pdf->setPrintHeader(true);
        $pdf->SetMargins(0, 0, 0); // Sin márgenes
        $pdf->SetAutoPageBreak(false); // Desactivar salto automático de página

        // Posiciones de los cuadros en la hoja A4
        $posiciones = [
            ['x' => 1, 'y' => 1, 'img_seguridad_y' => 127],
            ['x' => 106, 'y' => 1, 'img_seguridad_y' => 127],
            ['x' => 1, 'y' => 150, 'img_seguridad_y' => 277],
            ['x' => 106, 'y' => 150, 'img_seguridad_y' => 277]
        ];

        foreach ($data as $index => $item) {
            $id = isset($item['id']) ? $item['id'] : null;
            $razonSocial = isset($item['razonsocial']) ? $item['razonsocial'] : null;
            $placa = isset($item['placa']) ? $item['placa'] : null;

            if ($id !== null && $razonSocial !== null && $placa !== null) {
                // Agregar una nueva página cada 4 cuadros
                if ($index % 4 === 0) {
                    $pdf->AddPage();
                }

                // Determinar la posición dentro de la página actual
                $posIndex = $index % 4;
                $posX = $posiciones[$posIndex]['x'];
                $posY = $posiciones[$posIndex]['y'];
                $imgY = $posiciones[$posIndex]['img_seguridad_y'];

                // Añadir el cuadro en la posición correspondiente
                $pdf->AddDesignFrame($posX, $posY, $imgY, $razonSocial, $placa);

                // Generar y colocar el código QR
                $datosQR = "http://www.munichiclayo.gob.pe/sisTransporte/validar.php?placa=" . $placa;
                $imagenBase64 = generarQR($datosQR, 'H', 8);
                $imgdata = base64_decode($imagenBase64);
                $pdf->Image('@' . $imgdata, $posX + 19, $posY + 40, 62, 62); // Coloca el código QR dentro del rectángulo amarillo
            } else {
                echo "ID o razón social no proporcionados.";
            }
        }

        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="qr.pdf"');
        $pdf->Output();
    } else {
        echo "Datos no válidos.";
    }
} else {
    echo "Solicitud inválida.";
}

