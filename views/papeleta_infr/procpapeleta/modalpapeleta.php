<div class="modal fade" id="modal-lg" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="titulo_modal" class="modal-title"></h4>
                <button id="close_modal" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="bs-stepper">
                    <div class="bs-stepper-header row" role="tablist">
                        <div class="step col-6 col-md-4 col-lg-3" data-target="#papeleta-part">
                            <button type="button" class="step-trigger" role="tab" aria-controls="papeleta-part" id="papeleta-part-trigger">
                                <span class="bs-stepper-circle">1</span>
                                <span class="bs-stepper-label">Papeleta</span>
                            </button>
                        </div>
                        <div class="step col-6 col-md-4 col-lg-3" data-target="#infractor-part">
                            <button type="button" class="step-trigger" role="tab" aria-controls="infractor-part" id="infractor-part-trigger">
                                <span class="bs-stepper-circle">2</span>
                                <span class="bs-stepper-label">Infractor</span>
                            </button>
                        </div>
                        <div class="step col-6 col-md-4 col-lg-3" data-target="#solidario-part">
                            <button type="button" class="step-trigger" role="tab" aria-controls="solidario-part" id="solidario-part-trigger">
                                <span class="bs-stepper-circle">3</span>
                                <span class="bs-stepper-label">Solidario</span>
                            </button>
                        </div>
                        <div class="step col-6 col-md-4 col-lg-3" data-target="#infraccion-part">
                            <button type="button" class="step-trigger" role="tab" aria-controls="infraccion-part" id="infraccion-part-trigger">
                                <span class="bs-stepper-circle">4</span>
                                <span class="bs-stepper-label">Infracción</span>
                            </button>
                        </div>
                    </div>
                        <div id="papeleta-part" class="content col" role="tabpanel" aria-labelledby="papeleta-part-trigger">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-control-label">Visto: <span
                                                class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" id="txtvisto" name="txtvisto" value=""
                                            placeholder="Ingrese visto"  autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">Papeleta: <span
                                                class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" id="numpapeleta" name="numpapeleta" value=""
                                            placeholder="Papeleta" onkeypress="return soloNumeros(event);" pattern="[0-9]{11}" maxlength="11" title="Max. 11 caracteres" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">Placa: <span
                                                class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" id="numplaca" name="numplaca" value=""
                                            placeholder="Placa" required maxlength="6" pattern="^(?=.*[A-Za-z])[A-Za-z0-9]{6}$" title="La placa debe tener exactamente 6 caracteres alfanuméricos (letras y números)." autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Fecha y hora de intervención: <span
                                                class="tx-danger">*</span></label>
                                        <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                            <input type="text" id="fecha_incio" class="form-control datetimepicker-input" data-target="#reservationdatetime" required />
                                            <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary" onclick="validarFormulario('papeleta-part')">Siguiente</button>
                        </div>
                        <div id="infractor-part" class="content col" role="tabpanel" aria-labelledby="infractor-part-trigger">
                            <div class="row">
                                <div class="col-12 col-md-6 col-xl-3">
                                    <div class="form-group">
                                        <label class="form-control-label">Tipo doc. Infractor:<span
                                                class="tx-danger">*</span></label>
                                        <select class="form-control select2" style="width: 100%;" type="select"
                                            id="select_tipodoc_infractor" data-placeholder="Seleccione"
                                            onchange="configurarNumDoc('infractor')" required>
                                            <option label="Escoge tipo de documento"></option>
                                            <option value="1">DNI</option>
                                            <option value="3">CE</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-xl-3">
                                    <div class="form-group">
                                        <label class="form-control-label">Inf. N° doc: <span
                                                class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" id="infdni" name="infdni" value=""
                                            placeholder="DNI Infractor" required required onkeyup="if(event.keyCode === 13) limitabuscadoc(this, 'infractor')">
                                        <label id="infractor_mensaje" style="display: none; color: green; width: 100%; ">Correcto!</label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-xl-3">
                                    <div class="form-group">
                                        <label class="form-control-label">Inf. Apel. Pat: <span
                                                class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" id="infapellidopat" name="infapellidopat" value=""
                                            placeholder="Infractor Apel. Paterno" required oninput="">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-xl-3">
                                    <div class="form-group">
                                        <label class="form-control-label">Inf. Apel. Mat: <span
                                                class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" id="infapellidomat" name="infapellidomat" value=""
                                            placeholder="Infractor Apel. Materno" required oninput="">
                                    </div>
                                </div>
                                <div class="col-12 col-xl-3">
                                    <div class="form-group">
                                        <label class="form-control-label">Inf. Nombre: <span
                                                class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" id="infnombre" name="infnombre" value=""
                                            placeholder="Infractor nombre" required oninput="">
                                    </div>
                                </div>
                                <div class="col-12 col-xl-9">
                                    <div class="form-group">
                                        <label class="form-control-label">Inf. Domicilio 1°: <span
                                                class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" id="infdomicilio" name="infdomicilio" value=""
                                            placeholder="Infractor domicilio" required oninput="">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-control-label">Inf. Domicilio 2°:</label>
                                        <input class="form-control" type="text" id="infdomicilio_papeleta" name="infdomicilio_papeleta" value=""
                                            placeholder="Infractor domicilio (papeleta)">
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary" onclick="stepper.previous()">Anterior</button>
                            <button class="btn btn-primary" onclick="validarFormulario('infractor-part')">Siguiente</button>
                        </div>
                        <div id="solidario-part" class="content col" role="tabpanel" aria-labelledby="solidario-part-trigger">
                            <div class="row">
                                <div class="col-12 col-md-6 col-xl-3">
                                    <div class="form-group">
                                        <label class="form-control-label">Tipo doc. Solidario:<span
                                                class="tx-danger">*</span></label>
                                        <select class="form-control select2" style="width: 100%;" type="select"
                                            id="select_tipodoc_solidario" data-placeholder="Seleccione"
                                            data-parsley-errors-container="#slErrorDniSoli" onchange="configurarNumDoc('solidario')" required>
                                            <option label="Escoge tipo de documento"></option>
                                            <option value="1">DNI</option>
                                            <option value="3">CE</option>
                                            <option value="5">RUC</option>
                                        </select>
                                        <div id="slErrorDniSoli"></div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-xl-3">
                                    <div class="form-group">
                                        <label class="form-control-label">Sol. N° doc: <span
                                                class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" id="soldni" name="soldni" value=""
                                            placeholder="DNI Solidario" required onkeyup="if(event.keyCode === 13) limitabuscadoc(this, 'solidario')">
                                        <label id="solidario_mensaje" style="display: none; color: green; width: 100%; ">Correcto!</label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-xl-3" id="apellidoPatCampo">
                                    <div class="form-group">
                                        <label class="form-control-label">Sol. Apel. Pat: <span
                                                class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" id="solapellidopat" name="solapellidopat" value=""
                                            placeholder="Solidario Apel. Paterno" required oninput="">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-xl-3" id="apellidoMatCampo">
                                    <div class="form-group">
                                        <label class="form-control-label">Sol. Apel. Mat: <span
                                                class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" id="solapellidomat" name="solapellidomat" value=""
                                            placeholder="Solidario Apel. Materno" required oninput="">
                                    </div>
                                </div>
                                <div class="col-12 col-xl-3" id="nombreCampo">
                                    <div class="form-group">
                                        <label class="form-control-label">Sol. Nombre: <span
                                                class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" id="solnombre" name="solnombre" value=""
                                            placeholder="Solidario nombre" required oninput="">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-xl-6" id="razonSocialCampo" style="display: none;">
                                    <div class="form-group">
                                        <label class="form-control-label">Razón Social: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" id="razon_social" name="razon_social" placeholder="Razón Social">
                                    </div>
                                </div>
                                <div class="col-12 col-xl-9" id="solDomicilioCampo">
                                    <div class="form-group">
                                        <label class="form-control-label">Sol. Domicilio 1°: <span
                                                class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" id="soldomicilio" name="soldomicilio" value=""
                                            placeholder="Solidario domicilio" required oninput="">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-control-label">Sol. Domicilio 2°:</label>
                                        <input class="form-control" type="text" id="soldomicilio_segundo" name="soldomicilio_papeleta" value=""
                                            placeholder="Solidario domicilio (papeleta)">
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary" onclick="stepper.previous()">Anterior</button>
                            <button class="btn btn-primary" onclick="validarFormulario('solidario-part')">Siguiente</button>
                        </div>
                        <div id="infraccion-part" class="content col" role="tabpanel" aria-labelledby="infraccion-part-trigger">
                            <div class="row">
                                <div class="col-sm-6 col-md-6 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <label class="form-control-label">Infracción: <span
                                                class="tx-danger">*</span></label>
                                        <select class="form-control select2" style="width: 100%;" type="select"
                                            id="select_tipoinf" data-placeholder="Seleccione" onchange="obtenerInfraccion()"
                                            data-parsley-errors-container="#slErrorTipoInf" required>
                                        </select>
                                        <div id="slErrorTipoInf"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <label class="form-control-label">Sanción (% UIT): <span
                                                class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" id="sancion_uit" name="sancion_uit" value=""
                                            placeholder="Ingrese la sanción" required oninput="Sancion(this)" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <label class="form-control-label">Evaluac.: <span
                                                class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" id="evaluacion" name="evaluacion" value="" onkeypress="return Evalua(event);" maxlength="1" pattern="[NCSncs]{1}" title="N no aplica, C cancelacion, S sanción" placeholder="Ingrese la evaluación" required>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <label class="form-control-label">N. vez/año: <span
                                                class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" id="n_vez" name="n_vez" value="" onkeypress="return soloNumeros(event);" pattern="[0-9]{1}" maxlength="1" placeholder="Ingrese n° vez" required>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <label class="form-control-label">Monto (S/.): <span
                                                class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" id="monto" name="monto" placeholder="0.00" maxlength="7" required disabled>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary" onclick="stepper.previous()">Anterior</button>
                            <button type="submit" class="btn btn-primary" onclick="guardar_formulario()">Guardar</button>
                        </div>
                    </d>
                </div>
            </div>
        </div>
    </div>
</div>