<script src="<?= base_url('assets/js/') ?>/bootstrap-datepicker.min.js"></script>

<?php
$dis = (($operacao != 'I') ? 'disabled="disabled"' : '');
$disAll = (($operacao == 'D') ? 'disabled="disabled"' : '');
$id = $operacao . $codigo;
?>

<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">
            <h5 class="modal-title">
                Registro de Atendimento
                <i class="fa fa-2x fa-graduation-cap"></i>
            </h5>
        </div>

        <form id="formulario-registro<?= $id ?>">
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-xs-2">
                        <label>CÓDIGO</label>
                        <input value="<?= $registro->CD_REGISTRO ?>" readonly="readonly" type="text" name="codigo" id="codigo<?= $id ?>" class="form-control input-sm" />
                    </div>            

                    <div  class="col-xs-5">
                        <label>CURSO</label>
                        <select <?= $dis ?> required="required" name="curso" id="curso<?= $id ?>" class="form-control input-sm">
                            <option value=""></option>
                            <? foreach ($curso as $row) { ?>
                                <option <?= (($registro->CD_CURSO == $row['CD_CURSO']) ? 'selected="selected"' : '' ) ?> value="<?= $row['CD_CURSO'] ?>"><?= $row['NM_CURSO_RED'] ?></option>
                            <? } ?>
                        </select>
                    </div>

                    <div  class="col-xs-5">
                        <label>SÉRIE</label>
                        <select <?= $dis ?> required="required" name="serie" id="serie<?= $id ?>" class="form-control input-sm">
                            <option value=""></option>
                        </select>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-xs-9">
                        <label>RESPONSAVEL</label>
                        <select <?= $dis ?> required="required" name="responsavelAluno" id="responsavelAluno<?= $id ?>" class="form-control input-sm">
                            <? if ($operacao != 'I') { ?>
                                <option selected="selected" value="<?= $registro->ID_RESPONSAVEL . "-" . $registro->CD_ALUNO ?>">
                                    <?= $registro->NM_RESPONSAVEL . " | " . $registro->NM_ALUNO ?>
                                </option>
                            <? } ?>
                        </select>
                    </div>

                    <div class="col-xs-3">
                        <label>DATA</label>
                        <div class="input-group">
                            <input class="form-control input-sm" <?= $disAll ?> value="<?= (($registro->DT_ATENDIMENTO != '') ? date('d/m/Y', strtotime($registro->DT_ATENDIMENTO)) : date('d/m/Y')) ?>" class="input-sm form-control" name="data" id="data<?= $id ?>" />
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-6">
                        <label>DESCRIÇÃO DO ATENDIMENTO</label>
                        <textarea <?= $disAll ?> required="required" class="form-control input-sm" name="atendimento" id="atendimento<?= $id ?>" rows="5"><?= $registro->DS_ATENDIMENTO ?></textarea>
                    </div>

                    <div class="col-xs-6">
                        <label>OBSERVAÇÃO</label>
                        <textarea <?= $disAll ?> required="required" class="form-control input-sm" name="observacao" id="observacao<?= $id ?>" rows="5"><?= $registro->DS_OBSERVACAO ?></textarea>
                    </div>            
                </div>                
            </div>

            <div class="modal-footer" id="resp<?= $id ?>"></div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger2 pull-left" data-dismiss="modal">
                    <i class="fa fa-times"></i> Fechar
                </button>

                <button type="button" class="btn btn-<?= (($operacao == 'I') ? 'primary' : (($operacao == 'E') ? 'info' : 'danger')) ?> " id="frmRegistrar<?= $id ?>">
                    <i class="fa fa-<?= $operacao != "D" ? "save" : "trash"?>"></i> <?= (($operacao == 'I') ? 'REGISTRAR' : (($operacao == 'E') ? "Salvar" : LBL_BTN_EXCLUIR)) ?> 
                </button>
            </div>

            <input type="hidden" name="operacao" id="operacao<?= $id ?>" value="<?= $operacao ?>">
        </form>
    </div>

    <?php if ($operacao != 'I') { ?>
        <script type="text/javascript">
            $(document).ready(function () {

                $("#serie<?= $id ?>").html('<option>Carregando</option>');
                $.post("<?= base_url('/comum/combobox/serie') ?>", {
                    curso: <?= $registro->CD_CURSO ?>,
                    selecionado: <?= $registro->ORDEM_SERIE ?>
                },
                function (valor) {
                    $("#serie<?= $id ?>").html(valor);
                });
            });
        </script>
    <?php } ?>    

    <script type="text/javascript">
        $("#responsavelAluno<?= $id ?>").select2();

        $("#data<?= $id ?>").datepicker({
            format: "dd/mm/yyyy"
        });

        $("#curso<?= $id ?>").change(function () {
            $("#serie<?= $id ?>").html('<option>Carregando</option>');
            $.post("<?= base_url('/comum/combobox/serie') ?>", {
                curso: $(this).val()
            },
            function (valor) {
                $("#serie<?= $id ?>").html(valor);
            });
        });

        $("#serie<?= $id ?>").change(function () {
            $("#responsavelAluno<?= $id ?>").html('Carregando');
            $.post("<?= base_url('/comum/combobox/turma_responsavel_aluno') ?>", {
                curso: $('#curso<?= $id ?>').val(),
                serie: $('#serie<?= $id ?>').val(),
                tipo: 'T'
            },
            function (data) {
                $("#responsavelAluno<?= $id ?>").html(data);
            });
        });

        $("button[id=frmRegistrar<?= $id ?>]").click(function () {

            if ($("#curso<?= $id ?>").val() == '') {
                $("#resp<?= $id ?>").html('<label class="text-danger">Selecione o CURSO</label>');
            } else if ($("#serie<?= $id ?>").val() == '') {
                $("#resp<?= $id ?>").html('<label class="text-danger">Selecione a SÉRIE </label>');
            } else if ($("#responsavelAluno<?= $id ?>").val() == '') {
                $("#resp<?= $id ?>").html('<label class="text-danger">Selecione o RESPONSÁVEL </label>');
            } else if ($("#data<?= $id ?>").val() == '') {
                $("#resp<?= $id ?>").html('<label class="text-danger">Informe a DATA DO ATENDIMENTO </label>');
            } else if ($("#atendimento<?= $id ?>").val() == '') {
                $("#resp<?= $id ?>").html('<label class="text-danger">Informe a DESCRIÇÃO DO ATENDIMENTO </label>');
            } else {

                $("#resp<?= $id ?>").html('<?= LOAD ?>');

                var dados = $("#formulario-registro<?= $id ?>").serialize();

                $.post("<?= base_url($this->session->userdata('SGP_SISTEMA') . '/atendimento/formManter') ?>",
                        dados, function (response) {
                            $("#resp<?= $id ?>").html(response);
                        });
            }
        });

    </script>
</div>
