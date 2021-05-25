<?php
$disabled = $operacao == "D" || $operacao == "V" ? "disabled" : "";
$disabledUpdate = $operacao == "E" ? "disabled" : "";
$multiple = $operacao == "I" ? "multiple" : "";
?>

<div class="modal-dialog modal-lg">
    <div class="color-line"></div>

    <div class="modal-content">
        <form id="formulario-solicitacao">
            <div class="modal-header" style="padding: 15px">
                <h5 class="modal-title text-right"><?= $titulo ?></h5>
            </div>

            <div class="modal-body">             
                <div class="row">
                    <div class="form-group col-xs-4">
                        <label>PROFESSOR(ES)</label>
                        <select name="professor[]" id="professor" class="form-control input-sm" <?php echo $disabled, $multiple, $disabledUpdate ?> >                            
                            <?php foreach ($professores as $row) : ?>
                                <option <?= (($solicitacao->CD_PROFESSOR == $row->CD_PROFESSOR) ? 'selected=selected' : '') ?> value="<?= $row->CD_PROFESSOR ?>"><?= $row->NM_PROFESSOR ?></option>
                            <?php endforeach; ?>
                        </select>

                        <?php if ($operacao === "E"): ?>
                            <input type="hidden" name="professor[]" value="<?= $solicitacao->CD_PROFESSOR ?>">
                        <?php endif; ?>
                    </div>                    

                    <div class="form-group col-xs-4">
                        <label>MOTIVO</label>
                        <select name="motivo" id="motivo" class="form-control" <?= $disabled ?>>                             
                            <option></option>

                            <?php foreach ($motivos as $row) : ?>
                                <option <?= (($solicitacao->CD_MOTIVO == $row->CD_MOTIVO) ? 'selected=selected' : '') ?> value="<?= $row->CD_MOTIVO ?>"><?= $row->NM_MOTIVO ?></option>
                            <? endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group col-xs-4">
                        <label>DATA PENDÊNCIA</label>
                        <input type="text" id="dataPendencia" name="dataPendencia" value="<?= empty($solicitacao->DT_PENDENCIA) ? "" : date("d/m/Y", strtotime($solicitacao->DT_PENDENCIA)) ?>" class="form-control" <?= $disabled ?>>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-12">
                        <label>DESCRIÇÃO</label>
                        <textarea maxlength="1000" name="descricao" id="descricao" spellcheck="true" rows="2" class="form-control" <?= $disabled ?>><?= $solicitacao->DS_SOLICITACAO ?></textarea>
                    </div>

                    <input name="codigo" type="hidden" value="<?= $solicitacao->CD_SOLICITACAO ?>"/>
                    <input id="operacao" name="operacao" type="hidden" value="<?= $operacao ?>"/>
                </div>

                <fieldset>
                    <legend>Aulas</legend>

                    <div class="row">
                        <div class="col-xs-12">
                            <div id="aulas-pendente" style="max-height: 150px; overflow-y: auto">
                                <?php
                                if ($operacao !== "I") {
                                    $data = array(
                                        'aulas' => $aulas,
                                        'operacao' => $operacao,
                                    );

                                    echo $this->load->view("113/justificativa_solicitacao/gridRegistroAulas", $data, true);
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>

            <div class="modal-footer">
                <div id="resposta">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                    <i class="fa fa-times"></i> Fechar
                </button>

                <?php if ($operacao !== "V"): ?>
                    <button type="button" id="btnConfirmar" class="btn btn-<?= $operacao == "D" ? "danger" : "success" ?> pull-right">
                        <i class="fa fa-<?= $operacao == "D" ? "trash" : "save" ?>"></i>
                        <?= $operacao == "D" ? LBL_BTN_EXCLUIR : LBL_BTN_SALVAR ?>
                    </button> 
                <?php endif; ?>
            </div>
        </form>        
    </div>

    <?php if ($operacao === "I"): ?>
        <script type="text/javascript" src="<?= base_url('assets/js/bootstrap-multiselect.js') ?>">
        </script>

        <script type="text/javascript">
            $("#professor").multiselect({
                enableClickableOptGroups: true,
                enableCollapsibleOptGroups: true,
                enableFiltering: true,
                includeSelectAllOption: true,
                maxHeight: 200,
                enableCaseInsensitiveFiltering: true,
                filterPlaceholder: 'Digite o nome do Professor',
                numberDisplayed: 0
            });
        </script>
    <?php endif; ?>

    <script type="text/javascript">
        $("#dataPendencia").datepicker({
            format: 'dd/mm/yyyy',
            language: 'pt-BR',
            endDate: '-1d',
            autoclose: true
        });

        $("#motivo").select2();

        $("#dataPendencia, #professor").change(function () {
            if ($("#professor").val() !== null && $("#dataPendencia").val() !== "") {
                var dados = $("#formulario-solicitacao").serialize();

                $("#resposta").html('<?= LOAD ?>');
                $("#aulas-pendente").html("");

                $.ajax({
                    url: "<?= site_url("113/justificativa_solicitacao/obterAulasPendente") ?>",
                    data: dados,
                    method: "post",
                    dataType: "json",
                    success: function (response) {
                        $("#resposta").html("");

                        if (response['success']) {
                            $("#aulas-pendente").html(response['mensagem']);
                        } else {
                            $("#resposta").html(response['mensagem']);
                        }
                    }
                });
            }
        });

        function validar() {
            var status = true;
            var aulas = $("#aulas-pendente input[type=checkbox]:checked");

            if ($("#professor").val() === null) {
                status = false;
                $("#resposta").html('<label class="text-danger">Informe o PROFESSOR</label>');
            } else if ($("#motivo").val() === "") {
                status = false;
                $("#resposta").html('<label class="text-danger">Informe o MOTIVO</label>');
            } else if ($("#dataPendencia").val() === "") {
                status = false;
                $("#resposta").html('<label class="text-danger">Informe a DATA DA PENDÊNCIA</label>');
            } else if ($("#descricao").val() === "") {
                status = false;
                $("#resposta").html('<label class="text-danger">Informe a DESCRIÇÃO</label>');
            } else if (aulas.length === 0) {
                status = false;
                $("#resposta").html('<label class="text-danger">Selecione as AULAS COM PENDÊNCIA</label>');
            } else if (aulas.length > 0) {
                //verificar se para cada professor foi selecionada uma aula
                professores = $("#professor").find("option:selected");
                for (j = 0; j < professores.length; j++) {
                    status = false;
                    for (i = 0; i < aulas.length; i++) {
                        aux = $(aulas[i]).val().split("-");

                        if ($(professores[j]).val() === aux[1]) {
                            status = true;
                            break;
                        }
                    }

                    //se professor não tiver a aula disparar mensagem
                    if (!status) {
                        mensagem = "Selecione uma aula do(a) professor(a): " + $(professores[j]).text();
                        $("#resposta").html('<label class="text-danger">' + mensagem + '</label>');
                        break;
                    }
                }
            }

            return status;
        }

        $("#btnConfirmar").click(function () {
            var dados = $("#formulario-solicitacao").serialize();

            //validar se campos foram preenchidos
            if (validar()) {
                $.ajax({
                    url: "<?= site_url("113/justificativa_solicitacao/formManter") ?>",
                    data: dados,
                    type: "post",
                    dataType: "json",
                    success: function (data) {
                        $("#resposta").html("");

                        if (data['success']) {
                            $("#resposta").html(data['mensagem']);
                        } else {
                            $("#resposta").html(data['mensagem']);
                        }
                    }
                });
            }
        });
    </script>
</div>