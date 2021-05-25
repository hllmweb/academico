<? $this->load->view('home/header'); ?>
<script type='text/javascript'>
    function txtFiltrar() {
        $("#tblFiltro").html('<?= LOAD ?>');
        $.post("<?= base_url('' . $this->session->userdata('SGP_SISTEMA') . '/reserva/grdRegistroProfessor') ?>", {
               data: $("#Data").val(),
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
                    <div class="col-xs-1"></div>
                    <form id="frmNovaPesquisa" class="col-xs-11 pull-right">
                        <div class="col-xs-4 pull-right">
                            <div class="input-group">
                                <label>Data:</label>
                                <div class="input-group m-b">
                                    <input type="text" class="form-control input-sm" name="Data" id="Data" value="<?=date('d/m/Y')?>">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span> 
                                    <span class="input-group-btn">
                                        <button onclick="txtFiltrar()" type="button" id="" class="btn btn-xs btn-warning input-sm">
                                            <span class="btn-label"><i class="fa fa-search"></i></span>
                                            Filtrar
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="panel-body no-padding" id="tblFiltro">
            </div>
        </div>
    </div>
</div>
<script>
$("#Data").datepicker({
        format: "dd/mm/yyyy",
        autoclose: true,
        //endDate: '+0d',
    });
</script>
<? $this->load->view('home/footer'); ?>