<?php
require_once("config/conexion.php");

if (isset($_POST["enviar"]) and $_POST["enviar"] == "si") {
  require_once("models/Usuario.php");
  $usuario = new Usuario();
  $usuario->login();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="public/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="public/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="public/dist/css/adminlte.min.css">

  <link rel="apple-touch-icon" sizes="144x144" href="public/img/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="public/img/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="public/img/favicon-16x16.png">
  <link rel="mask-icon" href="public/img/safari-pinned-tab.svg" color="#5bbad5">
  <link rel="icon" href="public/img/favicon.png" type="image/x-icon">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">

  <title>Municipalidad de Chiclayo</title>

  <style>
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
      -webkit-appearance: none !important;
      margin: 0 !important;
    }

    input[type=number] {
      -moz-appearance: textfield;
      appearance: textfield;
    }
  </style>
</head>


<body class="hold-transition login-page" style=" background-color: #1D2939;">

  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-header text-center">
        <img src="public/img/logo2.png">
      </div>
      <div class="card-body login-card-body">
        <p class="login-box-msg">SISTEMA DE TRANSPORTE v.1.0.0 </p>

        <form action="" method="post">
          <?php
          if (isset($_GET["m"])) {
            switch ($_GET["m"]) {
              case "1":
          ?>
                <div class="alert alert-danger" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <strong class="d-block d-sm-inline-block-force">Error!</strong> Error
                </div>
              <?php
                break;
              case "2":
              ?>
                <div class="alert alert-danger" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <strong class="d-block d-sm-inline-block-force">Error!</strong> Campos vacios
                </div>
              <?php
                break;
              case "3":
              ?>
                <div class="alert alert-danger" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <strong class="d-block d-sm-inline-block-force">Error!</strong> No se encontraron datos
                </div>
              <?php
                break;
              case "4":
              ?>
                <div class="alert alert-danger" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <strong class="d-block d-sm-inline-block-force">Error!</strong> IP Persona no registrada
                </div>
              <?php
                break;
              case "5":
              ?>
                <div class="alert alert-danger" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <strong class="d-block d-sm-inline-block-force">Error!</strong> Persona inactiva
                </div>
              <?php
                break;
              case "6":
              ?>
                <div class="alert alert-danger" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <strong class="d-block d-sm-inline-block-force">Error!</strong> Fuera de la hora de acceso
                </div>
              <?php
                break;
              case "7":
              ?>
                <div class="alert alert-success" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <strong class="d-block d-sm-inline-block-force">Error!</strong> Usuario no vigente
                </div>
              <?php
                break;
              case "8":
              ?>
                <div class="alert alert-success" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <strong class="d-block d-sm-inline-block-force">Error!</strong> Datos incorrectos
                </div>
          <?php
                break;
            }
          }
          ?>
          <div class="input-group mb-3">
            <input type="number" id="usu_dni" name="usu_dni" class="form-control" placeholder="Ingrese su dni"
              oninput="limitarADigitosDNI(this)" onkeydown="bloquearIncrementoDecremento(event)" onwheel="bloquearRueda(event)">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-users"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" id="usu_contrasena" name="usu_contrasena" class="form-control"
              placeholder="Ingrese su contraseña">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>

          <p class="mb-1">
            <a href="https://www.munichiclayo.gob.pe/sisSeguridad/view/USURecuperacionContra/index.php?sistema=Transporte"
              class="tx-info tx-12 d-block mg-t-10">Olvidó su contraseña?</a>
          </p>

          <input type="hidden" name="enviar" class="form-control" value="si">
          <button type="submit" class="btn btn-info btn-block">Ingresar</button>
          <!-- /.social-auth-links -->
        </form>



      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>

  <!-- jQuery -->
  <script src="public/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="public/dist/js/adminlte.min.js"></script>
  <script>
    function limitarADigitosDNI(input) {
      let valor = input.value.toString().replace(/\D/g, '');
      if (valor.length > 8) {
        valor = valor.slice(0, 8);
      }
      input.value = valor;
    }

    function bloquearIncrementoDecremento(event) {
      if (event.key === "ArrowUp" || event.key === "ArrowDown") {
        event.preventDefault();
      }
    }

    function bloquearRueda(event) {
      event.preventDefault();
    }
  </script>
</body>

</html>