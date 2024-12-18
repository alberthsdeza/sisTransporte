<?php
require('../Libreria_tcpdf/TCPDF/tcpdf.php');
require_once("../config/conexion.php");
require "../PHPQR/phpqrcode/qrlib.php";

class PDF extends TCPDF
{
    function AddCustomLine($x1, $y1, $x2, $y2)
    {
        $this->SetLineWidth(0.5);
        $this->Line($x1, $y1, $x2, $y2);
    }

    function Header()
    {
        // Agregar fondo de color
        $this->SetFillColor(197, 234, 252); // Rojo (R, G, B)
        $this->Rect(0, 0, $this->GetPageWidth(), $this->GetPageHeight(), 'F');

        //Realizando los valores para el rectangulo personalizado
        $x =27;
        $y = 65;
        $w = 94;
        $h = 117;
        $radius = 4;

        $this->SetLineWidth(1);

        $colorFondo = array(255, 255, 0);

        // Dibuja el rectángulo redondeado
        $this->RoundedRect($x, $y, $w, $h, $radius, '1111', 'DF', array(0, 0, 0), $colorFondo);

        $this->Image('../Libreria_tcpdf/logo_mototaxi.png', 3, 4, 142, 60);
        $this->Image('../Libreria_tcpdf/seguridad.png', 30, 185, 90, 16);

        //Linea superior
        $this->SetLineWidth(0.5);
        $this->Rect(3, 4, $this->GetPageWidth() - 6, 0, 'D');

        //Linea derecha
        $this->SetLineWidth(0.5);
        $this->Rect($this->GetPageWidth() - 3, 3.7, 0, $this->GetPageHeight() - 8.5, 'D');

        //Linea izquierda
        $this->SetLineWidth(0.5);
        $this->Rect($this->GetPageWidth() - 145, 3.7, 0, $this->GetPageHeight() - 8.5, 'D');

        //Linea inferior
        $this->SetLineWidth(0.5);
        $this->Rect(3, 205, $this->GetPageWidth() - 6, 0, 'D');

    }

    function Footer()
    {

        // Centro del Footer
        // $this->SetFont('helvetica', 'B', 13);
        // $this->SetTextColor(233, 31, 38);
        // $this->Text(6, 135, 'TU SEGURIDAD ES NUESTRA PRIORIDAD');

    }

    function ContenidoCentral($razonSocial, $placa)
    {
        $this->SetTextColor(44,49,141); // Rojo
        $this->SetFont('helvetica', 'B', 13);
    
        // Define el contenido HTML
        $textoCentral = "
        <p style='text-align: center;'><b>$razonSocial</b></p>";
    
        // Define el ancho y alto de la celda
        $anchoCelda = 83;
        $altoCelda = 6;
    
        // Calcula la posición X para centrar la celda en la página
        $posX = 34;
    
        // Establece la posición Y (puedes ajustarla según tus necesidades)
        $posY = 155;
    
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
        $pdf = new PDF('P', 'mm', 'A5');
        $pdf->setPrintHeader(true);
        $pdf->SetMargins(2, 4, 2);

        foreach ($data as $item) {
            $id = isset($item['id']) ? $item['id'] : null;
            $razonSocial = isset($item['razonsocial']) ? $item['razonsocial'] : null;
            $placa = isset($item['placa']) ? $item['placa'] : null;

            if ($id !== null && $razonSocial !== null && $placa !== null) {
                $pdf->AddPage();

                $pdf->ContenidoCentral($razonSocial,$placa);
                $pdf->SetTextColor(255, 0, 0);
                $pdf->SetFont('helvetica', 'B', 26);
                $pdf->Text(56, 169, $placa);
                $datosQR = "http://www.munichiclayo.gob.pe/sisTransporte/validar.php?placa=" . $placa;
                $imagenBase64 = generarQR($datosQR, 'H', 8);
                $imgdata = base64_decode($imagenBase64);
                $pdf->Image('@' . $imgdata, 37, 69, 75, 85);
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