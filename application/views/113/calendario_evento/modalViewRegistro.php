<?php
$codigo = $registro->CD_EVENTO;
$id = empty($codigo) ? 0 : $codigo;
$id.= $operacao;
?>

<div class="modal-dialog modal-lg">
    <div class="color-line"></div>

    <div class="modal-content">
        <form id="formulario-registro<?= $id ?>" enctype="multipart/form-data">
            <div class="modal-header" style="padding: 15px">
                <h5 class="modal-title text-right"><?= $titulo ?></h5>
            </div>

            <div class="modal-body">             
                <div class="hpanel">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a data-toggle="tab" href="#tab-evento<?= $registro->CD_EVENTO ?>" aria-expanded="true">
                                <i class="fa fa-list"></i> EVENTO
                            </a>
                        </li>

                        <li>
                            <a data-toggle="tab" href="#tab-alunos<?= $registro->CD_EVENTO ?>" aria-expanded="false">
                                <i class="fa fa-user"></i> ALUNOS
                            </a>
                        </li>
                    </ul>

                    <!-- DADOS EVENTO -->
                    <div class="tab-content">
                        <div id="tab-evento<?= $registro->CD_EVENTO ?>" class="tab-pane active">                                
                            <div class="panel-body">
                                <div class="row">
                                    <div class="form-group col-xs-4">
                                        <img alt="Foto Banner" src="<?= $registro->DS_IMAGEM ?>" style="height: 150px; width: 100%" />
                                    </div>                                   

                                    <div class="form-group col-xs-8">
                                        <div class="row">
                                            <div class="form-group col-xs-3">
                                                <label>CODIGO</label>
                                                <input class="form-control input-sm" type="text" id="codigo<?= $id ?>" name="codigo" value="<?= $registro->CD_EVENTO ?>" disabled="">
                                            </div>

                                            <div class="form-group col-xs-9">
                                                <label>NOME EVENTO</label>
                                                <input class="form-control input-sm" type="text" id="nome<?= $id ?>" name="nome" value="<?= $registro->NM_EVENTO ?>" disabled="">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-xs-3">
                                                <label>DATA INÍCIO</label>
                                                <input class="form-control input-sm datepicker" type="text" id="dataInicio<?= $id ?>" name="dataInicio" value="<?= empty($registro->DT_INICIO) ? "" : date("d/m/Y", strtotime($registro->DT_INICIO)) ?>" disabled="">
                                            </div>                                        

                                            <div class="form-group col-xs-3">
                                                <label>DATA FIM</label>
                                                <input class="form-control input-sm datepicker" type="text" id="dataFim<?= $id ?>" name="dataFim" value="<?= empty($registro->DT_FIM) ? "" : date("d/m/Y", strtotime($registro->DT_FIM)) ?>" disabled="">
                                            </div>                                    

                                            <div class="form-group col-xs-3">
                                                <label>HORÁRIO</label>
                                                <input class="form-control input-sm timepicker" type="text" id="horaInicio<?= $id ?>" name="horaInicio" value="<?= $registro->HR_INICIO . " - " . $registro->HR_FIM ?>" disabled="">
                                            </div>                    

                                            <div class="form-group col-xs-2">
                                                <label>COR</label><br>
                                                <input class="form-control colorpicker" type="text" id="cor<?= $id ?>" name="cor" value="<?= $registro->DS_COR ?>" disabled="">
                                            </div>
                                        </div>
                                    </div>
                                </div>                

                                <div class="row">
                                    <div class="form-group col-xs-12">
                                        <label>DESCRIÇÃO</label>
                                        <textarea class="form-control input-sm editor" style="resize: none" rows="3" id="descricao<?= $id ?>" name="descricao" spellcheck="true" disabled=""><?= isset($registro->DS_EVENTO) ? $registro->DS_EVENTO->read($registro->DS_EVENTO->size()) : "" ?></textarea>
                                    </div>
                                </div>                                

                                <div class="row">
                                    <div class="form-group col-xs-6">
                                        <label>PRODUTO</label>
                                        <select class="form-control input-sm" id="produto<?= $id ?>" name="produto" disabled="">
                                            <option value="">EVENTO GRATUITO</option>
                                            <?php foreach ($produtos as $row): ?>                                                                
                                                <option <?= $row->CD_PRODUTO == $registro->CD_PRODUTO ? "selected" : "" ?> value="<?= $row->CD_PRODUTO ?>">
                                                    <?= $row->NM_PRODUTO ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <?php if ($registro->CD_PRODUTO !== null) : ?>
                                        <div class="form-group col-xs-3">
                                            <label>PREÇO</label>
                                            <input class="form-control input-sm datepicker" type="text" id="preco<?= $id ?>" name="preco" value="<?= number_format($produtos[0]->PRECO, 2, ',', '') ?>" disabled="">
                                        </div>

                                        <div class="form-group col-xs-3">
                                            <label>VENCIMENTO BOLETO</label>
                                            <input class="form-control input-sm datepicker" type="text" id="dataFim<?= $id ?>" name="dataFim" value="<?= empty($registro->DT_FIM) ? "" : date("d/m/Y", strtotime($registro->DT_FIM)) ?>" disabled="">
                                        </div>
                                    <?php endif; ?>

                                    <div class="form-group col-xs-3">                        
                                        <input type="checkbox" id="notificar<?= $id ?>" name="notificar" value="S" <?= $registro->FL_NOTIFICAR == "S" ? "checked" : "" ?> disabled> Notificar via aplicativo o responsável?                        
                                    </div>
                                </div>

                                <input id="codigo<?= $id ?>" name="codigo" type="hidden" value="<?= $registro->CD_EVENTO ?>"/>                
                            </div>
                        </div>

                        <!-- DADOS ALUNO -->
                        <div id="tab-alunos<?= $registro->CD_EVENTO ?>" class="tab-pane">
                            <div class="panel-body" style="padding: 0px">
                                <table class="table table-hover table-condensed table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">MATRÍCULA</th>
                                            <th class="text-center">NOME</th>
                                            <th class="text-center">RESPONSÁVEL</th>
                                            <th class="text-center">AUTORIZOU</th>
                                            <?php if ($registro->CD_PRODUTO !== null): ?>
                                                <th class="text-center">PAGOU</th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($alunos as $row): ?>
                                            <tr>
                                                <td class="text-center"><?= $row->CD_ALUNO ?></td>
                                                <td class="text-center"><?= $row->NM_ALUNO ?></td>
                                                <td class="text-center"><?= $row->NM_RESPONSAVEL ?></td>
                                                <td class="text-center">
                                                    <?php
                                                    if ($row->FL_RESPOSTA == "S") {
                                                        echo "SIM";
                                                    } else if ($row->FL_RESPOSTA == "N") {
                                                        echo "NÃO";
                                                    }
                                                    ?>
                                                </td>
                                                <?php if ($registro->CD_PRODUTO !== null): ?>
                                                    <td class="text-center">
                                                        <?php
                                                        if ($row->FL_PAGAMENTO == "S") {
                                                            echo "SIM";
                                                        } else if ($row->FL_PAGAMENTO == "N") {
                                                            echo "NÃO";
                                                        } else {
                                                            echo "-";
                                                        }
                                                        ?>
                                                    </td>
                                                <?php endif; ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <td colspan="5">
                                                <?= "Total de " . count($alunos) . " aluno(s)." ?>
                                            </td>                                            
                                        </tr>                                        
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <div id="resposta<?= $id ?>">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                    <i class="fa fa-times"></i> Fechar
                </button>

                <div class="pull-right">
                    <a data-toggle="formModalWarning" data-dismiss="modal" data-tipo="warning" class="btn btn-warning" href="<?= site_url($this->session->userdata('SGP_SISTEMA') . "/calendario_evento/modalRegistro/E-" . $registro->CD_EVENTO) ?>">
                        <i class="fa fa-edit"></i> <?= LBL_BTN_EDITAR ?>
                    </a>

                    <button type="button" id="btnDeletar<?= $id ?>" class="btn btn-danger">
                        <i class="fa fa-trash"></i> <?= LBL_BTN_EXCLUIR ?>
                    </button>                
                </div>                
            </div>
        </form>
    </div>

    <script type="text/javascript">
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

        tinymce.activeEditor.setMode('readonly');
        
        $(".colorpicker").spectrum({
            allowEmpty: true,
            preferredFormat: "hex",
            showPallete: true,
            chooseText: "Ok",
            cancelText: "Cancelar",
            palette: [
                ["#000", "#444", "#666", "#999", "#ccc", "#eee", "#f3f3f3", "#fff"],
                ["#f00", "#f90", "#ff0", "#0f0", "#0ff", "#00f", "#90f", "#f0f"],
                ["#f4cccc", "#fce5cd", "#fff2cc", "#d9ead3", "#d0e0e3", "#cfe2f3", "#d9d2e9", "#ead1dc"],
                ["#ea9999", "#f9cb9c", "#ffe599", "#b6d7a8", "#a2c4c9", "#9fc5e8", "#b4a7d6", "#d5a6bd"],
                ["#e06666", "#f6b26b", "#ffd966", "#93c47d", "#76a5af", "#6fa8dc", "#8e7cc3", "#c27ba0"],
                ["#c00", "#e69138", "#f1c232", "#6aa84f", "#45818e", "#3d85c6", "#674ea7", "#a64d79"],
                ["#900", "#b45f06", "#bf9000", "#38761d", "#134f5c", "#0b5394", "#351c75", "#741b47"],
                ["#600", "#783f04", "#7f6000", "#274e13", "#0c343d", "#073763", "#20124d", "#4c1130"]
            ],
            change: function (color) {
                $("#cor<?= $id ?>").val(color.toHexString());
            }
        });

        $("#btnDeletar<?= $id ?>").click(function () {
            swal({
                title: "Excluir",
                text: "Tem certeza que deseja excluir este evento do calendário?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                cancelButtonText: "Não",
                confirmButtonText: "Sim",
                closeOnConfirm: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    var codigo = $("#codigo<?= $id ?>").val();
                    $.ajax({
                        url: "<?= site_url($this->session->userdata('SGP_SISTEMA') . "/calendario_evento/formManter") ?>",
                        method: "post",
                        dataType: "json",
                        data: {
                            codigo: codigo,
                            operacao: "D"
                        },
                        success: function (response) {
                            var titulo = "";
                            var tipo = "";

                            if (response['success']) {
                                tipo = "success";
                                titulo = "Excluído";
                                $('#formModalInfo').modal("hide");
                            } else {
                                tipo = "error";
                                titulo = "Erro";
                            }

                            swal({
                                title: titulo,
                                text: response['mensagem'],
                                type: tipo,
                                confirmButtonColor: "#DD6B55",
                                confirmButtonText: "Ok",
                                closeOnConfirm: false
                            }, function (isConfirm) {
                                if (isConfirm) {
                                    window.location.reload();
                                }
                            });
                        }
                    });
                }
            });
        });
    </script>
</div>