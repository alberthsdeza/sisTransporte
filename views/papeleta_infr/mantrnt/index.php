<?php
require_once("../../../config/conexion.php");
require_once("../../../config/config.php");

if (isset($_SESSION["usua_id"]) && verificarAccesoPorCarpeta($_SESSION["rol_id"])) {
?>

  <!DOCTYPE html>
  <html lang="es">

  <head>
    <?php require_once("../../html/mainHead.php"); ?>
    <link href="../../../public/css/switch_checkbox.css" rel="stylesheet">
    <link href="../../../public/plugins/SpinKit/spinkit.css" rel="stylesheet">
    <title>MPCH::RNT</title>
    <style>
      .modal-header {
        background: #007bff;
        color: white;
      }
    </style>
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
                <h1>Gestión del Reglamento Nacional de Tránsito</h1>
                <p>Pantalla para la gestión del reglamento nacional de tránsito</p>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h5 class="card-title">Lista de registro del RNT</h5>
                    <div class="card-tools">
                      <button class="btn btn-outline-primary" id="Nuevo"><i class="fa fa-plus-square"></i> Nuevo registro</button>
                    </div>
                  </div>
                  <div class="card-body">
                    <table id="ul_registros_rnt" class="table table-bordered table-hover">
                      <thead class="thead-colored thead-dark">
                        <tr>
                          <th class="wd-5p">ID</th>
                          <th class="wd-5p">CODIGO</th>
                          <th class="wd-5p">DESCRIPCIÓN</th>
                          <th class="wd-10p">OBSERVACIÓN</th>
                          <th class="wd-10p">CALIF.</th>
                          <th class="wd-10p">ESTADO</th>
                          <th class="wd-5p">Acción</th>
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
    <?php require_once("../mantrnt/modalRegistroRNT.php"); ?>
    <?php require_once("../mantrnt/modalRegistroRNT_vista.php"); ?>
    <?php require_once("../mantrnt/modalActualizarRNT.php"); ?>
    <?php require_once("../../html/mainjs.php"); ?>
    <script src="../mantrnt/rnt.js?v=<?php echo time(); ?>"></script>
    <script src="../mantrnt/visualizar_rnt.js?v=<?php echo time(); ?>"></script>
    <script src="../mantrnt/inactivar.js?v=<?php echo time(); ?>"></script>
    <script src="../mantrnt/activar.js?v=<?php echo time(); ?>"></script>
    <script src="../mantrnt/anular.js?v=<?php echo time(); ?>"></script>
    <script src="../mantrnt/actualizar_rnt.js?v=<?php echo time(); ?>"></script>

  </body>

  </html>
<?php
} else {
  header("Location: " . Conectar::ruta() . "index.php");
}
?>