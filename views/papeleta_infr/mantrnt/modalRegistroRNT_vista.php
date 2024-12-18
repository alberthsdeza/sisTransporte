<div id="modalRNT_vista" class="modal fade" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header pd-x-20">
                <h6 id="lbltitulo_modalRNT_vista" class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"></h6>
                <button id="Close_rntvista_x" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pd-20">
                <form id="vista_rnt" class="parsley-style-1" action="" method="post">
                    <div class="modal-body pd-20">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-5 col-xl-6">
                                <div class="form-group">
                                    <label class="form-control-label">Norma:</label>
                                    <input class="form-control" type="text" id="inf_norma" name="inf_norma" value="" placeholder="" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <div class="form-group">
                                    <label class="form-control-label">Tipo inf.:</label>
                                    <input class="form-control" type="text" id="inf_clasificacion" name="inf_clasificacion" value="" placeholder="" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-3 col-xl-3">
                                <div class="d-flex wd-auto">
                                    <div class="form-group">
                                        <label class="form-control-label">Infracción:</label>
                                        <input class="form-control" type="text" id="inf_codigo" name="inf_codigo" value="" placeholder="" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label class="form-control-label">Descripción:</label>
                                    <textarea class="form-control" id="inf_descripcion" name="inf_descripcion" placeholder="" readonly></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label class="form-control-label">Observación:</label>
                                    <textarea class="form-control" id="inf_observacion" name="inf_observacion" placeholder="" readonly></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
                                <div class="form-group">
                                    <label class="form-control-label">Sanción (% UIT):</label>
                                    <input class="form-control" type="text" id="inf_sancion_uit" name="inf_sancion_uit" value="" placeholder="" readonly oninput="Sancion(this)">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
                                <div class="form-group">
                                    <label class="form-control-label">Puntos:</label>
                                    <input class="form-control" type="text" id="inf_puntos" name="inf_puntos" value="" placeholder="" readonly>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label class="form-control-label">Medida Prev:</label>
                                    <textarea class="form-control" id="inf_med_prev" name="inf_med_prev" placeholder="" rows="1" readonly></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Retención lic:</label>
                                            <div class="checkbox-wrapper-35">
                                                <input value="N" name="switch_retencionlic" id="inf_switch_retencionlic" type="checkbox" class="switch" disabled>
                                                <label for="inf_switch_retencionlic">
                                                    <span class="switch-x-text"></span>
                                                    <span class="switch-x-toggletext">
                                                        <span class="switch-x-unchecked"><span class="switch-x-hiddenlabel"></span>No</span>
                                                        <span class="switch-x-checked"><span class="switch-x-hiddenlabel"></span>Si</span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Descuento:</label>
                                            <div class="checkbox-wrapper-35">
                                                <input value="N" name="switch_descuento" id="inf_switch_descuento" type="checkbox" class="switch" disabled>
                                                <label for="inf_switch_descuento">
                                                    <span class="switch-x-text"></span>
                                                    <span class="switch-x-toggletext">
                                                        <span class="switch-x-unchecked"><span class="switch-x-hiddenlabel"></span>No</span>
                                                        <span class="switch-x-checked"><span class="switch-x-hiddenlabel"></span>Si</span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-control-label">R. Solidaria:</label>
                                            <div class="checkbox-wrapper-35">
                                                <input value="N" name="switch_resp_solidaria" id="inf_switch_resp_solidaria" type="checkbox" class="switch" disabled>
                                                <label for="inf_switch_resp_solidaria">
                                                    <span class="switch-x-text"></span>
                                                    <span class="switch-x-toggletext">
                                                        <span class="switch-x-unchecked"><span class="switch-x-hiddenlabel"></span>No</span>
                                                        <span class="switch-x-checked"><span class="switch-x-hiddenlabel"></span>Si</span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Dosaje Etílico:</label>
                                            <div class="checkbox-wrapper-35">
                                                <input value="N" name="switch_dosaje_etilico" id="inf_switch_dosaje_etilico" type="checkbox" class="switch" disabled>
                                                <label for="inf_switch_dosaje_etilico">
                                                    <span class="switch-x-text"></span>
                                                    <span class="switch-x-toggletext">
                                                        <span class="switch-x-unchecked"><span class="switch-x-hiddenlabel"></span>No</span>
                                                        <span class="switch-x-checked"><span class="switch-x-hiddenlabel"></span>Si</span>
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
                                    <input class="form-control" type="text" id="inf_monto" name="inf_monto" placeholder="0.00" maxlength="7" readonly>
                                </div>
                            </div>
                        </div>
                    </div><!-- modal-body -->
                    <div class="modal-footer" style="text-align: center;">
                        <button id="modalRNTvista_cerrar" type="button" class="btn btn-secondary tx-size-xs" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div><!-- modal-body -->
            <div class="modal-footer" style="text-align: center;">
            </div>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->