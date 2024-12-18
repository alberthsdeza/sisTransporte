var datos = [];
$(document).ready(function () {
  listarVehiculos(datos);
});

function limitarbuscarruc(input) {
  let valor = input.value.toString().replace(/\D/g, "");
  let botonBuscar = $("#buscar_vehiculos"); // Suponiendo que el botón tiene el ID 'buscar_empresa'

  if (valor.length > 11) {
    valor = valor.slice(0, 11);
  }

  if (valor.length < 11) {
    listarVehiculos(datos);
    var spinner = $("<i>")
      .addClass("fa fa-spinner fa-spin")
      .attr("id", "spinner");
    $("#mensaje_empresa")
      .text("Faltan datos...")
      .css("color", "grey")
      .show()
      .append(spinner)
      .show();

    if ($("#spinner").length === 0) {
      var spinner = $("<i>")
        .addClass("fa fa-spinner fa-spin")
        .attr("id", "spinner");
      $("#mensaje_empresa").before(spinner);
    }

    botonBuscar.attr("disabled", "disabled");
  } else if (valor.length == 11) {
    $("#mensaje_empresa")
      .text("Ahora haga clic en el botón 'Buscar'.")
      .css("color", "blue")
      .show();
    $("#spinner").remove(); // Asegurarse de que el spinner no se muestre
    botonBuscar.removeAttr("disabled");
  }

  if (valor.length == 0) {
    listarVehiculos(datos);
    $("#spinner").removeClass("fa fa-spinner fa-spin");
    $("#mensaje_empresa").text("").hide();
    $("#spinner").remove();
    botonBuscar.attr("disabled", "disabled");
  }

  input.value = valor;
}

function nuevo() {
  buscaRUC();
}

function buscaRUC() {
  var empr_ruc = $("#buscar_empresa").val();
  var spinner = $("<i>")
    .addClass("fa fa-spinner fa-spin")
    .attr("id", "spinner");
  $("#mensaje_empresa")
    .text("Buscando...")
    .css("color", "grey")
    .show()
    .append(spinner)
    .show();
  $.post(
    "../../../controller/api_sistra_antiguo_mototaxi.php",
    { rucempresa: empr_ruc },
    function (data) {
      var response = JSON.parse(data);
      if (
        response.success &&
        response.message === "Consulta realizada correctamente" &&
        response.data.length > 0
      ) {
        listarVehiculos(response.data);
        $("#mensaje_empresa")
          .text("Empresa encontrada")
          .css("color", "green")
          .show();
        $("#spinner").removeClass("fa fa-spinner fa-spin");
      } else {
        listarVehiculos(response.data);
        $("#mensaje_empresa")
          .text("Empresa no encontrada")
          .css("color", "red")
          .show();
        $("#spinner").removeClass("fa fa-spinner fa-spin");
      }
    }
  ).fail(function () {
    $("#mensaje_empresa").hide();
    alert("Error al conectarse al servicio.");
  });
}

function listarVehiculos(data) {
  $("#ul_visualizacion_vehiculos").show();
  $("#ul_visualizacion_vehiculos").DataTable().destroy();
  $("#ul_visualizacion_vehiculos").DataTable({
    responsive: true,
    autoWidth: false,
    lengthChange: false,
    dom: '<"row"<"col-md-6"l><"col-md-6 d-flex justify-content-end align-items-center"fB>>tip',
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
        data: "csituacion",
        render: function (data, type, row) {
          return (
            '<input type="checkbox" name="detallecheck[]" value="' +
            row.csituacion +
            '">'
          );
        }
      },
      {
        width: "3%", // Ajusta el ancho según sea necesario
        data: "nplaca",
        render: function (data, type, row) {
          // Aplicar estilo de justificación
          return (
            '<div style="max-width: 100%; text-align: justify; white-space: pre-wrap;">' +
            row.nplaca +
            "</div>"
          );
        }
      },
      {
        width: "4%",
        data: "fecha_autorizacion",
        render: function (data, type, row) {
          return (
            '<div style="max-width: 100%; text-align: center;">' +
            row.fecha_autorizacion +
            "</div>"
          );
        }
      },
      { width: "3%", data: "modalidad" },
      {
        width: "6%",
        data: "anno_fabricacion",
        render: function (data, type, row) {
          return (
            '<div style="max-width: 100%; text-align: center;">' +
            row.anno_fabricacion +
            "</div>"
          );
        }
      },
      { width: "3%", data: "marca" },
      {
        width: "15%", // Ajusta el ancho según sea necesario
        data: "dnipropietario",
        render: function (data, type, row) {
          // Aplicar estilo de justificación
          return (
            '<div style="max-width: 100%; text-align: justify; white-space: pre-wrap;">' +
            row.dnipropietario +
            " - " +
            row.propietario +
            "</div>"
          );
        }
      },
      {
        width: "15%", // Ajusta el ancho según sea necesario
        data: "razonsocial",
        render: function (data, type, row) {
          // Aplicar estilo de justificación
          return (
            '<div style="max-width: 100%; text-align: justify; white-space: pre-wrap;">' +
            row.razonsocial +
            "</div>"
          );
        }
      }
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
      $("#lbltotal_vehiculos").html(total);
    }
  });
}

function GenerarQR() {
  var empresa_ruc = $("#buscar_empresa").val();
  table = $("#ul_visualizacion_vehiculos").DataTable();
  var mototaxi_id = [];

  table.rows().every(function (rowIdx, tableLoop, rowLoop) {
    cell1 = table.cell({ row: rowIdx, column: 0 }).node();

    if ($("input", cell1).prop("checked") == true) {
      // Obtener los datos de la fila actual
      var id = $("input", cell1).val();
      var rowData = table.row(rowIdx).data(); // Obtener todos los datos de la fila
      var razonsocial = rowData.razonsocial;
      var placa = rowData.nplaca;

      mototaxi_id.push({
        id: id,
        ruc: empresa_ruc,
        razonsocial: razonsocial,
        placa: placa
      });
    }
  });

  // Verificar si se seleccionó al menos un vehículo
  if (mototaxi_id.length === 0) {
    Swal.fire({
      title: "Error!",
      text: "Por favor, selecciona un vehículo de la fila.",
      icon: "error",
      confirmButtonText: "Aceptar"
    });
  } else {
    Swal.fire({
      title: "Generar QR",
      text: "¿Quieres generar QR de los vehículos seleccionados?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Sí, generar!",
      cancelButtonText: "No, cancelar"
    }).then((result) => {
      if (result.isConfirmed) {
        Procesar_qr(mototaxi_id);
      }
    });
  }
}

function Procesar_qr(mototaxi_id) {
  var form = document.createElement("form");
  form.method = "POST";
  form.action = "../../../controller/visualizar_qr_mototaxi.php";
  form.target = "_blank"; // Abre el PDF en una nueva pestaña

  var input = document.createElement("input");
  input.type = "hidden";
  input.name = "id";
  input.value = JSON.stringify(mototaxi_id); // Convierte el objeto a JSON string
  form.appendChild(input);
  console.log(JSON.stringify(mototaxi_id));
  document.body.appendChild(form);
  form.submit();
  document.body.removeChild(form);
}
