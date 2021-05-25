<? $this->load->view('home/header'); ?>
<div class="hpanel col-cd-3" style="position: fixed; bottom:20px">
    <div class="panel-heading">
        Professor Avaliado
    </div>
    <div class="panel-body">
        <div class="col-xs-3">
            <img width="50" src="http://server01.seculomanaus.com.br/academico/usuarios/foto?codigo=<?=$professor->CD_PROFESSOR?>" class="img-rounded" >
        </div>
        <div class="col-xs-9">
            <?=$professor->NM_PROFESSOR?><br>
            <?=$professor->NM_DISCIPLINA?>
        </div>
    </div>
</div>
<div class="content animate-panel">
    <div class="row">
        <div class="col-sm-4"></div>
      <div class="col-sm-8 block-center mt-xl wd-xl" style="top: 10px">
         <!-- START panel-->
         <div class="panel panel-warning">
            <div class="panel-heading">
                <h4>QUESTIONÁRIO DA AVALIAÇÃO INSTITUCIONAL</h4>
            </div>
            <div class="panel-body">
                <form action="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/institucional/frmValidar')?>" method="POST" class="mb-lg">
                    <input type="hidden" name="professor" id="professor" value="<?=$professor->CD_PROFESSOR?>">
                    <input type="hidden" name="disciplina" id="disciplina" value="<?=$professor->CD_DISCIPLINA?>">
                    <table class="table table-hover">
                        <tbody>
                            <? 
                            $divisor = '';
                            foreach($questionario as $qt){ 
                                
                                if($divisor <> $qt['DC_DIVISAO']){
                                $divisor = $qt['DC_DIVISAO'];
                                ?>
                            <tr>
                                <th colspan="3"><?=$qt['DC_DIVISAO']?></th>
                            </tr>
                                <? } ?>
                            <tr>
                                <td><?=$qt['CD_PERGUNTA']?></td>
                                <td><?=$qt['DC_PERGUNTA']?></td>
                                <td>
                                    <select required="required" name="resposta[]" class="btn btn-sm btn-info no-padding no-margins">
                                        <option></option>
                                        <? foreach($resposta as $rp){ ?>
                                            <option value="<?=$qt['CD_PERGUNTA'].'-'.$rp['CD_RESPOSTA_PADRAO']?>"><?=$rp['CD_RESPOSTA_PADRAO'].' - '.$rp['DC_RESPOSTA_PADRAO']?></option>
                                        <? } ?>
                                    </select>
                                </td>
                            </tr>
                            <? } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-center"></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-center"><input type="submit" class="btn btn-warning" value="Finalizar Questionário" ></td>
                            </tr>
                        </tfoot>
                    </table>
               </form>
            </div>
         </div>
      </div>
    </div>
</div>

<? $this->load->view('home/footer'); ?>