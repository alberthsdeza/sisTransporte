var usua_id = $("#pe_idx").val();
function inactivo_rnt(id_, codigo) {
    Swal.fire({
        title: 'Advertencia',
        text: 'A continuación, deberá ingresar el motivo de la desactivación. Cualquier cambio irregular será responsabilidad del trabajador que lo realiza.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Continuar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Ingrese el motivo',
                input: 'text',
                inputPlaceholder: 'Motivo de la desactivación',
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
        
                    $.ajax({
                        url: "../../../controller/rnt.php?op=desactivar_rnt",
                        method: "POST",
                        data: {
                            identificador: id_,
                            pers_id: usua_id,
                            motivo: motivo,
                            usua_nombre: $("#pe_nomx").val().trim().replace(/\s+/g, " ").toUpperCase(),
                        },
                        success: function (data) {
                            var response = JSON.parse(data);
                            if (response.status === 'success') {
                                Swal.fire({
                                    icon: "success",
                                    title: "Exitoso!",
                                    text: `El rnt código: ${codigo} se deshabilitó correctamente.`,
                                    showConfirmButton: true,
                                });
                                $('#ul_registros_rnt').DataTable().ajax.reload(null, false);
                            } else {
                                console.log(response);
                                Swal.fire({
                                    icon: "error",
                                    title: "Error!",
                                    text: "Error personalizado: " + response.code + " / " + response.line,
                                    showConfirmButton: true,
                                });
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            Swal.fire({
                                icon: "error",
                                title: "Error en la solicitud!",
                                text: "Hubo un problema al intentar deshabilitar la rnt. Por favor, inténtelo nuevamente más tarde.",
                                showConfirmButton: true,
                            });
                            console.error("Error de AJAX:", {
                                status: textStatus,
                                error: errorThrown,
                                response: jqXHR.responseText
                            });
                        }
                    });
                }
            });
        }
    });
}

