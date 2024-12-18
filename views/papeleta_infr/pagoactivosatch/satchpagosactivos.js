var datos = [];

$(document).ready(function () {
    listarpapeleta(datos);
});

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

function validarFormulario(event) {
    event.preventDefault(); // Evita que el formulario se envíe si no es válido
    const campos = document.querySelectorAll("#buscar_papeleta, #buscar_placa"); // Selecciona los dos campos de búsqueda
    let esValido = true;

    campos.forEach((campo) => {
        if (!campo.checkValidity()) {
            campo.reportValidity();
            esValido = false;
            $("#mensaje_buscar").hide();
        }
    });

    if (esValido) {
        var placa = $("#buscar_placa").val();
        var papeleta = $("#buscar_papeleta").val();
        var spinner = $("<i>")
            .addClass("fa fa-spinner fa-spin")
            .attr("id", "spinner");
        $("#mensaje_buscar")
            .text("Buscando...")
            .css("color", "grey")
            .show()
            .append(spinner)
            .show();
        $.get(
            "../../../controller/api_consulta_papeleta_transito_satch.php",
            { nropap: papeleta, placa: placa },
            function (data) {
                if (
                    data.status &&
                    data.message === "Datos encontrados exitosamente." &&
                    data.data.length > 0
                ) {
                    listarpapeleta(data.data);
                    $("#mensaje_buscar")
                        .text("papeleta encontrada")
                        .css("color", "green")
                        .show();
                    $("#spinner").removeClass("fa fa-spinner fa-spin");
                } else {
                    //listarVehiculos(data.data);
                    $("#mensaje_buscar")
                        .text("papeleta no encontrada")
                        .css("color", "red")
                        .show();
                    $("#spinner").removeClass("fa fa-spinner fa-spin");
                }
            }
        ).fail(function () {
            $("#mensaje_buscar").hide();
            alert("Error al conectarse al servicio.");
        });
    }
}

function listarpapeleta(data) {
    $("#ul_visualizacion_infraccion").show();
    $("#ul_visualizacion_infraccion").DataTable().destroy();
    $("#ul_visualizacion_infraccion").DataTable({
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
                data: "placa",
                render: function (data, type, row) {
                    return (
                        '<div style="max-width: 100%; text-align: justify; white-space: pre-wrap;">' +
                        row.placa +
                        "</div>"
                    );
                }
            },
            { width: "3%", data: "tipo" },
            {
                width: "3%",
                data: "nro_papeleta",
                render: function (data, type, row) {
                    return (
                        '<div style="max-width: 100%; text-align: justify; white-space: pre-wrap;">' +
                        row.nro_papeleta +
                        "</div>"
                    );
                }
            },
            {
                width: "10%",
                data: "fecimp",
                render: function (data, type, row) {
                    return (
                        '<div style="max-width: 100%; text-align: justify;">' +
                        row.fecimp +
                        "</div>"
                    );
                }
            },
            {
                width: "10%",
                data: "infrac",
                render: function (data, type, row) {
                    return (
                        '<div style="max-width: 100%; text-align: justify;">' +
                        row.infrac +
                        "</div>"
                    );
                }
            },
            {
                width: "15%",
                data: "deuda_total",
                render: function (data, type, row) {
                    // Aplicar estilo de justificación
                    return (
                        '<div style="max-width: 100%; text-align: justify; white-space: pre-wrap;">' +
                        row.deuda_total +
                        "</div>"
                    );
                }
            },
            {
                width: "5%",
                data: "desc",
                render: function (data, type, row) {
                    return (
                        '<div style="max-width: 100%; text-align: justify; white-space: pre-wrap;">' +
                        row.desc +
                        "</div>"
                    );
                }
            },
            { width: "3%", data: "deuda_pagar" },
            {
                width: "5%",
                data: null,
                render: function (data, type, row) {
                    // Convertir el objeto 'det' en una cadena JSON para pasarlo como parámetro
                    var detalle = JSON.stringify(row.det).replace(/'/g, "\\'").replace(/"/g, '&quot;');
                    return (
                        '<button class="btn btn-info btn-sm" onclick="visualizarDetalles(\'' +
                        row.nro_papeleta + '\', \'' + detalle + '\', \'' + row.fecimp + '\', \'' + row.infrac + '\')"><i class="fa fa-eye"></i></button>'
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
            $("#lbltotal_infracciones").html(total);
        }
    });
}
function visualizarDetalles(nro_papeleta, detalle, fechaimp, infrac) {
    $("#lbltitulo_modaldetalle").html("Detalle Papeleta Tránsito:  " + nro_papeleta + " - " + fechaimp + " - '" + infrac + "'");
    $("#modaldetalle").modal("show");
    var det = JSON.parse(detalle.replace(/&quot;/g, '"'));
    listardetalle(det);
}
function listardetalle(data) {
    $("#ul_visualizacion_detalle").show();
    $("#ul_visualizacion_detalle").DataTable().destroy();
    $("#ul_visualizacion_detalle").DataTable({
        responsive: true,
        autoWidth: false,
        lengthChange: false,
        buttons: [],
        data: data,
        bDestroy: true,
        responsive: true,
        bInfo: true,
        iDisplayLength: 5,
        columns: [
            { width: "15%", 
                data: "tributo",
                render: function (data, type, row) {
                    return data ? data : '-';
                } 
            },
            { width: "20%", data: "infractor", 
                render: function (data, type, row) {
                    return data ? data : '-';
                }
            },
            { width: "20%", data: "propietario", 
                render: function (data, type, row) {
                    return data ? data : '-';
                }
            },
            { width: "20%", data: "rs", 
                render: function (data, type, row) {
                    return data ? data : '-';
                }
            },
            { width: "20%", data: "rir", 
                render: function (data, type, row) {
                    return data ? data : '-';
                }
            },
            { width: "20%", data: "exp_rs", 
                render: function (data, type, row) {
                    return data ? data : '-';
                }
            },
            { width: "20%", data: "exp_rir", 
                render: function (data, type, row) {
                    return data ? data : '-';
                }
            },
            { width: "20%", data: "insoluto", 
                render: function (data, type, row) {
                    return data ? data : '-';
                }
            },
            { width: "20%", data: "gastos", 
                render: function (data, type, row) {
                    return data ? data : '-';
                }
            },
            { width: "10%", data: "total_deuda", 
                render: function (data, type, row) {
                    return data ? data : '-';
                }
            },
            { width: "10%", data: "desc", 
                render: function (data, type, row) {
                    return data ? data : '-';
                }
            },
            { width: "10%", data: "total_pagar", 
                render: function (data, type, row) {
                    return data ? data : '-';
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
            sSearch: "Buscar:",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Último",
                sNext: "Siguiente",
                sPrevious: "Anterior"
            }
        }
    });
}
