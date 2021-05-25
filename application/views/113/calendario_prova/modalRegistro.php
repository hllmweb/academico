<?php
$codigo = $registro->CD_CALENDARIO;
$id = empty($codigo) ? 0 : $codigo;
$id.= $operacao;
$disabled = $operacao == "D" || $operacao == "V" ? "disabled" : "";
$disabledFieldDisc = $registro->CD_TIPO_PROVA == 1 ? "disabled" : "";
?>


<div class="modal-dialog modal-lg">
    <div class="color-line"></div>

    <div class="modal-content">
        <form id="formulario-registro<?= $id ?>">
            <div class="modal-header" style="padding: 15px">
                <h5 class="modal-title text-right"><?= $titulo ?></h5>
            </div>

            <div class="modal-body">             
                <div class="row">
                    <div class="form-group col-xs-4">
                        <label>TIPO DE PROVA</label>
                        <select id="tipoProva<?= $id ?>" name="tipoProva" class="form-control input-sm" <?= $disabled ?>>                            
                            <option></option>
                            <?php foreach ($tipoProvas as $row) : ?>
                                <option <?= (($registro->CD_TIPO_PROVA == $row->CD_TIPO_PROVA) ? 'selected=selected' : '') ?> value="<?= $row->CD_TIPO_PROVA ?>"><?= $row->DC_TIPO_PROVA ?></option>
                            <?php endforeach; ?>
                        </select>                        
                    </div>

                    <div class="form-group col-xs-4">
                        <label>CURSO</label>
                        <select id="curso<?= $id ?>" name="curso" class="form-control input-sm" <?= $disabled ?> >                            
                            <option></option>
                            <?php foreach ($cursos as $row) : ?>
                                <option <?= (($registro->CD_CURSO == $row['CD_CURSO']) ? 'selected=selected' : '') ?> value="<?= $row['CD_CURSO'] ?>"><?= $row['NM_CURSO_RED'] ?></option>
                            <?php endforeach; ?>
                        </select>                        
                    </div>                    

                    <div class="form-group col-xs-4">
                        <label>SÉRIE</label>
                        <select id="serie<?= $id ?>" name="serie" class="form-control input-sm" <?= $disabled ?> >                            
                            <option></option>
                            <?php foreach ($series as $row) : ?>
                                <option <?= (($registro->ORDEM_SERIE == $row->ORDEM_SERIE) ? 'selected=selected' : '') ?> value="<?= $row->ORDEM_SERIE ?>"><?= $row->NM_SERIE ?></option>
                            <?php endforeach; ?>
                        </select>                        
                    </div>                                        
                </div>

                <div class="row">
                    <div class="form-group col-xs-4">
                        <label>TURMA</label>
                        <select id="turma<?= $id ?>" name="turma" class="form-control input-sm" <?= $disabled ?>>                            
                            <option></option>
                            <?php foreach ($turmas as $row) : ?>
                                <option <?= (($registro->CD_TURMA == $row->CD_TURMA) ? 'selected=selected' : '') ?> value="<?= $row->CD_TURMA ?>"><?= $row->CD_TURMA ?></option>
                            <?php endforeach; ?>
                        </select>                        
                    </div>

                    <div class="form-group col-xs-4">
                        <label>DISCIPLINA</label>
                        <select id="disciplina<?= $id ?>" name="disciplina" class="form-control input-sm" <?php echo $disabled, $disabledFieldDisc ?>>
                            <option></option>
                            <?php foreach ($disciplinas as $row) : ?>
                                <option <?= (($registro->CD_DISCIPLINA == $row->CD_DISCIPLINA) ? 'selected=selected' : '') ?> value="<?= $row->CD_DISCIPLINA ?>"><?= $row->NM_DISCIPLINA ?></option>
                            <?php endforeach; ?>
                        </select>         
                        <input class="form-control" type="text" maxlength="250" id="disciplinaTexto<?= $id ?>" name="disciplinaTexto" value="<?= $registro->OBSERVACAO ?>" <?php echo $disabled, $disabledFieldDisc ?>>
                    </div>                    

                    <div class="form-group col-xs-4">
                        <label>BIMESTRE</label>
                        <select id="bimestre<?= $id ?>" name="bimestre" class="form-control input-sm" <?= $disabled ?>>                            
                            <option></option>
                            <?php for ($i = 1; $i <= 5; $i++) : ?>
                                <option value="<?= $i ?>" <?= $i == $registro->BIMESTRE ? "selected" : "" ?>><?= $i ?>º Bimestre</option>
                            <?php endfor; ?>                            
                        </select>                        
                    </div>                    

                    <input id="codigo<?= $id ?>" name="codigo" type="hidden" value="<?= $registro->CD_CALENDARIO ?>"/>
                    <input id="operacao<?= $id ?>" name="operacao" type="hidden" value="<?= $operacao ?>"/>                
                </div>

                <div class="row">
                    <div class="form-group col-xs-4">
                        <label>NOTA</label>
                        <select id="nota<?= $id ?>" name="nota" class="form-control input-sm" <?= $disabled ?>>                            
                            <option></option>
                            <?php foreach ($estruturaNotas as $row) : ?>
                                <option <?=
                                (($registro->NUM_NOTA == $row->NUM_NOTA &&
                                $registro->CD_TIPO_NOTA == $row->CD_TIPO_NOTA &&
                                $registro->BIMESTRE == $row->BIMESTRE &&
                                $registro->PERIODO == $row->PERIODO) ? 'selected=selected' : '')
                                ?> value="<?= $row->NUM_NOTA . "-" . $row->CD_TIPO_NOTA ?>">
                                        <?= $row->DC_TIPO_NOTA . " (" . $row->NM_MINI . ")" ?>
                                </option>
                            <?php endforeach; ?>
                        </select>                        
                    </div>

                    <div class="form-group col-xs-4">
                        <label>CHAMADA</label>
                        <select id="chamada<?= $id ?>" name="chamada" class="form-control input-sm" <?= $disabled ?>>                                                        
                            <option></option>
                            <option value="1" <?= $registro->NR_CHAMADA == 1 ? "selected" : "" ?>>1º CHAMADA</option>
                            <option value="2" <?= $registro->NR_CHAMADA == 2 ? "selected" : "" ?>>2º CHAMADA</option>                            
                        </select>                        
                    </div>

                    <div class="form-group col-xs-4">
                        <label>DATA DA PROVA</label>
                        <input id="dataProva<?= $id ?>" name="dataProva" value="<?= empty($registro->DT_PROVA) ? "" : date("d/m/Y", strtotime($registro->DT_PROVA)) ?>" class="form-control" <?= $disabled ?>>
                    </div>    
                        

                    <?php 
                     if ($operacao == "V" || $operacao == "E"){
                        foreach ($visualizaNota as $value) {
                            
                             $nota[] = $value; 
                        }
                    ?>

                     <div class="form-group col-xs-4">
                        <label>EXIBIR NOTA  </label>
                        <select id="chamada<?= $id ?>" name="exibirNota" class="form-control input-sm">                                                        
                            <option value="1" <?php echo ($nota[5][0]['FLG_EXIBE_RESULTADO'] == 1 ? "selected" : "") ?> >SIM</option>
                            <option value="0" <?php echo ($nota[5][0]['FLG_EXIBE_RESULTADO'] == 0 ? "selected" : "") ?> >NÃO</option>                            
                        </select>                        
                     </div>
                   <?php }else{ ?>

                      <div class="form-group col-xs-4">
                        <label>EXIBIR NOTA  </label>
                        <select id="chamada<?= $id ?>" name="exibirNota" class="form-control input-sm">                                                        
                            <option value="1">SIM</option>
                            <option value="0">NÃO</option>                            
                        </select>                        
                     </div>


                   <?php } ?> 
                </div>

               
                <?php if ($operacao == "V"): ?>
                    <div class="row">
                        <div class="form-group col-xs-4">
                            <label>NÚMERO PROVA</label>
                            <input id="numProva<?= $id ?>" name="numProva" value="<?= $registro->NUM_PROVA ?>" class="form-control" <?= $disabled ?>>
                        </div>

                        <div class="form-group col-xs-8">
                            <label>TÍTULO PROVA</label>
                            <input id="tituloProva<?= $id ?>" name="tituloProva" value="<?= $registro->TITULO ?>" class="form-control" <?= $disabled ?>>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="modal-footer">
                <div id="resposta<?= $id ?>">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                    <i class="fa fa-times"></i> Fechar
                </button>

                <?php if ($operacao == "V"): ?>
                    <a data-toggle="formModalWarning" class="btn btn-warning" href="<?= site_url($this->session->userdata('SGP_SISTEMA') . "/calendario_prova/modalRegistro/E-" . $registro->CD_CALENDARIO) ?>">
                        <i class="fa fa-edit"></i> <?= LBL_BTN_EDITAR ?>
                    </a>

                    <button type="button" id="btnDeletar<?= $id ?>" class="btn btn-danger">
                        <i class="fa fa-trash"></i> <?= LBL_BTN_EXCLUIR ?>
                    </button>
                <?php else: ?>
                    <button type="button" id="btnConfirmar<?= $id ?>" class="btn btn-<?= $operacao == "D" ? "danger" : "success" ?> pull-right">
                        <i class="fa fa-<?= $operacao == "D" ? "trash" : "save" ?>"></i>
                        <?= $operacao == "D" ? LBL_BTN_EXCLUIR : LBL_BTN_SALVAR ?>
                    </button> 
                <?php endif; ?>
            </div>
        </form>        
    </div>        

    <script type="text/javascript">
        function toggleDisciplina(isSimulado) {
            var operacao = "<?= $operacao ?>";

            if (isSimulado) {
                $("#disciplina<?= $id ?>").attr("disabled", "disabled");
                $("#disciplina<?= $id ?>").hide();

                $("#disciplinaTexto<?= $id ?>").removeAttr("disabled");
                $("#disciplinaTexto<?= $id ?>").show();
            } else {
                $("#disciplinaTexto<?= $id ?>").attr("disabled", "disabled");
                $("#disciplinaTexto<?= $id ?>").hide();

                $("#disciplina<?= $id ?>").removeAttr("disabled");
                $("#disciplina<?= $id ?>").show();
            }

            if (operacao === "V") {
                $("#disciplina<?= $id ?>").attr("disabled", "disabled");
                $("#disciplinaTexto<?= $id ?>").attr("disabled", "disabled");
            }
        }

        function isSimulado() {
            var tipoProva = $("#tipoProva<?= $id ?>").val();

            if (tipoProva === "") {
                toggleDisciplina(false);
            } else {
                $.ajax({
                    url: "<?= site_url($this->session->userdata('SGP_SISTEMA') . "/calendario_prova/isSimulado") ?>",
                    data: {
                        codigo: tipoProva
                    },
                    dataType: "json",
                    method: "post",
                    success: function (response) {
                        toggleDisciplina(response['success']);
                    }
                });
            }
        }

        $("#tipoProva<?= $id ?>").change(function () {
            isSimulado();
        });

        $(document).ready(function () {
            isSimulado();
        });

        $("#dataProva<?= $id ?>").datepicker({
            format: 'dd/mm/yyyy',
            language: 'pt-BR',
            autoclose: true,
            startDate: "0d"
        });

        $("#curso<?= $id ?>").change(function () {
            $("#serie<?= $id ?>").html("");
            $("#turma<?= $id ?>").html("");
            $("#disciplina<?= $id ?>").html("");
            $("#nota<?= $id ?>").html("");
            $("#bimestre<?= $id ?>").val("");

            $.post("<?= site_url("comum/combobox/serie") ?>", {
                curso: $("#curso<?= $id ?>").val()
            },
            function (response) {
                $("#serie<?= $id ?>").html(response);
            });
        });

        $("#serie<?= $id ?>").change(function () {
            $("#turma<?= $id ?>").html("");
            $("#disciplina<?= $id ?>").html("");
            $("#nota<?= $id ?>").html("");
            $("#bimestre<?= $id ?>").val("");

            $.post("<?= site_url("comum/combobox/turma_regular") ?>", {
                curso: $("#curso<?= $id ?>").val(),
                serie: $("#serie<?= $id ?>").val()
            },
            function (response) {
                $("#turma<?= $id ?>").html(response);
            });
        });

        $("#turma<?= $id ?>").change(function () {
            $("#disciplina<?= $id ?>").html("");
            $("#nota<?= $id ?>").html("");
            $("#bimestre<?= $id ?>").val("");

            $.post("<?= site_url("comum/combobox/disciplina") ?>", {
                curso: $("#curso<?= $id ?>").val(),
                serie: $("#serie<?= $id ?>").val()
            },
            function (response) {
                $("#disciplina<?= $id ?>").html(response);
            });
        });

        $("#bimestre<?= $id ?>").change(function () {
            $("#nota<?= $id ?>").html("");

            $.post("<?= site_url("comum/combobox/estrutura_notas") ?>", {
                bimestre: $("#bimestre<?= $id ?>").val(),
                turma: $("#turma<?= $id ?>").val()
            },
            function (response) {
                $("#nota<?= $id ?>").html(response);
            });
        });

        function validar() {
            var status = true;
            var mensagem = "";
            if ($("#curso<?= $id ?>").val() === "") {
                status = false;
                mensagem = '<label class="text-danger">Selecione o CURSO</label>';
            } else if ($("#serie<?= $id ?>").val() === "") {
                status = false;
                mensagem = '<label class="text-danger">Selecione a SÉRIE</label>';
            } else if ($("#turma<?= $id ?>").val() === "") {
                status = false;
                mensagem = '<label class="text-danger">Selecione a TURMA</label>';
            } else if ($("#disciplina<?= $id ?>").val() === "" && $("#disciplinaTexto<?= $id ?>").val() === "") {
                status = false;
                mensagem = '<label class="text-danger">Informe a DISCIPLINA</label>';
            } else if ($("#bimestre<?= $id ?>").val() === "") {
                status = false;
                mensagem = '<label class="text-danger">Selecione o BIMESTRE</label>';
            } else if ($("#nota<?= $id ?>").val() === "") {
                status = false;
                mensagem = '<label class="text-danger">Selecione a NOTA</label>';
            } else if ($("#tipoProva<?= $id ?>").val() === "") {
                status = false;
                mensagem = '<label class="text-danger">Selecione o TIPO DE PROVA</label>';
            } else if ($("#dataProva<?= $id ?>").val() === "") {
                status = false;
                mensagem = '<label class="text-danger">Informe a DATA DA PROVA</label>';
            } else if ($("#chamada<?= $id ?>").val() === "") {
                status = false;
                mensagem = '<label class="text-danger">Informe a CHAMADA</label>';
            }

            if (!status) {
                $("#resposta<?= $id ?>").html(mensagem);
            }

            return status;
        }

        $("#btnConfirmar<?= $id ?>").click(function () {
            if (validar()) {
                $("#resposta<?= $id ?>").html('<?= LOAD ?>');

                var dados = $("#formulario-registro<?= $id ?>").serialize();

                $.ajax({
                    url: "<?= site_url($this->session->userdata('SGP_SISTEMA') . "/calendario_prova/formManter") ?>",
                    data: dados,
                    type: "post",
                    dataType: "json",
                    success: function (data) {
                        $("#resposta<?= $id ?>").html("");

                        if (data['success']) {
                            $("#resposta<?= $id ?>").html(data['mensagem']);
                            filtrar();
                        } else {
                            $("#resposta<?= $id ?>").html(data['mensagem']);
                        }
                    }
                });
            }
        });

        $("#btnDeletar<?= $id ?>").click(function () {
            swal({
                title: "Excluir",
                text: "Tem certeza que deseja excluir esta prova do calendário?",
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
                        url: "<?= site_url($this->session->userdata('SGP_SISTEMA') . "/calendario_prova/formManter") ?>",
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
                                closeOnConfirm: false,
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