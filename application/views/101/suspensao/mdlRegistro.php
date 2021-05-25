<div class="modal-dialog">    
    <?
    $dis = (($operacao == 'D') ? 'disabled="disabled"' : '');
    $disX = (($operacao == 'E' || $operacao == 'D') ? 'disabled="disabled"' : '');
    $id = $codigo;
    $dt = date('hms');
    ?>

    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">
            <h5 class="modal-title">
                Registro de Suspensão
                <i class="fa fa-2x fa-graduation-cap"></i>
            </h5>
        </div>
        <div class="modal-body row">
            <div class="col-xs-4">
                <div class="form-group">
                    <label>CÓDIGO</label>
                    <input value="<?= $filtro->CD_SUSPENSAO ?>" readonly="readonly" type="text" name="Codigo" id="Codigo<?= $id ?>" class="form-control input-sm" />
                </div>
            </div>
            <div class="col-xs-4 no-padding">
                <label>CURSO</label>
                <select <?= $disX ?> name="Curso" id="Curso<?= $id ?>" class="form-control input-sm">
                    <option value=""></option>
                    <? foreach ($curso as $row) { ?>
                        <option <?= (($filtro->CD_CURSO == $row['CD_CURSO']) ? 'selected="selected"' : '' ) ?> value="<?= $row['CD_CURSO'] ?>"><?= $row['NM_CURSO_RED'] ?></option>
                    <? } ?>
                </select>
            </div>

            <div class="col-xs-4">
                <label>SÉRIE</label>
                <select <?= $disX ?> name="Serie" id="Serie<?= $id ?>" class="form-control input-sm">
                    <option value=""></option>
                </select>
            </div>

            <div class="col-xs-12">
                <div class="form-group">
                    <label>ALUNO</label>
                    <select <?= $disX ?> name="Aluno" id="Aluno<?= $id ?>" class="form-control input-sm"  multiple="multiple">
                        <? if ($operacao != 'A') { ?>
                            <option selected="selected" value="<?= $filtro->CD_ALUNO ?>"><?= $filtro->NM_ALUNO ?></option>
                        <? } ?>
                    </select>
                </div>
            </div>

            <div class="col-xs-12" id="datepicker">
                <label>PERÍODO</label>
                <div class="input-daterange input-group" id="datepicker">
                    <input value="<?= (($filtro->DT_INICIO != '') ? date('d/m/Y', strtotime(implode("-", array_reverse(explode("/", $filtro->DT_INICIO))))) : date('d/m/Y')) ?> " <?= $dis ?> type="text" class="input-sm form-control" name="Inicio" id="Inicio<?= $id ?>" />
                    <span class="input-group-addon">até</span>
                    <input value="<?= (($filtro->DT_FIM != '') ? date('d/m/Y', strtotime(implode("-", array_reverse(explode("/", $filtro->DT_FIM))))) : date('d/m/Y')) ?> " <?= $dis ?> type="text" class="input-sm form-control" name="Fim" id="Fim<?= $id ?>" />
                </div>
            </div>


            <div class="col-xs-12">
                <label>MOTIVO DA SUSPENSÃO</label>
                <textarea  <?= $dis ?> class="form-control input-sm" name="Motivo" id="Motivo<?= $id ?>" rows="5"><?= $filtro->MOTIVO ?></textarea>
            </div>

            <?php if ($operacao == "A"): ?>
                <div class="col-xs-12">
                    <input type="checkbox" id="notificar<?= $id ?>" name="notificar" value="S"> <label>Notificar responsável via aplicativo?</label>
                </div>
            <?php endif; ?>
        </div>
        <div class="modal-footer" id="resp<?= $id ?>"></div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger2 pull-left" data-dismiss="modal">
                <i class="fa fa-times"></i> Fechar
            </button>
            <button type="button" class="btn btn-warning2" id="frmRegistrar<?= $id ?>">
                <i class="fa fa-save"></i> <?= $operacao == "D" ? "Deletar" : "Salvar" ?> 
            </button>
        </div>
        <input type="hidden" name="Operacao" id="Operacao<?= $id ?>" value="<?= $operacao ?>">
    </div>

    <script src="<?= base_url('assets/js/') ?>/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="<?= base_url('assets/js/bootstrap-multiselect.js') ?>"></script>
    <script>
<? if ($operacao != 'A') { ?>
            $.post("<?= base_url('/comum/combobox/serie') ?>", {
                curso: <?= $filtro->CD_CURSO ?>,
                selecionado: <?= $filtro->ORDEM_SERIE ?>,
            },
                    function (valor) {
                        $("select[id=Serie<?= $id ?>]").html(valor);
                    });
<? } ?>
    </script>
    <script type="text/javascript">
        $("select[id=Aluno<?= $id ?>]").multiselect();
        $('.input-daterange').datepicker();

        $("select[id=Curso<?= $id ?>]").change(function () {
            $("select[id=Serie<?= $id ?>]").html('<option>Carregando</option>');
            $.post("<?= base_url('/comum/combobox/serie') ?>", {
                curso: $(this).val()
            },
            function (valor) {
                $("select[id=Serie<?= $id ?>]").html(valor);
            });
        });

        $("select[id=Serie<?= $id ?>]").change(function () {
            $("select[id=Aluno<?= $id ?>]").multiselect('destroy');
            $("select[id=Aluno<?= $id ?>]").html('Carregando');
            $.post("<?= base_url('/comum/combobox/alunos') ?>", {
                curso: $('select[id=Curso<?= $id ?>]').val(),
                serie: $('select[id=Serie<?= $id ?>]').val(),
            },
                    function (data) {
                        $("select[id=Aluno<?= $id ?>]").html(data);
                        $("select[id=Aluno<?= $id ?>]").multiselect({
                            enableClickableOptGroups: true,
                            enableCollapsibleOptGroups: true,
                            enableFiltering: true,
                            includeSelectAllOption: true,
                            maxHeight: 200,
                            enableCaseInsensitiveFiltering: true,
                            numberDisplayed: 0
                        });
                        // evitar bug do multiselect em modals
                        // em que ao clicar não exibe lista            
                        $('.dropdown-toggle').dropdown();
                    });
        });

        $("button[id=frmRegistrar<?= $id ?>]").click(function () {

            if ($("select[id=Curso<?= $id ?>]").val() == '') {
                $("#resp<?= $id ?>").html('<label class="text-danger">Selecione o CURSO</label>');

            } else if ($("select[id=Serie<?= $id ?>]").val() == '') {
                $("#resp<?= $id ?>").html('<label class="text-danger">Selecione a SÉRIE </label>');

            } else if ($("select[id=Aluno<?= $id ?>]").val() == '') {
                $("#resp<?= $id ?>").html('<label class="text-danger">Selecione um ALUNO </label>');

            } else if ($("input[id=Inicio<?= $id ?>]").val() == '') {
                $("#resp<?= $id ?>").html('<label class="text-danger">Informe a DATA INÍCIO DA SUSPENSÃO </label>');

            } else if ($("input[id=Fim<?= $id ?>]").val() == '') {
                $("#resp<?= $id ?>").html('<label class="text-danger">Informe a DATA FIM DA SUSPENSÃO </label>');

            } else if ($("textarea[id=Motivo<?= $id ?>]").val() == '') {
                $("#resp<?= $id ?>").html('<label class="text-danger">Informe a MOTIVO DA SUSPENSÃO </label>');
            } else {
                var loading = "";
                
                if ($("#notificar<?= $id ?>:checked").val() == "S") {
                    loading = '<?= LOAD_NOTIFICACAO ?>';
                } else {
                    loading = '<?= LOAD ?>';
                }

                $("#resp<?= $id ?>").html(loading);
                
                $.post("<?= base_url('' . $this->session->userdata('SGP_SISTEMA') . '/suspensao/frmManter') ?>", {
                    operacao: $("input[id=Operacao<?= $id ?>]").val(),
                    codigo: $("input[id=Codigo<?= $id ?>]").val(),
                    aluno: $("select[id=Aluno<?= $id ?>]").val(),
                    inicio: $("input[id=Inicio<?= $id ?>]").val(),
                    fim: $("input[id=Fim<?= $id ?>]").val(),
                    motivo: $("textarea[id=Motivo<?= $id ?>]").val(),
                    notificar: $("#notificar<?= $id ?>:checked").val()
                },
                function (response) {
                    var tipo = "";

                    if (response['success'] && response['mensagem'] !== "") {
                        tipo = "warning";
                    } else if (response['success']) {
                        tipo = "success";
                    } else {
                        tipo = "error";
                    }

                    swal({
                        title: response['titulo'],
                        text: "<div style='max-height: 200px; overflow-y: auto'>" + response['mensagem'] + "</div>",
                        type: tipo,
                        html: true,
                        showCancelButton: false,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Ok",
                        closeOnConfirm: false
                    },
                    function () {
                        window.location = "<?= site_url($this->session->userdata('SGP_SISTEMA') . "/suspensao/index") ?>";
                    });
                }, "json");
            }
        });

    </script>
</div>
