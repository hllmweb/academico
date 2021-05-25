<?= $this->load->view("home/header"); ?>

<div class="content animate-panel">
    <div class="row projects">
        <div class="hpanel hgreen">
            <div class="panel-footer text-right">
                <h4>Relatório Conteúdo Ministrado</h4>
            </div>

            <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-2">
                        <label>Segmento:</label>
                        <select name="segmento" id="segmento" class="form-control">
                            <option></option>
                            <?php foreach ($cursos as $curso): ?>
                                <option value="<?= $curso['CD_CURSO'] ?>"><?= $curso['NM_CURSO_RED'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-sm-2">
                        <label>Série:</label>
                        <select name="serie" id="serie" class="form-control">
                            <option></option>
                        </select>
                    </div>

                    <div class="col-sm-2">
                        <label>Turma:</label>
                        <select name="turma" id="turma" class="form-control">
                            <option></option>
                        </select>
                    </div>                    

                    <div class="col-sm-2">
                        <label>Disciplina:</label>
                        <select name="disciplina" id="disciplina" class="form-control">
                            <option></option>                                
                        </select>
                    </div>                    

                    <div class="col-sm-3">
                        <label>Bimestre:</label>
                        <div class="input-group btn-group">                            
                            <select name="bimestre" id="bimestre" class="form-control">
                                <option></option>
                                <?php foreach ($bimestres as $bimestre): ?>
                                    <option value="<?= $bimestre['CODIGO'] ?>"><?= $bimestre['DESCRICAO'] ?></option>                                
                                <?php endforeach; ?>
                            </select>
                            <span class="input-group-btn">
                                <button type="button" id="filtrar" class="btn btn-labeled btn-info">
                                    <span class="btn-label"><i class="fa fa-search"></i></span>
                                    Filtrar
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-body no-padding" id="tblFiltro">
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#segmento').change(function () {
        $("#serie").html("<option>Carregando</option>");
        $("#turma").html("");
        $("#disciplina").html("");

        $.ajax({
            url: "<?= site_url("comum/combobox/serie") ?>",
            method: 'post',
            dataType: 'html',
            data: {
                curso: $("#segmento").val()
            },
            success: function (data, textStatus) {
                $("#serie").html(data);
            }
        });
    });

    $('#serie').change(function () {
        $("#turma").html("<option>Carregando</option>");
        $("#disciplina").html("");

        $.ajax({
            url: "<?= site_url("comum/combobox/turma") ?>",
            method: 'post',
            dataType: 'html',
            data: {
                serie: $("#serie").val(),
                curso: $("#segmento").val()
            },
            success: function (data, textStatus) {
                $("#turma").html(data);
            }
        });
    });

    $('#turma').change(function () {
        $("#disciplina").html("<option>Carregando</option>");

        $.ajax({
            url: "<?= site_url("comum/combobox/disciplina") ?>",
            method: 'post',
            dataType: 'html',
            data: {
                curso: $("#segmento").val(),
                serie: $("#serie").val()
            },
            success: function (data, textStatus) {
                $("#disciplina").html(data);
            }
        });
    });

    $("#filtrar").click(function () {
        $("#tblFiltro").html('<?= LOAD ?>');

        $.ajax({
            url: "<?= site_url("113/relatorio/grid_conteudo_ministrado") ?>",
            method: 'post',
            dataType: 'html',
            data: {
                turma: $("#turma").val(),
                disciplina: $("#disciplina").val(),
                bimestre: $("#bimestre").val()
            },
            success: function (data, textStatus) {
                $("#tblFiltro").html(data);
            }
        });
    });
</script>

<?= $this->load->view("home/footer"); ?>