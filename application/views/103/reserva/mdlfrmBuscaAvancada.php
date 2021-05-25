<div class="modal-dialog">
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">
            <h4 class="modal-title">Busca Avançada</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-xs-4">
                    <label>Período:</label>
                    <select name="resPeriodo" id="resPeriodo" class="form-control">
                        <option value="2016/1">2016/1</option>
                        <option value="2015/1">2015/1</option>
                        <option value="2014/1">2014/1</option>
                    </select>
                </div>
                <div class="col-xs-4">
                    <label>Curso:</label>
                    <select name="resCurso" id="resCurso" class="form-control">
                        <option></option>
                            <? foreach ($curso as $c) { ?>
                            <option value="<?= $c['CD_CURSO'] ?>"><?= $c['NM_CURSO_RED'] ?></option>
                            <? } ?>
                    </select>
                </div>
                <div class="col-xs-4">
                    <label>Série:</label>
                    <select name="resSerie" id="resSerie" class="form-control">
                        <option></option>
                    </select>
                </div>
                
                <div class="col-xs-4">
                    <label>Turma:</label>
                    <select name="resTurma" id="resTurma" class="form-control">
                        <option></option>
                    </select>
                </div>
                <div class="col-xs-8">
                    <label>Disciplina:</label>
                    <select name="resDisciplina" id="resDisciplina" class="form-control">
                        <option></option>
                    </select>
                </div>

                <div class="col-xs-8">
                    <label>Professor:</label>
                    <select name="resProfessor" id="resProfessor" class="form-control">
                        <option></option>
                    </select>
                </div>
                <div class="col-xs-4">
                    <label>Data:</label>
                    <input name="resData" type="date" id="resData" class="form-control" />
                </div>
                
                <div class="col-xs-12">
                    <label>Local:</label>
                    <div class="input-group btn-group">
                        <select name="resLocal" id="resLocal" class="form-control">
                            <option></option>
                            <option value="L">LABORATÓRIO</option>
                            <option value="E">ESPAÇO</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger2 pull-left" data-dismiss="modal">
                <i class="fa fa-times-circle"></i> Cancelar
            </button>
            <button target="_blank" class="btn btn-info" >
                <i class="fa fa-search-minus"></i> Buscar
            </button>
        </div>
        <script type="text/javascript">
            $("select[id=resCurso]").change(function() {
                $("select[id=resSerie]").html('<option>Carregando</option>');
                $.post("<?= base_url('comum/combobox/serie') ?>", {
                    curso: $(this).val()
                },
                function(valor) {
                    $("select[id=resSerie]").html(valor);
                    $("select[id=resTurma]").val();
                });
            });

            $("select[id=resSerie]").change(function() {
                $("select[id=resTurma]").html('<option>Carregando</option>');
                $.post("<?= base_url('comum/combobox/turma') ?>", {
                    curso: $("select[id=resCurso]").val(),
                    serie: $("select[id=resSerie]").val(),
                },
                function(valor) {
                    $("select[id=resTurma]").html(valor);
                });
            });

            $("select[id=resTurma]").change(function() {
                $("select[id=resDisciplina]").html('<option>Carregando</option>');
                $.post("<?= base_url('comum/combobox/disciplina') ?>", {
                    curso: $("select[id=resCurso]").val(),
                    serie: $("select[id=resSerie]").val(),
                },
                function(valor) {
                    $("select[id=resDisciplina]").html(valor);
                });
            });

            $("select[id=resDisciplina]").change(function() {
                $("select[id=resProfessor]").html('<option>Carregando</option>');
                $.post("<?= base_url('comum/combobox/professor') ?>", {
                    curso: $("select[id=resCurso]").val(),
                    disciplina: $("select[id=resDisciplina]").val(),
                },
                function(valor) {
                    $("select[id=resProfessor]").html(valor);
                });
            });
        </script>
    </div>
</div>
