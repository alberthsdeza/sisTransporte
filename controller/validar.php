<?php
require_once("../config/conexion.php");
require_once("../ws/sistra_antiguo_vehiculo/consulta_validar.php");
require_once("../models/Vehiculo_adicional.php");
$validar = new Validar_vehiculo();
$veh_adic = new Vehiculo_adicional();

function response_message($message, $data, $suc, $httpStatusCode = 200)
{
    date_default_timezone_set('America/Bogota');
    $status = $httpStatusCode;
    $success = $suc;
    $datetime = date("Y-m-d H:i:s");
    http_response_code($httpStatusCode);
    header('Content-Type: application/json');
    echo json_encode(compact('datetime', 'status', 'success', 'message', 'data'));
    exit();
}

// Verifica la operación solicitada
switch ($_GET["op"]) {
    case "validar_html":
        $datos = $validar->validar_vehiculo(
            $_POST["num_doc"],
        );
        $datos1 = $veh_adic->get_verificar_soat_tecn($_POST["num_doc"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                // Definir clase según estado de vencimiento
                $clase_estado = (strtoupper(str_replace(' ', '', trim($row["estado_vencimiento"]))) === 'VIGENTE') ? 'vigente' : 'vencida';
                $estado_soat = (isset($datos1[0]["estado_soat"]) && strtoupper($datos1[0]["estado_soat"]) === 'VIGENTE') ? 'vigente' : 'vencida';
                $estado_revtecnica = (isset($datos1[0]["estado_revtecnica"]) && strtoupper($datos1[0]["estado_revtecnica"]) === 'VIGENTE') ? 'vigente' : 'vencida';
                $html = '            
                <style>
                    .vigente {
                        background-color: green !important;
                        color: white;
                    }

                    .vencida {
                        background-color: red !important;
                        color: white;
                    }

                    .no_disponible {
                        background-color: grey !important;
                        color: white;
                    }

                    /* Estilos para el contenedor de Datos del Vehículo */
                    .vehicle-data-card,
                    .circulation-card,
                    .additional-card {
                        background-color: #f8f9fa;
                        border-radius: 8px;
                        padding: 20px;
                        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                        margin-top: 10px;
                        margin-right: 10px;
                        /* Para que ocupen el mismo espacio */
                    }

                    .vehicle-data-card h4,
                    .circulation-card h4,
                    .additional-card h4 {
                        background-color: #4680ff;
                        /* Color de fondo del título */
                        color: white;
                        /* Color del texto */
                        margin-bottom: 10px;
                        text-align: center;
                        font-weight: bold;
                        /* Resaltar el título */
                        font-size: 15px;
                        /* Tamaño del título */
                        padding: 10px;
                        /* Espaciado interno del título */
                        border-radius: 5px;
                        /* Bordes redondeados */
                    }

                    .vehicle-data-card .form-group label,
                    .circulation-card .form-group label,
                    .additional-card .form-group label {
                        font-weight: bold;
                    }

                    .vehicle-data-card .form-control,
                    .circulation-card .form-control,
                    .additional-card .form-control {
                        border: 1px solid #ced4da;
                        border-radius: 4px;
                        padding: 10px;
                        /* Mayor espaciado interno */
                        font-size: 12px;
                        /* Aumentar el tamaño de fuente */
                    }

                    .row.form-row {
                        display: flex;
                        flex-wrap: wrap;
                        /* Permitir que los elementos se envuelvan */
                        margin-bottom: 15px;
                        /* Espacio entre filas */
                    }

                    .row.form-row .form-group {
                        flex: 1;
                        /* Tomar el mismo ancho */
                        min-width: 150px;
                        /* Ancho mínimo para los campos */
                        margin-right: 15px;
                        /* Espaciado entre los grupos */
                    }

                    .row.form-row .form-group:last-child {
                        margin-right: 0;
                        /* Eliminar margen del último elemento */
                    }

                    .additional-circulation-container {
                        display: flex;
                        flex-direction: column;
                        justify-content: flex-start;
                        margin-left: 15px;
                        /* Espaciado entre las tarjetas y el card de vehículo */
                    }


                    @media (max-width: 768px) {
                        .row.form-row .form-group {
                            flex: 1;
                            /* Mantener todos los elementos en una fila */
                            margin-right: 0;
                            /* Eliminar margen */
                            margin-bottom: 15px;
                            /* Espaciado inferior */
                        }
                    }

                    .cards-container {
                        display: flex;
                        justify-content: center;
                        margin-top: 20px;
                        /* Espacio entre cards */
                    }

                    @media (max-width: 768px) {
                        .cards-container {
                            flex-direction: column;
                            /* Cambiar a columna en pantallas pequeñas */
                        }

                        .vehicle-data-card,
                        .circulation-card,
                        .additional-card {
                            margin-right: 0;
                            /* Eliminar margen derecho en móviles */
                            margin-bottom: 20px;
                            /* Espacio entre los cards */
                        }
                    }
                </style>

            <!-- Sección de Cards -->
            <div class="cards-container">
                <div class="vehicle-data-card">
                    <h4><i class="fa fa-car" aria-hidden="true"></i> DATOS DEL VEHÍCULO</h4>
                    <div class="row">
                        <div class="form-group col-12 col-sm-12 col-md-6">
                            <label for="placa">Placa</label>
                            <input type="text" class="form-control" id="placa" value="'.trim($row["placa"]).'" disabled>
                        </div>
                        <div class="form-group col-12 col-sm-12 col-md-6">
                            <label for="modalidad">Modalidad</label>
                            <input type="text" class="form-control" id="modalidad" value="'.trim($row["modalida"]).'" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-sm-12 col-md-6">
                            <label for="marca">Marca</label>
                            <input type="text" class="form-control" id="marca" value="'.trim($row["marca"]).'" disabled>
                        </div>
                        <div class="form-group col-12 col-sm-12 col-md-6">
                            <label for="modelo">Modelo</label>
                            <input type="text" class="form-control" id="modelo" value="'.trim($row["modelo"]).'" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="clase">Clase</label>
                            <input type="text" class="form-control" id="clase" value="'.trim($row["clase"]).'" disabled>
                        </div>
                        <div class="form-group col-12">
                            <label for="tp_servicio">Tipo Servicio</label>
                            <input type="text" class="form-control" id="tp_servicio" value="'.trim($row["tp_servicio"]).'" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="clase">Vigencia SOAT</label>
                            <input type="text" class="form-control '.$estado_soat.'" id="clase" value="'.(isset($datos1[0]["inve_soat_fecha"]) ? trim($datos1[0]["inve_soat_fecha"]) : 'No disponible').'" disabled>
                        </div>
                        <div class="form-group col-12">
                            <label for="tp_servicio">Vigencia Rev. Tecnica</label>
                            <input type="text" class="form-control '.$estado_revtecnica.'" id="tp_servicio" value="'.(isset($datos1[0]["inve_revtecnica"]) ? trim($datos1[0]["inve_revtecnica"]) : 'No disponible').'" disabled>
                        </div>
                    </div>
                </div>

                <div class="additional-circulation-container">
                    <div class="circulation-card">
                        <h4><i class="fa fa-id-card" aria-hidden="true"></i> TARJETA ÚNICA DE CIRCULACIÓN / CONSTANCIA DE HABILITACIÓN</h4>
                        <div class="row">
                            <div class="form-group col-12 col-sm-4">
                                <label for="numero">Número</label>
                                <input type="text" class="form-control" id="numero" value="'.trim($row["nrotarjeta"]).'" disabled>
                            </div>
                            <div class="form-group col-12 col-sm-4">
                                <label for="fecha_emision">Fecha Emisión</label>
                                <input type="text" class="form-control" id="emision" value="'.trim($row["fechaemision"]).'" disabled>
                            </div>
                            <div class="form-group col-12 col-sm-4">
                                <label for="fecha_vencimiento">Fecha Vencimiento</label>
                                <input type="text" class="form-control" id="vencimiento" value="'.trim($row["fechacaducidad"]).'" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12 col-sm-8">
                                <label for="propietario">Propietario</label>
                                <textarea class="form-control" name="propietario" id="propietario" rows="1" disabled>'. trim($row["dnipropietario"]).'." - "'.trim($row["propietario"]).'</textarea>
                            </div>
                            <div class="form-group col-12 col-sm-4">
                                <label for="estado">Estado</label>
                                <input type="text" class="form-control '.$clase_estado.'" id="estado" value="'.strtoupper(str_replace(' ', '', trim($row["estado_vencimiento"]))).'" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="additional-card">
                        <h4><i class="fa fa-building" aria-hidden="true"></i> TITULAR DE LA AUTORIZACIÓN</h4>
                        <div class="row">
                            <div class="form-group col-12 col-sm-12 col-md-6">
                                <label for="numero_documento">Número de Documento</label>
                                <input type="text" class="form-control" id="numero_documento" value="'.trim($row["rucempresa"]).'" disabled>
                            </div>
                            <div class="form-group col-12 col-sm-12 col-md-6">
                                <label for="ruta">Ruta</label>
                                <input type="text" class="form-control" id="ruta" value="'.trim($row["abreviatura"]).'" disabled>
                            </div>
                        </div>
                        <div class="row form-row">
                            <div class="form-group col-12">
                                <label for="apellidos_nombres">Apellidos y Nombres / Razón Social</label>
                                <textarea class="form-control" name="apellidos_nombres_ruc" id="ap_nom_ruc" disabled>'.trim($row["razonsocial"]).'</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            ';
            }
            response_message('Operación exitosa', $html, true);
        } else {
            response_message('No existe','', false);
        }
        break;
}
