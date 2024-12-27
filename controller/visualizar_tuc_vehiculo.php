<?php
require_once("../config/conexion.php");
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

    // Nueva función para manejar la transparencia de la imagen
    function ImageWithAlpha($file, $x, $y, $w, $h, $type = '', $alpha = 1)
    {
        // Establecer la transparencia
        $this->SetAlpha($alpha);

        // Insertar la imagen con la transparencia
        $this->Image($file, $x, $y, $w, $h, $type);

        // Restaurar la transparencia (opcional)
        $this->SetAlpha(1);
    }

    // Función para la parte frontal con transparencia
    function ParteFrontal($n_tarj,$placa,$tipserv,$propietario,$fechainicio, $fechatermino,$nroregistro,$clase, $marca, $aniofab)
    {
        // Link de la imagen
        $imageFile = '../Libreria_tcpdf/palacio_chiclayo.png';

        // Establecer los márgenes
        $left_margin = 0;
        $top_margin = 0;
        $right_margin = 0;
        $bottom_margin = 0;

        $this->SetMargins($left_margin, $top_margin, $right_margin);
        $this->SetAutoPageBreak(false, 0);

        // Añadir una nueva página
        $this->AddPage();

        // Rellenar el área completa con un fondo blanco para ocultar cualquier línea o borde
        $this->SetFillColor(255, 255, 255);
        $this->Rect(0, 0, 86, 55, 'F');  // Rellenar toda la página con blanco

        // Insertar la imagen dentro del área de los márgenes (parte frontal) con transparencia
        $this->ImageWithAlpha($imageFile, $left_margin, $top_margin, 86 - $left_margin - $right_margin, 55 - $top_margin - $bottom_margin, 'PNG', 0.3);

        //AGREGAR MULTICELL
        // primera fila
        $this->SetFont('helveticaB', '', 10);
        $this->SetTextColor(0, 0, 255);
        $this->SetXY(0, 1);
        $this->MultiCell(0, 4.5, 'MUNICIPALIDAD PROVINCIAL DE CHICLAYO', 1, 'C', 0, 1);
        $this->Image('../Libreria_tcpdf/logo_izquierda.PNG', 2, 6, 8, 8);

        // segunda fila
        $this->SetFont('helveticaB', '', 9);
        $this->SetTextColor(0, 0, 0);
        $this->MultiCell(0, 4, 'Gerencia de Desarrollo Vial y Transporte', 1, 'C', 0, 1);

        // tercera fila
        $this->SetFont('helveticaB', '', 9);
        $this->MultiCell(0, 4, 'TUC: '.$n_tarj, 1, 'C', 0, 1);

        // cuarta fila
        $this->SetFont('helveticaB', '', 9);
        $this->SetTextColor(0, 0, 0);
        $this->MultiCell(0, 5, 'SERVICIO PÚBLICO', 1, 'C', 0, 1);

        // quinta fila
        $this->SetFont('helveticaB', '', 8);
        $this->SetTextColor(0, 0, 0);
        $this->MultiCell(19, 7.5, 'Placa:', 1, 'L', 0, 0);
        $this->SetFont('helvetica', '', 8);
        $this->MultiCell(19, 7.5, $placa, 1, 'C', 0, 0);
        $this->SetFont('helveticaB', '', 8);
        $this->SetTextColor(0, 0, 0);
        $this->MultiCell(21, 7.5, 'Tipo Servicio: ', 1, 'L', 0, 0);
        $this->SetFont('helvetica', '', 7);
        $this->MultiCell(27, 7.5, $tipserv, 1, 'C', 0, 1);

        // sexta fila
        $this->SetFont('helveticaB', '', 8);
        $this->SetTextColor(0, 0, 0);
        $this->MultiCell(19, 11, 'Propietario:', 1, 'L', 0, 0);
        if (strlen($propietario) < 30) {
            $fontSize = 10;
            $altura = 8;
        } else {
            $fontSize = 8;
            $altura = 11;
        }
        $this->SetFont('helvetica', '', $fontSize);
        $this->SetTextColor(0, 0, 0);
        $this->MultiCell(66, $altura, $propietario, 1, 'J', 0, 1);

        // Septima fila
        $this->SetFont('helveticaB', '', 8);
        $this->SetTextColor(0, 0, 0);
        $this->MultiCell(19, 5, 'Fecha Exp.:', 1, 'L', 0, 0);
        $this->SetFont('helvetica', '', 8);
        $this->MultiCell(19, 5, $fechainicio, 1, 'C', 0, 0);
        $this->SetFont('helveticaB', '', 8);
        $this->MultiCell(33.5, 5, 'R. Individual:', 1, 'C', 0, 1);

        // Octava fila
        $this->SetFont('helveticaB', '', 8);
        $this->SetTextColor(0, 0, 0);
        $this->MultiCell(19, 5, 'Fecha Vcto:', 1, 'L', 0, 0);
        $this->SetFont('helvetica', '', 8);
        $this->MultiCell(19, 5, $fechatermino, 1, 'C', 0, 0);
        $this->MultiCell(33.5, 5, $nroregistro, 1, 'C', 0, 1);

        // Novena fila
        $this->SetFont('helveticaB', '', 8);
        $this->MultiCell(19, 6.5, 'Clase:', 1, 'L', 0, 0);
        $this->SetFont('helvetica', '', 7);
        $this->MultiCell(19, 6.5, $clase, 1, 'J', 0, 0);
        $this->SetFont('helveticaB', '', 8);
        $this->MultiCell(11.5, 6.5, 'Marca:', 1, 'L', 0, 0);
        $this->SetFont('helvetica', '', 7);
        $this->MultiCell(22, 7, $marca, 1, 'J', 0, 0);
    }

    // Función para la parte posterior con transparencia
    function PartePosterior($modelo, $combust, $long, $carroceria, $peso, $ejes, $ruedas, $cilind, $nummotor,
    $categoria, $numasiento, $colores, $empresa, $nserie, $rutautorizada)
    {
        // Link de la imagen
        $imageFile = '../Libreria_tcpdf/MPCH3.png';
        // Añadir una nueva página para la parte posterior
        $this->AddPage();

        // Rellenar el área completa con un fondo blanco para ocultar cualquier línea o borde
        // Rellenar toda la página con blanco
        $this->SetFillColor(255, 255, 255);
        $this->Rect(0, 0, 86, 55, 'F');
        // Establecer los márgenes (iguales a la parte frontal)
        $left_margin = 0;
        $top_margin = 0;
        $right_margin = 0;
        $bottom_margin = 0;

        // Insertar la imagen dentro del área de los márgenes (parte posterior) con transparencia
        $this->ImageWithAlpha($imageFile, $left_margin, $top_margin, 86 - $left_margin - $right_margin, 55 - $top_margin - $bottom_margin, 'PNG', 0.3);  // Transparencia al 60%

        // Ahora agregar la tabla
        // Primera fila
        $this->Ln(1);
        $this->SetFont('helveticaB', '', 8);
        $this->MultiCell(15, 7, 'Modelo:', 1, 'L', 0, 0);
        $this->SetFont('helvetica', '', 7);
        $this->MultiCell(32, 7, $modelo, 1, 'L', 0, 0);
        $this->SetFont('helveticaB', '', 8);
        $this->MultiCell(16, 7, 'Combust.:', 1, 'J', 0, 0);
        $this->SetFont('helvetica', '', 7);
        $this->MultiCell(13, 7, $combust, 1, 'J', 0, 0);
        $this->SetFont('helveticaB', '', 7);
        $this->MultiCell(10, 7, 'Long.:'. $long, 1, 'J', 0, 1);

        // Segunda fila
        $this->SetFont('helveticaB', '', 7);
        $this->MultiCell(15, 7, 'Carrocería', 1, 'J', 0, 0);
        $this->SetFont('helvetica', '', 6);
        $this->MultiCell(16, 7, $carroceria, 1, 'J', 0, 0);
        $this->SetFont('helveticaB', '', 7.5);
        $this->MultiCell(16, 7, 'Peso: '.$peso, 1, 'J', 0, 0);
        $this->SetFont('helveticaB', '', 7.5);
        $this->MultiCell(16, 7, 'Ejes: '.$ejes, 1, 'J', 0, 0);
        $this->SetFont('helveticaB', '', 7.5);
        $this->MultiCell(13, 7, 'Cilindros:', 1, 'J', 0, 0);
        $this->SetFont('helvetica', '', 7.5);
        $this->MultiCell(10, 7, $cilind, 1, 'J', 0, 1);

        // Tercera fila
        $this->SetFont('helveticaB', '', 8);
        $this->MultiCell(15, 7, 'N° Motor:', 1, 'J', 0, 0);
        $this->SetFont('helvetica', '', 7);
        $this->MultiCell(32, 7, $nummotor, 1, 'J', 0, 0);
        $this->SetFont('helveticaB', '', 7);
        $this->MultiCell(16, 7, 'Categoria: '.$categoria, 1, 'J', 0, 0);
        $this->MultiCell(13, 7, 'N° Asientos:', 1, 'J', 0, 0);
        $this->SetFont('helvetica', '', 7);
        $this->MultiCell(15, 7, $numasiento, 1, 'J', 0, 1);

        // Cuarta fila
        $this->SetFont('helveticaB', '', 8);
        $this->MultiCell(15, 7, 'Colores:', 1, 'J', 0, 0);
        $this->SetFont('helvetica', '', 7);
        $this->MultiCell(48, 7, $colores, 1, 'L', 0, 0);
        $this->SetFont('helveticaB', '', 7.5);
        $this->MultiCell(13, 7, 'Ruedas:', 1, 'J', 0, 0);
        $this->SetFont('helvetica', '', 7);
        $this->MultiCell(15, 7, $ruedas, 1, 'J', 0, 1);

        // Quinta fila
        $this->SetFont('helveticaB', '', 7);
        $this->MultiCell(32, 6, 'Empresa y/o Asociación', 1, 'J', 0, 0);
        $this->SetFont('helveticaB', '', 7);
        $this->MultiCell(15, 6, 'N° de serie', 1, 'J', 0, 0);
        $this->SetFont('helvetica', '', 7);
        $this->MultiCell(39, 6, $nserie, 1, 'J', 0, 1);

        // Sexta fila
        $this->SetFont('helvetica', '', 7);
        $this->MultiCell(47, 7, $empresa, 1, 'J', 0, 1);
        $this->SetFont('helveticaB', '', 7);
        $this->MultiCell(47, 7, 'Ruta Autorizada: '.$rutautorizada, 1, 'L', 0, 1);

        
        // Añadir el texto debajo de la imagen
        $this->Image('../Libreria_tcpdf/firma_2.png', 52, 32, 28, 11);
        $this->SetFont('times', 'B', 6);
        $this->SetXY(52, 43); // 2 es el espaciado entre la imagen y el texto
        $this->MultiCell(30, 5, 'Abg. Zelmy M. Rosario Camacho GERENTE', 0, 'C', 0, 0);
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
    $codsit = isset($_POST['codsit']) ? $_POST['codsit'] : null;
    $placa = isset($_POST['placa']) ? $_POST['placa'] : null;
    $temp_storage = isset($_POST['temp_storage']) ? json_decode($_POST['temp_storage'], true) : null;

    if ($codsit !== null && $placa !== null && $temp_storage !== null) {
        // Acceder a la data
        $data = $temp_storage['data'];
        if (!empty($data)) {
            $pdf = new PDF('L', 'mm', array(86, 55));
            // Llamar a la función para la parte frontal
            $n_tarj = trim(html_entity_decode($data[0]['nrotarjeta']));
            $tipserv = trim(html_entity_decode($data[0]['tp_servicio']));
            $propietario = trim(html_entity_decode($data[0]['propietario']));
            $fechainicio = trim(html_entity_decode($data[0]['fechainicio']));
            $fechatermino = trim(html_entity_decode($data[0]['fechatermino']));
            $nroregistro = trim(html_entity_decode($data[0]['nroregistro']));
            $clase = trim(html_entity_decode($data[0]['clase']));
            $marca = trim(html_entity_decode($data[0]['marca']));
            $aniofab = trim(html_entity_decode($data[0]['anno_fabricacion']));
            $modelo = trim(html_entity_decode($data[0]['modelo']));
            $combust = trim(html_entity_decode($data[0]['combustible']));
            $long = trim(html_entity_decode($data[0]['longitud']));
            $carroceria = trim(html_entity_decode($data[0]['carroceria']));
            $peso = trim(html_entity_decode($data[0]['peso_seco']));
            $ejes = trim(html_entity_decode($data[0]['ejes']));
            $ruedas = trim(html_entity_decode($data[0]['ruedas']));
            $cilind = trim(html_entity_decode($data[0]['cilindros']));
            $nummotor = trim(html_entity_decode($data[0]['nummotor']));
            $categoria = trim(html_entity_decode($data[0]['categoria']));
            $numasiento = trim(html_entity_decode($data[0]['num_asientos']));
            $colores = trim(html_entity_decode($data[0]['color']));
            $empresa = trim(html_entity_decode($data[0]['razonsocial']));
            $nserie = trim(html_entity_decode($data[0]['num_serie']));
            $rutautorizada = trim(html_entity_decode($data[0]['abreviatura']));
            $pdf->ParteFrontal($n_tarj,$placa, $tipserv,$propietario, fechainicio: $fechainicio, fechatermino: $fechatermino,nroregistro: $nroregistro,clase: $clase, marca: $marca, aniofab: $aniofab);
            $datosQR = "https://www.munichiclayo.gob.pe/sisTransporte/validar.php?placa=" . $placa;
            $imagenBase64 = generarQR($datosQR, 'H', 8);
            $imgdata = base64_decode($imagenBase64);
            $pdf->Image('@' . $imgdata, 72, 39, 12.5, 12.5);
            $pdf->PartePosterior( $modelo, $combust, $long, $carroceria, $peso, $ejes, $ruedas, $cilind, $nummotor,
            $categoria, $numasiento, $colores, $empresa, $nserie, $rutautorizada);

            // Salida del PDF
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="tuc.pdf"');
            $pdf->Output();
        } else {
            echo "No hay datos disponibles.";
        }
    }
}