<? $this->load->view('home/header'); ?>
<script type='text/javascript'>
    function txtFiltrar() {
        $("#tblFiltroFunc").html('<?= LOAD ?>');
        $.post("<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/funcionario/grdFuncionario') ?>", {
            DTMes: $("#DTMes").val(),
        },
        function(valor) {
            $("#tblFiltroFunc").html(valor);
        });
    };
</script>
<div class="content animate-panel">
    <div class="row projects">
        <div class="hpanel hgreen">
            <div class="panel-footer" id="BuscaAvancada" >
                <form role="form" class="form-inline">
                    <div class="form-group">
                        DATA FIM<br>
                        <input name="DTMes" id="DTMes" type="month" class="form-control m-b" />
                    </div>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button onclick="txtFiltrar()" type="button" id="" class="btn btn-labeled btn-info">
                                <span class="btn-label"><i class="fa fa-search"></i></span>
                                Filtrar
                            </button>
                        </span>
                    </div>
                    
                    
                </form>
            </div>
            <div class="panel-body" id="tblFiltroFunc">
                <small>Faça primeiro o filtro</small>
            </div>
        </div>
    </div>
</div>
<? $this->load->view('home/footer'); ?>