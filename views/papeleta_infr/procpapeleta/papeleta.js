let stepper;
document.addEventListener("DOMContentLoaded", function () {
  stepper = new Stepper(document.querySelector(".bs-stepper"));

  const montoInput = document.getElementById("monto");

  montoInput.addEventListener("input", function () {
    let valor = montoInput.value.replace(/\D/g, "");

    if (valor.length > 6) {
      valor = valor.slice(0, 6);
    }
    while (valor.length < 3) {
      valor = "0" + valor;
    }

    const partEntera = valor.slice(0, -2);
    const partDecimal = valor.slice(-2);

    const valorFormateado = `${parseInt(partEntera, 10)}.${partDecimal}`;

    // Mostrar el valor formateado en el campo de entrada
    montoInput.value = valorFormateado;
  });
});

$(document).ready(function () {
  $("#reservationdatetime").datetimepicker({
    locale: "es", // Configura el datetimepicker a español
    icons: {
      time: "far fa-clock"
    }
  });
  listar();
});

$("#Nuevo").click(function () {
  $("#titulo_modal").html("Registrar datos de papeleta");
  $("#modal-lg").modal("show");
  $("#close_modal").css("color", "white");
  listar_codinfraccion();
});

function listar_codinfraccion() {
  $.ajax({
    url: "../../../controller/rnt.php?op=listar_codigo_infraccion",
    method: "POST",
    data: {},
    success: function (data) {
      var llenar_selectcodinfr = JSON.parse(data);
      var select_tipoinf = $("#select_tipoinf");
      select_tipoinf.empty();
      select_tipoinf.append('<option label="Seleccionar norma"></option>');

      select_tipoinf.val(select_tipoinf.find("option:first").val());

      if (
        llenar_selectcodinfr.aaData &&
        llenar_selectcodinfr.aaData.length > 0
      ) {
        llenar_selectcodinfr.aaData.forEach(function (item) {
          select_tipoinf.append(
            '<option value="' + item[0] + '">' + item[1] + "</option>"
          );
        });
      }
    }
  });
}

function Sancion(input) {
  let timeout;
  clearTimeout(timeout);

  timeout = setTimeout(() => {
    let valores = input.value.split(",").map((v) => v.trim());

    let valoresProcesados = valores.map((valor) => {
      let soloNumeros = valor.replace(/\D/g, "");
      if (soloNumeros !== "") {
        let numero = parseInt(soloNumeros, 10);
        numero = Math.min(150, Math.max(0, numero));
        return numero + "%";
      }
      return "";
    });

    let resultado = valoresProcesados.filter((v) => v !== "").join(", ");

    input.value = resultado;
  }, 700);
}

function soloLetras(e) {
  key = e.keyCode || e.which;
  tecla = String.fromCharCode(key).toString();
  letras = "ABCDEFGHIJKLMNOPQRSTUVWXYZÁÉÍÓÚÜÑabcdefghijklmnopqrstuvwxyzáéíóúüñ";
  especiales = [8, 13, 32];
  tecla_especial = false;
  for (var i in especiales) {
    if (key == especiales[i]) {
      tecla_especial = true;
      break;
    }
  }
  if (letras.indexOf(tecla) == -1 && !tecla_especial) {
    const Toast = Swal.mixin({
      toast: true,
      position: "top-end",
      showConfirmButton: false,
      timer: 1800,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
      }
    });
    Toast.fire({
      icon: "error",
      title: "Ingrese solo letras"
    });
    return false;
  }
}

function Evalua(e) {
  key = e.keyCode || e.which;
  tecla = String.fromCharCode(key).toString().toUpperCase();
  letras = "CNS";
  especiales = [8, 13];
  tecla_especial = false;
  for (var i in especiales) {
    if (key == especiales[i]) {
      tecla_especial = true;
      break;
    }
  }
  if (letras.indexOf(tecla) == -1 && !tecla_especial) {
    const Toast = Swal.mixin({
      toast: true,
      position: "top-end",
      showConfirmButton: false,
      timer: 1800,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
      }
    });
    Toast.fire({
      icon: "error",
      title: "Ingrese solo N (no aplica), C (Cancelación), S (Sanción)"
    });
    return false;
  }
}

function soloNumeros(e) {
  if (window.event) {
    keynum = e.keyCode;
  } else {
    keynum = e.which;
  }
  if ((keynum > 47 && keynum < 58) || keynum == 8 || keynum == 13) {
    return true;
  } else {
    const Toast = Swal.mixin({
      toast: true,
      position: "top-end",
      showConfirmButton: false,
      timer: 1800,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
      }
    });
    Toast.fire({
      icon: "error",
      title: "Ingrese solo números"
    });
    return false;
  }
}

function configurarNumDoc(opcion) {
  var tipoDocumento;
  var inputDocumento;
  const apellidoPatCampo = document.getElementById("apellidoPatCampo");
  const apellidoMatCampo = document.getElementById("apellidoMatCampo");
  const nombreCampo = document.getElementById("nombreCampo");
  const razonSocialCampo = document.getElementById("razonSocialCampo");
  const solDomicilioCampo = document.getElementById("solDomicilioCampo");

  if (opcion === "infractor") {
    tipoDocumento = document.getElementById("select_tipodoc_infractor").value;
    inputDocumento = document.getElementById("infdni");
  } else if (opcion === "solidario") {
    tipoDocumento = document.getElementById("select_tipodoc_solidario").value;
    inputDocumento = document.getElementById("soldni");
  }

  inputDocumento.value = "";
  inputDocumento.maxLength = 15;
  inputDocumento.type = "text";
  inputDocumento.removeAttribute("pattern");

  if (tipoDocumento === "1") {
    inputDocumento.maxLength = 8;
    inputDocumento.pattern = "[0-9]*";
    inputDocumento.placeholder =
      opcion === "infractor" ? "DNI Infractor" : "DNI Solidario";
    limpiar(opcion);
    mostrarSpinner(opcion);
    apellidoPatCampo.style.display = "block";
    apellidoMatCampo.style.display = "block";
    nombreCampo.style.display = "block";
    razonSocialCampo.style.display = "none";
    document.getElementById("solapellidopat").setAttribute("required", "true");
    document.getElementById("solapellidomat").setAttribute("required", "true");
    document.getElementById("solnombre").setAttribute("required", "true");
    document.getElementById("razon_social").removeAttribute("required");
    solDomicilioCampo.className = "col-12 col-xl-9";
  } else if (tipoDocumento === "2") {
    inputDocumento.maxLength = 12;
    inputDocumento.pattern = "[a-zA-Z0-9]*";
    inputDocumento.placeholder =
      opcion === "infractor" ? "CE Infractor" : "CE Solidario";
    mostrarSpinner(opcion);
    limpiar(opcion);
    apellidoPatCampo.style.display = "block";
    apellidoMatCampo.style.display = "block";
    nombreCampo.style.display = "block";
    razonSocialCampo.style.display = "none";
    document.getElementById("solapellidopat").setAttribute("required", "true");
    document.getElementById("solapellidomat").setAttribute("required", "true");
    document.getElementById("solnombre").setAttribute("required", "true");
    document.getElementById("razon_social").removeAttribute("required");
    solDomicilioCampo.className = "col-12 col-xl-9";
  } else if (tipoDocumento === "3" && opcion === "solidario") {
    inputDocumento.maxLength = 11;
    inputDocumento.pattern = "[0-9]*";
    inputDocumento.placeholder = "RUC Solidario";
    limpiar(opcion);
    mostrarSpinner(opcion);
    apellidoPatCampo.style.display = "none";
    apellidoMatCampo.style.display = "none";
    nombreCampo.style.display = "none";
    razonSocialCampo.style.display = "block";
    solDomicilioCampo.className = "col-12";
    document.getElementById("solapellidopat").removeAttribute("required");
    document.getElementById("solapellidomat").removeAttribute("required");
    document.getElementById("solnombre").removeAttribute("required");
    document.getElementById("razon_social").setAttribute("required", "true");
  }
}

function buscar_api_integrado(tipo, numdoc) {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: "../../../controller/api_integrado.php",
      method: "POST",
      data: { tipo: tipo, doc: numdoc },
      success: function (response) {
        resolve(response);
      },
      error: function (error) {
        console.error("Error al enviar la solicitud:", error);
        reject(error);
      }
    });
  });
}

function limitabuscadoc(input, opcion) {
  let valor = input.value.toString().replace(/\D/g, "");

  let tipoDocumento;
  let mensajeElemento;

  if (opcion === "infractor") {
    tipoDocumento = $("#select_tipodoc_infractor").val();
    mensajeElemento = $("#infractor_mensaje");
    limpiar(opcion);
  } else if (opcion === "solidario") {
    tipoDocumento = $("#select_tipodoc_solidario").val();
    mensajeElemento = $("#solidario_mensaje");
    limpiar(opcion);
  }

  let spinner = $("<i>")
    .addClass("fa fa-spinner fa-spin")
    .attr("id", "spinner-ciud");
  mensajeElemento
    .text("Buscando... ")
    .css("color", "grey")
    .append(spinner)
    .show();

  if (tipoDocumento === "1" && valor.length === 8 && /^[0-9]{8}$/.test(valor)) {
    buscar_api_integrado("dni", valor)
      .then((data) => {
        if (data.message === "Consulta realizada correctamente") {
          if (opcion === "infractor") {
            infnombre.value = data.data.prenombres;
            infapellidopat.value = data.data.apPrimer;
            infapellidomat.value = data.data.apSegundo;
            infdomicilio.value = data.data.direccion;
            ciud_foto = "data:image/png;base64," + data.data.foto;
            mensajeElemento
              .text("Ciudadano encontrado")
              .css("color", "green")
              .show();
          } else if (opcion === "solidario") {
            solnombre.value = data.data.prenombres;
            solapellidopat.value = data.data.apPrimer;
            solapellidomat.value = data.data.apSegundo;
            soldomicilio.value = data.data.direccion;
            mensajeElemento
              .text("Solidario encontrado")
              .css("color", "green")
              .show();
          }
        } else {
          if (opcion === "infractor") {
            mensajeElemento
              .text("Ciudadano no encontrado")
              .css("color", "red")
              .show();
          } else if (opcion === "solidario") {
            mensajeElemento
              .text("Solidario no encontrado")
              .css("color", "red")
              .show();
          }
        }
      })
      .catch((error) => {
        console.error("Error en la solicitud:", error);
        mensajeElemento.text("Error en la consulta").css("color", "red").show();
      })
      .finally(() => {
        $("#infdni").removeAttr("disabled");
      });
  }
  if (tipoDocumento === "2" && valor.length >= 7) {
    // Llamar a la función de búsqueda para el CE
    buscar_api_integrado("ce", valor)
      .then((data) => {
        if (data.message === "Consulta realizada correctamente") {
          if (opcion === "infractor") {
            infnombre.value = data.data.nombres;
            infapellidopat.value = data.data.apep;
            infapellidomat.value = data.data.apem;
            mensajeElemento
              .text("Ciudadano encontrado")
              .css("color", "green")
              .show();
          } else if (opcion === "solidario") {
            solnombre.value = data.data.nombres;
            solapellidopat.value = data.data.apep;
            solapellidomat.value = data.data.apem;
            mensajeElemento
              .text("Solidario encontrado")
              .css("color", "green")
              .show();
          }
        } else {
          if (opcion === "infractor") {
            mensajeElemento
              .text("Ciudadano no encontrado")
              .css("color", "red")
              .show();
          } else if (opcion === "solidario") {
            mensajeElemento
              .text("Solidario no encontrado")
              .css("color", "red")
              .show();
          }
        }
      })
      .catch((error) => {
        console.error("Error en la solicitud:", error);
        mensajeElemento.text("Error en la consulta").css("color", "red").show();
      })
      .finally(() => {
        $("#infdni").removeAttr("disabled");
      });
  }
  if (
    tipoDocumento === "3" &&
    valor.length === 11 &&
    /^[0-9]{11}$/.test(valor)
  ) {
    buscar_api_integrado("ruc", valor)
      .then((data) => {
        if (data.message === "Consulta realizada correctamente") {
          if (opcion === "solidario") {
            razon_social.value = data.data.raz_social;
            soldomicilio.value = data.data.domicilio;
            mensajeElemento.text("RUC encontrado").css("color", "green").show();
          }
        }
      })
      .catch((error) => {
        console.error("Error en la solicitud:", error);
        mensajeElemento.text("Error en la consulta").css("color", "red").show();
      })
      .finally(() => {
        $("#infdni").removeAttr("disabled");
      });
  }
  if (valor.length === 0) {
    $("#spinner-ciud").removeClass("fa fa-spinner fa-spin");
    mensajeElemento.text("Buscando...").css("color", "green").hide();
    $("#spinner-ciud").remove();
  }

  input.value = valor; // Limita la entrada a solo números
}

function buscar_infraccion(codigo) {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: "../../../controller/rnt.php?op=visualizar_rnt",
      method: "POST",
      data: { ident_rnt: codigo },
      success: function (response) {
        var data = JSON.parse(response);
        resolve(data);
      },
      error: function (error) {
        console.error("Error al enviar la solicitud:", error);
        reject(error);
      }
    });
  });
}

function obtener_uit() {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: "../../../controller/uit.php?op=vista_uit",
      method: "POST",
      data: {},
      success: function (response) {
        try {
          var data = JSON.parse(response);
          if (data.mensaje === "Operación exitosa") {
            resolve(data);
          } else {
            reject("Error: " + data.mensaje);
          }
        } catch (error) {
          console.error("Error al procesar la respuesta JSON:", error);
          reject("Error al procesar la respuesta.");
        }
      },
      error: function (error) {
        console.error("Error al enviar la solicitud:", error);
        reject("Error en la solicitud AJAX.");
      }
    });
  });
}

function obtenerInfraccion() {
  const selectInfraccion = document.getElementById("select_tipoinf").value;
  const monto = document.getElementById("monto");
  if (selectInfraccion) {
    buscar_infraccion(selectInfraccion)
      .then((data) => {
        if (data.mensaje === "Operación exitosa") {
          const sancionValues = data.sancion_uit.replace(/{|}/g, "").split(",");

          if (sancionValues.length > 1) {
            let dropdownHTML =
              '<select id="dropdownPorcentajes" class="form-control select2">';
            sancionValues.forEach((value) => {
              dropdownHTML += `<option value="${value.trim()}">${value.trim()}%</option>`;
            });
            dropdownHTML += "</select>";

            Swal.fire({
              title: "Selecciona un porcentaje",
              html: dropdownHTML,
              confirmButtonText: "Aceptar",
              showCancelButton: true,
              cancelButtonText: "Cancelar",
              preConfirm: () => {
                const dropdown = document.getElementById("dropdownPorcentajes");
                return dropdown ? dropdown.value : null;
              }
            }).then((result) => {
              if (result.isConfirmed && result.value) {
                const selectedValue = result.value;
                const sancion_uit = document.getElementById("sancion_uit");
                sancion_uit.value = `${selectedValue}%`;
                sancion_uit.dispatchEvent(new Event("input")); // Disparar el evento input
                Swal.fire(
                  "Porcentaje seleccionado",
                  `${selectedValue}% (UIT) fue asignado`,
                  "success"
                );
                obtener_uit()
                  .then((data) => {
                    const valorCalculado = (selectedValue / 100) * data.valor;
                    monto.value = valorCalculado.toFixed(2);
                  })
                  .catch((error) => {
                    console.error("Error al obtener los datos:", error);
                    monto.value = '0.00'
                  });

                if (data.codigo === 'M-40') {
                  Swal.fire({
                    title: 'Ingrese los meses que no revalidó la licencia',
                    input: 'text',
                    inputAttributes: {
                      placeholder: '0.00',
                      maxlength: 3,  // Limitar a 3 caracteres
                      min: 0,
                      max: 999,
                      step: 1
                    },
                    inputPlaceholder: 'Meses (0-999)',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar',
                    preConfirm: (value) => {
                      // Verificar que el valor sea un número entero positivo dentro del rango y con máximo 3 caracteres
                      if (value === "" || isNaN(value) || value < 0 || value > 999 || !Number.isInteger(Number(value)) || value.length > 3) {
                        Swal.showValidationMessage('Por favor ingresa un número válido entre 0 y 999 (máximo 3 caracteres).');
                        return false;
                      }
                      return value; // Retorna el valor si es válido
                    }
                  }).then((result) => {
                    if (result.isConfirmed) {
                      const costoPorMes = 50;
                      const meses = parseInt(result.value); // Asegurarse de que sea un número entero
                      const montoActual = parseFloat(document.getElementById("monto").value) || 0; // Obtener el valor de 'monto'
                      const montoTotal = meses * costoPorMes;
                      const montoFinal = montoTotal + montoActual;

                      monto.value = montoFinal.toFixed(2);;
                    }
                  });
                }
              }
            });
          } else if (sancionValues.length === 1) {
            // Asignar directamente si solo hay un porcentaje
            const sancion_uit = document.getElementById("sancion_uit");
            sancion_uit.value = `${sancionValues[0].trim()}%`;
            sancion_uit.dispatchEvent(new Event("input"));
            Swal.fire(
              "Porcentaje asignado",
              `Se asignó automáticamente ${sancionValues[0].trim()}% (UIT)`,
              "info"
            );
            obtener_uit()
              .then((data) => {
                const valorCalculado = (sancionValues[0].trim() / 100) * data.valor;
                monto.value = valorCalculado.toFixed(2);
              })
              .catch((error) => {
                console.error("Error al obtener los datos:", error);
                monto.value = '0.00'
              });
          }
        }
      })
      .catch((error) => {
        console.error("Error en la solicitud:", error);
        Swal.fire("Error", "Hubo un problema al consultar los datos.", "error");
      });
  }
}

function validarFormulario(parte) {
  const campos = document.querySelectorAll(`#${parte} [required]`);
  for (const campo of campos) {
    if (!campo.checkValidity()) {
      campo.reportValidity();
      return false;
    }
  }
  stepper.next();
}

function guardar_formulario() {
  const campos = document.querySelectorAll("#infraccion-part [required]");
  for (const campo of campos) {
    if (!campo.checkValidity()) {
      campo.reportValidity();
      return false;
    }
  }
  var formData = new FormData();
  const camposFormulario = [
    "txtvisto",
    "numpapeleta",
    "numplaca",
    "fecha_incio",
    "select_tipodoc_infractor",
    "infdni",
    "infapellidopat",
    "infapellidomat",
    "infnombre",
    "infdomicilio",
    "infdomicilio_papeleta",
    "select_tipodoc_solidario",
    "soldni",
    "solapellidopat",
    "solapellidomat",
    "solnombre",
    "razon_social",
    "soldomicilio",
    "soldomicilio_segundo",
    "select_tipoinf",
    "sancion_uit",
    "evaluacion",
    "n_vez",
    "monto",
    "pe_idx"
  ];
  for (const campo of camposFormulario) {
    formData.append(campo, $(`#${campo}`).val());
  }

  $.ajax({
    url: "../../../controller/form_papeleta.php?op=insertar_papeleta",
    type: "POST",
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {
      try {
        const respuesta = JSON.parse(data);
        console.log(respuesta);
        if (respuesta.status === "success") {
          Swal.fire({
            icon: "success",
            title: "Exitoso!",
            text: respuesta.message,
            showConfirmButton: true
          });
          cerrar_modal();
          $("#ul_registros_papeleta").DataTable().ajax.reload(null, false);
          $("#modal-lg").modal("hide");
        } else {
          Swal.fire({
            icon: "error",
            title: "¡Algo salió mal!",
            text: respuesta.message,
            showConfirmButton: true
          });
        }
      } catch (e) {
        Swal.fire({
          icon: "error",
          title: "¡Algo salió mal!",
          text: "Ocurrió un error al procesar la respuesta del servidor.",
          showConfirmButton: true
        });
      }
    },
    error: function (xhr, status, error) {
      console.error("Error al enviar el formulario:", error);
      alert("Error al enviar los datos. Por favor, intente nuevamente.");
    }
  });
}

function listar() {
  $("#ul_registros_papeleta").show();
  $("#ul_registros_papeleta").DataTable().destroy();
  let table = $("#ul_registros_papeleta").DataTable({
    responsive: true,
    autoWidth: false,
    lengthChange: false,
    dom: '<"row"<"col-md-6"l><"col-md-6 d-flex justify-content-end align-items-center"fB>>tip',
    buttons: [
      { extend: "excel", text: "Excel" },
      { extend: "pdf", text: "PDF" },
      { extend: "print", text: "Imprimir" }
    ],
    ajax: {
      url: "../../../controller/form_papeleta.php?op=listar_papeleta",
      type: "post",
      data: function (d) {
        d.pe_rolx = $("#pe_rolx").val();
      }
    },
    bDestroy: true,
    responsive: true,
    bInfo: true,
    iDisplayLength: 5,
    order: [[1, "asc"]],
    searching: true,
    columnDefs: [{ orderable: false, targets: [1] }],
    columns: [
      { width: "3%" },
      { width: "3%" },
      {
        width: "3%",
        render: function (data, type, row) {
          return (
            '<div style="width: 90%; text-align: justify; white-space: pre-wrap;">' +
            data +
            "</div>"
          );
        }
      },
      { width: "2%" },
      {
        width: "10%",
        render: function (data, type, row) {
          return (
            '<div style="width: 90%; text-align: justify; white-space: pre-wrap;">' +
            data +
            "</div>"
          );
        }
      },
      {
        width: "5%",
        render: function (data, type, row) {
          return (
            '<div style="width: 90%; text-align: justify; white-space: pre-wrap;">' +
            data +
            "</div>"
          );
        }
      },
      { width: "3%" },
      { width: "3%" },
      { width: "3%" }
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
    }
  });
  table
    .buttons()
    .container()
    .appendTo("#ul_registros_papeleta_wrapper .col-md-6:eq(0)");
}

function limpiar(opcion) {
  const campos = {
    infractor: [
      "#infapellidopat",
      "#infapellidomat",
      "#infnombre",
      "#infdomicilio",
      "#infdomicilio_papeleta"
    ],
    solidario: [
      "#solapellidopat",
      "#solapellidomat",
      "#solnombre",
      "#razon_social",
      "#soldomicilio",
      "#soldomicilio_segundo"
    ]
  };
  (campos[opcion] || []).forEach((selector) => $(selector).val(""));
}

function mostrarSpinner(opcion) {
  $("#spinner-ciud").removeClass("fa fa-spinner fa-spin");
  $("#" + opcion + "_mensaje")
    .text("Buscando...")
    .css("color", "green")
    .hide();
  $("#spinner-ciud").remove();
}

$("#close_modal").click(function () {
  $(
    "#txtvisto, #numpapeleta, #numplaca, #fecha_incio, #infdni, #infapellidopat, #infapellidomat, #infnombre, #infdomicilio, #infdomicilio_papeleta, #soldni, #solapellidopat, #solapellidomat, #solnombre, #soldomicilio, #soldomicilio_segundo, #razon_social, #evaluacion, #n_vez, #sancion_uit, #monto"
  ).val("");
  $("#select_tipodoc_infractor, #select_tipodoc_solidario, #select_tipoinf")
    .val("")
    .trigger("change");
  $("#infractor_mensaje").hide();
  $("#solidario_mensaje").hide();
  $("#fecha_incio").datetimepicker("clear");
  stepper.reset();
});

function cerrar_modal() {
  $(
    "#txtvisto, #numpapeleta, #numplaca, #fecha_incio, #infdni, #infapellidopat, #infapellidomat, #infnombre, #infdomicilio, #infdomicilio_papeleta, #soldni, #solapellidopat, #solapellidomat, #solnombre, #soldomicilio, #soldomicilio_segundo, #razon_social, #evaluacion, #n_vez, #sancion_uit, #monto"
  ).val("");
  $("#select_tipodoc_infractor, #select_tipodoc_solidario, #select_tipoinf")
    .val("")
    .trigger("change");
  $("#infractor_mensaje").hide();
  $("#solidario_mensaje").hide();
  $("#fecha_incio").datetimepicker("clear");
  stepper.reset();
}
