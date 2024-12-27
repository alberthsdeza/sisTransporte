<div id="modalRNT" class="modal fade" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header pd-x-20">
                <h6 id="lbltitulo_modalRNT" class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"></h6>
                <button id="Close_rnt_x" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pd-20">
                <form id="registrar_rnt" class="parsley-style-1" action="" method="post">
                    <div class="modal-body pd-20">
                        <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Nota*: registrar de acuerdo al texto
                            único ordenado del reglamento nacional de tránsito</h6>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-5 col-xl-6">
                                <div class="form-group">
                                    <label class="form-control-label">Norma: <span class="tx-danger">*</span></label>
                                    <select class="form-control select2" style="width: 100%;" type="select"
                                        id="select_norma" data-placeholder="Seleccione"
                                        data-parsley-errors-container="#slErrorNorma" required>
                                    </select>
                                    <div id="slErrorNorma"></div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <div class="form-group">
                                    <label class="form-control-label">Tipo inf.: <span
                                            class="tx-danger">*</span></label>
                                    <select class="form-control select2" style="width: 100%;" type="select"
                                        id="select_tipoinf" data-placeholder="Seleccione"
                                        data-parsley-errors-container="#slErrorTipoInf" required>
                                    </select>
                                    <div id="slErrorTipoInf"></div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-3 col-xl-3">
                                <div class="d-flex wd-auto">
                                    <div class="form-group">
                                        <label class="form-control-label">Infracción: <span
                                                class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" id="infraccion" name="infraccion"
                                            value="" placeholder="Ej. M-01"
                                            oninput="formatearInfraccion(this),this.value = this.value.toUpperCase(),validateInf(this)"
                                            required>
                                        <label id="verificar_ingresoinfraccion"
                                            style="display: none; color: green;">Nueva infracción!</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label class="form-control-label">Descripción: <span
                                            class="tx-danger">*</span></label>
                                    <textarea class="form-control" id="descripcion" name="descripcion"
                                        placeholder="Ingrese la descripción de la infracción" required></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label class="form-control-label">Observación:</label>
                                    <textarea class="form-control" id="observacion" name="observacion" placeholder=""
                                        required></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
                                <div class="form-group">
                                    <label class="form-control-label">Sanción (% UIT): <span
                                            class="tx-danger">*</span></label>
                                    <input class="form-control" type="text" id="sancion_uit" name="sancion_uit" value=""
                                        placeholder="Ingrese la sanción" required oninput="Sancion(this)">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
                                <div class="form-group">
                                    <label class="form-control-label">Puntos: <span class="tx-danger">*</span></label>
                                    <input class="form-control" type="text" id="puntos" name="puntos" value=""
                                        placeholder="" oninput="Puntos(this)" required>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label class="form-control-label">Medida Prev:</label>
                                    <textarea class="form-control" id="med_prev" name="med_prev" placeholder="" rows="1"
                                        required></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Retención lic:</label>
                                            <div class="checkbox-wrapper-35">
                                                <input value="N" name="switch_retencionlic" id="switch_retencionlic"
                                                    type="checkbox" class="switch">
                                                <label for="switch_retencionlic">
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
                                                <input value="N" name="switch_descuento" id="switch_descuento"
                                                    type="checkbox" class="switch">
                                                <label for="switch_descuento">
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
                                                <input value="N" name="switch_resp_solidaria" id="switch_resp_solidaria"
                                                    type="checkbox" class="switch">
                                                <label for="switch_resp_solidaria">
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
                                                <input value="N" name="switch_dosaje_etilico" id="switch_dosaje_etilico"
                                                    type="checkbox" class="switch">
                                                <label for="switch_dosaje_etilico">
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
                                    <input class="form-control" type="text" id="monto" name="monto" placeholder="0.00"
                                        maxlength="7" required>
                                </div>
                            </div>
                        </div>
                    </div><!-- modal-body -->
                    <div class="modal-footer" style="text-align: center;">
                        <button id="modalRNT_guardar" type="button" class="btn btn-primary tx-size-xs"
                            disabled>Guardar</button>
                        <button id="modalRNT_cerrar" type="button" class="btn btn-secondary tx-size-xs"
                            data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div><!-- modal-body -->
            <div class="modal-footer" style="text-align: center;">
            </div>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->