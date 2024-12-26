var actrnt;
var actrntd;

$(document).ready(function () {
    // Cargar datos en el modal antes de continuar
    listar_norma_modal_actualizar();
    listar_calinfraccion_modal_actualizar();
});

async function actualizar_rnt(id_, codigo) {
    $("#lbltitulo_modalRNT_actualizar").html(`Actualizar infracción del RNT seleccionado: ${codigo}`);
    $("#modalRNT_actualizar").modal("show");
    
    // Inicializar select2 con el dropdownParent
    $(
        "#select_norma_actualizar, #select_tipoinf_actualizar"
    ).select2({
        dropdownParent: $("#modalRNT_actualizar")
    });
    
    //await listar_norma_modal_actualizar();
    //await listar_calinfraccion_modal_actualizar();

    try {
        const data = await buscar_rnt_id(id_);

        if (data.mensaje === 'Operación exitosa') {
            actrnt = data.id_;
            $("#select_norma_actualizar").val(data.codigo_norma).trigger("change");
            $("#select_tipoinf_actualizar").val(data.codigo_calif).trigger("change");
            infraccion_actualizar.value = codigo;
            descripcion_actualizar.value = data.descripcion;
            observacion_actualizar.value = data.observacion;
            actrntd = data.id_de;
            sancion_uit_actualizar.value = data.sancion.replace(/{|}/g, "");
            sancion_uit_actualizar.dispatchEvent(new Event('input'));
            puntos_actualizar.value = data.puntos;
            med_prev_actualizar.value = data.medida_prev;
            switch_retencionlic_actualizar.checked = (data.retencion_lic === "S");
            switch_descuento_actualizar.checked = (data.descuento === "S");
            switch_dosaje_etilico_actualizar.checked = (data.dosaje_etilico === "S");
            switch_resp_solidaria_actualizar.checked = (data.responsable_solidaria === "S");
            monto_actualizar.value = data.monto_mes_venc;
        }
    } catch (error) {
        console.error("Error en la solicitud:", error);
    }
}


function Sancion_actualizar(input) {
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

function Puntos_actualizar(input) {
    let valor = input.value.replace(/\D/g, "");
    if (valor !== "") {
        valor = parseInt(valor); // Convierte a entero
        valor = Math.min(100, Math.max(0, valor));
    }
    input.value = valor !== "" ? valor : "";
}

function listar_norma_modal_actualizar() {
    $.ajax({
        url: "../../../controller/norma.php?op=listar_norma",
        method: "POST",
        data: {},
        success: function (data) {
            var llenar_selectnorma = JSON.parse(data);
            var select_norma = $("#select_norma_actualizar");
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

function listar_calinfraccion_modal_actualizar() {
    $.ajax({
        url: "../../../controller/calificacion_infraccion.php?op=listar_califinfraccion",
        method: "POST",
        data: {},
        success: function (data) {
            var llenar_selectcalinfraccion = JSON.parse(data);
            var select_calinf = $("#select_tipoinf_actualizar");
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

function buscar_rnt_id(id_) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: "../../../controller/rnt.php?op=obtener_rnt",
            method: "POST",
            data: { rntid: id_ },
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

$("#modalRNT_actualizar_editar").click(function () {
    var descripcion = $("#descripcion_actualizar").parsley();
    var sancion = $("#sancion_uit_actualizar").parsley();
    var puntos = $("#puntos_actualizar").parsley();

    if (
        descripcion.isValid() &&
        sancion.isValid() &&
        puntos.isValid()
    ) {
        Swal.fire({
            title: 'Advertencia',
            text: 'A continuación, deberá ingresar el motivo de cambio de datos. Cualquier cambio irregular será responsabilidad del trabajador que lo realiza.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Continuar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Ingrese el motivo',
                    input: 'text',
                    inputPlaceholder: 'Motivo del cambio de datos',
                    showCancelButton: true,
                    confirmButtonText: 'Enviar',
                    cancelButtonText: 'Cancelar',
                    inputValidator: (value) => {
                        if (!value) {
                            return 'Debe ingresar un motivo!';
                        }
                        const regex = /^[a-zA-Z0-9\s\.,-]*$/;
                        if (!regex.test(value)) {
                            return 'El motivo contiene caracteres no permitidos!';
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        let motivo = result.value;

                        var formData = new FormData();
                        formData.append("_id", actrnt);
                        formData.append("_iddetalle", actrnt);
                        formData.append(
                            "rnt_descripcion",
                            $("#descripcion_actualizar").val().trim().replace(/\s+/g, " ").toUpperCase()
                        );
                        formData.append("pers_id", $("#pe_idx").val());
                        formData.append(
                            "usua_nombre",
                            $("#pe_nomx").val().trim().replace(/\s+/g, " ").toUpperCase()
                        );
                        formData.append(
                            "rnt_observacion",
                            $("#observacion_actualizar").val().trim().replace(/\s+/g, " ").toUpperCase()
                        );
                        formData.append("rntd_sancion", $("#sancion_uit_actualizar").val());
                        formData.append("rntd_puntos", $("#puntos_actualizar").val());
                        formData.append(
                            "rntd_medida_preventiva",
                            $("#med_prev_actualizar").val().trim().replace(/\s+/g, " ").toUpperCase()
                        );
                        formData.append("rntd_retencion_lic", $("#switch_retencionlic_actualizar").val());
                        formData.append("rntd_descuento", $("#switch_descuento_actualizar").val());
                        formData.append("rnt_dosaje_etilico", $("#switch_dosaje_etilico_actualizar").val());
                        formData.append("rntd_monto_x_mes_venc", $("#monto_actualizar").val());
                        formData.append("rntd_respo_solidaria", $("#switch_resp_solidaria_actualizar").val());
                        formData.append("motivo", motivo);
                        $("#spinner-container").removeClass("d-none");
                        $.ajax({
                            url: "../../../controller/rnt.php?op=actualizar_rnt",
                            type: "POST",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (data) {
                                console.log('entro');
                                $("#spinner-container").addClass("d-none");
                                $("#actualizar_rnt")[0].reset();
                                cerrar_modal_actualizar();
                                $("#ul_registros_rnt").DataTable().ajax.reload(null, false);
                            },
                            error: function (xhr, status, error) {
                                console.log(error);
                            }
                        });
                    }
                });
            }
        });

    } else {
        descripcion.validate();
        sancion.validate();
        puntos.validate();
    }
});

function cerrar_modal_actualizar() {
    $("#select_norma").val(null).change();
    $("#select_tipoinf").val(null).change();
    document.getElementById("infraccion_actualizar").value = "";
    document.getElementById("descripcion_actualizar").value = "";
    document.getElementById("observacion_actualizar").value = "";
    document.getElementById("sancion_uit_actualizar").value = "";
    document.getElementById("puntos_actualizar").value = "";
    document.getElementById("med_prev_actualizar").value = "";
    document.getElementById("switch_retencionlic_actualizar").value = "N";
    document.getElementById("switch_descuento_actualizar").value = "N";
    document.getElementById("switch_resp_solidaria_actualizar").value = "N";
    document.getElementById("switch_dosaje_etilico_actualizar").value = "N";
    document.getElementById("monto_actualizar").value = "";
    resetear_parsley_actualizar();
    $("#modalRNT_actualizar").modal("hide");
}

function resetear_parsley_actualizar() {
    $("#select_norma_actualizar").parsley().reset();
    $("#select_tipoinf_actualizar").parsley().reset();
    $("#infraccion_actualizar").parsley().reset();
    $("#descripcion_actualizar").parsley().reset();
    $("#sancion_uit_actualizar").parsley().reset();
    $("#puntos_actualizar").parsley().reset();
}

$("#switch_retencionlic_actualizar").change(function () {
    // Verifica si el checkbox está marcado
    if ($(this).is(":checked")) {
        switch_retencionlic_actualizar.value = "S"; // Texto cuando el checkbox está marcado
    } else {
        switch_retencionlic_actualizar.value = "N"; // Texto cuando el checkbox no está marcado
    }
});

$("#switch_descuento_actualizar").change(function () {
    // Verifica si el checkbox está marcado
    if ($(this).is(":checked")) {
        switch_descuento_actualizar.value = "S"; // Texto cuando el checkbox está marcado
    } else {
        switch_descuento_actualizar.value = "N"; // Texto cuando el checkbox no está marcado
    }
});

$("#switch_resp_solidaria_actualizar").change(function () {
    // Verifica si el checkbox está marcado
    if ($(this).is(":checked")) {
        switch_resp_solidaria_actualizar.value = "S"; // Texto cuando el checkbox está marcado
    } else {
        switch_resp_solidaria_actualizar.value = "N"; // Texto cuando el checkbox no está marcado
    }
});

$("#switch_dosaje_etilico_actualizar").change(function () {
    // Verifica si el checkbox está marcado
    if ($(this).is(":checked")) {
        switch_dosaje_etilico_actualizar.value = "S"; // Texto cuando el checkbox está marcado
    } else {
        switch_dosaje_etilico_actualizar.value = "N"; // Texto cuando el checkbox no está marcado
    }
});