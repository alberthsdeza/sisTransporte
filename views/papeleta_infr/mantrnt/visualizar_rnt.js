function visualizar_rnt(id, codigo) {
    $("#lbltitulo_modalRNT_vista").html(`Visualizar infracción del RNT seleccionado: ${codigo}`);
    $("#modalRNT_vista").modal("show");
    if (id) {
        obtener_dato_rnt(id)
            .then((data) => {
                inf_norma.value = data.norma;
                inf_clasificacion.value = data.calif;
                inf_codigo.value = data.codigo;
                inf_descripcion.value = data.descripcion;
                inf_observacion.value = data.observacion;
                inf_sancion_uit.value = data.sancion_uit.replace(/{|}/g, ""); 
                inf_sancion_uit.dispatchEvent(new Event('input'));
                inf_puntos.value = data.puntos;
                inf_med_prev.value = data.medida_prev;
                if (data.retencion_lic === "S") {
                    inf_switch_retencionlic.checked = true;
                } else {
                    inf_switch_retencionlic.checked = false;
                }
                if (data.descuento === "S") {
                    inf_switch_descuento.checked = true;
                } else {
                    inf_switch_descuento.checked = false;
                }
                if (data.dosaje_etilico === "S") {
                    inf_switch_dosaje_etilico.checked = true;
                } else {
                    inf_switch_dosaje_etilico.checked = false;
                }
                if (data.responsable_solidaria === "S") {
                    inf_switch_resp_solidaria.checked = true;
                } else {
                    inf_switch_resp_solidaria.checked = false;
                }
                inf_monto.value = data.monto_mes_venc;

            })
            .catch((error) => {
                console.error("Error en la solicitud:", error);
            });
    }
}

function obtener_dato_rnt(id) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: "../../../controller/rnt.php?op=visualizar_rnt",
            method: "POST",
            data: { ident_rnt: id },
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
    }, 300);
}