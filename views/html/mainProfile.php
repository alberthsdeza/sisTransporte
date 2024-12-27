<style>
  /* Ocultar el nombre en pantallas pequeñas */
  @media (max-width: 767px) {
    .user-name {
      display: none;
    }

    .user-role {
      display: inline;
    }
  }

  /* Asegúrate de que en pantallas más grandes, ambos elementos sean visibles */
  @media (min-width: 768px) {
    .user-name {
      display: inline;
    }

    .user-role {
      display: inline;
    }
  }
</style>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#" role="button">
        <p>
          <span class="user-name"><?php echo $_SESSION["nombre_completo"]; ?></span> |
          <small class="user-role tx-bold"><?php echo $_SESSION["rol_nombre"]; ?></small>
          <input type="hidden" id="pe_idx" value="<?php echo $_SESSION["usua_id"] ?>">
          <input type="hidden" id="pe_nomx" value="<?php echo $_SESSION["nombre_completo"] ?>">
          <input type="hidden" id="depe_idx" value="<?php echo $_SESSION["depe_id"] ?>">
          <input type="hidden" id="pe_rolx" value="<?php echo $_SESSION["rol_id"] ?>">
        </p>
      </a>
      <div class="dropdown-menu dropdown-menu-right">
        <a href="/sisTransporte/views/html/logout.php" class="dropdown-item">
          <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
        </a>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" href="#" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>
    </li>
  </ul>
</nav>
<!-- /.navbar -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var pushMenuButton = document.querySelector('[data-widget="pushmenu"]');
    var logoMPCH = document.querySelector('.logo-mpch');
    var logoSeparator = document.querySelector('.logo-separator');
    var menuCompressed = false; // Estado inicial: menú desplegado

    pushMenuButton.addEventListener('click', function() {
      if (!menuCompressed) {
        // Ocultar "MPCH" y el separador cuando el menú se comprime
        logoMPCH.style.display = 'none';
        logoSeparator.style.display = 'none';
        menuCompressed = true; // Cambiar estado a comprimido
      } else {
        // Mostrar "MPCH" y el separador cuando el menú se expande
        logoMPCH.style.display = 'inline';
        logoSeparator.style.display = 'inline';
        menuCompressed = false; // Cambiar estado a desplegado
      }
    });
  });
</script>