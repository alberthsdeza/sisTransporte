<?php
require_once("../../config/conexion.php");
require_once("../../config/config.php");

if (isset($_SESSION["usua_id"]) && verificarAccesoPorCarpeta($_SESSION["rol_id"])) {
?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <?php require_once("../html/mainHead.php"); ?>
        <title>MPCH::INICIO</title>
    </head>


    <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
        <div class="wrapper">
            <?php require_once("../html/menu.php"); ?>
            <?php require_once("../html/mainProfile.php"); ?>

            <?php require_once("../html/footer.php"); ?>
        </div>
        <?php require_once("../html/mainjs.php"); ?>
    </body>

    </html>
<?php
} else {
    header("Location: " . Conectar::ruta() . "index.php");
}
?>