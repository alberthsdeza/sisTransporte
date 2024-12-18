$(document).ready(function () {
    listar();
});

$("#Nuevo").click(function () {
    $("#lbltitulo_modalRNT").html("Registrar infracciones del RNT");
    $("#modalRNT").modal("show");
    $(
        "#select_norma, #select_tipoinf"
    ).select2({
        dropdownParent: $("#modalRNT")
    });
    listar_norma();
    listar_calinfraccion();
});

function formatearInfraccion(input) {
    let valor = input.value.replace(/[^a-zA-Z0-9]/g, "");

    if (valor.length > 1 && valor[1] !== "-") {
        valor = valor[0] + "-" + valor.slice(1);
    }

    const regex = /^[A-Za-z]-?\d*[A-Za-z]?$/;
    if (regex.test(valor)) {
        input.value = valor;
    } else {
        input.value = valor.slice(0, -1);
    }
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
    }, 900);
}

function Puntos(input) {
    let valor = input.value.replace(/\D/g, "");
    if (valor !== "") {
        valor = parseInt(valor); // Convierte a entero
        valor = Math.min(100, Math.max(0, valor));
    }
    input.value = valor !== "" ? valor : "";
}

function listar_norma() {
    $.ajax({
        url: "../../../controller/norma.php?op=listar_norma",
        method: "POST",
        data: {},
        success: function (data) {
            var llenar_selectnorma = JSON.parse(data);
            var select_norma = $("#select_norma");
            select_norma.empty();
            select_norma.append('<option label="Seleccionar norma"></option>');

            select_norma.val(select_norma.find("option:first").val());

            if (llenar_selectnorma.aaData && llenar_selectnorma.aaData.length > 0) {
                llenar_selectnorma.aaData.forEach(function (item) {
                    select_norma.append(
                        '<option value="' + item[0] + '">' + item[1] + "</option>"
                    );
                });
            }
        }
    });
}

function listar_calinfraccion() {
    $.ajax({
        url: "../../../controller/calificacion_infraccion.php?op=listar_califinfraccion",
        method: "POST",
        data: {},
        success: function (data) {
            var llenar_selectcalinfraccion = JSON.parse(data);
            var select_calinf = $("#select_tipoinf");
            select_calinf.empty();
            select_calinf.append('<option label="Seleccionar norma"></option>');

            select_calinf.val(select_calinf.find("option:first").val());

            if (
                llenar_selectcalinfraccion.aaData &&
                llenar_selectcalinfraccion.aaData.length > 0
            ) {
                llenar_selectcalinfraccion.aaData.forEach(function (item) {
                    select_calinf.append(
                        '<option value="' + item[0] + '">' + item[1] + "</option>"
                    );
                });
            }
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
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

function validateInf(input) {
    document
        .getElementById("modalRNT_guardar")
        .setAttribute("disabled", "disabled");
}

$(document).on("blur", "#infraccion", function () {
    let valor = $("#infraccion").val();
    if (valor) {
        if ($("#infraccion").val().length > 3) {
            var spinner = $("<i>")
                .addClass("fa fa-spinner fa-spin")
                .attr("id", "spinner");
            $("#verificar_ingresoinfraccion")
                .text("Verificando...")
                .css("color", "grey")
                .show()
                .append(spinner)
                .show();
            $.ajax({
                url: "../../../controller/rnt.php?op=verificar_codigo_infraccion",
                method: "POST",
                data: {
                    codigo_infraccion: valor
                },
                success: function (data) {
                    var response = JSON.parse(data);
                    if (response.mensaje != "Operación exitosa") {
                        $("#verificar_ingresoinfraccion")
                            .text("Código nuevo")
                            .css("color", "green")
                            .show();
                        document
                            .getElementById("modalRNT_guardar")
                            .removeAttribute("disabled");
                    } else {
                        $("#verificar_ingresoinfraccion")
                            .text("Código registrado")
                            .css("color", "red")
                            .show();
                    }
                    $("#spinner").removeClass("fa fa-spinner fa-spin");
                }
            });
        } else {
            $("#verificar_ingresoinfraccion")
                .text("Falta datos ej.:(M-01)")
                .css("color", "grey")
                .show();
        }
    } else {
        $("#spinner").removeClass("fa fa-spinner fa-spin");
        $("#verificar_ingresoinfraccion").css("display", "none");
    }
});

$("#modalRNT_guardar").click(function () {
    var norma_decreto = $("#select_norma").parsley();
    var tipo_inf = $("#select_tipoinf").parsley();
    var descripcion = $("#descripcion").parsley();
    var sancion = $("#sancion_uit").parsley();
    var puntos = $("#puntos").parsley();

    $("#select_norma").on("change", function () {
        norma_decreto.reset();
    });
    $("#select_tipoinf").on("change", function () {
        tipo_inf.reset();
    });

    if (
        norma_decreto.isValid() &&
        tipo_inf.isValid() &&
        descripcion.isValid() &&
        sancion.isValid() &&
        puntos.isValid()
    ) {
        var formData = new FormData();
        formData.append("norma_decreto", $("#select_norma").val());
        formData.append("calificacion_inf", $("#select_tipoinf").val());
        formData.append("codigo_inf", $("#infraccion").val());
        formData.append(
            "rnt_descripcion",
            $("#descripcion").val().trim().replace(/\s+/g, " ").toUpperCase()
        );
        formData.append("usua", $("#pe_idx").val());
        formData.append(
            "usua_nombre",
            $("#pe_nomx").val().trim().replace(/\s+/g, " ").toUpperCase()
        );
        formData.append(
            "rnt_observacion",
            $("#observacion").val().trim().replace(/\s+/g, " ").toUpperCase()
        );
        formData.append("rntd_sancion", $("#sancion_uit").val());
        formData.append("rntd_puntos", $("#puntos").val());
        formData.append(
            "rntd_medida_preventiva",
            $("#med_prev").val().trim().replace(/\s+/g, " ").toUpperCase()
        );
        formData.append("rntd_retencion_lic", $("#switch_retencionlic").val());
        formData.append("rntd_descuento", $("#switch_descuento").val());
        formData.append("rnt_dosaje_etilico", $("#switch_dosaje_etilico").val());
        formData.append("rntd_monto_x_mes_venc", $("#monto").val());
        formData.append("rntd_respo_solidaria", $("#switch_resp_solidaria").val());
        $("#spinner-container").removeClass("d-none");
        $.ajax({
            url: "../../../controller/rnt.php?op=insertar_rnt",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                $("#spinner-container").addClass("d-none");
                $("#registrar_rnt")[0].reset();
                cerrar_modal();
                $("#ul_registros_rnt").DataTable().ajax.reload(null, false);
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    } else {
        norma_decreto.validate();
        tipo_inf.validate();
        descripcion.validate();
        sancion.validate();
        puntos.validate();
    }
});

function cerrar_modal() {
    $("#select_norma").val(null).change();
    $("#select_tipoinf").val(null).change();
    document.getElementById("infraccion").value = "";
    document.getElementById("descripcion").value = "";
    document.getElementById("observacion").value = "";
    document.getElementById("sancion_uit").value = "";
    document.getElementById("puntos").value = "";
    document.getElementById("med_prev").value = "";
    document.getElementById("switch_retencionlic").value = "N";
    document.getElementById("switch_descuento").value = "N";
    document.getElementById("switch_resp_solidaria").value = "N";
    document.getElementById("switch_dosaje_etilico").value = "N";
    document.getElementById("monto").value = "";
    $("#verificar_ingresoinfraccion").css("display", "none");
    document
        .getElementById("modalRNT_guardar")
        .setAttribute("disabled", "disabled");
    resetear_parsley();
    $("#modalRNT").modal("hide");
}

$("#Close_rnt_x").click(function () {
    $("#select_norma").val(null).change();
    $("#select_tipoinf").val(null).change();
    document.getElementById("infraccion").value = "";
    document.getElementById("descripcion").value = "";
    document.getElementById("observacion").value = "";
    document.getElementById("sancion_uit").value = "";
    document.getElementById("puntos").value = "";
    document.getElementById("med_prev").value = "";
    document.getElementById("switch_retencionlic").value = "N";
    document.getElementById("switch_descuento").value = "N";
    document.getElementById("switch_resp_solidaria").value = "N";
    document.getElementById("switch_dosaje_etilico").value = "N";
    $("#switch_retencionlic").prop("checked", false);
    $("#switch_descuento").prop("checked", false);
    $("#switch_resp_solidaria").prop("checked", false);
    $("#switch_dosaje_etilico").prop("checked", false);
    document.getElementById("monto").value = "";
    $("#verificar_ingresoinfraccion").css("display", "none");
    document
        .getElementById("modalRNT_guardar")
        .setAttribute("disabled", "disabled");
    resetear_parsley();
});

$("#modalRNT_cerrar").click(function () {
    $("#select_norma").val(null).change();
    $("#select_tipoinf").val(null).change();
    document.getElementById("infraccion").value = "";
    document.getElementById("descripcion").value = "";
    document.getElementById("observacion").value = "";
    document.getElementById("sancion_uit").value = "";
    document.getElementById("puntos").value = "";
    document.getElementById("med_prev").value = "";
    document.getElementById("switch_retencionlic").value = "N";
    document.getElementById("switch_descuento").value = "N";
    document.getElementById("switch_resp_solidaria").value = "N";
    document.getElementById("switch_dosaje_etilico").value = "N";
    $("#switch_retencionlic").prop("checked", false);
    $("#switch_descuento").prop("checked", false);
    $("#switch_resp_solidaria").prop("checked", false);
    $("#switch_dosaje_etilico").prop("checked", false);
    document.getElementById("monto").value = "";
    $("#verificar_ingresoinfraccion").css("display", "none");
    document
        .getElementById("modalRNT_guardar")
        .setAttribute("disabled", "disabled");
    resetear_parsley();
});

function resetear_parsley() {
    $("#select_norma").parsley().reset();
    $("#select_tipoinf").parsley().reset();
    $("#infraccion").parsley().reset();
    $("#descripcion").parsley().reset();
    $("#sancion_uit").parsley().reset();
    $("#puntos").parsley().reset();
}

$("#switch_retencionlic").change(function () {
    // Verifica si el checkbox está marcado
    if ($(this).is(":checked")) {
        switch_retencionlic.value = "S"; // Texto cuando el checkbox está marcado
    } else {
        switch_retencionlic.value = "N"; // Texto cuando el checkbox no está marcado
    }
});

$("#switch_descuento").change(function () {
    // Verifica si el checkbox está marcado
    if ($(this).is(":checked")) {
        switch_descuento.value = "S"; // Texto cuando el checkbox está marcado
    } else {
        switch_descuento.value = "N"; // Texto cuando el checkbox no está marcado
    }
});

$("#switch_resp_solidaria").change(function () {
    // Verifica si el checkbox está marcado
    if ($(this).is(":checked")) {
        switch_resp_solidaria.value = "S"; // Texto cuando el checkbox está marcado
    } else {
        switch_resp_solidaria.value = "N"; // Texto cuando el checkbox no está marcado
    }
});

$("#switch_dosaje_etilico").change(function () {
    // Verifica si el checkbox está marcado
    if ($(this).is(":checked")) {
        switch_dosaje_etilico.value = "S"; // Texto cuando el checkbox está marcado
    } else {
        switch_dosaje_etilico.value = "N"; // Texto cuando el checkbox no está marcado
    }
});

function listar() {
    $("#ul_registros_rnt").show();
    $("#ul_registros_rnt").DataTable().destroy();
    let table = $("#ul_registros_rnt").DataTable({
        responsive: true,
        autoWidth: false,
        lengthChange: false,
        dom: '<"row"<"col-md-6"l><"col-md-6 d-flex justify-content-end align-items-center"fB>>tip',
        buttons: [
            { extend: "excel", text: "Excel" },
            { extend: "pdf", text: "PDF" },
            { extend: "print", text: "Imprimir" },
        ],
        ajax: {
            url: "../../../controller/rnt.php?op=listar_rnt",
            type: "post"
        },
        bDestroy: true,
        responsive: true,
        bInfo: true,
        iDisplayLength: 5,
        order: [[1, "asc"]],
        searching: true,
        columnDefs: [
            { "orderable": false, "targets": [6] } // Cambia el índice [0] por el índice de la columna deseada
        ],
        columns: [
            { width: "3%" },
            { width: "3%" },
            {
                width: "20%",
                render: function (data, type, row) {
                    return (
                        '<div style="width: 90%; text-align: justify; white-space: pre-wrap;">' +
                        data +
                        "</div>"
                    );
                }
            },
            {
                width: "20%",
                render: function (data, type, row) {
                    return (
                        '<div style="width: 90%; text-align: justify; white-space: pre-wrap;">' +
                        data +
                        "</div>"
                    );
                }
            },
            { width: "2%" },
            { width: "2%" },
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
    table.buttons().container().appendTo('#ul_registros_rnt_wrapper .col-md-6:eq(0)');

}

function truncateText(text, maxLength = 50) {
    if (text.length > maxLength) {
        return text.substring(0, maxLength) + "...";
    } else {
        return text;
    }
}
