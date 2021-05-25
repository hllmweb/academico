<? $this->load->view('home/header'); ?>

<script src='<?= base_url("libs/fullcalendar/lib/moment.min.js") ?>'></script>

<script type="text/javascript">
    function filtrar() {
        $.post("<?= site_url($this->session->userdata('SGP_SISTEMA') . "/cardapio/gridRegistro") ?>", {
            semana: $("#FTSemana").val()
        }, function (response) {
            $("#grid-registro").html(response);
        });
    }
</script>

<style type="text/css">
    .datepicker-dropdown .table-condensed tbody tr:hover{
        background-color: #eee;
    }
</style>

<div class="content animate-panel">
    <div class="row projects">
        <div class="hpanel hgreen">    
            <div class="panel-heading">                
            </div>

            <div class="panel-footer">                
                <div class="row">
                    <div class="col-xs-4">
                        <a data-toggle="modal" data-tipo="primary" class="btn btn-labeled btn-info" href="#form-semana" style="margin-top:7px">
                            <span class="btn-label">
                                <i class="fa fa-cutlery"></i>
                            </span>
                            Montar Cardápio
                        </a>                                                
                    </div>

                    <div class="col-xs-4 pull-right">
                        <label>SEMANA</label>
                        <div class="input-group">                            
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input id="FTSemana" class="form-control weekpicker">
                            <span class="input-group-btn">
                                <button class="btn btn-labeled btn-info" onclick="filtrar()">
                                    <i class="fa fa-search"></i> Filtrar
                                </button>
                            </span>
                        </div>                        
                    </div>
                </div>
            </div>                    

            <div class="panel-body">                
                <div id="grid-registro">
                </div>                    
            </div>                       
        </div>
    </div>
</div>

<div id="form-semana" class="modal fade in">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= site_url($this->session->userdata("SGP_SISTEMA") . "/cardapio/formRegistro") ?>" method="post">
                <div class="modal-header" style="padding: 15px">
                    <h5 class="modal-title text-right">SELECIONE A SEMANA</h5>
                </div>

                <div class="modal-body">             
                    <div class="row">
                        <div class="form-group col-xs-6">
                            <label>SEMANA</label>                                            
                            <div class="input-group">
                                <input id="semana" name="semana" class="form-control weekpicker" required="">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>                        
                        </div>                                        
                    </div>                                                    
                </div>

                <div class="modal-footer">
                    <div id="resposta">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                        <i class="fa fa-times"></i> Fechar
                    </button>

                    <button type="submit" class="btn btn-success pull-right">
                        <i class="fa fa-check"></i> Selecionar
                    </button> 
                </div>                                
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $(".weekpicker").datepicker({
            format: "dd/mm/yyyy",
            forceParse: false
        });

        $(".weekpicker").datepicker().on('changeDate', function () {
            var data = $(this).val();

            //obter o inicio e fim da semana a partir da data informada
            var inicio = moment(data, "DD/MM/YYYY").day(0).format("DD/MM/YYYY");
            var final = moment(data, "DD/MM/YYYY").day(6).format("DD/MM/YYYY");

            $(this).val(inicio + " - " + final);
        });
    });
</script>

<? $this->load->view('home/footer'); ?>