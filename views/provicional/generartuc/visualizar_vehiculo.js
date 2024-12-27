var temp_storage;
function nuevo() {
  buscaPlaca();
}

function buscaPlaca() {
  var numplaca = $("#num_placa").val();
  if ($("#num_placa").val().length >= 6) {
    $.post(
      "../../../controller/api_consulta_datos_antvehiculo.php",
      { numplaca: numplaca },
      function (data) {
        var response = JSON.parse(data);
        if (
          response.success &&
          response.message === "Consulta realizada correctamente" &&
          response.data.length > 0
        ) {
          temp_storage = response;
          $("#csit").text(response.data[0].codsit);
          $("#n_placa").text(response.data[0].placa);
          $("#n_motor").text(response.data[0].nummotor);
          $("#f_proc").text(response.data[0].fechaproceso);
          $("#f_emi").text(response.data[0].fechainicio);
          $("#f_caduc").text(response.data[0].fechatermino);
          $("#n_serie").text(response.data[0].num_serie);
          $("#marca").text(response.data[0].marca);
          $("#clase").text(response.data[0].clase);
          $("#tuc").text(response.data[0].nrotarjeta);
          $("#mensaje_vehiculo")
            .text("Validación exitosa")
            .css("color", "green")
            .show();
          $("#spinner").removeClass("fa fa-spinner fa-spin");
          $.post(
            "../../../controller/vehiculo_adicional.php?op=verificar_placa_vehiculo",
            { numplaca: numplaca },
            function (data1) {
              var response_adicional = JSON.parse(data1);
              console.log(response_adicional)
              Object.assign(temp_storage.data[0], response_adicional);
              if (
                response_adicional.mensaje ===
                "Operación exitosa" && response_adicional !== ""
              ) {
                $("#soat").text(response_adicional.soat);
                $("#rev_tec").text(response_adicional.reviciontec);
                $("#responsable").text(response_adicional.responsable);
                document.getElementById("modificar").onclick = function () {
                  ModificarInf();
                };
                document.getElementById("modificar").disabled = false;
                document.getElementById("modificar").innerText = "Modificar información";
              } else {
                document.getElementById("modificar").disabled = false;
                document.getElementById("modificar").onclick = function () {
                  AccionInf();
                };
                $("#soat").text("");
                $("#rev_tec").text("");
                $("#responsable").text("");
                document.getElementById("modificar").innerText = "Agregar información";
              }
              $.post(
                "../../../controller/vehiculo_adicional.php?op=verificar_tuc_contador",
                { numplaca: numplaca },
                function (data2) {
                  var response_adicional1 = JSON.parse(data2);
                  if (
                    response_adicional1.mensaje ===
                    "Operación exitosa" && response_adicional1 !== ""
                  ) {
                    $("#primera").text(response_adicional1.primeraimpresion);
                    $("#duplicado").text(response_adicional1.duplicado);
                  }else{
                    $("#primera").text("0");
                    $("#duplicado").text("0");
                  }
                  
                }
              ).fail(function () { });
            }
          ).fail(function () { });
        } else {
          limpiarDatos();
          $("#mensaje_vehiculo")
            .text("Verificar datos")
            .css("color", "red")
            .show();
          $("#spinner").removeClass("fa fa-spinner fa-spin");
        }
      }
    ).fail(function () {
      limpiarDatos();
      $("#mensaje_vehiculo").hide();
    });
    //agregamos
  } else {
    limpiarDatos();
    $("#mensaje_vehiculo")
      .text("Ingrese la placa correcta")
      .css("color", "red")
      .show();
    $("#spinner").removeClass("fa fa-spinner fa-spin");
  }
}

function limpiarDatos() {
  $("#csit").text("");
  $("#n_placa").text("");
  $("#n_motor").text("");
  $("#f_proc").text("");
  $("#f_emi").text("");
  $("#f_caduc").text("");
  $("#n_serie").text("");
  $("#marca").text("");
  $("#clase").text("");
  $("#tuc").text("");
  $("#soat").text("");
  $("#rev_tec").text("");
  $("#primera").text("");
  $("#duplicado").text("");
  $("#responsable").text("");
  document.getElementById("modificar").disabled = true;
}

function ImprimirTUC() {
  var v_codsit = $("#csit").text();
  var v_numplaca = $("#n_placa").text();
  if (v_codsit && v_numplaca) {
    Swal.fire({
      title: "IMPRIMIR TUC",
      text: "¿Quieres imprimir TUC del vehículo con placa: " + v_numplaca + " ?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Sí, generar!",
      cancelButtonText: "No, cancelar"
    }).then(result => {
      if (result.isConfirmed) {
        Procesar_tuc(v_codsit, v_numplaca);
        Swal.fire({
          title: 'Impresión de TUC',
          text: '¿La impresión del TUC se realizó correctamente?',
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Si',
          cancelButtonText: 'Cancelar',
          allowOutsideClick: false,  
          allowEscapeKey: false,     
          allowEnterKey: false       
        }).then((result) => {
          if (result.isConfirmed) {
            $.post(
              "../../../controller/vehiculo_adicional.php?op=verificar_tuc_contador",
              { numplaca: v_numplaca },
              function (data) {
                var response_tuc = JSON.parse(data);
                var formData = new FormData();
                formData.append("placa", String(temp_storage.data[0].placa).trim());
                formData.append("tuc", String(temp_storage.data[0].nrotarjeta).trim());
                formData.append("usua_id", $("#pe_idx").val());
                formData.append("duplicado", response_tuc.duplicado ? response_tuc.duplicado : 0);
        
                // Ejecutar la llamada AJAX
                $.ajax({
                  url: "../../../controller/vehiculo_adicional.php?op=contador_tuc_impresion", // URL para modificar
                  type: "POST",
                  data: formData,
                  processData: false,
                  contentType: false,
                  success: function (data) {
                    Swal.fire({
                      title: "Proceso correcto!",
                      text: "El proceso se realizó correctamente!",
                      icon: "success"
                    });
                    buscaPlaca();
                  },
                  error: function (xhr, status, error) {
                    console.log(error);
                  }
                });
              }
            ).fail(function () {
              console.error("Error en la verificación del contador TUC.");
            });
          }
        });
        
      }
    });
  } else {
    Swal.fire({
      icon: "error",
      title: "Oops...",
      text: "Por favor realice la busqueda de la placa!",
    });
  }

}

function Procesar_tuc(codsit, placa) {
  // Corrige la comparación aquí
  if (
    String(codsit).trim() === String(temp_storage.data[0].codsit).trim() &&
    String(placa).trim() === String(temp_storage.data[0].placa).trim()
  ) {
    var form = document.createElement("form");
    form.method = "POST"; // Asegúrate de que sea POST
    form.action = "../../../controller/visualizar_tuc_vehiculo.php";
    form.target = "_blank"; // Abre el formulario en una nueva pestaña

    // Crear input para 'codsit'
    var codsitInput = document.createElement("input");
    codsitInput.type = "hidden";
    codsitInput.name = "codsit";
    codsitInput.value = codsit;
    form.appendChild(codsitInput);

    // Crear input para 'placa'
    var placaInput = document.createElement("input");
    placaInput.type = "hidden";
    placaInput.name = "placa";
    placaInput.value = placa;
    form.appendChild(placaInput);

    // Crear input para el JSON de temp_storage
    var tempStorageInput = document.createElement("input");
    tempStorageInput.type = "hidden";
    tempStorageInput.name = "temp_storage"; // Nombre del input
    tempStorageInput.value = JSON.stringify(temp_storage); // Convertir a JSON
    form.appendChild(tempStorageInput);

    // Añadir el formulario al cuerpo y enviarlo
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
  }
}

function AccionInf() {
  Swal.fire({
    title: "Agregar información adicional",
    html: `
        <h5>Ingresar solo la fecha de vencimiento</h5>
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
            <div class="form-group">
              <label class="form-control-label">SOAT:</label>
              <input class="form-control" type="date" id="soat_fecha" name="soat_fecha">
            </div>
          </div>
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
            <div class="form-group">
                <label class="form-control-label">Revisión Téc.:</label>
                <input class="form-control" type="date" id="fecha_revtec" name="fecha_revtec">
            </div>
          </div>
      </div>
    `,
    focusConfirm: false,
    showCancelButton: true,
    confirmButtonText: "Guardar",
    preConfirm: () => {
      const fechaSoat = document.getElementById("soat_fecha").value;
      const fechaRevision = document.getElementById("fecha_revtec").value;

      return { fechaSoat, fechaRevision };
    }
  }).then(result => {
    if (result.isConfirmed) {
      var formData = new FormData();
      formData.append("placa", String(temp_storage.data[0].placa).trim());
      formData.append("soat_fecha", result.value.fechaSoat);
      formData.append("fecha_revtec", result.value.fechaRevision);
      formData.append("usua", $("#pe_idx").val());
      $.ajax({
        url: "../../../controller/vehiculo_adicional.php?op=insertar_soatrevtec_vehiculo",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (data) {
          //$("#spinner-container").addClass("d-none");
          Swal.fire({
            title: "Registro correcto!",
            text: "Se registro correctamente los datos adicionales!",
            icon: "success"
          });
          buscaPlaca();
        },
        error: function (xhr, status, error) {
          console.log(error);
        }
      });
    }
  });
}


function ModificarInf() {
  const fechaSoatActual = temp_storage.data[0].soat;
  const fechaRevisionActual = temp_storage.data[0].reviciontec;
  Swal.fire({
    title: "Modificar información adicional",
    html: `
        <h5>Modificar solo la fecha de vencimiento</h5>
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
            <div class="form-group">
              <label class="form-control-label">SOAT:</label>
              <input class="form-control" type="date" id="soat_fecha" name="soat_fecha" value="${fechaSoatActual}">
            </div>
          </div>
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
            <div class="form-group">
                <label class="form-control-label">Revisión Téc.:</label>
                <input class="form-control" type="date" id="fecha_revtec" name="fecha_revtec" value="${fechaRevisionActual}">
            </div>
          </div>
      </div>
    `,
    focusConfirm: false,
    showCancelButton: true,
    confirmButtonText: "Modificar",
    preConfirm: () => {
      const fechaSoat = document.getElementById("soat_fecha").value;
      const fechaRevision = document.getElementById("fecha_revtec").value;

      return { fechaSoat, fechaRevision };
    }
  }).then(result => {
    if (result.isConfirmed) {
      var formData = new FormData();
      formData.append("placa", String(temp_storage.data[0].placa).trim());
      formData.append("soat_fecha", result.value.fechaSoat);
      formData.append("fecha_revtec", result.value.fechaRevision);
      formData.append("usua", $("#pe_idx").val());
      $.ajax({
        url: "../../../controller/vehiculo_adicional.php?op=modificar_soatrevtec_vehiculo",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (data) {
          Swal.fire({
            title: "Modificación correcto!",
            text: "Se actualizó correctamente los datos adicionales!",
            icon: "success"
          });
          buscaPlaca();
        },
        error: function (xhr, status, error) {
          console.log(error);
        }
      });
    }
  });
}