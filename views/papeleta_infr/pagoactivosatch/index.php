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
            <?php require_once("../../html/MainProfile.php"); ?>
            <div class="content-wrapper">
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-12">
                                <h1>Consulta de papeleta de tránsito (SATCH - pagos papeletas en linea)</h1>
                                <p>Visualización de la deuda de las infracciones que estan registradas en el SATCH</p>
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
                                        <span class="info-box-text">Listado de Papeletas de Tránsito</span>
                                        <span class="info-box-number" id="lbltotal_infracciones">0</span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-6">
                                            <input id="buscar_placa" class="form-control" type="text"
                                                maxlength="6" pattern="^(?=.*[A-Za-z])[A-Za-z0-9]{6}$" title="La placa debe tener exactamente 6 caracteres alfanuméricos (letras y números)." autocomplete="off" placeholder="Buscar placa" required>
                                        </div>
                                        <div class="col-6">
                                            <input id="buscar_papeleta" class="form-control" type="text"
                                                onkeypress="return soloNumeros(event);" pattern="[0-9]{11}" maxlength="11" title="Max. 11 caracteres" required autocomplete="off" placeholder="Buscar papeleta" required>
                                        </div>
                                    </div>
                                    <label id="mensaje_buscar" style="display: none; color: green;">Correcto!</label>
                                    <button id="boton_placa" class="btn btn-oblong btn-primary tx-uppercase tx-bold btn-block" style="margin-top: 2px;" onclick="validarFormulario(event)"><i
                                            class="fa fa-search fa-lg" aria-hidden="true"></i> Buscar</button>
                                </div>
                                <br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Listado de Papeletas de Tránsito</h5>
                                    </div>
                                    <div class="card-body">
                                        <table id="ul_visualizacion_infraccion" class="table table-bordered table-hover">
                                            <thead class="thead-colored thead-dark">
                                                <tr>
                                                    <th class="wd-5p">N° PLACA</th>
                                                    <th class="wd-5p">TIPO</th>
                                                    <th class="wd-10p">N° PAPELETA</th>
                                                    <th class="wd-5p">FECHA IMP</th>
                                                    <th class="wd-5p">INFRACCIÓN</th>
                                                    <th class="wd-10p">DEUDA TOTAL</th>
                                                    <th class="wd-5p">DESCUENTO</th>
                                                    <th class="wd-5p">DEUDA PAGAR</th>
                                                    <th class="wd-5p">ACCIÓN</th>
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
        <?php require_once("../../papeleta_infr/pagoactivosatch/modaldetalle.php"); ?>
        <?php require_once("../../html/mainjs.php"); ?>
        <script src="../../papeleta_infr/pagoactivosatch/satchpagosactivos.js?v=<?php echo time(); ?>"></script>
    </body>

    </html>
<?php
} else {
    header("Location: " . Conectar::ruta() . "index.php");
}
?>