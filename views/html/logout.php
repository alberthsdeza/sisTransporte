<?php
    require_once("../../config/conexion.php");
    require_once("../../models/Usuario.php");
    $historialsesion = new Usuario();
    $historialsesion->update_historial_sesion($_SESSION["historial_login"]);
    session_destroy();
    header("Location:".Conectar::ruta()."index.php");
    exit();