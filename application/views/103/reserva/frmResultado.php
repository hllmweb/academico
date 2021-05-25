<div class="modal-dialog" id="frmNovaSolicitacao">
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">
            <h4 class="modal-title">Solicitação de Reserva</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <form id="frmSolicitacao">                
                    <div class="col-xs-4">
                        <label>Período:</label>
                        <select name="resPeriodo" id="resPeriodo" class="form-control input-sm">
                            <option value="<?=$this->session->userdata('SGP_PERIODO')?>"><?=$this->session->userdata('SGP_PERIODO')?></option>
                        </select>
                    </div>
                    <div class="col-xs-4 no-padding">
                        <label>Curso:</label>
                        <select name="resCurso" id="resCurso" class="form-control input-sm">
                            <option></option>
                                <? foreach ($curso as $c) { ?>
                                <option value="<?= $c['CD_CURSO'] ?>"><?= $c['NM_CURSO_RED'] ?></option>
                                <? } ?>
                        </select>
                    </div>
                    <div class="col-xs-4">
                        <label>Série:</label>
                        <select name="resSerie" id="resSerie" class="form-control input-sm">
                            <option></option>
                        </select>
                    </div>

                    <div class="col-xs-4">
                        <label>Turma:</label>
                        <select name="resTurma" id="resTurma" class="form-control input-sm">
                            <option></option>
                        </select>
                    </div>
                    <div class="col-xs-8" style="padding-left: 0px">
                        <label>Disciplina:</label>
                        <select name="resDisciplina" id="resDisciplina" class="form-control input-sm">
                            <option></option>
                        </select>
                    </div>

                    <div class="col-xs-8">
                        <label>Professor:</label>
                        <select name="resProfessor" id="resProfessor" class="form-control input-sm">
                            <option></option>
                        </select>
                    </div>
                    <div class="col-xs-4" style="padding-left: 0px">
                        <label>Data:</label>
                        <div class="input-group m-b">
                            <input size="16" type="text" class="form-control input-sm"   name="resData" id="resData" >
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span> 
                        </div>
                    </div>
                    
                    <div class="col-xs-4">
                        <label>Hora Início:</label>
                        <div class="input-group m-b">
                            <input size="16" type="text" class="form-control input-sm"   name="resHInicio" id="resHInicio" >
                            <span class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </span> 
                        </div>
                    </div>
                    
                    <div class="col-xs-4" style="padding-left: 0px">
                        <label>Data:</label>
                        <div class="input-group m-b">
                            <input size="16" type="text" class="form-control input-sm"   name="resHFim" id="resHFim" >
                            <span class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </span> 
                        </div>
                    </div>

                    <div class="col-xs-4">
                        <label>Tipo Local:</label>
                        <select name="resTipoLocal" id="resTipoLocal" class="form-control input-sm">
                            <option></option>
                            <option value="L">LABORATÓRIO</option>
                            <option value="E">ESPAÇO</option>
                        </select>
                    </div>
                    
                    <div class="col-xs-12" >
                        <label>Local:</label>
                        <select name="resLocal" id="resLocal" class="form-control input-sm">
                            <option></option>
                        </select>
                    </div>
                    <input type="hidden" name="operacao" id="operacao" value="<?=$operacao?>">
                </form>
            </div>
        </div>
        <div class="modal-footer" id="resRetorno"></div>
        
        <div class="modal-footer">
            <button type="button" class="btn btn-danger2 pull-left" data-dismiss="modal">
                <i class="fa fa-times-circle"></i> Fechar
            </button>
            <button target="_blank" class="btn btn-info btnSubmit" >
                <i class="fa fa-search-minus"></i> Finalizar
            </button>
        </div>
        <script type="text/javascript">
            
            $("#resData").datepicker({
                format: "dd/mm/yyyy",
                autoclose: true,
                //endDate: '+0d',
            });
            $('#resHInicio').timepicker({
                showMeridian: false,
            });
            $('#resHFim').timepicker({
                showMeridian: false,
            });
            
            $("select[id=resTipoLocal]").change(function() {
                $("select[id=resLocal]").html('<option>Carregando</option>');
                $.post("<?= base_url('comum/combobox/reserva_local') ?>", {
                    tipo: $(this).val()
                },
                function(valor) {
                    $("select[id=resLocal]").html(valor);
                });
            });
            
            $("select[id=resCurso]").change(function() {
                $("select[id=resSerie]").html('<option>Carregando</option>');
                $.post("<?= base_url('comum/combobox/serie') ?>", {
                    curso: $(this).val()
                },
                function(valor) {
                    $("select[id=resSerie]").html(valor);
                    $("select[id=resTurma]").val();
                });
            });

            $("select[id=resSerie]").change(function() {
                $("select[id=resTurma]").html('<option>Carregando</option>');
                $.post("<?= base_url('comum/combobox/turma') ?>", {
                    curso: $("select[id=resCurso]").val(),
                    serie: $("select[id=resSerie]").val(),
                },
                function(valor) {
                    $("select[id=resTurma]").html(valor);
                });
            });

            $("select[id=resTurma]").change(function() {
                $("select[id=resDisciplina]").html('<option>Carregando</option>');
                $.post("<?= base_url('comum/combobox/disciplina') ?>", {
                    curso: $("select[id=resCurso]").val(),
                    serie: $("select[id=resSerie]").val(),
                },
                function(valor) {
                    $("select[id=resDisciplina]").html(valor);
                });
            });

            $("select[id=resDisciplina]").change(function() {
                $("select[id=resProfessor]").html('<option>Carregando</option>');
                $.post("<?= base_url('comum/combobox/professor') ?>", {
                    curso: $("select[id=resCurso]").val(),
                    disciplina: $("select[id=resDisciplina]").val(),
                },
                function(valor) {
                    $("select[id=resProfessor]").html(valor);
                });
            });
            
            $('.btnSubmit').click(function() {
                swal({
                    title: "Solicitação de Reserva",
                    text: "Você tem certeza que deseja salvar essa solicitação de reserva? ",
                    type: "info",
                    showCancelButton: true,
                    confirmButtonText: "Sim, finalizar!",
                    cancelButtonText: "Não, Cancelar!",
                    closeOnConfirm: false,
                    closeOnCancel: true,
                },
                function(isConfirm) {
                    if (isConfirm) {
                        var dados = jQuery('#frmSolicitacao').serialize();
			jQuery.ajax({
                            type: "POST",
                            url: "<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/reserva/frmManter') ?>",
                            data: dados,
                            success: function( data ){
                                swal("Sucesso!", "Solicitação de reserva criada.", "success");
                                $("#resRetorno").html(data);
                            }
			});
			return false;

                    }
                });
            });
        </script>
    </div>
</div>
