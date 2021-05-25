<? $this->load->view('home/header'); ?>
<script src="<?= base_url('assets/js/daterangepicker.js') ?>"></script>

<script type='text/javascript'>
    function txtFiltrar() {
        $("#tblFiltro").html('<?= LOAD ?>');
        $.post("<?= base_url('103/parecer/gridRegistro') ?>", {
            motivo: $("#FTMotivo").val(),
            data: $("#FTDataPendencia").val(),
            professor: $("#FTProfessor").val(),
            situacao: $("#FTSituacao").val()
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
                    <div class="col-xs-2">
                        <br>
                        <a class="btn btn-info" data-toggle="frmModalDeferir" href="<?= base_url('103/parecer/modalDeferir?codigo=' . $row->CD_SOLICITACAO) ?>">
                            <i class="fa fa-edit"></i> Avaliar
                        </a>
                    </div>

                    <div class="col-xs-10">                        
                        <div class="col-xs-3 form-group-sm">
                            <label>PROFESSOR</label>
                            <select id="FTProfessor" class="form-control input-sm">
                                <option value="">TODOS</option>
                                <?php foreach ($professores as $row): ?>
                                    <option value="<?= $row->CD_PROFESSOR ?>"><?= $row->NM_PROFESSOR ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-xs-3 form-group-sm">
                            <label>DATA PENDÊNCIA</label>
                            <div class="input-group m-b">
                                <input type="text" class="form-control input-sm" id="FTDataPendencia">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span> 
                            </div>
                        </div>

                        <div class="col-xs-3 form-group-sm">
                            <label>MOTIVO</label>
                            <select id="FTMotivo" class="form-control input-sm">
                                <option value="">TODOS</option>
                                <?php foreach ($motivos as $row): ?>
                                    <option value="<?= $row->CD_MOTIVO ?>"><?= $row->NM_MOTIVO ?></option>
                                <?php endforeach; ?>                                    
                            </select>                                
                        </div>                        

                        <div class="col-xs-3 form-group-sm">
                            <label>SITUAÇÃO</label>
                            <div class="input-group ">    
                                <select id="FTSituacao" class="form-control input-sm" style="display: table; table-layout: fixed">
                                    <option value="">TODAS</option>
                                    <option value="I">AGUARDANDO INFORMAÇÕES</option>                                    
                                    <option value="A">APROVADA</option>
                                    <option value="N">NOVA SOLICITAÇÃO</option>
                                    <option value="R">REPROVADA</option>                                    
                                </select>

                                <span class="input-group-btn">
                                    <button onclick="txtFiltrar()" type="button" id="" class="btn btn-xs btn-info input-sm">
                                        <span class="btn-label"><i class="fa fa-search"></i></span>
                                        Filtrar
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-body no-padding" id="tblFiltro">
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#FTProfessor").select2();
        $("#FTMotivo").select2();
        $("#FTSituacao").select2();
    });

    $("#FTDataPendencia").daterangepicker({
        startDate: "<?= $dataInicio ?>",
        endDate: "<?= $dataFim ?>",
        locale: {
            format: "DD/MM/YYYY",
            applyLabel: "Ok",
            cancelLabel: "Cancelar"
        }
    });

    $('[data-toggle="frmModalDeferir"]').on('click',
            function (e) {
                e.preventDefault();
                if ($("#tblFiltro :checked").length === 0) {
                    swal("Aviso", "Por favor, selecione uma solicitação para validar.", "warning");
                } else {
                    $('#frmModalDeferir').remove();
                    var $this = $(this)
                            , $remote = $this.data('remote') || $this.attr('href')
                            , $modal = $('<div class="modal fade hmodal-warning no-padding"  id="frmModalDeferir"  tabindex="-1" role="dialog" ><div class="modal-dialog no-padding" ><div class="modal-content no-padding"></div></div></div>');
                    $('body').append($modal);
                    $modal.modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $modal.load($remote);
                }
            }
    );
</script>

<? $this->load->view('home/footer'); ?>