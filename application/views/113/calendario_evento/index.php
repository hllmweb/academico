<? $this->load->view('home/header'); ?>

<script src='<?= base_url("libs/fullcalendar/lib/moment.min.js") ?>'></script>
<script src='<?= base_url("libs/fullcalendar/fullcalendar.js") ?>'></script>
<script src='<?= base_url("libs/fullcalendar/locale/pt-br.js") ?>'></script>
<script src="<?= base_url('libs/tinymce/tinymce.min.js') ?>"></script>
<script src="<?= base_url('assets/js/spectrum.js') ?>"></script>
<link rel="stylesheet" href="<?= base_url('assets/css/spectrum.css')?>" />

<script type="text/javascript">
    function filtrar() {
        $("#calendario-eventos").fullCalendar("refetchEvents");
    }
</script>

<div class="content animate-panel">
    <div class="row projects">
        <div class="hpanel hgreen">    
            <div class="panel-heading">                
            </div>

            <div class="panel-footer">                
                <div class="row">
                    <div class="col-xs-4">
                        <a data-toggle="formModalPrimary" data-tipo="primary" class="btn btn-labeled btn-info" href="<?= base_url('' . $this->session->userdata('SGP_SISTEMA') . '/calendario_evento/modalRegistro/I') ?>" style="margin-top:7px">
                            <span class="btn-label">
                                <i class="fa fa-plus"></i>
                            </span>
                            <?= LBL_BTN_ADICIONAR ?>
                        </a>                        
                    </div>                    
                </div>                    
            </div>

            <div class="panel-body">                
                <div id="calendario-eventos">
                </div>                    
            </div>   
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#calendario-eventos").fullCalendar({
            locale: "pt-br",
            events: {
                url: "<?= site_url($this->session->userdata('SGP_SISTEMA')."/calendario_evento/registros") ?>",
                type: "POST",
                startParam: "inicio",
                endParam: "fim"
            },
            eventClick: function (calEvent, jsEvent, view) {
                $('#formModalInfo').remove();
                var $this = $(this)
                        , $remote = $this.data('remote') || calEvent.modal
                        , $modal = $('<div class="modal hmodal-info"  id="formModalInfo"  tabindex="-1" role="dialog" ><div class="modal-dialog" ><div class="modal-content"></div></div></div>');
                $('body').append($modal);
                $modal.modal({backdrop: 'static', keyboard: false});
                $modal.load($remote);
            }
        });
    });


    $('body').on('click', '[data-toggle="formModalPrimary"]',
            function (e) {
                $('#formModalPrimary').remove();
                e.preventDefault();
                var $this = $(this)
                        , $remote = $this.data('remote') || $this.attr('href')
                        , $modal = $('<div class="modal fade hmodal-primary" id="formModalPrimary"  tabindex="-1" role="dialog" ><div class="modal-dialog" ><div class="modal-content"></div></div></div>');
                $('body').append($modal);
                $modal.modal({backdrop: 'static', keyboard: false});
                $modal.load($remote);
            }
    );

    $('body').on('click', '[data-toggle="formModalWarning"]',
            function (e) {
                $('#formModalWarning').remove();
                e.preventDefault();
                var $this = $(this)
                        , $remote = $this.data('remote') || $this.attr('href')
                        , $modal = $('<div class="modal hmodal-warning" id="formModalWarning"  tabindex="-1" role="dialog" ><div class="modal-dialog" ><div class="modal-content"></div></div></div>');
                $('body').append($modal);
                $modal.modal({backdrop: 'static', keyboard: false});
                $modal.load($remote);
            }
    );

    $('body').on('click', '[data-toggle="formModalDanger"]',
            function (e) {
                $('#formModalDanger').remove();
                e.preventDefault();
                var $this = $(this)
                        , $remote = $this.data('remote') || $this.attr('href')
                        , $modal = $('<div class="modal fade hmodal-danger" id="formModalDanger"  tabindex="-1" role="dialog" ><div class="modal-dialog" ><div class="modal-content"></div></div></div>');
                $('body').append($modal);
                $modal.modal({backdrop: 'static', keyboard: false});
                $modal.load($remote);
            }
    );
</script>

<? $this->load->view('home/footer'); ?>