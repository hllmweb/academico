<? $this->load->view('home/header'); ?>
<script type='text/javascript'>//<![CDATA[
$(window).load(function(){
$(function(){
    $(".btn-toggle").click(function(e){
        e.preventDefault();
        el = $(this).data('element');
        $(el).toggle();
    });
});
});//]]> 

    function txtFiltrar() {
        $("#tblFiltro").html('<?= LOAD ?>');
        $.post("<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/registro_pedagogico/grdRegistro') ?>", {
            curso: $("#FTCurso").val(),
            serie: $("#FTSerie").val(),
            turma: $("#FTTurma").val(),
        },
        function(valor) {
            $("#tblFiltro").html(valor);
        });
    };
    </script>
<div class="content animate-panel">
    <div class="row projects">
        <div class="hpanel hgreen">
            <div class="panel-footer">
                <div class="row">
                    <div class="col-xs-2">
                        <button href="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/registro_pedagogico/mdlRegistro/A')?>" data-toggle="frmModal" type="button" id="" class="btn btn-labeled btn-primary2">
                            <span class="btn-label"><i class="fa fa-plus"></i></span>
                            Novo Registro
                        </button>
                    </div>
                    <div class="form-inline col-xs-10 text-right">
                        <div class="form-group">
                            <label>CURSO</label><br>
                            <select name="FTCurso" id="FTCurso" class="form-control m-b" style="width:150px">
                                <option value=""></option>
                                <? foreach ($curso as $row) {?>
                                        <option value="<?= $row['CD_CURSO'] ?>"><?= $row['NM_CURSO_RED'] ?></option>
                                <? } ?>
                            </select>
                        </div> 
                        <div class="form-group">
                            <label>SÉRIE</label><br>
                            <select name="FTSerie" id="FTSerie" class="form-control m-b" style="width:120px">
                                <option value=""></option>
                            </select>
                        </div> 
                        <div class="form-group">
                            <label>TURMA</label><br>
                            <select name="FTTurma" id="FTTurma" class="form-control m-b" >
                                <option></option>
                            </select>
                        </div>
                        <div class="input-group">
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
            <div class="panel-body" id="tblFiltro">
                <small>Faça primeiro o filtro</small>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    $("select[id=FTCurso]").change(function() {
        $("select[id=FTSerie]").html('<option>Carregando</option>');
        $.post("<?= base_url('/comum/combobox/serie') ?>", {
            curso: $(this).val()
        },
        function(valor) {
            $("select[id=FTSerie]").html(valor);
        });
    });

    $("select[name=FTSerie]").change(function() {
        $("select[name=FTTurma]").html('Carregando');
        $.post("<?= base_url('/comum/combobox/turma') ?>", {
            curso: $('select[name=FTCurso]').val(),
            serie: $('select[name=FTSerie]').val(),
        },
        function(valor) {
            $("select[name=FTTurma]").html(valor);
        });
    });
</script>
<? $this->load->view('home/footer'); ?>