<div id="modalRNT_actualizar" class="modal fade" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header pd-x-20">
                <h6 id="lbltitulo_modalRNT_actualizar" class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"></h6>
                <button id="Close_rnt_x_actualizar" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pd-20">
                <form id="actualizar_rnt" class="parsley-style-1" action="" method="post">
                    <div class="modal-body pd-20">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-5 col-xl-6">
                                <div class="form-group">
                                    <label class="form-control-label">Norma: <span class="tx-danger">*</span></label>
                                    <select class="form-control select2" style="width: 100%;" type="select"
                                        id="select_norma_actualizar" data-placeholder="Seleccione"
                                        data-parsley-errors-container="#slErrorNorma" required disabled>
                                    </select>
                                    <div id="slErrorNorma"></div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <div class="form-group">
                                    <label class="form-control-label">Tipo inf.: <span
                                            class="tx-danger">*</span></label>
                                    <select class="form-control select2" style="width: 100%;" type="select"
                                        id="select_tipoinf_actualizar" data-placeholder="Seleccione"
                                        data-parsley-errors-container="#slErrorTipoInf_actualizar" required disabled>
                                    </select>
                                    <div id="slErrorTipoInf_actualizar"></div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-3 col-xl-3">
                                <div class="d-flex wd-auto">
                                    <div class="form-group">
                                        <label class="form-control-label">Infracción: <span
                                                class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" id="infraccion_actualizar" name="infraccion_actualizar"
                                            value="" placeholder="Ej. M-01" required readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label class="form-control-label">Descripción: <span
                                            class="tx-danger">*</span></label>
                                    <textarea class="form-control" id="descripcion_actualizar" name="descripcion_actualizar"
                                        placeholder="Ingrese la descripción de la infracción" required></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label class="form-control-label">Observación:</label>
                                    <textarea class="form-control" id="observacion_actualizar" name="observacion_actualizar" placeholder=""
                                        required></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
                                <div class="form-group">
                                    <label class="form-control-label">Sanción (% UIT): <span
                                            class="tx-danger">*</span></label>
                                    <input class="form-control" type="text" id="sancion_uit_actualizar" name="sancion_uit_actualizar" value=""
                                        placeholder="Ingrese la sanción" required oninput="Sancion_actualizar(this)">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
                                <div class="form-group">
                                    <label class="form-control-label">Puntos: <span class="tx-danger">*</span></label>
                                    <input class="form-control" type="text" id="puntos_actualizar" name="puntos_actualizar" value=""
                                        placeholder="" oninput="Puntos_actualizar(this)" required>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label class="form-control-label">Medida Prev:</label>
                                    <textarea class="form-control" id="med_prev_actualizar" name="med_prev_actualizar" placeholder="" rows="1"
                                        required></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Retención lic:</label>
                                            <div class="checkbox-wrapper-35">
                                                <input value="N" name="switch_retencionlic_actualizar" id="switch_retencionlic_actualizar"
                                                    type="checkbox" class="switch">
                                                <label for="switch_retencionlic_actualizar">
                                                    <span class="switch-x-text"></span>
                                                    <span class="switch-x-toggletext">
                                                        <span class="switch-x-unchecked"><span
                                                                class="switch-x-hiddenlabel"></span>No</span>
                                                        <span class="switch-x-checked"><span
                                                                class="switch-x-hiddenlabel"></span>Si</span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Descuento:</label>
                                            <div class="checkbox-wrapper-35">
                                                <input value="N" name="switch_descuento_actualizar" id="switch_descuento_actualizar"
                                                    type="checkbox" class="switch">
                                                <label for="switch_descuento_actualizar">
                                                    <span class="switch-x-text"></span>
                                                    <span class="switch-x-toggletext">
                                                        <span class="switch-x-unchecked"><span
                                                                class="switch-x-hiddenlabel"></span>No</span>
                                                        <span class="switch-x-checked"><span
                                                                class="switch-x-hiddenlabel"></span>Si</span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-control-label">R. Solidaria:</label>
                                            <div class="checkbox-wrapper-35">
                                                <input value="N" name="switch_resp_solidaria_actualizar" id="switch_resp_solidaria_actualizar"
                                                    type="checkbox" class="switch">
                                                <label for="switch_resp_solidaria_actualizar">
                                                    <span class="switch-x-text"></span>
                                                    <span class="switch-x-toggletext">
                                                        <span class="switch-x-unchecked"><span
                                                                class="switch-x-hiddenlabel"></span>No</span>
                                                        <span class="switch-x-checked"><span
                                                                class="switch-x-hiddenlabel"></span>Si</span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Dosaje Etílico:</label>
                                            <div class="checkbox-wrapper-35">
                                                <input value="N" name="switch_dosaje_etilico_actualizar" id="switch_dosaje_etilico_actualizar"
                                                    type="checkbox" class="switch">
                                                <label for="switch_dosaje_etilico_actualizar">
                                                    <span class="switch-x-text"></span>
                                                    <span class="switch-x-toggletext">
                                                        <span class="switch-x-unchecked"><span
                                                                class="switch-x-hiddenlabel"></span>No</span>
                                                        <span class="switch-x-checked"><span
                                                                class="switch-x-hiddenlabel"></span>Si</span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                <div class="form-group">
                                    <label class="form-control-label">Monto por mes vencido (S/):</label>
                                    <input class="form-control" type="text" id="monto_actualizar" name="monto_actualizar" placeholder="0.00"
                                        maxlength="7" required>
                                </div>
                            </div>
                        </div>
                    </div><!-- modal-body -->
                    <div class="modal-footer" style="text-align: center;">
                        <button id="modalRNT_actualizar_editar" type="button" class="btn btn-primary tx-size-xs">Editar</button>
                        <button id="modalRNT_actualizar_cerrar" type="button" class="btn btn-secondary tx-size-xs"
                            data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div><!-- modal-body -->
            <div class="modal-footer" style="text-align: center;">
            </div>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->