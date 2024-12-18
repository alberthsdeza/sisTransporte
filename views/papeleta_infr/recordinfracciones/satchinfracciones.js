var datos = [];
$(document).ready(function () {
  listarinfracciones(datos);
});

function limitarbuscarplaca(input) {
  let valor = input.value.toString().toUpperCase().replace(/[^A-Za-z0-9]/g, "");
  let botonBuscar = $("#boton_placa");

  if (valor.length > 7) {
    valor = valor.slice(0, 6);
  }

  if (valor.length < 6) {
    listarinfracciones(datos);
    var spinner = $("<i>")
      .addClass("fa fa-spinner fa-spin")
      .attr("id", "spinner");
    $("#mensaje_placa")
      .text("Faltan datos...")
      .css("color", "grey")
      .show()
      .append(spinner)
      .show();

    if ($("#spinner").length === 0) {
      var spinner = $("<i>")
        .addClass("fa fa-spinner fa-spin")
        .attr("id", "spinner");
      $("#mensaje_placa").before(spinner);
    }

    botonBuscar.attr("disabled", "disabled");
  } else if (valor.length == 6 || valor.length == 7) {
    $("#mensaje_placa")
      .text("Ahora haga clic en el botón 'Buscar'.")
      .css("color", "blue")
      .show();
    $("#spinner").remove();
    botonBuscar.removeAttr("disabled");
  }

  if (valor.length == 0) {
    listarinfracciones(datos);
    $("#spinner").removeClass("fa fa-spinner fa-spin");
    $("#mensaje_placa").text("").hide();
    $("#spinner").remove();
    botonBuscar.attr("disabled", "disabled");
  }

  input.value = valor;
}

function nuevo() {
  buscaplaca();
}

function buscaplaca() {
  var placa = $("#buscar_placa").val();
  var spinner = $("<i>")
    .addClass("fa fa-spinner fa-spin")
    .attr("id", "spinner");
  $("#mensaje_placa")
    .text("Buscando...")
    .css("color", "grey")
    .show()
    .append(spinner)
    .show();
  $.get(
    "../../../controller/api_consulta_record_inf_satch.php",
    { placa: placa },
    function (data) {
      if (
        data.status &&
        data.message === "Datos encontrados exitosamente." &&
        data.data.length > 0
      ) {
        listarinfracciones(data.data);
        $("#mensaje_placa")
          .text("placa encontrada")
          .css("color", "green")
          .show();
        $("#spinner").removeClass("fa fa-spinner fa-spin");
      } else {
        listarinfracciones(data.data);
        $("#mensaje_placa")
          .text("placa no encontrada")
          .css("color", "red")
          .show();
        $("#spinner").removeClass("fa fa-spinner fa-spin");
      }
    }
  ).fail(function () {
    $("#mensaje_placa").hide();
    alert("Error al conectarse al servicio.");
  });
}

function listarinfracciones(data) {
  $("#ul_visualizacion_infraccion").show();
  $("#ul_visualizacion_infraccion").DataTable().destroy();
  $("#ul_visualizacion_infraccion").DataTable({
    responsive: true,
    autoWidth: false,
    lengthChange: false,
    dom:
      '<"row"<"col-md-6"l><"col-md-6 d-flex justify-content-end align-items-center"fB>>tip',
    buttons: [],
    data: data,
    bDestroy: true,
    responsive: true,
    bInfo: true,
    iDisplayLength: 10,
    order: [[1, "asc"]],
    columns: [
      {
        width: "2%",
        data: "placa",
        render: function (data, type, row) {
          return (
            '<div style="max-width: 100%; text-align: justify; white-space: pre-wrap;">' +
            row.placa +
            "</div>"
          );
        }
      },
      {
        width: "3%", // Ajusta el ancho según sea necesario
        data: "nro_papeleta",
        render: function (data, type, row) {
          // Aplicar estilo de justificación
          return (
            '<div style="max-width: 100%; text-align: justify; white-space: pre-wrap;">' +
            row.nro_papeleta +
            "</div>"
          );
        }
      },
      {
        width: "4%",
        data: "fecha_imp",
        render: function (data, type, row) {
          return (
            '<div style="max-width: 100%; text-align: justify;">' +
            row.fecha_imp +
            "</div>"
          );
        }
      },
      {
        width: "15%",
        data: "infractor",
        render: function (data, type, row) {
          return (
            '<div style="max-width: 100%; text-align: justify;">' +
            row.infractor +
            "</div>"
          );
        }
      },
      {
        width: "15%", // Ajusta el ancho según sea necesario
        data: "propietario",
        render: function (data, type, row) {
          // Aplicar estilo de justificación
          return (
            '<div style="max-width: 100%; text-align: justify; white-space: pre-wrap;">' +
            row.propietario +
            "</div>"
          );
        }
      },
      {
        width: "5%", // Ajusta el ancho según sea necesario
        data: "infraccion",
        render: function (data, type, row) {
          // Aplicar estilo de justificación
          return (
            '<div style="max-width: 100%; text-align: justify; white-space: pre-wrap;">' +
            row.infraccion +
            "</div>"
          );
        }
      },
      { width: "3%", data: "estado" }
    ],
    language: {
      sProcessing: "Procesando...",
      sLengthMenu: "Mostrar _MENU_ registros",
      sZeroRecords: "No se encontraron resultados",
      sEmptyTable: "Ningún dato disponible en esta tabla",
      sInfo:
        "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
      sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
      sInfoPostFix: "",
      sSearch: "Buscar:",
      sUrl: "",
      sInfoThousands: ",",
      sLoadingRecords: "Cargando...",
      oPaginate: {
        sFirst: "Primero",
        sLast: "Último",
        sNext: "Siguiente",
        sPrevious: "Anterior"
      }
    },
    oAria: {
      sSortAscending: ": Activar para ordenar la columna de manera ascendente",
      sSortDescending: ": Activar para ordenar la columna de manera descendente"
    },
    drawCallback: function (settings) {
      var api = this.api();
      var total = api.page.info().recordsTotal;
      $("#lbltotal_infracciones").html(total);
    }
  });
}
