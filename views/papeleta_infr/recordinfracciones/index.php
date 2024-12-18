<?php
require_once("../../../config/conexion.php");
require_once("../../../config/config.php");

if (isset($_SESSION["usua_id"]) && verificarAccesoPorCarpeta($_SESSION["rol_id"])) {
?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <?php require_once("../../html/mainHead.php"); ?>
        <title>MPCH::Record</title>
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
                                <h1>Consultar de record de infracciones - SATCH</h1>
                                <p>Visualización de las infracciones que estan registradas en el SATCH</p>
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
                                        <span class="info-box-text">Listado de infracciones según placa</span>
                                        <span class="info-box-number" id="lbltotal_infracciones">0</span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <input id="buscar_placa" class="form-control" type="text" oninput="limitarbuscarplaca(this)"
                                        pattern="\d{6}" placeholder="Buscar placa" required>
                                    <label id="mensaje_placa" style="display: none; color: green;">Correcto!</label>
                                    <button id="boton_placa" class="btn btn-oblong btn-primary tx-uppercase tx-bold btn-block" style="margin-top: 2px;" onclick="nuevo()" disabled><i
                                            class="fa fa-search fa-lg" aria-hidden="true"></i> Buscar placa</button>
                                </div>
                                <br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Lista de infracciones según placa</h5>
                                    </div>
                                    <div class="card-body">
                                        <table id="ul_visualizacion_infraccion" class="table table-bordered table-hover">
                                            <thead class="thead-colored thead-dark">
                                                <tr>
                                                    <th class="wd-5p">N° PLACA</th>
                                                    <th class="wd-10p">N° PAPELETA</th>
                                                    <th class="wd-5p">FECHA IMPOSICIÓN</th>
                                                    <th class="wd-5p">INFRACTOR</th>
                                                    <th class="wd-10p">PROPIETARIO</th>
                                                    <th class="wd-5p">INFRACCIÓN</th>
                                                    <th class="wd-5p">ESTADO</th>
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
        <script src="../../papeleta_infr/recordinfracciones/satchinfracciones.js?v=<?php echo time(); ?>"></script>
    </body>

    </html>
<?php
} else {
    header("Location: " . Conectar::ruta() . "index.php");
}
?>