<?php $id = date('dmYhis');?>
<div class="modal-dialog">    
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">
            <h5 class="modal-title pull-left">
                <?= $turno_extenso . ' - ' . $dia_extenso . ' - ' . $tempo . 'º Tempo' ?>
            </h5>
            <i class="fa fa-4x fa-graduation-cap"></i>
        </div>
        <form id="frmTurmaHorario<?=$id?>">
            <div class="modal-body row">
                <div class="row">
                    <div class="col-xs-7">
                        <label>PROFESSOR</label>
                        <div class="input-group m-b">
                            <span class="input-group-addon">
                                <i class="fa fa-user"></i>
                            </span>
                            <input value="<?=$dados->NM_PROFESSOR?>" disabled="disabled" type="text" class="input-sm form-control" name="nmProfessor" />
                        </div>
                    </div>
                    <div class="col-xs-5" style="padding-left: 0px">
                        <label>DISCIPLINA</label>
                        <div class="input-group m-b">
                            <span class="input-group-addon">
                                <i class="fa fa-sitemap"></i>
                            </span>
                            <input value="<?=$dados->NM_DISCIPLINA_REDUZIDO?>" disabled="disabled" type="text" class="input-sm form-control" name="nmDisciplina" />
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <label>PERÍODO</label>                        
                        <div class="input-daterange input-group" id="datepicker">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input value="<?=date('d/m/Y', strtotime(implode("-", array_reverse(explode("/", $dados->DT_INICIO)))))?>" type="text" class="input-sm form-control" name="DTInicio" placeholder="INÍCIO" />
                            <span class="input-group-addon">Até</span>
                            <input value="<?=(($dados->DT_FIM != '')? date('d/m/Y', strtotime(implode("-", array_reverse(explode("/", $dados->DT_FIM))))) : '')?>" type="text" class="input-sm form-control" name="DTFim" placeholder="FIM"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="FRMRetorno">
            </div>
            <div class="modal-footer">
                
                <input type="hidden" name="Operacao" value="U" />
                <input type="hidden" name="Horario" value="<?=$dados->CD_CL_TURMA_HORARIO?>"/>
                
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                    <i class="fa fa-times"></i> Fechar
                </button>
                <button id='btnEnviar' type="submit" class="btn btn-primary">
                    <i class="fa fa-plus"></i>
                    SALVAR
                </button>
            </div>
        </form>
        <script type="text/javascript">

        $(document).ready(function (e) {
            
            $('.input-daterange').datepicker({
                autoclose: true
            });
            
            $("#frmTurmaHorario<?=$id?>").on('submit', (function (e) {
                e.preventDefault();
                $("#FRMRetorno").html('Enviando dados...');
                $.ajax({
                    url: "<?=base_url($this->session->userdata('SGP_SISTEMA') . '/turma_horario/frmManter')?>",
                    type: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        $("#datagridview").html('<small><i>Atualizando datagrid</i></small>');
                        $.post("<?= base_url($this->session->userdata('SGP_SISTEMA') . '/tempos/datagridHorarioTurma') ?>", {
                            p: '<?= $this->input->get('p') ?>',
                        },
                        function (data) {
                            $("#datagridview").html(data);
                        });
                        $("#FRMRetorno").html(data);
                        //$('#frmModalDataGridView').modal('hide');
                    }
                });
            }));
        });
    </script>
    </div>    
</div>
