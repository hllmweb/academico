<?php
$disabled = $operacao == "D" || $operacao == "V" ? "disabled" : "";
?>

<div class="modal-dialog modal-lg">
    <div class="color-line"></div>

    <div class="modal-content">
        <form id="formulario-registro">
            <div class="modal-header" style="padding: 15px">
                <h5 class="modal-title text-right"><?= $titulo ?></h5>
            </div>

            <div class="modal-body">             
                <?php if ($operacao == "I"): ?>
                    <div class="row">
                        <div class="form-group col-xs-4">
                            <label>CURSO</label>
                            <select name="curso" id="curso" class="form-control input-sm" <?php echo $disabled ?> >                            
                                <option value=""></option>
                                <?php foreach ($cursos as $row) : ?>
                                    <option value="<?= $row['CD_CURSO'] ?>"><?= $row['NM_CURSO_RED'] ?></option>
                                <?php endforeach; ?>
                            </select>                        
                        </div>                    

                        <div class="form-group col-xs-4">
                            <label>SÉRIE</label>
                            <select name="serie" id="serie" class="form-control input-sm" <?= $disabled ?>>                             
                                <option></option>                            
                            </select>
                        </div>

                        <div class="form-group col-xs-4">
                            <label>TURMA</label>
                            <select name="turma" id="turma" class="form-control input-sm" <?= $disabled ?>>                             
                                <option></option>                            
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 form-group">                            
                            <label>TIPO DE DESTINATÁRIO</label>
                            <div>
                                <label class="radio-inline">
                                    <input type="radio" name="tipo" value="AL"> Aluno
                                </label>

                                <label class="radio-inline">
                                    <input type="radio" name="tipo" value="RF"> Responsável Financeiro
                                </label>

                                <label class="radio-inline">
                                    <input type="radio" name="tipo" value="RA"> Responsável Acadêmico
                                </label>
                            </div>
                        </div>

                        <div class="col-xs-6">
                            <label>DESTINATÁRIO</label>
                            <select name="destinatario[]" id="destinatario" class="form-control input-sm selectpicker" multiple="">
                            </select>
                        </div>
                    </div>                        
                <?php endif; ?>

                <div class="row">
                    <?php if ($operacao == "V"): ?>
                        <div class="form-group col-xs-12">
                            <label>DESTINATÁRIO</label>
                            <select name="destinatario" id="destinatario" class="form-control input-sm" <?= $disabled ?>>                                                            
                                <option value="<?= $registro->CD_DESTINATARIO ?>"><?= $registro->NM_DESTINATARIO ?></option>
                            </select>
                        </div>
                    <?php endif; ?>

                    <div class="form-group col-xs-12">
                        <label>TÍTULO</label>
                        <input name="titulo" id="titulo" value="<?= $registro->DS_TITULO ?>" class="form-control input-sm" <?= $disabled ?>>
                    </div>

                    <div class="col-xs-12">
                        <label>MENSAGEM</label>
                        <textarea name="mensagem" maxlength="2000" id="mensagem" spellcheck="true" rows="2" class="form-control input-sm" <?= $disabled ?>><?= $registro->DS_MENSAGEM ?></textarea>
                    </div>

                    <input id="codigo" name="codigo" type="hidden" value="<?= $registro->CD_COMUNICADO ?>"/>
                    <input id="operacao" name="operacao" type="hidden" value="<?= $operacao ?>"/>
                </div>                
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
                    <button type="button" id="btnConfirmar" class="btn btn-success pull-right">
                        <i class="fa fa-save"></i>
                        <?= LBL_BTN_SALVAR ?>
                    </button> 
                <?php elseif ($operacao === "V" && $registro->FLG_LIDO == "N"): ?>
                    <button type="button" id="btnEnviar" class="btn btn-success pull-right">
                        <i class="fa fa-refresh"></i>
                        Reenviar
                    </button> 
                <?php endif; ?>
            </div>
        </form>        
    </div>

    <?php if ($operacao === "I"): ?>
        <script type="text/javascript" src="<?= base_url('assets/js/bootstrap-multiselect.js') ?>"></script>

        <script type="text/javascript">
            function initMultiselect() {
                $("#destinatario").multiselect({
                    enableClickableOptGroups: true,
                    enableCollapsibleOptGroups: true,
                    enableFiltering: true,
                    includeSelectAllOption: true,
                    maxHeight: 200,
                    enableCaseInsensitiveFiltering: true,
                    numberDisplayed: 0
                });
            }
            initMultiselect();
        </script>
    <?php endif; ?>

    <script type="text/javascript">
        $("#curso").change(function () {
            $("#serie").html("");
            $("#turma").html("");

            $.post("<?= base_url('comum/combobox/serie') ?>", {
                curso: $(this).val()
            },
            function (valor) {
                $("#serie").html(valor);
            });
        });

        $("#serie").change(function () {
            $("#turma").html("");

            $.post("<?= base_url('comum/combobox/turma') ?>", {
                curso: $("#curso").val(),
                serie: $(this).val()
            },
            function (valor) {
                $("#turma").html(valor);
            });
        });

        $("#turma").change(function () {
            atualizaDestinatarios();
        });

        function atualizaDestinatarios() {
            $("#destinatario").html("");
            $("#destinatario").multiselect("destroy");

            var url = "";
            var tipo = "";

            if ($("input[name=tipo]:checked").val() === "RF" ||
                    $("input[name=tipo]:checked").val() === "RA") {
                url = "<?= base_url("comum/combobox/turma_responsaveis") ?>";
            } else {
                url = "<?= base_url("comum/combobox/turma_alunos") ?>";
            }

            if ($("input[name=tipo]:checked").val() === "RF") {
                tipo = "F";
            } else {
                tipo = null;
            }

            $.post(url, {
                curso: $("#curso").val(),
                serie: $("#serie").val(),
                turma: $("#turma").val(),
                tipo: tipo,
                multiplo: true
            }, function (response) {
                $("#destinatario").html(response);
                initMultiselect();
            });
        }

        $("input[name=tipo]").change(function () {
            atualizaDestinatarios();
        });

        function validar() {
            var status = true;

            if ($("#curso").val() === "") {
                status = false;
                $("#resposta").html('<label class="text-danger">Informe o CURSO</label>');

            } else if ($("#serie").val() === "") {
                status = false;
                $("#resposta").html('<label class="text-danger">Informe o SÉRIE</label>');

            } else if ($("#turma").val() === "") {
                status = false;
                $("#resposta").html('<label class="text-danger">Informe a TURMA</label>');

            } else if ($("input[name=tipo]:checked").length === 0) {
                status = false;
                $("#resposta").html('<label class="text-danger">Informe o TIPO DE DESTINATÁRIO</label>');

            } else if ($("#destinatario").val() === null) {
                status = false;
                $("#resposta").html('<label class="text-danger">Selecione pelo menos um DESTINATÁRIO</label>');

            } else if ($("#titulo").val() === "") {
                status = false;
                $("#resposta").html('<label class="text-danger">Informe o TÍTULO</label>');

            } else if ($("#mensagem").val() === "") {
                status = false;
                $("#resposta").html('<label class="text-danger">Informe a MENSAGEM</label>');
            }

            return status;
        }

        $("#btnConfirmar").click(function () {
            var dados = $("#formulario-registro").serialize();

            $("#resposta").html('<?= LOAD_NOTIFICACAO ?>');

            //validar se campos foram preenchidos
            if (validar()) {
                $.post("<?= site_url($this->session->userdata("SGP_SISTEMA") . "/comunicado/formManter") ?>",
                        dados,
                        function (response) {
                            $("#resposta").html(response);
                        });
            }
        });

        $("#btnEnviar").click(function () {
            $("#resposta").html('<?= LOAD_NOTIFICACAO ?>');

            $.post("<?= site_url($this->session->userdata("SGP_SISTEMA") . "/comunicado/formManter") ?>", {
                codigo: $("#codigo").val(),
                operacao: "R"
            },
            function (response) {
                $("#resposta").html(response);
            });
        });
    </script>
</div>