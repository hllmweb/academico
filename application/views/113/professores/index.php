<? $this->load->view('home/header'); ?>
<script type='text/javascript'>
    function txtFiltrar() {
        $("#tblFiltro").html('<?= LOAD ?>');
        $.post("<?= base_url('' . $this->session->userdata('SGP_SISTEMA') . '/professores/grdAcompanhamentoProfessor') ?>", {
            professor:  $("#sgpProfessor").val(),
            turma:      $("#sgpTurma").val(),
            disciplina: $("#sgpDisciplina").val(),
            consultar:  $("#sgpConsultar").val(),
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
                <h4>Acompanhamento de Professores</h4>
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-3">
                        <label>Professor:</label>
                        <select name="sgpProfessor" id="sgpProfessor" class="form-control sgpProfessor">
                            <option></option>
                            <? foreach ($professor as $p) { ?>
                                <option value="<?= $p['CD_PROFESSOR'] ?>"><?= $p['NM_PROFESSOR'] ?></option>
                            <? } ?>
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
                        <label>Consultar:</label>
                        <div class="input-group btn-group">
                            <select name="sgpConsultar" id="sgpConsultar" class="form-control sgpProfessor">
                                <option></option>                                
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
    $("select[id=sgpProfessor]").change(function() {
        $("select[id=sgpTurma]").html("");
        $("select[id=sgpDisciplina]").html("");
        $("select[id=sgpConsultar]").html("");
        
        $("select[id=sgpTurma]").select2('val',"");
        $("select[id=sgpDisciplina]").select2('val',"");
        $("select[id=sgpConsultar]").select2('val',"");
        
        $.post("<?= base_url('comum/combobox/turma_professor') ?>", {
            professor: $(this).val()
        },
        function(valor) {
            $("select[id=sgpTurma]").html(valor);
        });
    });

    $("select[id=sgpTurma]").change(function() {
        $("select[id=sgpDisciplina]").html("");        
        $("select[id=sgpConsultar]").html("");
        
        $("select[id=sgpDisciplina]").select2('val',"");
        $("select[id=sgpConsultar]").select2('val',"");
        
        $.post("<?= base_url('comum/combobox/turma_disciplina') ?>", {
            professor: $("select[id=sgpProfessor]").val(),
            turma: $("select[id=sgpTurma]").val(),
        },
        function(valor) {
            $("select[id=sgpDisciplina]").html(valor);
        });
    });
    
    $("select[id=sgpDisciplina]").change(function(){        
        $("select[id=sgpConsultar]").html("");
        $("select[id=sgpConsultar]").select2('val',"");
        
        $.post("<?= base_url('113/professores/combo_consultar') ?>", {            
            turma: $("select[id=sgpTurma]").val()
        },
        function(valor) {
            $("select[id=sgpConsultar]").html(valor);
        });
        
    })
</script>
<? $this->load->view('home/footer'); ?>