<?php
require_once("../../../config/conexion.php");
require_once("../../../config/config.php");

if (isset($_SESSION["usua_id"]) && verificarAccesoPorCarpeta($_SESSION["rol_id"])) {
?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <?php require_once("../../html/mainHead.php"); ?>
        <title>MPCH::TUC</title>
        <style>
            .spinner-container {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(40, 78, 114, 255);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 9999;
            }

            .footer {
                background-color: #D42F2F;
                color: white;
                text-align: center;
                padding: 10px;
                font-weight: bold;
            }

            .form-layout-6 .row>div:first-child,
            .form-layout-7 .row>div:first-child {
                align-items: initial !important;
                background-color: initial !important;
                font-weight: initial !important;
            }

            .form-layout-6 .row>div,
            .form-layout-7 .row>div {
                padding: 5px 10px !important;
            }

            .titulo {
                font-size: 14px;
                color: black;
                font-weight: bold;
            }

            .respuesta {
                font-size: 13px;
                color: black;
            }

            .border-custom {
                border: 1px solid #333;
                padding: 10px;
            }
        </style>
    </head>


    <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
        <div class="spinner-container d-none" id="spinner-container">
            <div class="sk-cube-grid circle-spinner">
                <div class="sk-cube sk-cube1"></div>
                <div class="sk-cube sk-cube2"></div>
                <div class="sk-cube sk-cube3"></div>
                <div class="sk-cube sk-cube4"></div>
                <div class="sk-cube sk-cube5"></div>
                <div class="sk-cube sk-cube6"></div>
                <div class="sk-cube sk-cube7"></div>
                <div class="sk-cube sk-cube8"></div>
                <div class="sk-cube sk-cube9"></div>
            </div>
        </div>
        <div class="wrapper">
            <?php require_once("../../html/menu.php"); ?>
            <?php require_once("../../html/mainProfile.php"); ?>
            <div class="content-wrapper">
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <h1>Consultar vehículos por placa</h1>
                                <p>Pantalla para consultar en el antiguo sistema para ver los vehículos por placa</p>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6 col-md-3">
                                <div class="form-group">
                                    <input id="num_placa" class="form-control" type="text" maxlength="7"
                                        placeholder="Buscar vehículo por placa" required>
                                    <label id="mensaje_vehiculo" style="display: none; color: green;">Correcto!</label>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <button id="buscar_vehiculo" class="btn btn-oblong btn-primary tx-uppercase tx-bold btn-block" onclick="nuevo()"><i
                                        class="fa fa-search fa-lg" aria-hidden="true"></i> Buscar vehículo</button>
                            </div>
                        </div>
                        <div style="margin-top: 5px;">
                            <div class="border border-dark rounded">
                                <div class="footer">DETALLES DEL VEHÍCULO</div>
                                <div class="form-layout form-layout-6">
                                    <div class="row no-gutters">
                                        <div class="col-6 col-md-2 border-custom">
                                            <label class="titulo">cSIT:</label>
                                        </div><!-- col-4 -->
                                        <div class="col-6 col-md-2 border-custom">
                                            <label id="csit" class="respuesta"></label>
                                        </div><!-- col-8 -->
                                        <div class="col-6 col-md-3 border-custom">
                                            <label class="titulo">PLACA:</label>
                                        </div><!-- col-4 -->
                                        <div class="col-6 col-md-5 border-custom">
                                            <label id="n_placa" class="respuesta"></label>
                                        </div><!-- col-8 -->
                                        <div class="col-6 col-md-2 border-custom">
                                            <label class="titulo">N° Motor:</label>
                                        </div><!-- col-4 -->
                                        <div class="col-6 col-md-2 border-custom">
                                            <label id="n_motor" class="respuesta"></label>
                                        </div><!-- col-8 -->
                                        <div class="col-6 col-md-3 border-custom">
                                            <label class="titulo">F. PROCESO:</label>
                                        </div><!-- col-4 -->
                                        <div class="col-6 col-md-5 border-custom">
                                            <label id="f_proc" class="respuesta"></label>
                                        </div><!-- col-8 -->
                                        <div class="col-6 col-md-2 border-custom">
                                            <label class="titulo">F. EMISIÓN:</label>
                                        </div><!-- col-4 -->
                                        <div class="col-6 col-md-2 border-custom">
                                            <label id="f_emi" class="respuesta"></label>
                                        </div><!-- col-8 -->
                                        <div class="col-6 col-md-3 border-custom">
                                            <label class="titulo">F. CADUCA:</label>
                                        </div><!-- col-4 -->
                                        <div class="col-6 col-md-5 border-custom">
                                            <label id="f_caduc" class="respuesta"></label>
                                        </div><!-- col-8 -->
                                        <div class="col-6 col-md-2 border-custom">
                                            <label class="titulo">N° SERIE:</label>
                                        </div><!-- col-4 -->
                                        <div class="col-6 col-md-2 border-custom">
                                            <label id="n_serie" class="respuesta"></label>
                                        </div><!-- col-8 -->
                                        <div class="col-6 col-md-3 border-custom">
                                            <label class="titulo">MARCA:</label>
                                        </div><!-- col-4 -->
                                        <div class="col-6 col-md-5 border-custom">
                                            <label id="marca" class="respuesta"></label>
                                        </div><!-- col-8 -->
                                        <div class="col-6 col-md-2 border-custom">
                                            <label class="titulo">CLASE:</label>
                                        </div><!-- col-4 -->
                                        <div class="col-6 col-md-2 border-custom">
                                            <label id="clase" class="respuesta"></label>
                                        </div><!-- col-8 -->
                                        <div class="col-6 col-md-3 border-custom">
                                            <label class="titulo">N° DE TARJETA (TUC):</label>
                                        </div><!-- col-4 -->
                                        <div class="col-6 col-md-5 border-custom">
                                            <label id="tuc" class="respuesta"></label>
                                        </div><!-- col-8 -->
                                        <div class="col-6 col-md-2 border-custom">
                                            <label class="titulo">SOAT FECH. VENC.:</label>
                                        </div><!-- col-4 -->
                                        <div class="col-6 col-md-2 border-custom">
                                            <label id="soat" class="respuesta"></label>
                                        </div><!-- col-8 -->
                                        <div class="col-6 col-md-3 border-custom">
                                            <label class="titulo">REVISIÓN TEC. FECH. VENC.:</label>
                                        </div><!-- col-4 -->
                                        <div class="col-6 col-md-5 border-custom">
                                            <label id="rev_tec" class="respuesta"></label>
                                        </div><!-- col-8 -->
                                        <div class="col-6 col-md-2 border-custom">
                                            <label class="titulo">1ERA IMPRESIÓN:</label>
                                        </div><!-- col-4 -->
                                        <div class="col-6 col-md-2 border-custom">
                                            <label id="primera" class="respuesta"></label>
                                        </div><!-- col-8 -->
                                        <div class="col-6 col-md-3 border-custom">
                                            <label class="titulo">DUPLICADOS:</label>
                                        </div><!-- col-4 -->
                                        <div class="col-6 col-md-5 border-custom">
                                            <label id="duplicado" class="respuesta"></label>
                                        </div><!-- col-8 -->
                                        <div class="col-6 col-md-2 border-custom">
                                            <label class="titulo">Ultimo Responsable:</label>
                                        </div><!-- col-4 -->
                                        <div class="col-6 col-md-10 border-custom">
                                            <label id="responsable" class="respuesta"></label>
                                        </div><!-- col-8 -->
                                    </div><!-- row -->
                                </div><!-- form-layout -->
                            </div>
                            <div style="text-align: center; margin-top: 3px">
                                <div class="col-lg-12">
                                    <button id="imprimir_tuc" type="button" class="btn btn-primary tx-size-xs"
                                        onclick="ImprimirTUC()">Imprimir TUC</button>
                                    <button id="modificar" type="button" class="btn btn-primary tx-size-xs"
                                        disabled>Agregar información</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
        <?php require_once("../../html/footer.php"); ?>
        <?php require_once("../../html/mainjs.php"); ?>
        <script src="../../provicional/generartuc/visualizar_vehiculo.js?v=<?php echo time(); ?>"></script>
    </body>

    </html>
<?php
} else {
    header("Location: " . Conectar::ruta() . "index.php");
}
?>