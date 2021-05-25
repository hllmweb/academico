<?php
$codigo = $registro->CD_CARDAPIO;
$id = empty($codigo) ? 0 : $codigo;
$id.= $operacao;
$disabled = $operacao == "D" ? "disabled" : "";
?>

<div class="modal-dialog modal-lg">
    <div class="color-line"></div>

    <div class="modal-content">
        <form id="formulario-registro<?= $id ?>">
            <div class="modal-header" style="padding: 15px">
                <h5 class="modal-title text-right"><?= $titulo ?></h5>
            </div>

            <div class="modal-body">             
                <div class="hpanel">
                    <div class="row">
                        <div class="col-xs-6">
                            <label>TIPO DE CARDÁPIO</label>
                            <select id="tipo<?= $id ?>" name="tipo" class="form-control" disabled="">
                                <option value=""></option>
                                <?php foreach ($tipos as $row): ?>
                                    <option <?= $row->CD_TIPO_CARDAPIO == $registro->CD_TIPO_CARDAPIO ? "selected" : "" ?>
                                        value="<?= $row->CD_TIPO_CARDAPIO ?>">
                                            <?= $row->DC_TIPO_CARDAPIO ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>                        
                        </div>

                        <div class="col-xs-6">
                            <label>OPÇÃO</label>
                            <select id="opcao<?= $id ?>" name="opcao" class="form-control" disabled="">
                                <option value=""></option>
                                <?php foreach ($opcoes as $row): ?>
                                    <option <?= $row->CD_OPCAO_CARDAPIO == $registro->CD_OPCAO_CARDAPIO ? "selected" : "" ?>
                                        value="<?= $row->CD_OPCAO_CARDAPIO ?>"><?= $row->DC_OPCAO_CARDAPIO ?></option>
                                    <?php endforeach; ?>
                            </select>                        
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6">
                            <label>DATA</label>
                            <input id="data<?= $id ?>" name="data" class="form-control" value="<?= date('d/m/Y', strtotime($registro->DT_CARDAPIO)) ?>" disabled="">
                        </div>

                        <div class="col-xs-6">
                            <label>MATERIAL</label>
                            <select id="material<?= $id ?>" name="material" class="form-control" <?= $disabled ?>>
                                <option value=""></option>
                                <?php foreach ($materiais as $row): ?>
                                    <option <?= $row->CD_MATERIAL == $registro->CD_MATERIAL ? "selected" : "" ?>
                                        value="<?= $row->CD_MATERIAL ?>"><?= $row->NM_MATERIAL ?></option>
                                    <?php endforeach; ?>
                            </select>                        
                        </div>                        
                    </div>                    
                </div>
            </div>

            <div class="modal-footer">
                <div id="resposta<?= $id ?>">
                </div>
            </div>

            <div class="modal-footer">
                <input type="hidden" name="codigo" value="<?= $registro->CD_CARDAPIO ?>">
                <input type="hidden" name="operacao" value="<?= $operacao ?>">

                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                    <i class="fa fa-times"></i> Fechar
                </button>

                <div class="pull-right">                    
                    <?php if ($operacao == "E"): ?>
                        <button type="button" id="btnEditar<?= $id ?>" class="btn btn-success">
                            <i class="fa fa-edit"></i> Salvar
                        </button>                

                    <?php elseif ($operacao == "D"): ?>
                        <button type="button" id="btnDeletar<?= $id ?>" class="btn btn-danger">
                            <i class="fa fa-trash"></i> <?= LBL_BTN_EXCLUIR ?>
                        </button>                
                    <?php endif; ?>
                </div>                
            </div>
        </form>
    </div>

    <script type="text/javascript">
        function atualizarCardapio() {
            var inicio = $("#dataInicio").val();
            var fim = $("#dataFim").val();

            $("#grid-registro").html('<?= LOAD ?>');

            $.post("<?= site_url($this->session->userdata("SGP_SISTEMA") . "/cardapio/gridRegistro") ?>", {
                semana: inicio + " - " + fim
            }, function (response) {
                $("#grid-registro").html(response);
            });
        }

        function validar() {
            var validou = true;

            if ($("#material<?= $id ?>").val() === "") {
                validou = false;
                swal("Selecione o MATERIAL", "O preenchimento do campo é obrigatório", "error");
            }

            return validou;
        }

        $("#btnEditar<?= $id ?>").click(function () {
            if (validar()) {
                var dados = $("#formulario-registro<?= $id ?>").serialize();

                $.post("<?= site_url($this->session->userdata('SGP_SISTEMA') . "/cardapio/manterRegistro") ?>",
                        dados,
                        function (response) {
                            var tipo = response['success'] ? "success" : "error";
                            swal(response['mensagem'], "", tipo);

                            if (response['success']) {
                                atualizarCardapio();
                                $('#modalWarningRegistro').modal('hide');
                            }
                        }, "json");
            }
        });

        $("#btnDeletar<?= $id ?>").click(function () {
            swal({
                title: "Excluir",
                text: "Tem certeza que deseja remover essa opção do cardápio?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                cancelButtonText: "Não",
                confirmButtonText: "Sim",
                closeOnConfirm: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    var dados = $("#formulario-registro<?= $id ?>").serialize();

                    $.post("<?= site_url($this->session->userdata('SGP_SISTEMA') . "/cardapio/manterRegistro") ?>",
                            dados, function (response) {
                                var tipo = response['success'] ? "success" : "error";
                                swal(response['mensagem'], "", tipo);

                                if (response['success']) {
                                    atualizarCardapio();
                                    $('#modalDangerRegistro').modal('hide');
                                }
                            }, "json");
                }
            });
        });
    </script>
</div>