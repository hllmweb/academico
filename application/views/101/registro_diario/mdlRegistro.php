<div class="modal-dialog modal-lg" style="width: 70%;">
    <?
    $dis = (($operacao != 'A')? 'disabled="disabled"': '');
    $disVis = (($operacao == 'V')? 'disabled="disabled"': '');
    $disAll = ((($operacao == 'D')||($operacao == 'V'))? 'disabled="disabled"': '');
    $id = $codigo;
    ?>
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">
            <h5 class="modal-title">
                Registro Diário
                <i class="fa fa-2x fa-graduation-cap"></i>
            </h5>
        </div>
        <div class="modal-body row">
            <div class="col-xs-3">
                <label>CÓDIGO</label>
                <input value="<?= $filtro->CD_REGISTRO ?>" readonly="readonly" type="text" name="oriCodigo" id="oriCodigo<?= $id ?>" class="form-control input-sm" />
            </div>

            <div class="col-xs-3">
                <label>DATA</label>
                <div required="required" class="input-daterange" id="datepicker">
                    <input <?= $disAll ?> value="<?= (($filtro->DT_REGISTRO != '') ? date('d/m/Y', strtotime($filtro->DT_REGISTRO)) : date('d/m/Y')) ?> " type="text" class="input-sm form-control" name="Data" id="Data<?= $id ?>" />
                </div>
            </div>

            <div class="col-xs-3">
                <label>CURSO</label>
                <select <?= $dis ?> name="oriCurso" id="oriCurso<?= $id ?>" class="form-control input-sm" required="required">
                    <option value=""></option>
                    <? foreach ($curso as $row) { ?>
                    <option <?= (($filtro->CD_CURSO == $row['CD_CURSO']) ? 'selected="selected"' : '' ) ?> value="<?= $row['CD_CURSO'] ?>"><?= $row['NM_CURSO_RED'] ?></option>
                    <? } ?>
                </select>
            </div>

            <!-- <div class="col-xs-3">
                <label>SÉRIE</label>
                <select <?= $dis ?> name="oriSerie" id="oriSerie<?= $id ?>" class="form-control input-sm" required="required">
                    <option value=""></option>
                </select>
            </div> -->

            <div class="col-xs-3">
                <label>SÉRIE</label>
                <select <?= $dis ?> name="oriSerie" id="oriSerie<?= $id ?>" class="form-control input-sm" required="required">
                    <option value="<?=$serie?>"><?=$serie?></option>
                </select>
            </div>

            <div class="col-xs-3 no-padding no-margins">
                <label>TIPO REGISTRO</label>
                <select <?= $disAll ?> name="oriTipo" id="oriTipo<?= $id ?>" class="form-control input-sm">
                    <option value=""></option>
                    <? foreach ($tipo as $tp) { ?>
                    <option <?= (($filtro->CD_TIPO_REGISTRO == $tp['CD_TIPO_REGISTRO']) ? 'selected="selected"' : '' ) ?> value="<?= $tp['CD_TIPO_REGISTRO'] ?>"><?= $tp['NM_TIPO_REGISTRO'] ?></option>
                    <? } ?>
                </select>
            </div>
            <div class="col-xs-6">
                <div class="form-group">
                    <label>ALUNO</label>
                    <select <?= $dis ?> name="oriAluno" id="oriAluno<?= $id ?>" class="form-control  input-sm"  multiple="multiple" required="required">
                        <? if($operacao != 'A'){ ?>
                        <option selected="selected" value="<?= $filtro->CD_ALUNO ?>"><?= $filtro->NM_ALUNO ?></option>
                        <? } ?>
                    </select>
                </div>
            </div>

            <div class="col-xs-3">
                <label>Visibilidade do registro</label>
                <input value="<?= (($filtro->STATUS == 0) ? "0 - Liberado" : "1 - Não liberado" ) ?>" readonly="readonly" type="text" name="oriStatus" id="oriStatus<?= $id ?>" class="form-control input-sm" />
            </div>

            <div class="col-xs-12">
                <label>DESCRIÇÃO</label>
                <textarea <?= ($operacao == 'L' ? "readonly='readonly'" : "") ?>  <?= $disAll ?> class="form-control input-sm" name="oriDescricao" id="oriDescricao<?= $id ?>" rows="5" required="required"><?= $filtro->DS_REGISTRO ?></textarea>
            </div>

            <?php # if ($operacao == "A"): ?>
            <div class="col-xs-12">
                <input type="checkbox" id="notificar<?= $id ?>" name="notificar" value="S"> <label>Notificar responsável via aplicativo?</label>
            </div>
            <?php #endif; ?>
        </div>
        <div class="modal-footer" id="resp<?= $id ?>"></div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger2 pull-left"  id="btnClose">
                <i class="fa fa-times"></i> Fechar
            </button>

            <? if ($operacao != 'V'){ ?>
            <button <?= $disVis ?> type="button" class="btn btn-<?= ((($operacao == 'A') || ($operacao == 'L')) ? 'primary' : (($operacao == 'E') ? 'info' : (($operacao == 'V') ? 'info' : 'danger'))) ?> " id="frmRegistrar<?= $id ?>">
                <i class="fa fa-save"></i> <?= (($operacao == 'A') ? 'REGISTRAR' : (($operacao == 'E') ? 'EDITAR' : (($operacao == 'V') ? 'VISUALIZAR' : (($operacao == 'L') ? 'ALTERAR LIBERAÇÃO' : 'DELETAR')))) ?> 
            </button>
            <? } ?>
        </div>
        <input type="hidden" name="oriOperacao" id="oriOperacao<?= $id ?>" value="<?= $operacao ?>">
    </div>

    <script src="<?= base_url('assets/js/') ?>/jquery.min.js"></script>
    <script src="<?= base_url('assets/js/') ?>/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="<?= base_url('assets/js/bootstrap-multiselect.js') ?>"></script>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap-multiselect.css') ?>" type="text/css"/>


    <script type="text/javascript">
        $(function () {

            $("select[id=oriCurso<?= $id ?>]").change(function () {

                $("select[id=oriSerie<?= $id ?>]").html('<option>Carregando</option>');
                $.post("<?= base_url('/comum/combobox/serie') ?>", {
                    curso: $(this).val()
                },
                        function (valor) {
                            $("select[id=oriSerie<?= $id ?>]").html(valor);
                        });
            });

            $("select[id=oriSerie<?= $id ?>]").change(function () {
                $("select[id=oriAluno<?= $id ?>]").multiselect('destroy');
                $("select[id=oriAluno<?= $id ?>]").html('Carregando');
                $.post("<?= base_url('/comum/combobox/alunos') ?>", {
                    curso: $('select[id=oriCurso<?= $id ?>]').val(),
                    serie: $('select[id=oriSerie<?= $id ?>]').val(),
                },
                        function (data) {
                            $("select[id=oriAluno<?= $id ?>]").html(data);
                            $('#oriAluno<?= $id ?>').multiselect({
                                enableClickableOptGroups: true,
                                enableCollapsibleOptGroups: true,
                                enableFiltering: true,
                                includeSelectAllOption: true
                            });
                            // evitar bug do multiselect em modals
                            // em que ao clicar não exibe lista            
                            $('.dropdown-toggle').dropdown();
                        });
            });

            $("button[id=frmRegistrar<?= $id ?>]").click(function () {

                if ($("input[id=Data<?= $id ?>]").val() == '') {
                    $("#resp<?= $id ?>").html('<label class="text-danger">Informe a DATA</label>');

                } else if ($("select[id=oriCurso<?= $id ?>]").val() == '') {
                    $("#resp<?= $id ?>").html('<label class="text-danger">Selecione o CURSO</label>');

                } else if ($("select[id=oriSerie<?= $id ?>]").val() == '') {
                    $("#resp<?= $id ?>").html('<label class="text-danger">Selecione a SÉRIE</label>');

                } else if ($("#oriAluno<?= $id ?>").val() == null) {
                    $("#resp<?= $id ?>").html('<label class="text-danger">Selecione o(s) ALUNO(s)</label>');

                } else if ($("#oriDescricao<?= $id ?>").val() == "") {
                    $("#resp<?= $id ?>").html('<label class="text-danger">Informe a DESCRIÇÃO</label>');

                } else {
                    $.post("<?= base_url('' . $this->session->userdata('SGP_SISTEMA') . '/registro_diario/frmManter') ?>", {
                        operacao: $("input[id=oriOperacao<?= $id ?>]").val(),
                        codigo: $("input[id=oriCodigo<?= $id ?>]").val(),
                        status: $("input[id=oriStatus<?= $id ?>]").val(),
                        aluno: $("select[id=oriAluno<?= $id ?>]").val(),
                        data: $("input[id=Data<?= $id ?>]").val(),
                        descricao: $("textarea[id=oriDescricao<?= $id ?>]").val(),
                    },
                            function (valor) {
                                $("#resp<?= $id ?>").html(valor);
                            });
                }
            });


            $('#btnClose').on('click', function () {
                location.reload();
            });
        });
    </script>

    <script>
        $(function () {
            $("select[id=oriAluno<?= $id ?>]").multiselect();
            $('.input-daterange').datepicker({
                endDate: '+0d',
                autoclose: true
            });

            < ? if ($operacao != 'A'){ ? >
                    $("select[id=oriSerie<?= $id ?>]").html('<option>Carregando</option>');
            $.post("<?= base_url('/comum/combobox/serie') ?>", {
            curso: <?= $filtro->CD_CURSO ?>,
                    selecionado: <?= $filtro->ORDEM_SERIE ?>,
            },
                    function (valor) {
                        $("select[id=oriSerie<?= $id ?>]").html(valor);
                    });
                    < ? } ? >
        });
    </script>


    <script type="text/javascript">
        $(function () {

        });
    </script>
</div>
