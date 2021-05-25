<? $this->load->view('home/header'); ?>
<script src="<?= base_url('assets/js/daterangepicker.js') ?>"></script>

<script type="text/javascript">
    function txtFiltrar() {
        $("#tblFiltro").html('<?= LOAD ?>');

        $.post("<?= base_url($this->session->userdata('SGP_SISTEMA') . '/comunicado/gridRegistro') ?>", {
            data: $("#FTDataEnvio").val()
        },
        function (valor) {
            $("#tblFiltro").html(valor);
        });
    }
</script>

<div class="content animate-panel">
    <div class="row projects">
        <div class="hpanel hgreen">
            <div class="panel-footer">
                <div class="row">                                       
                    <form id="frmNovaPesquisa">
                        <div class="col-xs-2 pull-left">
                            <br>
                            <a href="<?= base_url($this->session->userdata('SGP_SISTEMA') . '/comunicado/modalRegistro/I') ?>" data-toggle="frmModalRegistro" class="btn btn-labeled btn-info">
                                <span class="btn-label"><i class="fa fa-plus"></i></span>
                                Adicionar
                            </a>
                        </div>

                        <div class="col-xs-10 pull-right">
                            <div class="col-xs-9 clearfix">
                            </div>

                            <div class="col-xs-3">
                                <label>DATA ENVIO</label>
                                <div class="input-group">
                                    <input type="text" class="form-control input-sm" id="FTDataEnvio">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span> 

                                    <span class="input-group-btn">
                                        <div class="btn-group">
                                            <button onclick="txtFiltrar()" type="button" id="" class="btn btn-xs btn-info input-sm" style="margin-right: 10px">
                                                <span class="btn-label"><i class="fa fa-search"></i></span>
                                                Filtrar
                                            </button>              
                                        </div>                                        
                                    </span>                                
                                </div>
                            </div>
                        </div>                        
                    </form>
                </div>
            </div>

            <div class="panel-body" id="tblFiltro" style="z-index: -1">
                <small>Faça primeiro o filtro</small>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $("#FTDataEnvio").datepicker({
        format: 'dd/mm/yyyy',
        language: 'pt-BR',
        autoclose: true
    });

    $('body').on('click', '[data-toggle="frmModalRegistro"]',
            function (e) {
                var tipo = $(this).attr("data-tipo");
                $('#frmModalRegistro').remove();
                e.preventDefault();
                var $this = $(this)
                        , $remote = $this.data('remote') || $this.attr('href')
                        , $modal = $('<div class="modal fade hmodal-' + tipo + '"  id="frmModalRegistro"  tabindex="-1" role="dialog" ><div class="modal-dialog" ><div class="modal-content"></div></div></div>');
                $('body').append($modal);
                $modal.modal({backdrop: 'static', keyboard: false});
                $modal.load($remote);
            }
    );
</script>

<? $this->load->view('home/footer'); ?>