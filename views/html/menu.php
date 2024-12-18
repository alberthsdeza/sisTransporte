<?php
$base_url = '/sisTransporte/';
// Verifica si la sesión ya ha sido iniciada
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

$menus = array(
  9 => array(
    array(
      'header' => 'PROCESOS - TRANSPORTE',
    ),
    array(
      'url' => '#',
      'icon' => 'fas fa-file-signature',
      'label' => 'PROCESO PAPELETAS INFRACCIÓN',
      'submenu' => array(
        array(
          'header' => 'MANTENIMIENTO',
        ),
        array(
          'url' => $base_url . 'views/papeleta_infr/mantrnt/',
          'icon' => 'fa fa-cogs',
          'label' => 'Gestión de RNT'
        ),
        array(
          'header' => 'PROCEDIMIENTO',
        ),
        array(
          'url' => $base_url . 'views/papeleta_infr/procpapeleta/',
          'icon' => 'fas fa-file-signature',
          'label' => 'Registro de papeleta',
          'status' => 'En Mantenimiento',
        ),
        array(
          'header' => 'CONSULTAS - SATCH',
        ),
        array(
          'url' => '#',
          'icon' => 'fas fa-circle',
          'label' => 'Record infracción',
          'submenu' => array(
            array(
              'url' => $base_url . 'views/papeleta_infr/recordinfracciones/',
              'icon' => 'fas fa-search',
              'label' => 'Por placa',
            ),
          )
        ),
        array(
          'url' => '#',
          'icon' => 'fas fa-circle',
          'label' => 'Pagos activos de papeletas',
          'submenu' => array(
            array(
              'url' => $base_url . 'views/papeleta_infr/pagoactivosatch/',
              'icon' => 'fas fa-search',
              'label' => 'Papeleta y placa',
            ),
          )
        ),
        array(
          'header' => 'REPORTES',
        )
      )
    ),
    array(
      'url' => '#',
      'icon' => 'fa fa-print',
      'label' => 'PROCESO TUC/QR PROVICIONAL',
      'submenu' => array(
        array(
          'header' => 'GENERAR QR PEGATINA',
        ),
        array(
          'url' => $base_url . 'views/provicional/qrmototaxi/',
          'icon' => 'fa fa-search',
          'label' => 'Consulta empresa - mototaxi'
        ),
        array(
          'header' => 'GENERAR TUC',
        ),
        array(
          'url' => $base_url . 'views/provicional/generartuc/',
          'icon' => 'fa fa-search',
          'label' => 'Consultar vehiculos'
        ),
      )
    ),
  ),
  3 => array(
    array(
      'url' => '#',
      'icon' => 'fa fa-print',
      'label' => 'PROCESO TUC/QR PROVICIONAL',
      'submenu' => array(
        array(
          'header' => 'GENERAR TUC',
        ),
        array(
          'url' => $base_url . 'views/provicional/generartuc/',
          'icon' => 'fa fa-search',
          'label' => 'Consultar vehiculos'
        ),
      )
    ),
  ),

);

$current_menu = isset($menus[$_SESSION["rol_id"]]) ? $menus[$_SESSION["rol_id"]] : array();
$current_url = $_SERVER['REQUEST_URI'];
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="<?= $base_url . 'views/home/' ?>" class="brand-link text-center" style="display: flex; justify-content: center; align-items: center;">
    <span style="font-size: 30px; font-weight: bold;">
      <img src="<?= $base_url . 'public/img/mstile-150x150.png' ?>" alt="" class="brand-image img-circle elevation-3">
      <span class="logo-separator" style="color: white;"> | </span>
      <span class="logo-mpch" style="color: white;">MPCH</span>
    </span>
  </a>
  <div class="sidebar" style="padding-top: 20px;">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <?php foreach ($current_menu as $menu): ?>
          <?php if (isset($menu['header'])): ?>
            <li class="nav-header"><?= htmlspecialchars($menu['header']) ?></li>
          <?php else: ?>
            <!-- Menú principal -->
            <li class="nav-item <?= isset($menu['submenu']) ? 'has-treeview ' . (strpos($current_url, $menu['url']) !== false ? 'menu-open' : '') : '' ?>">
              <a href="<?= htmlspecialchars($menu['url']) ?>" class="nav-link <?= strpos($current_url, $menu['url']) !== false ? 'active' : '' ?>">
                <i class="nav-icon <?= htmlspecialchars($menu['icon']) ?>"></i>
                <p>
                  <?= htmlspecialchars($menu['label']) ?>
                  <?php if (isset($menu['status'])): ?>
                    <span class="badge badge-warning ml-2"><?= htmlspecialchars($menu['status']) ?></span>
                  <?php endif; ?>
                  <?php if (isset($menu['submenu'])): ?>
                    <i class="right fas fa-angle-left"></i>
                  <?php endif; ?>
                </p>
              </a>
              <!-- Submenú -->
              <?php if (isset($menu['submenu'])): ?>
                <ul class="nav nav-treeview">
                  <?php foreach ($menu['submenu'] as $submenu): ?>
                    <?php if (isset($submenu['header'])): ?>
                      <li class="nav-header"><?= htmlspecialchars($submenu['header']) ?></li>
                    <?php else: ?>
                      <li class="nav-item <?= isset($submenu['submenu']) ? 'has-treeview ' . (strpos($current_url, $submenu['url']) !== false ? 'menu-open' : '') : '' ?>">
                        <a href="<?= htmlspecialchars($submenu['url']) ?>" class="nav-link <?= strpos($current_url, $submenu['url']) !== false ? 'active' : '' ?>">
                          <i class="nav-icon <?= htmlspecialchars($submenu['icon']) ?>"></i>
                          <p>
                            <?= htmlspecialchars($submenu['label']) ?>
                            <?php if (isset($submenu['status'])): ?>
                              <span class="badge badge-warning ml-2"><?= htmlspecialchars($submenu['status']) ?></span>
                            <?php endif; ?>
                            <?php if (isset($submenu['submenu'])): ?>
                              <i class="right fas fa-angle-left"></i>
                            <?php endif; ?>
                          </p>
                        </a>
                        <?php if (isset($submenu['submenu'])): ?>
                          <ul class="nav nav-treeview">
                            <?php foreach ($submenu['submenu'] as $subsubmenu): ?>
                              <li class="nav-item">
                                <a href="<?= htmlspecialchars($subsubmenu['url']) ?>" class="nav-link">
                                  <i class="nav-icon <?= htmlspecialchars($subsubmenu['icon']) ?>"></i>
                                  <p><?= htmlspecialchars($subsubmenu['label']) ?></p>
                                  <?php if (isset($subsubmenu['status'])): ?>
                                    <span class="badge badge-warning ml-2"><?= htmlspecialchars($subsubmenu['status']) ?></span>
                                  <?php endif; ?>
                                </a>
                              </li>
                            <?php endforeach; ?>
                          </ul>
                        <?php endif; ?>
                      </li>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>
            </li>
          <?php endif; ?>
        <?php endforeach; ?>
      </ul>
    </nav>
  </div>
</aside>