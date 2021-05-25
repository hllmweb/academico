<? $this->load->view('home/header'); ?>
<script type='text/javascript'>
    function txtFiltrar() {
        $("#tblFiltro").html('<?= LOAD ?>');
        $.post("<?= base_url('113/infantil/grdResultado') ?>", {
            turma: $("#sgpTurma").val(),
            tipo: $("#sgpConsultar").val(),
            dia: $("#sgpDia").val(),
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
                <h4>Relatório Educação Infantil</h4>
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-2">
                        <label>Curso:</label>
                        <select name="sgpCurso" id="sgpCurso" class="form-control sgpProfessor">
                            <option></option>
                            <? foreach ($curso as $c) { 
                                if($c['CD_CURSO'] == 1){
                                ?>
                                <option value="<?= $c['CD_CURSO'] ?>"><?= $c['NM_CURSO'] ?></option>
                            <? } } ?>
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
                    <div class="col-sm-2">
                        <label>Relatório:</label>
                        <select name="sgpConsultar" id="sgpConsultar" class="form-control sgpProfessor">
                            <option></option>
                            <option value="P">PROGRESSÃO DO ALUNO</option>
                            <option value="A">ACOMPANHAMENTO DIÁRIO</option>
                        </select>
                    </div>
                    <div class="col-xs-2">
                        <label>DATA</label>
                        <div required="required" class="input-daterange" id="datepicker">
                            <input <?=$disAll?> value="<?=(($filtro->DT_REGISTRO != '')? date('d/m/Y',strtotime($filtro->DT_REGISTRO)) : date('d/m/Y'))?> " type="text" class="form-control" name="sgpDia" id="sgpDia" />
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <label>Relatório:</label>
                        <div class="input-group btn-group">
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
<script src="<?=base_url('assets/js/')?>/bootstrap-datepicker.min.js"></script>
<script>
    $(function() {
        $(".sgpProfessor").select2();
        $('.input-daterange').datepicker({
            endDate: '+0d',
           autoclose: true
       });
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