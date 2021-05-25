<? $this->load->view('home/header'); ?>
<script type='text/javascript'>
    function txtFiltrar() {
        $("#tblFiltro").html('<?= LOAD ?>');
        $.post("<?= base_url('' . $this->session->userdata('SGP_SISTEMA') . '/reserva/grdRegistro') ?>", {
            periodo: $("#Periodo").val(),
               data: $("#Data").val(),
              local: $("#Local").val(),
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
                    <div class="col-xs-1">
                        <br>
                        <button type="button" id="" class="btn btn-sm btn-info pull-left" data-toggle="frmModal" href="<?=base_url('' . $this->session->userdata('SGP_SISTEMA') . '/reserva/mdlfrmSolicitacao/A')?>">
                            <span class="btn-label"><i class="fa fa-plus"></i></span>
                            Nova Solicitação
                        </button>
                    </div>
                    
                    <form id="frmNovaPesquisa" class="col-xs-11 pull-right">
                        
                        <div class="col-xs-4 pull-right">
                            <label>Local:</label>
                            <div class="input-group btn-group">
                                <select required name="Local" id="Local" class="form-control input-sm">
                                    <option></option>
                                    <option value="L">LABORATÓRIO</option>
                                    <option value="E">ESPAÇO</option>
                                </select>
                                <span class="input-group-btn">
                                    <button onclick="txtFiltrar()" type="button" id="" class="btn btn-xs btn-warning input-sm">
                                        <span class="btn-label"><i class="fa fa-search"></i></span>
                                        Filtrar
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="col-xs-2 pull-right no-padding">
                            <label>Data:</label>
                            <div class="input-group m-b">
                                <input size="16" type="text" class="form-control input-sm"   name="Data" id="Data" >
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span> 
                            </div>
                        </div>
                        <div class="col-xs-2  pull-right">
                            <label>Período:</label>
                            <select required name="Periodo" id="Periodo" class="form-control input-sm">
                                <option></option>
                                <option value="2017/1">2017/1</option>
                                <option value="2016/1">2016/1</option>
                                <option value="2015/1">2015/1</option>
                                <option value="2014/1">2014/1</option>
                            </select>
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