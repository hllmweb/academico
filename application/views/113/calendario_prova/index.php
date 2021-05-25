<? $this->load->view('home/header'); ?>

<!--<script src='<?= base_url("libs/fullcalendar/lib/jquery.min.js") ?>'></script>-->
<script src='<?= base_url("libs/fullcalendar/lib/moment.min.js") ?>'></script>
<script src='<?= base_url("libs/fullcalendar/fullcalendar.js") ?>'></script>
<script src='<?= base_url("libs/fullcalendar/locale/pt-br.js") ?>'></script>

<script type="text/javascript">
    function filtrar() {
        $("#calendario-provas").fullCalendar("refetchEvents");
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
                        <a data-toggle="formModalPrimary" data-tipo="primary" class="btn btn-labeled btn-info" href="<?= base_url('' . $this->session->userdata('SGP_SISTEMA') . '/calendario_prova/modalRegistro/I') ?>" style="margin-top:7px">
                            <span class="btn-label">
                                <i class="fa fa-plus"></i>
                            </span>
                            <?= LBL_BTN_ADICIONAR ?>
                        </a>                        
                    </div>

                    <div class="col-xs-8">
                        <div class="row">
                            <div class="col-sm-4">
                                <label>Bimestre</label><br/>
                                <select name="Bimestre" id="FTBimestre" class="form-control input-sm">
                                    <option value=""></option>
                                    <option value="1">1º BIMESTRE</option>
                                    <option value="2">2º BIMESTRE</option>
                                    <option value="3">3º BIMESTRE</option>
                                    <option value="4">4º BIMESTRE</option>
                                </select>
                            </div>

                            <div class="col-sm-4" style="padding-left:0px">
                                <label>Curso</label><br/>
                                <select name="Curso" id="FTCurso" class="form-control input-sm">
                                    <option value=""></option>                                    
                                    <? foreach ($curso as $row) { ?>
                                        <option value="<?= $row['CD_CURSO'] ?>">
                                            <?= $row['NM_CURSO_RED'] ?>
                                        </option>
                                    <? } ?>
                                </select>
                            </div>

                            <div class="col-sm-4" style="padding-left:0px">
                                <div class="form-group">
                                    <label>Série</label>
                                    <div class="input-group">
                                        <select name="Serie" id="FTSerie" class="form-control input-sm">
                                            <option value=""></option>
                                        </select>

                                        <span class="input-group-btn">
                                            <button onclick="filtrar()" type="button" class="btn btn-labeled btn-info input-sm">
                                                <span class="btn-label">
                                                    <i class="fa fa-search"></i>
                                                </span>
                                                Filtrar
                                            </button>
                                        </span>
                                    </div>
                                </div>                    
                            </div>
                        </div>
                    </div>
                </div>                    
            </div>

            <div class="panel-body">                
                <div id="calendario-provas">
                </div>                    
            </div>   
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#calendario-provas").fullCalendar({
            locale: "pt-br",
            events: {
                url: "<?= site_url($this->session->userdata('SGP_SISTEMA')."/calendario_prova/registros") ?>",
                type: "POST",
                startParam: "inicio",
                endParam: "fim",
                data: function () {
                    return {
                        curso: $("#FTCurso").val(),
                        serie: $("#FTSerie").val(),
                        bimestre: $("#FTBimestre").val()
                    };
                },
                allDayDefault: true
            },
            eventClick: function (calEvent, jsEvent, view) {
                $('#formModalInfo').remove();
                var $this = $(this)
                        , $remote = $this.data('remote') || calEvent.modal
                        , $modal = $('<div class="modal fade hmodal-info"  id="formModalInfo"  tabindex="-1" role="dialog" ><div class="modal-dialog" ><div class="modal-content"></div></div></div>');
                $('body').append($modal);
                $modal.modal({backdrop: 'static', keyboard: false});
                $modal.load($remote);
            }
        });
    });

    $("#FTCurso").change(function () {
        $("FTSerie").html('<option>Carregando</option>');
        $.post("<?= base_url('comum/combobox/serie') ?>", {
            curso: $(this).val()
        },
        function (valor) {
            $("#FTSerie").html(valor);
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
                        , $modal = $('<div class="modal fade hmodal-warning" id="formModalWarning"  tabindex="-1" role="dialog" ><div class="modal-dialog" ><div class="modal-content"></div></div></div>');
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