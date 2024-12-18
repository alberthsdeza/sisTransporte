<?php
require_once("../../../config/conexion.php");
require_once("../../../config/config.php");

if (isset($_SESSION["usua_id"]) && verificarAccesoPorCarpeta($_SESSION["rol_id"])) {
?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <?php require_once("../../html/mainHead.php"); ?>
        <title>MPCH::QR</title>
    </head>


    <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
        <div class="wrapper">
            <?php require_once("../../html/menu.php"); ?>
            <?php require_once("../../html/mainProfile.php"); ?>
            <div class="content-wrapper">
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-12">
                                <h1>Consultar vehículos menores</h1>
                                <p>Pantalla para consultar en el antiguo sistema para ver los vehículos menores autorizados y activos según el RUC</p>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md">
                                <div class="info-box">
                                    <span class="info-box-icon bg-info"><i class="fa fa-list"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Listado de vehiculos activos - autorizados</span>
                                        <span class="info-box-number" id="lbltotal_vehiculos">0</span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <input id="buscar_empresa" class="form-control" type="text" oninput="limitarbuscarruc(this)"
                                        pattern="\d{11}" placeholder="Buscar empresa RUC" required>
                                    <label id="mensaje_empresa" style="display: none; color: green;">Correcto!</label>
                                    <button id="buscar_vehiculos" class="btn btn-oblong btn-primary tx-uppercase tx-bold btn-block" style="margin-top: 2px;" onclick="nuevo()" disabled><i
                                            class="fa fa-search fa-lg" aria-hidden="true"></i> Buscar vehículos activos</button>
                                </div>
                                <br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Lista de vehículos activos - autorizados</h5>
                                        <div class="card-tools">
                                            <button id="modalAsignar_inspector" type="button" class="btn btn-outline-primary"
                                                onclick="GenerarQR()"><i class="fa fa-qrcode"></i> Generar QR</button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <table id="ul_visualizacion_vehiculos" class="table table-bordered table-hover">
                                            <thead class="thead-colored thead-dark">
                                                <tr>
                                                    <th class="wd-5p"></th>
                                                    <th class="wd-5p">N° PLACA</th>
                                                    <th class="wd-10p">Fech. Autorización</th>
                                                    <th class="wd-5p">MODALIDAD</th>
                                                    <th class="wd-5p">AÑO DE FABR.</th>
                                                    <th class="wd-10p">MARCA</th>
                                                    <th class="wd-5p">PROPIETARIO</th>
                                                    <th class="wd-5p">EMPRESA</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <?php require_once("../../html/footer.php"); ?>
        <?php require_once("../../html/mainjs.php"); ?>
        <script src="../../provicional/qrmototaxi/visualizarlistavehiculos.js?v=<?php echo time(); ?>"></script>
    </body>

    </html>
<?php
} else {
    header("Location: " . Conectar::ruta() . "index.php");
}
?>