<div class="modal-dialog" id="frmNovaSolicitacao">
    <?
    $lock = (($operacao == 'D' || $operacao == 'V' || $operacao == 'L') ? 'disabled="disabled"' : '');
    $id = $operacao . $filtro->CD_RESERVA;
    ?>
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">
            <h4 class="modal-title">Solicitação de Reserva</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <form id="frmSolicitacao<?= $id ?>">
                    <div class="hpanel">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a data-toggle="tab" href="#tab<?= $id ?>-3" aria-expanded="true" class="text-primary-2">
                                    <i class="fa fa-list"></i> Dados da Solicitação
                                </a>
                            </li>
                            <li class="">
                                <a data-toggle="tab" href="#tab<?= $id ?>-4" aria-expanded="false" class="text-warning">
                                    <i class="fa fa-dot-circle-o"></i> O que será feito!?
                                </a>
                            </li>
                            <li class="">
                                <a data-toggle="tab" href="#tab<?= $id ?>-5" aria-expanded="false" class="text-info">
                                    <i class="fa fa-user"></i> O que o Professor fez!?
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab<?= $id ?>-3" class="tab-pane active">
                                <div class="panel-body no-padding">
                                    <br>
                                    <div class="col-xs-2">
                                        <label>Código:</label>
                                        <input readonly="readonly" size="16" type="text" class="form-control input-sm" value="<?= $filtro->CD_RESERVA ?>" name="resCodigo" id="resCodigo" />
                                    </div>
                                    <div class="col-xs-2 no-padding">
                                        <label>Período:</label>
                                        <select <?= $lock ?> required="required" name="resPeriodo" id="resPeriodo" class="form-control input-sm">
                                            <? foreach ($periodo as $p) { ?>
                                                <option <?= (($filtro->PERIODO == $p['DC_PERIODO']) ? 'selected="selected"' : '' ) ?> value="<?= $p['DC_PERIODO'] ?>"><?= $p['DC_PERIODO'] ?></option>
                                            <? } ?>
                                        </select>
                                    </div>
                                    <div class="col-xs-4">

                                        <label>Curso:</label>
                                        <select <?= $lock ?> required="required" name="resCurso" id="resCurso<?= $id ?>" class="form-control input-sm">
                                            <? if ($operacao == 'L' || $operacao == 'V') { ?>
                                                <option value="<?= $filtro->CD_CURSO ?>"><?= $filtro->NM_CURSO ?></option>
                                            <? } else { ?>
                                                <option></option>
                                            <? } foreach ($curso as $c) { ?>
                                                <option <?= (($filtro->CD_CURSO == $c['CD_CURSO']) ? 'selected="selected"' : '' ) ?> value="<?= $c['CD_CURSO'] ?>"><?= $c['NM_CURSO_RED'] ?></option>
                                            <? } ?>
                                        </select>
                                    </div>
                                    <div class="col-xs-4" style="padding-left: 0px">
                                        <label>Série:</label>
                                        <select <?= $lock ?> required="required" name="resSerie" id="resSerie<?= $id ?>" class="form-control input-sm">
                                            <option></option>
                                        </select>
                                    </div>
                                    <div class="col-xs-4">
                                        <label>Turma:</label>
                                        <select <?= $lock ?> required="required" name="resTurma" id="resTurma<?= $id ?>" class="form-control input-sm">
                                            <option></option>
                                        </select>
                                    </div>
                                    <div class="col-xs-8" style="padding-left: 0px">
                                        <label>Disciplina:</label>
                                        <select <?= $lock ?> required="required" name="resDisciplina" id="resDisciplina<?= $id ?>" class="form-control input-sm">
                                            <option></option>
                                        </select>
                                    </div>
                                    <div class="col-xs-8">
                                        <label>Professor:</label>
                                        <select <?= $lock ?> required="required" name="resProfessor" id="resProfessor<?= $id ?>" class="form-control input-sm">
                                            <option></option>
                                        </select>
                                    </div>
                                    <div class="col-xs-4" style="padding-left: 0px">
                                        <label>Tipo Local:</label>
                                        <select <?= $lock ?> required="required" name="resTipoLocal" id="resTipoLocal<?= $id ?>" class="form-control input-sm">
                                            <option></option>
                                            <option value="L" <?= (($filtro->TP_LOCAL == 'L') ? 'selected="selected"' : '' ) ?>>LABORATÓRIO</option>
                                            <option value="E" <?= (($filtro->TP_LOCAL == 'E') ? 'selected="selected"' : '' ) ?>>ESPAÇO</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-6" >
                                        <label>Data:</label>                                        
                                        <div class="input-group">
                                            <div class="input-group input-daterange" data-provide="datepicker" data-date-autoclose="true" data-date-format="dd/mm/yyyy">
                                                <input name="ResInicio" class="form-control" type="text" value="">
                                                <span class="input-group-addon">até</span>
                                                <input name="ResTermino" class="form-control" type="text" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-3">
                                        <label>Hora Início:</label>
                                        <div class="input-group m-b">
                                            <input <?= $lock ?> required="required" value="<?= $filtro->HR_INICIO ?>" size="16" type="text" class="form-control input-sm"   name="resHInicio" id="resHInicio<?= $id ?>" >
                                            <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span> 
                                        </div>
                                    </div>
                                    <div class="col-xs-3" style="padding-left: 0px">
                                        <label>Hora Fim:</label>
                                        <div class="input-group m-b">
                                            <input <?= $lock ?> required="required" value="<?= $filtro->HR_FINAL ?>" size="16" type="text" class="form-control input-sm"   name="resHFim" id="resHFim<?= $id ?>" >
                                            <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span> 
                                        </div>
                                    </div>
                                    
                                    <div class="col-xs-12" >
                                        <label>Local:</label>
                                        <select <?= $lock ?> required="required" name="resLocal" id="resLocal<?= $id ?>" class="form-control input-sm">
                                            <option></option>
                                        </select>
                                        <br><br>
                                    </div>
                                </div>
                            </div>
                            <div id="tab<?= $id ?>-4" class="tab-pane">
                                <div class="panel-body">
                                    <div class="col-xs-12 no-padding">
                                        <label>Conteúdo a ser ministrado:</label>
                                        <textarea <?= $lock ?> name="resConteudo" id="resConteudo<?= $id ?>" class="form-control input-sm"><?= $filtro->CONTEUDO ?></textarea>
                                    </div>
                                    <div class="col-xs-12 no-padding">
                                        <label>Objetivo da Aula:</label>
                                        <textarea <?= $lock ?> name="resObjetivo" id="resObjetivo<?= $id ?>" class="form-control input-sm"><?= $filtro->OBJETIVO ?></textarea>
                                    </div>
                                    <div class="col-xs-12 no-padding">
                                        <label>Material a ser utilizado:</label>
                                        <textarea <?= $lock ?> name="resMaterial" id="resMaterial<?= $id ?>" class="form-control input-sm"><?= $filtro->MATERIAL ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div id="tab<?= $id ?>-5" class="tab-pane">
                                <div class="panel-body">
                                    <div class="col-xs-12 no-padding">
                                        <label>Método que foi utilizado:</label>
                                        <textarea <?= (($operacao == 'L') ? '' : $lock) ?> name="resMetodo" id="resMetodo<?= $id ?>" class="form-control input-sm"><?= $filtro->METODO ?></textarea>
                                    </div>
                                    <div class="col-xs-12 no-padding">
                                        <label>Resultado:</label>
                                        <textarea <?= (($operacao == 'L') ? '' : $lock) ?> name="resResultado" id="resResultado<?= $id ?>" class="form-control input-sm"><?= $filtro->RESULTADO ?></textarea>
                                    </div>
                                    <div class="col-xs-12 no-padding">
                                        <label>Observações da Aula:</label>
                                        <textarea <?= (($operacao == 'L') ? '' : $lock) ?> name="resObservacao" id="resObservacao<?= $id ?>" class="form-control input-sm"><?= $filtro->OBSERVACAO ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="operacao" id="operacao" value="<?= $operacao ?>">
                </form>
            </div>
        </div>
        <div class="modal-footer" id="resRetorno<?= $id ?>"></div>

        <div class="modal-footer">
            <button type="button" class="btn btn-danger2 pull-left" data-dismiss="modal">
                <i class="fa fa-times-circle"></i> Fechar
            </button>
            <? if ($operacao != 'V') { ?>
                <button target="_blank" class="btn btn-<?= (($operacao == 'A') ? 'info' : (($operacao == 'E') ? 'warning' : (($operacao == 'L') ? 'primary' : 'danger'))) ?> btnSubmit" >
                    <i class="fa fa-database"></i> <?= (($operacao == 'A') ? 'Cadastrar' : (($operacao == 'E') ? 'Editar' : (($operacao == 'L') ? 'Lançar ' : 'Deletar'))) ?> Dados
                </button>
            <? } ?>
        </div>
        <script type="text/javascript">

<? if ($operacao != 'A') { ?>
                $(document).ready(function () {

                    $.post("<?= base_url('comum/combobox/reserva_local') ?>", {
                        tipo: '<?= $filtro->TP_LOCAL ?>',
                        selecionado: '<?= $filtro->CD_LOCAL ?>'
                    },
                    function (valor) {
                        $("select[id=resLocal<?= $id ?>]").html(valor);
                    });


                    $.post("<?= base_url('comum/combobox/serie') ?>", {
                        curso: '<?= $filtro->CD_CURSO ?>',
                        selecionado: '<?= $filtro->ORDEM_SERIE ?>'
                    },
                    function (valor) {
                        $("select[id=resSerie<?= $id ?>]").html(valor);
                    });



                    $.post("<?= base_url('comum/combobox/turma') ?>", {
                        curso: '<?= $filtro->CD_CURSO ?>',
                        serie: '<?= $filtro->ORDEM_SERIE ?>',
                        selecionado: '<?= $filtro->CD_TURMA ?>',
                    },
                            function (valor) {
                                $("select[id=resTurma<?= $id ?>]").html(valor);
                            });




                    $.post("<?= base_url('comum/combobox/disciplina') ?>", {
                        curso: '<?= $filtro->CD_CURSO ?>',
                        serie: '<?= $filtro->ORDEM_SERIE ?>',
                        selecionado: '<?= $filtro->CD_DISCIPLINA ?>',
                    },
                            function (valor) {
                                $("select[id=resDisciplina<?= $id ?>]").html(valor);
                            });




                    $.post("<?= base_url('comum/combobox/professor') ?>", {
                        curso: '<?= $filtro->CD_CURSO ?>',
                        disciplina: '<?= $filtro->CD_DISCIPLINA ?>',
                        selecionado: '<?= $filtro->CD_PROFESSOR ?>',
                    },
                            function (valor) {
                                $("select[id=resProfessor<?= $id ?>]").html(valor);
                            });

                });
<? } ?>

            $("#resData<?= $id ?>").datepicker({
                format: "dd/mm/yyyy",
                autoclose: true,
                //endDate: '+0d',
            });
            $('#resHInicio<?= $id ?>').timepicker({
                showMeridian: false,
            });
            $('#resHFim<?= $id ?>').timepicker({
                showMeridian: false,
            });

            $("select[id=resTipoLocal<?= $id ?>]").change(function () {
                $("select[id=resLocal<?= $id ?>]").html('<option>Carregando</option>');
                $.post("<?= base_url('comum/combobox/reserva_local') ?>", {
                    tipo: $(this).val()
                },
                function (valor) {
                    $("select[id=resLocal<?= $id ?>]").html(valor);
                });
            });

            $("select[id=resCurso<?= $id ?>]").change(function () {
                $("select[id=resSerie<?= $id ?>]").html('<option>Carregando</option>');
                $.post("<?= base_url('comum/combobox/serie') ?>", {
                    curso: $(this).val()
                },
                function (valor) {
                    $("select[id=resSerie<?= $id ?>]").html(valor);
                    $("select[id=resTurma<?= $id ?>]").val();
                });
            });

            $("select[id=resSerie<?= $id ?>]").change(function () {
                $("select[id=resTurma<?= $id ?>]").html('<option>Carregando</option>');
                $.post("<?= base_url('comum/combobox/turma') ?>", {
                    curso: $("select[id=resCurso<?= $id ?>]").val(),
                    serie: $("select[id=resSerie<?= $id ?>]").val(),
                },
                function (valor) {
                    $("select[id=resTurma<?= $id ?>]").html(valor);
                });
            });

            $("select[id=resTurma<?= $id ?>]").change(function () {
                $("select[id=resDisciplina<?= $id ?>]").html('<option>Carregando</option>');
                $.post("<?= base_url('comum/combobox/disciplina_turma') ?>", {
                    turma: $("select[id=resTurma<?= $id ?>]").val(),
                },
                function (valor) {
                    $("select[id=resDisciplina<?= $id ?>]").html(valor);
                });
            });

            $("select[id=resDisciplina<?= $id ?>]").change(function () {
                $("select[id=resProfessor<?= $id ?>]").html('<option>Carregando</option>');
                $.post("<?= base_url('comum/combobox/professor') ?>", {
                    curso: $("select[id=resCurso<?= $id ?>]").val(),
                    disciplina: $("select[id=resDisciplina<?= $id ?>]").val(),
                },
                        function (valor) {
                            $("select[id=resProfessor<?= $id ?>]").html(valor);
                        });
            });

            $('.btnSubmit').click(function () {


                var startTime = $("input[id=resHInicio<?= $id ?>]").val();
                var endTime = $("input[id=resHFim<?= $id ?>]").val();

                var startDate = new Date("1/1/1900 " + startTime);
                var endDate = new Date("1/1/1900 " + endTime);

                if ($("select[id=resPeriodo<?= $id ?>]").val() == '') {
                    $("#resRetorno<?= $id ?>").html("<label class='text-danger'>Informe o Período.</label>");
                } else if ($("select[id=resCurso<?= $id ?>]").val() == '') {
                    $("#resRetorno<?= $id ?>").html("<label class='text-danger'>Informe o Curso.</label>");
                } else if ($("select[id=resSerie<?= $id ?>]").val() == '') {
                    $("#resRetorno<?= $id ?>").html("<label class='text-danger'>Informe a Série.</label>");
                } else if ($("select[id=resTurma<?= $id ?>]").val() == '') {
                    $("#resRetorno<?= $id ?>").html("<label class='text-danger'>Informe a Turma.</label>");
                } else if ($("select[id=resDisciplina<?= $id ?>]").val() == '') {
                    $("#resRetorno<?= $id ?>").html("<label class='text-danger'>Informe a Disciplina.</label>");
                } else if ($("select[id=resProfessor<?= $id ?>]").val() == '') {
                    $("#resRetorno<?= $id ?>").html("<label class='text-danger'>Informe o Professor.</label>");
                } else if ($("input[id=resData<?= $id ?>]").val() == '') {
                    $("#resRetorno<?= $id ?>").html("<label class='text-danger'>Informe a Data.</label>");
                } else if (startDate > endDate) {
                    $("#resRetorno<?= $id ?>").html("<label class='text-danger'>Hora Final menor que Hora Inicial.</label>");
                } else if ($("select[id=resTipoLocal<?= $id ?>]").val() == '') {
                    $("#resRetorno<?= $id ?>").html("<label class='text-danger'>Informe o Tipo do Local a ser reservado.</label>");
                } else if ($("select[id=resLocal<?= $id ?>]").val() == '') {
                    $("#resRetorno<?= $id ?>").html("<label class='text-danger'>Informe o local a ser reservado.</label>");
                } else {
                    var dados = jQuery('#frmSolicitacao<?= $id ?>').serialize();
                    jQuery.ajax({
                        type: "POST",
                        url: "<?= base_url('' . $this->session->userdata('SGP_SISTEMA') . '/reserva/frmManter') ?>",
                        data: dados,
                        success: function (data) {
                            $("#resRetorno<?= $id ?>").html(data);
                            //txtFiltrar();
                        }
                    });
                }
            });
        </script>
    </div>
</div>
