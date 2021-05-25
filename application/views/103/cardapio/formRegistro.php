<?php $this->load->view("home/header"); ?>

<div class="content animate-panel">
    <div class="row projects">
        <div class="hpanel hgreen">    
            <div class="panel-heading">                
            </div>

            <div class="panel-footer">                                
                <div class="row">
                    <form id="formulario-registro">
                        <div class="form-group col-xs-2">
                            <label>DATA</label>
                            <div class="input-group">
                                <input id="data" name="data" class="form-control">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>

                        <div class="form-group col-xs-3">
                            <label>TIPO DE CARDÁPIO</label>
                            <select id="tipo" name="tipo" class="form-control lista">
                                <option value=""></option>
                                <?php foreach ($tipos as $row): ?>
                                    <option value="<?= $row->CD_TIPO_CARDAPIO ?>">
                                        <?= $row->DC_TIPO_CARDAPIO ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>                        
                        </div>

                        <div class="form-group col-xs-3">
                            <label>OPÇÃO</label>
                            <select id="opcao" name="opcao" class="form-control lista">
                                <option value=""></option>
                                <?php foreach ($opcoes as $row): ?>
                                    <option value="<?= $row->CD_OPCAO_CARDAPIO ?>"><?= $row->DC_OPCAO_CARDAPIO ?></option>
                                <?php endforeach; ?>
                            </select>                        
                        </div>

                        <div class="form-group col-xs-4">
                            <label>MATERIAL</label>
                            <div class="input-group">
                                <select id="material" name="material" class="form-control lista">
                                    <option value=""></option>
                                    <?php foreach ($materiais as $row): ?>
                                        <option value="<?= $row->CD_MATERIAL ?>"><?= $row->NM_MATERIAL ?></option>
                                    <?php endforeach; ?>
                                </select>                        
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-info" id="btnAdicionar">
                                        <i class="fa fa-plus"></i> Adicionar
                                    </button>
                                </span>                            
                            </div>
                        </div>                        

                        <input type="hidden" id="inicio" name="inicio" value="<?= $inicio ?>">
                        <input type="hidden" id="fim" name="fim" value="<?= $fim ?>">
                        <input type="hidden" id="operacao" name="operacao" value="<?= $operacao ?>">
                    </form>
                </div>
            </div>

            <div class="panel-body">                
                <div id="grid-registro">                    
                </div>                    
            </div>       

            <div class="panel-footer">
                <a class="btn btn-primary btn-labeled" href="<?= site_url($this->session->userdata('SGP_SISTEMA') . "/cardapio/index") ?>">
                    <i class="fa fa-backward"></i> Voltar
                </a>                    

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("select").select2();

        $("#data").datepicker({
            format: "dd/mm/yyyy",
            startDate: "<?= $inicio ?>",
            endDate: "<?= $fim ?>"
        });

        var inicio = $("#inicio").val();
        var fim = $("#fim").val();

        $.post("<?= site_url($this->session->userdata("SGP_SISTEMA") . "/cardapio/gridRegistro") ?>", {
            semana: inicio + " - " + fim
        }, function (response) {
            $("#grid-registro").html(response);
        });
    });

    function validar() {
        var validou = true;
        var mensagem = "";

        if ($("#tipo").val() === "") {
            validou = false;
            mensagem = "Selecione o TIPO";
        } else if ($("#opcao").val() === "") {
            validou = false;
            mensagem = "Selecione a OPÇÃO";
        } else if ($("#material").val() === "") {
            validou = false;
            mensagem = "Selecione o MATERIAL";
        } else if ($("#data").val() === "") {
            validou = false;
            mensagem = "Informe a DATA";
        }

        if (!validou) {
            swal(mensagem, "O preenchimento do campo é obrigatório", "error");
        }

        return validou;
    }

    function limparCampos() {
        $("#tipo").select2("val", "");
        $("#opcao").select2("val", "");
        $("#material").select2("val", "");
    }

    $("#btnAdicionar").click(function () {
        if (validar()) {
            var dados = $("#formulario-registro").serialize();

            $.post("<?= site_url($this->session->userdata("SGP_SISTEMA") . "/cardapio/manterRegistro/I") ?>",
                    dados, function (response) {
                        var tipo = response['success'] ? "success" : "error";

                        if (response['success']) {
                            limparCampos();
                            atualizarCardapio();
                        } else {
                            swal(response['mensagem'], "", tipo);
                        }

                    }, "json");
        }
    });
</script>

<?php $this->load->view("home/footer"); ?>