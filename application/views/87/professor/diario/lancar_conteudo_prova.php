<?php $this->load->view("home/header"); ?>

<div class="content animate-panel">
    <div class="row">
        <form action="<?= site_url("87/professor/diario/confirmar_conteudo_prova") ?>" method="post">
            <input type="hidden" id="disciplina" name="codigo-disciplina" value="<?= $codigoDisciplina ?>">
            <input type="hidden" name="descricao-disciplina" value="<?= $descricaoDisciplina ?>">
            <input type="hidden" id="turma" name="turma" value="<?= $turma ?>">                                            
            <input type="hidden" id="bimestre" name="bimestre" value="<?= $nota['BIMESTRE'] ?>">
            <input type="hidden" name="prova" value="<?= $prova['ID_PROVA_CONTEUDO'] ?>">

            <div class="panel">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label>Tipo de Nota:</label>                    
                                <select name="tipo-nota" class="form-control" readonly="true">
                                    <option value="<?= $nota['CD_TIPO_NOTA'] ?>" selected>
                                        <?= $nota['DC_TIPO_NOTA'] . "(" . $nota['NM_MINI'] . ") - " . $nota['BIMESTRE'] . "º Bimestre"; ?>
                                    </option>
                                </select>               
                            </div>
                        </div>

                        <div class="col-xs-4">
                            <div class="form-group">
                                <label>Turma:</label>       
                                <div>
                                    <?= $turma ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-4">
                            <div class="form-group">
                                <label>Disciplina:</label>                
                                <div>
                                    <?= $descricaoDisciplina ?>
                                </div>
                            </div>
                        </div>            
                    </div>

                    <div class="row">
                        <div class="col-xs-4">                
                            <div class="form-group">
                                <label>Data da Prova:</label>
                                <input required="true" name="data-prova" type="text" class="form-control" id="data-prova" value="<?= set_value("data-prova", $prova['DT_PROVA']) ?>">
                            </div>
                        </div>

                        <div class="col-xs-4">                                        
                            <div class="form-group">
                                <label>Conteúdo de:</label>
                                <input required="true" name="data-conteudo" type="text" class="form-control" id="data-conteudo" value="<?= set_value("data-conteudo", $prova['data-conteudo']) ?>">
                            </div>
                        </div>

                        <div class="col-xs-4">                                        
                            <div class="form-group">
                                <input name="flag" type="checkbox" value="S" <?= (set_value("flag") == "S" || $prova['FL_WEB'] == "S") ? "checked" : "" ?>>
                                <label>Liberar para visualização no portal.</label>                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="grid-conteudo" class="row">
                <?php if (!empty($conteudos)): ?>
                    <?php $this->load->view("87/professor/diario/grid_conteudo_prova") ?>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <a class="btn btn-danger" href="<?= site_url("87/professor/diario/conteudo_prova") ?>"><i class="fa fa-rotate-left"></i> Cancelar</a>
                <button class="btn btn-success" type="submit">
                    <i class="fa fa-check"></i> Lançar
                </button>
            </div>
        </form>
    </div>
</div>

<script src="<?= base_url("assets/js/bootstrap-datepicker.min.js") ?>"></script> 
<script src="<?= base_url("assets/js/moment.min.js") ?>"></script> 
<script src="<?= base_url("assets/js/daterangepicker.js") ?>"></script> 
<script src="<?= base_url("assets/js/daterangepicker.pt-BR.js") ?>" charset="UTF-8"></script> 
<script>
    $(document).ready(function () {
        $("#data-prova").datepicker({
            language: 'pt-BR',
            format: 'dd/mm/yyyy'
        });

        $('#data-conteudo').daterangepicker(daterangeOptions,
                function (start, end) {
                    $("#grid-conteudo").html('<div class="progress progress-striped progress-active"><div class="progress-bar progress-bar-warning" style="width: 100%;"></div></div>');
                    $.ajax({
                        url: "<?= site_url("87/professor/diario/grid_conteudo_prova") ?>",
                        method: "POST",
                        data: {
                            inicio: start.format("YYYY-MM-DD"),
                            fim: end.format("YYYY-MM-DD"),
                            bimestre: $("#bimestre").val(),
                            turma: $("#turma").val(),
                            disciplina: $("#disciplina").val()
                        },
                        success: function (data) {
                            $('#grid-conteudo').html(data);
                        }
                    });
                });
    });
</script>

<?php $this->load->view("home/footer") ?>