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
        <link rel="stylesheet" href="<?=base_url('assets/css/bootstrap-select.css')?>" />
        <script src="<?=base_url('assets/js/bootstrap-select.min.js')?>"></script>
        <form id="frmTurmaHorario<?=$id?>">
            <div class="modal-body row">
                <div class="row">
                    <div class="col-xs-12">
                        <label>PERÍODO</label>                        
                        <div class="input-daterange input-group" id="datepicker">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input type="text" class="input-sm form-control" name="DTInicio" placeholder="INÍCIO" />
                            <span class="input-group-addon">Até</span>
                            <input type="text" class="input-sm form-control" name="DTFim" placeholder="FIM"/>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <label>PROFESSOR</label>
                        <div class="input-group m-b">
                            <span class="input-group-addon">
                                <i class="fa fa-user"></i>
                            </span>
                            <select name="Professor" id="Professor" class="form-control">
                                <option></option>
                                <optgroup label="Professores Livres">
                                    <? foreach($professor as $p){ 
                                        if($p['ALOCADO'] == ''){
                                        ?>
                                        <option data-item-disciplina="<?=$p['CD_DISCIPLINA']?>" value="<?=$p['CD_PROFESSOR']?>" >
                                            <?=$p['NM_PROFESSOR'].' ('.$p['CD_PROFESSOR'].') - <strong>'. $p['NM_DISC_RED'].' ('.$p['CD_DISCIPLINA'].')</strong>'?>
                                        </option>
                                    <? }} ?>
                                </optgroup>
                                <optgroup label="Professor(es) Alocado(s) neste horário">
                                    <? foreach($professor as $p){ 
                                       if($p['ALOCADO'] != ''){
                                       ?>
                                       <option disabled="disabled" value="<?=$p['CD_PROFESSOR']?>" >
                                           <?=$p['NM_PROFESSOR'].' ('.$p['CD_PROFESSOR'].') '. $p['NM_DISC_RED'].' ('.$p['CD_DISCIPLINA'].') - '.' ('.$p['ALOCADO'].')'?>
                                       </option>                                    
                                   <? }} ?>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="FRMRetorno">
            </div>
            <div class="modal-footer">
                
                <input type="hidden" name="Operacao" value="<?='I'?>" />
                <input type="hidden" name="Turma" value="<?=$turma[0]->CD_TURMA?>" />
                <input type="hidden" name="Tempo" value="<?=$tempo?>" />
                <input type="hidden" name="Turno" value="<?=$turno?>" />
                <input type="hidden" name="Dia" value="<?=$dia?>" />
                <input type="hidden" name="Disciplina" value=""/>
                <input type="hidden" name="Curso" value="<?=$turma[0]->CD_CURSO?>"/>
                <input type="hidden" name="Serie" value="<?=$turma[0]->CD_SERIE?>"/>
                
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                    <i class="fa fa-times"></i> Fechar
                </button>
                <button id='btnEnviar' type="submit" class="btn btn-primary">
                    <i class="fa fa-plus"></i>
                    ADICIONAR HORÁRIO
                </button>
            </div>
        </form>
        <script type="text/javascript">

        $(document).ready(function (e) {
            
            $('.input-daterange').datepicker({
                autoclose: true
            });
            $('#Professor').selectpicker();
            
            
             $("select[id=Professor]").change(function() {
                var disc = $(this).find('option:selected').data('item-disciplina');
                $("input[name=Disciplina]").val(disc);
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
                    dataType: 'json',
                    processData: false,
                    success: function (data) {
                        // Caso tenha inserido os dados corretamente
                        if(data["status"] == true ){
                            $("#datagridview").html('<small><i>Atualizando datagrid</i></small>');
                            $.post("<?= base_url($this->session->userdata('SGP_SISTEMA') . '/tempos/datagridHorarioTurma') ?>", {
                                p: '<?= $this->input->get('p') ?>',
                            },
                            function (grid) {
                                $("#datagridview").html(grid);
                            });                        
                            $("#FRMRetorno").html(data["mensagem"]);
                            $('#frmModalDataGridView').modal('hide');
                        }else{
                            $("#FRMRetorno").html(data["mensagem"]);
                        }
                    }
                });
            }));
        });
    </script>
    </div>    
</div>
