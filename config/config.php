<?php
$PermitidasPorRol = [
    9 => ['*'], // Administrador acceso total
    10 => ['mantrnt', 'procpapeleta'], //prueba tecnico
    6 => ['procpapeleta'], //prueba digitador
    3 => ['home','generartuc'] //prueba emisor
];

function verificarAccesoPorCarpeta($rol_id) {
    global $PermitidasPorRol;
    
    // Obtiene la carpeta actual desde la URL o el directorio
    $directorioActual = basename(dirname($_SERVER['SCRIPT_NAME']));

    // Si el rol tiene acceso a todas las carpetas
    if (isset($PermitidasPorRol[$rol_id]) && in_array('*', $PermitidasPorRol[$rol_id])) {
        return true;
    }

    // Verificar si el rol tiene acceso a la carpeta actual
    return isset($PermitidasPorRol[$rol_id]) && in_array($directorioActual, $PermitidasPorRol[$rol_id]);
}