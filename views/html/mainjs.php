<script src="/sisTransporte/public/plugins/jquery/jquery.min.js"></script>
<script src="/sisTransporte/public/plugins/moment/moment.min.js"></script>
<script src="/sisTransporte/public/plugins/moment/moment-with-locales.min.js"></script>
<script src="/sisTransporte/public/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="/sisTransporte/public/plugins/jquery-validation/additional-methods.min.js"></script>
<script src="/sisTransporte/public/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="/sisTransporte/public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/sisTransporte/public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

<script src="/sisTransporte/public/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/sisTransporte/public/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/sisTransporte/public/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/sisTransporte/public/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="/sisTransporte/public/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="/sisTransporte/public/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="/sisTransporte/public/plugins/jszip/jszip.min.js"></script>
<script src="/sisTransporte/public/plugins/pdfmake/pdfmake.min.js"></script>
<script src="/sisTransporte/public/plugins/pdfmake/vfs_fonts.js"></script>
<script src="/sisTransporte/public/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="/sisTransporte/public/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="/sisTransporte/public/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script src="/sisTransporte/public/plugins/select2/js/select2.full.min.js"></script>
<script src="/sisTransporte/public/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="/sisTransporte/public/plugins/bs-stepper/js/bs-stepper.min.js"></script>
<script src="/sisTransporte/public/plugins/toastr/toastr.min.js"></script>

<script src="/sisTransporte/public/dist/js/adminlte.js"></script>

<script src="/sisTransporte/public/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="/sisTransporte/public/plugins/raphael/raphael.min.js"></script>
<script src="/sisTransporte/public/plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="/sisTransporte/public/plugins/jquery-mapael/maps/usa_states.min.js"></script>
<script src="/sisTransporte/public/plugins/chart.js/Chart.min.js"></script>
<script src="/sisTransporte/public/plugins/parsleyjs/parsley.js"></script>

<script>
  // Función para activar el menú según la URL actual
  function activateMenu() {
    const currentUrl = window.location.href;

    // Selecciona todos los elementos de menú con enlaces
    document.querySelectorAll('.nav-item a').forEach((item) => {
      // Si la URL actual incluye la URL del menú
      if (currentUrl.includes(item.href)) {
        item.classList.add('active'); // Activa el enlace

        // Activa el menú padre en caso de submenús
        const parentNavItem = item.closest('.nav-item.has-treeview');
        if (parentNavItem) {
          parentNavItem.classList.add('menu-open'); // Muestra el submenú
          const parentLink = parentNavItem.querySelector('a.nav-link');
          if (parentLink) parentLink.classList.add('active');
        }
      }
    });
  }

  // Llama a la función cuando la página se carga
  document.addEventListener('DOMContentLoaded', function () {
    activateMenu();

    // Inicializa Select2
    $('.select2').select2({
      theme: 'bootstrap4'
    });
    $('.select2').on('select2:open', function () {
      // Usa un pequeño delay para asegurar que el campo de búsqueda está visible
      setTimeout(function () {
        $('.select2-container .select2-search__field').focus();
      }, 0);
    });
  });
</script>