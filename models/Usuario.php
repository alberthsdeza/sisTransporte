<?php
class Usuario extends Conectar
{

    public function login()
    {
        $conectar = parent::conexion();
        parent::set_names();
        if (isset($_POST["enviar"])) {
            $dni_sitra = $_POST["usu_dni"];
            $pass_sitra = $_POST["usu_contrasena"];

            if (empty($dni_sitra) and empty($pass_sitra)) {
                header("Location:" . conectar::ruta() . "index.php?m=2");
                exit();
            } else {

                $ip = $_SERVER['REMOTE_ADDR'];

                //comienzo API seguridad
                $ch = curl_init();
                $ws_seguridad = "http://192.168.101.5/sisSeguridad/ws/ws.php/?op=login&pers_dni=" . $dni_sitra . "&pers_contrasena=" . $pass_sitra . "&pers_ip=" . $ip . "&sist_inic=SITRA";

                curl_setopt($ch, CURLOPT_URL, $ws_seguridad);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);

                if (curl_errno($ch)) {
                    $error_msg = curl_error($ch);
                    echo json_encode(array('error' => 'Error al conectarse al servicio'));
                } else {
                    curl_close($ch);
                    $data = json_decode($response, true);
                }
                //fin API
                $detalle = $data["detalle"];
                if ($detalle == "No se encontraron datos") {
                    header("Location:" . Conectar::ruta() . 'index.php?m=3');
                    exit();
                } elseif ($detalle == "IP Persona no registrada") {
                    header("Location:" . Conectar::ruta() . 'index.php?m=4');
                    exit();
                } elseif ($detalle == "Persona inactiva") {
                    header("Location:" . Conectar::ruta() . 'index.php?m=5');
                    exit();
                } elseif ($detalle == "Fuera de la hora de acceso") {
                    header("Location:" . Conectar::ruta() . 'index.php?m=6');
                    exit();
                } elseif ($detalle == "Usuario no vigente") {
                    header("Location:" . Conectar::ruta() . 'index.php?m=7');
                    exit();
                } elseif ($detalle == "Datos incorrectos") {
                    header("Location:" . Conectar::ruta() . 'index.php?m=8');
                    exit();
                } elseif ($detalle == "Sistema no disponible") {
                    header("Location:" . Conectar::ruta() . 'index.php?m=9');
                    exit();
                }

                // Verificar si la decodificación fue exitosa
                if ($data !== null) {

                    $_SESSION["usua_id"] = $data["pers_id"];
                    $_SESSION["usua_dni"] = $data["pers_dni"];
                    $_SESSION["rol_id"] = $data["perf_id"];
                    $_SESSION["usua_estado"] = $data["pers_estado"];
                    $_SESSION["historial_login"] = $data["hise_id"];
                    $_SESSION["pers_apellidos"] = $data["pers_apelpat"] . " " . $data["pers_apelmat"];
                    $_SESSION["pers_nombre"] = $data["pers_nombre"];
                    $_SESSION["nombre_completo"] = $data["pers_nombre"] . " " . $data["pers_apelpat"] . " " . $data["pers_apelmat"];
                    $_SESSION["rol_nombre"] = $data["perf_nombre"];
                    $_SESSION["pers_emailm"] = $data["pers_emailm"];
                    $_SESSION["pers_celu01"] = $data["pers_celu01"];
                    $_SESSION["depe_id"] = $data["depe_id"];
                    $datos2 = $this->get_Persona_por_id($data["pers_id"]);
                    foreach ($datos2 as $row) {
                        if ($row["pers_foto"] == "") {
                            $_SESSION["pers_foto"] = "../../public/img/usuario.png";
                        } else {
                            $_SESSION["pers_foto"] = "data:image/png;base64," . $row["pers_foto"];
                        }
                    }

                    // Utilizar consulta preparada para evitar inyección de SQL - dependencia
                    $depe_id = $_SESSION["depe_id"];
                    $sql = "SELECT depe_id, depe_codigo, depe_denominacion, depe_abreviatura, depe_siglasdoc, depe_representante, depe_cargo, depe_direccion, depe_telefono, depe_anexo, depe_codrof, depe_superior, depe_estado, nior_id, tpor_id, tpde_id, lomu_id
                            FROM public.tb_dependencia
                            WHERE depe_id = :depe_id";
                    $stmt = $conectar->prepare($sql);
                    $stmt->bindParam(":depe_id", $depe_id, PDO::PARAM_INT);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    // Guardar el valor de depe_codigo en la sesión
                    $_SESSION["depe_denominacion"] = $row["depe_denominacion"];
                    $_SESSION["depe_abreviatura"] = $row["depe_abreviatura"];
                    // Fin

                    switch ($_SESSION["rol_id"]) {
                        case 9:
                            header("Location: " . Conectar::ruta() . "views/home");
                            exit();
                        case 3:
                            header("Location: " . Conectar::ruta() . "views/home");
                            exit();
                    }
                } else {
                    header("Location:" . Conectar::ruta() . 'index.php?m=1');
                    exit();
                }
            }
        }
    }
    public function update_historial_sesion(
        $hiso_id_indi
    ) {
        $ch = curl_init();
        $ws_seguridad = "http://192.168.101.5/sisSeguridad/ws/ws.php/?op=logout&hise_id=" . $hiso_id_indi;

        curl_setopt($ch, CURLOPT_URL, $ws_seguridad);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            echo json_encode(array('error' => 'Error al conectarse al servicio'));
        } else {
            curl_close($ch);
            var_dump($response);
            $data = json_decode($response, true);
        }
    }

    //Funcion para buscar un Persona por su id, usando la siguiente funcion:
    public function get_Persona_por_id($pers_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM sc_escalafon.tb_persona 
            INNER JOIN sc_escalafon.tb_estado_civil ON sc_escalafon.tb_persona.esci_id = sc_escalafon.tb_estado_civil.esci_id
            WHERE pers_id = ?;";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $pers_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
}
