<script src="<?= base_url('assets/js/bootstrap-select.min.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/bootstrap-select.css') ?>">
<script src="<?= base_url('assets/js/daterangepicker.js') ?>"></script>

<?php
$codigo = $registro->CD_EVENTO;
$id = empty($codigo) ? 0 : $codigo;
$id.= $operacao;
$disabled = $operacao == "D" || $operacao == "V" ? "disabled" : "";
?>

<div class="modal-dialog modal-lg">
    <div class="color-line"></div>

    <div class="modal-content">
        <form id="formulario-registro<?= $id ?>" enctype="multipart/form-data">
            <div class="modal-header" style="padding: 15px">
                <h5 class="modal-title text-right"><?= $titulo ?></h5>
            </div>

            <div class="modal-body">             
                <div class="row">
                    <div class="form-group col-xs-6">
                        <label>NOME EVENTO</label>
                        <input class="form-control input-sm" type="text" id="nome<?= $id ?>" name="nome" value="<?= $registro->NM_EVENTO ?>">
                    </div>

                    <div class="form-group col-xs-6">
                        <label>BANNER EVENTO</label>
                        <input type="file" id="imagem<?= $id ?>" name="imagem">
                    </div>                   
                </div>

                <div class="row">
                    <div class="form-group col-xs-4">
                        <label>DATA EVENTO</label>
                        <div class="input-group">
                            <input class="form-control input-sm" type="text" id="dataEvento<?= $id ?>" name="dataEvento" value="">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>                    
                        </div>                        
                    </div>                                                            

                    <div class="form-group col-xs-3">
                        <label>HORA INÍCIO</label>
                        <div class="input-group">
                            <input class="form-control input-sm timepicker" type="text" id="horaInicio<?= $id ?>" name="horaInicio" value="<?= $registro->HR_INICIO ?>">
                            <span class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </span>                    
                        </div>                        
                    </div>                    

                    <div class="form-group col-xs-3">
                        <label>HORA FIM</label>
                        <div class="input-group">
                            <input class="form-control input-sm timepicker" type="text" id="horaFim<?= $id ?>" name="horaFim" value="<?= $registro->HR_FIM ?>">
                            <span class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </span>                            
                        </div>                        
                    </div>

                    <div class="form-group col-xs-2">
                        <label>COR</label><br>
                        <input class="form-control colorpicker" type="text" id="cor<?= $id ?>" name="cor" value="<?= $registro->DS_COR ?>">
                    </div>
                </div>                

                <div class="row">
                    <div class="form-group col-xs-12">
                        <label>DESCRIÇÃO</label>
                        <textarea class="form-control input-sm editor" style="resize: none" rows="3" id="descricao<?= $id ?>" name="descricao" spellcheck="true"><?= isset($registro->DS_EVENTO) ? $registro->DS_EVENTO->read($registro->DS_EVENTO->size()) : "" ?></textarea>
                    </div>
                </div>

                <div class="row">
                    <?php if ($operacao === "I"): ?>
                        <div class="form-group col-xs-3">
                            <label>CURSO</label>
                            <select id="curso<?= $id ?>" name="cursos[]" class="form-control input-sm selectpicker" <?= $disabled ?> multiple="">                        
                                <?php foreach ($cursos as $row) : ?>
                                    <option value="<?= $row['CD_CURSO'] ?>"><?= $row['NM_CURSO_RED'] ?></option>
                                <?php endforeach; ?>
                            </select>                        
                        </div>

                        <div class="form-group col-xs-3">
                            <label>SÉRIE</label>
                            <select id="serie<?= $id ?>" name="series[]" class="form-control input-sm selectpicker" <?= $disabled ?> multiple="">                                                        
                            </select>                        
                        </div>

                        <div class="form-group col-xs-3">
                            <label>TURMA</label>
                            <select id="turma<?= $id ?>" name="turmas[]" class="form-control input-sm selectpicker" <?= $disabled ?> multiple="">                                                    
                            </select>                        
                        </div>                    

                        <div class="form-group col-xs-3">                        
                            <input type="checkbox" id="notificar<?= $id ?>" name="notificar" value="S" <?= $registro->FL_NOTIFICAR == "S" ? "checked" : "" ?>> Notificar via app responsável?                        
                        </div>
                    <?php endif; ?>

                    <?php if ($operacao == "E"): ?>
                        <div class="form-group col-xs-6">                        
                            <input type="checkbox" id="notificar<?= $id ?>" name="notificar" value="S" <?= $registro->FL_NOTIFICAR == "S" ? "checked" : "" ?>> Notificar via aplicativo o responsável?                        
                        </div>
                    <?php endif; ?>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <div class="well well-sm">
                            <div class="row">
                                <div class="col-xs-12">
                                    <h4 class="font-bold">PARA FINS DE PAGAMENTO</h4>
                                    <hr style="margin-top: 10px">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-xs-6">
                                    <label>PRODUTO</label>
                                    <select class="form-control input-sm" id="produto<?= $id ?>" name="produto">
                                        <option value="">EVENTO GRATUITO</option>
                                        <?php foreach ($produtos as $row): ?>                                                                
                                            <option <?= $row->CD_PRODUTO == $registro->CD_PRODUTO ? "selected" : "" ?> value="<?= $row->CD_PRODUTO ?>">
                                                <?= $row->NM_PRODUTO . " - R$ " . number_format($row->PRECO, 2, ",", "") ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>                    

                                <div class="form-group col-xs-4">
                                    <label>VENCIMENTO BOLETO</label>
                                    <div class="input-group">
                                        <input class="form-control input-sm datepicker" type="text" id="dataVencimento<?= $id ?>" name="dataVencimento" value="<?= empty($registro->DT_FIM) || empty($registro->CD_PRODUTO) ? "" : date("d/m/Y", strtotime($registro->DT_FIM)) ?>" <?= empty($registro->DT_FIM) || empty($registro->CD_PRODUTO) ? "disabled" : "" ?>>
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>                                    
                                        </span>
                                    </div>                        
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <input id="codigo<?= $id ?>" name="codigo" type="hidden" value="<?= $registro->CD_EVENTO ?>"/>
                <input id="operacao<?= $id ?>" name="operacao" type="hidden" value="<?= $operacao ?>"/>                
            </div>

            <div class="modal-footer">
                <div id="resposta<?= $id ?>">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                    <i class="fa fa-times"></i> Fechar
                </button>

                <button type="submit" class="btn btn-<?= $operacao == "D" ? "danger" : "success" ?> pull-right">
                    <i class="fa fa-<?= $operacao == "D" ? "trash" : "save" ?>"></i>
                    <?= $operacao == "D" ? LBL_BTN_EXCLUIR : LBL_BTN_SALVAR ?>
                </button> 
            </div>
        </form>
    </div>

    <script type="text/javascript">
        $(".colorpicker").spectrum({
            color: "",
            preferredFormat: "hex",
            chooseText: "Ok",
            cancelText: "Cancelar",            
            change: function (color) {
                $("#cor<?= $id ?>").val(color.toHexString());
            }
        });

        $(document).ready(function () {
            if (tinymce.activeEditor !== null) {
                tinymce.activeEditor.destroy();
            }

            tinymce.init({
                mode: "textareas",
                language: "pt_BR",
                selector: "#descricao<?= $id ?>",
                plugins: [
                    "paste save"
                ],
                forced_root_block: false,
                menubar: false,
                statusbar: false,
                toolbar: [
                    'bold '
                ],
                paste_as_text: true
            });

            $(".selectpicker").selectpicker({
                noneSelectedText: ""
            });

            $(".datepicker").datepicker({
                format: 'dd/mm/yyyy',
                language: 'pt-BR',
                autoclose: true,
                startDate: "0d"
            });

            $("#dataEvento<?= $id ?>").daterangepicker({
                autoUpdateInput: $("#operacao<?= $id ?>").val() === "E" ? true : false,
                startDate: "<?= $registro->DT_INICIO == null ? date("d/m/Y") : date('d/m/Y', strtotime($registro->DT_INICIO)) ?>",
                endDate: "<?= $registro->DT_FIM == null ? date("d/m/Y") : date('d/m/Y', strtotime($registro->DT_FIM)) ?>",
                locale: {
                    format: "DD/MM/YYYY",
                    applyLabel: "Ok",
                    cancelLabel: "Cancelar"
                },
                minDate: "<?= date('d/m/Y') ?>"
            });

            $("#dataEvento<?= $id ?>").on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            });

            $("#dataEvento<?= $id ?>").on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });

            $(".timepicker").timepicker({
                showMeridian: false,
                defaultTime: false
            });
        });

        $("#produto<?= $id ?>").change(function () {
            if ($("#produto<?= $id ?>").val() === "") {
                $("#dataVencimento<?= $id ?>").val("");
                $("#dataVencimento<?= $id ?>").attr("disabled", true);
            } else {
                $("#dataVencimento<?= $id ?>").attr("disabled", false);
            }
        });

        $("#curso<?= $id ?>").change(function () {
            $("#serie<?= $id ?>").html("");
            $("#turma<?= $id ?>").html("");                      
            
            $("#serie<?= $id ?>").selectpicker("refresh");            
            $("#turma<?= $id ?>").selectpicker("refresh");

            $.post("<?= site_url("comum/combobox/serie") ?>", {
                curso: $("#curso<?= $id ?>").selectpicker("val"),
                multiplo: true
            },
            function (response) {
                $("#serie<?= $id ?>").html(response);
                
                $("#serie<?= $id ?>").selectpicker("refresh");
                $("#turma<?= $id ?>").selectpicker("refresh");
            });
        });

        $("#serie<?= $id ?>").change(function () {
            $("#turma<?= $id ?>").html("");
            $("#turma<?= $id ?>").selectpicker("refresh");

            $.post("<?= site_url("comum/combobox/turma_regular") ?>", {
                curso: $("#curso<?= $id ?>").selectpicker("val"),
                serie: $("#serie<?= $id ?>").selectpicker("val"),
                multiplo: true
            }, function (response) {
                $("#turma<?= $id ?>").html(response);
                $("#turma<?= $id ?>").selectpicker("refresh");
            });
        });

        function validar() {
            tinymce.triggerSave();
            var status = true;
            var mensagem = "";
            var operacao = "<?= $operacao ?>";

            if ($("#nome<?= $id ?>").val() === "") {
                status = false;
                mensagem = '<label class="text-danger">Informe o NOME EVENTO</label>';

            } else if ($("#dataEvento<?= $id ?>").val() === "") {
                status = false;
                mensagem = '<label class="text-danger">Informe a DATA EVENTO</label>';

            } else if ($("#horaInicio<?= $id ?>").val() === "") {
                status = false;
                mensagem = '<label class="text-danger">Informe a HORA INÍCIO</label>';

            } else if ($("#horaFim<?= $id ?>").val() === "") {
                status = false;
                mensagem = '<label class="text-danger">Informe a HORA FIM</label>';

            } else if ($("#cor<?= $id ?>").val() === "") {
                status = false;
                mensagem = '<label class="text-danger">Selecione uma COR</label>';

            } else if ($("#descricao<?= $id ?>").val() === "") {
                status = false;
                mensagem = '<label class="text-danger">Informe a DESCRIÇÃO</label>';

            } else if (operacao === "I" && $("#curso<?= $id ?>").selectpicker('val') === null) {
                status = false;
                mensagem = '<label class="text-danger">Selecione o(s) CURSO(S)</label>';

            } else if ($("#produto<?= $id ?>").val() !== "" && $("#dataVencimento<?= $id ?>").val() === "") {
                status = false;
                mensagem = '<label class="text-danger">Informe a DATA VENCIMENTO</label>';
            }

            if (!status) {
                $("#resposta<?= $id ?>").html(mensagem);
            }

            return status;
        }

        $("#formulario-registro<?= $id ?>").submit(function (e) {
            if (validar()) {
                var dados = new FormData(this);
                $("#resposta<?= $id ?>").html('<?= LOAD ?>');

                $.ajax({
                    url: "<?= site_url($this->session->userdata('SGP_SISTEMA') . "/calendario_evento/formManter") ?>",
                    data: dados,
                    type: "post",
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        //$("#resposta<?= $id ?>").html(data['mensagem']);
                        $("#resposta<?= $id ?>").html('Enviado com sucesso!');
                    }
                });
            }

            e.preventDefault();
        });
    </script>
</div>