<? $this->load->view('home/header'); ?>
<script type='text/javascript'>
    function txtFiltrar() {
        $("#tblFiltro").html('<?= LOAD ?>');
        //$.post("<?= base_url('' . $this->session->userdata('SGP_SISTEMA') . '/professores/grdAcompanhamentoProfessor') ?>", {
        $.post("<?= base_url('113/recuperacao/grdRecuperacao') ?>", {
            professor: $("#sgpProfessor").val(),
            turma: $("#sgpTurma").val(),
            disciplina: $("#sgpDisciplina").val(),
        },
        function(valor) {
            $("#tblFiltro").html(valor);
        });
    };
</script>

<div class="content animate-panel">
    <div class="row projects">
        <div class="hpanel hgreen">
            <div class="panel-footer text-right">
                <h4>Relatório de Recuperação</h4>
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-2">
                        <label>Curso:</label>
                        <select name="sgpCurso" id="sgpCurso" class="form-control sgpProfessor">
                            <option></option>
                            <? foreach ($curso as $c) { ?>
                                <option value="<?= $c['CD_CURSO'] ?>"><?= $c['NM_CURSO'] ?></option>
                            <? } ?>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <label>Série:</label>
                        <select name="sgpSerie" id="sgpSerie" class="form-control sgpProfessor">
                            <option></option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <label>Turma:</label>
                        <select name="sgpTurma" id="sgpTurma" class="form-control sgpProfessor">
                            <option></option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label>Disciplina:</label>
                        <select name="sgpDisciplina" id="sgpDisciplina" class="form-control sgpProfessor">
                            <option></option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label>Range de MÉDIAS:</label>
                        <div class="input-group btn-group">
                            <select name="sgpConsultar" id="sgpConsultar" class="form-control sgpProfessor">
                                <option></option>
                                <option value="1">DE 0 ATÉ 6.9</option>
                                <option value="2">DE 7 ATÉ 8.9</option>
                                <option value="3">DE 9 ATÉ 10</option>
                            </select>
                            <span class="input-group-btn">
                                <button onclick="txtFiltrar()" type="button" id="" class="btn btn-labeled btn-info">
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

<script>
    $(function() {
        $(".sgpProfessor").select2();
    });
</script>
<script type="text/javascript">
    $("select[id=sgpCurso]").change(function() {
        $("select[id=sgpSerie]").html('<option>Carregando</option>');
        $.post("<?= base_url('comum/combobox/serie') ?>", {
            curso: $(this).val()
        },
        function(valor) {
            $("select[id=sgpSerie]").html(valor);
        });
    });

    $("select[id=sgpSerie]").change(function() {
        $("select[id=sgpTurma]").html('<option>Carregando</option>');
        $.post("<?= base_url('comum/combobox/turma') ?>", {
            curso: $("select[id=sgpCurso]").val(),
            serie: $("select[id=sgpSerie]").val(),
        },
        function(valor) {
            $("select[id=sgpTurma]").html(valor);
        });
    });
    
    $("select[id=sgpTurma]").change(function() {
        $("select[id=sgpDisciplina]").html('<option>Carregando</option>');
        $.post("<?= base_url('comum/combobox/disciplina') ?>", {
            curso: $("select[id=sgpCurso]").val(),
            serie: $("select[id=sgpSerie]").val(),
        },
        function(valor) {
            $("select[id=sgpDisciplina]").html(valor);
        });
    });
</script>
<? $this->load->view('home/footer'); ?>