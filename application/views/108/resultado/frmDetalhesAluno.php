<style>
    .text-bold{
        font-weight: bold;
    }
</style>
<div class="modal-dialog modal-lg animated-panel zoomIn" style="animation-delay: 0.1s;">
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">

            <i class="fa fa-4x fa-graduation-cap pull-left"></i>
            <h5 class="modal-title  pull-left">Detalhes do Aluno - <strong><?= $aluno[0]['NM_ALUNO']; ?></strong></h5>
            
        </div>
        <div class="modal-body">
            <div class="well row">
                <div class="col-xs-12" style="margin-bottom: 15px">
                    <h6><strong><?=$aluno[0]['TITULO'].' - '.$aluno[0]['DISCIPLINAS']?></strong></h6>
                    <div class="col-xs-6">
                        <table class="table">
                              <!-- <tr>
                                <td class="text-center">Qtd. Questão: <?=$aluno[0]['QTD']?></td>                                
                            </tr>
                            <tr>
                                <td class="text-center">Valor por Questão: <?php #echo $aluno[0]['VL_QUESTAO']?></td>                                
                            </tr>                           
                            <tr>
                                <td class="text-center">Max Objetiva: <?=$aluno[0]['VL_T_OBJETIVA']?></td>
                            </tr>
                            <tr>
                                <td class="text-center">Max Discursiva: <?=$aluno[0]['VL_T_DISCURSIVA']?></td>                                
                            </tr>-->  
                        </table>
                    </div>                                        
                    </div>
                <br><br><br>
                <div class="col-xs-12">
                    <table class="table">
                        <tr style="background-color: #d3d3d3; color:#333;">
                            <td class="text-right"></td>
                            <?php for($i=1; $i <= 10; $i++){ ?>
                            <td class="text-center">
                                <strong><?= $i; ?><!--ª Questão--></strong>    
                            </td>
                            <?php } ?>
                        </tr>
                        <!-- <tr>
                            <td width="10%" class="text-right">Valor</td>
                            <?php 
                            $valor_separar = explode(",",$aluno[0]['VALOR']);
                            for($i=0; $i < 10; $i++){ 
                                $v1 = floatval($valor_separar[$i]);
                            ?>
                                <td class="text-center">
                                    <strong><?= $v1 ?></strong>
                                </td>
                            <? } ?>                            
                        </tr> -->
                        <tr>

                            <td width="10%" class="text-right">Gabarito</td>
                            <? 
                            for($i=0; $i < 10;$i++){ 
                                $s1 = substr($aluno[0]['RESPOSTAS'],$i,1);
                                $s2 = substr($aluno[0]['GABARITO'],$i,1);
                                ?>
                                <td class="bg-<?=(($s1 == $s2)? 'success text-bold': 'danger' )?> text-center">
                                    <?=substr($aluno[0]['GABARITO'],$i,1)?>
                                </td>
                            <? } ?>
                        </tr>
                        <tr>
                            <td class="text-right">Respostas</td>
                            <? for($i=0; $i < 10;$i++){ 
                                $s1 = substr($aluno[0]['RESPOSTAS'],$i,1);
                                $s2 = substr($aluno[0]['GABARITO'],$i,1);
                                ?>
                                <td class="bg-<?=(($s1 == $s2)? 'success text-bold': 'danger' )?> text-center">
                                    <?=substr($aluno[0]['RESPOSTAS'],$i,1)?>
                                </td>
                            <? } ?>
                        </tr>
                    </table>
             
                </div>

            </div>




                    <fieldset style="background-color: #f3f3f3; padding: 10px; margin-top:40px; font-weight: bold; border:1px solid #d3d3d3;">
                       
                        <legend style="border-bottom: 0; font-weight: bold; text-transform: uppercase; padding:0 10px; margin:20px 0 0 0; background-color: #d3d3d3; color:#333; font-size:14px;">Legenda</legend>
                        Z: QUESTÃO NÃO RESPONDIDA;<br>
                        #: QUESTÃO CANCELADA;<br>
                        *: QUESTÃO ANULADA;<br>
                        <span style="background-color: #F2DEDE; width: 30px; height: 30px; display: inline-block; vertical-align: middle; margin-right: 10px;"></span>Erro
                        <span style="background-color: #c4fcc6; width: 30px; height: 30px; display: inline-block; vertical-align: middle; margin-right: 10px;"></span>Acerto
                    </fieldset>
        </div>
        <div class="modal-footer">
            
            <button type="button" class="btn btn-danger2 pull-left" data-dismiss="modal">
                <i class="fa fa-times"></i> Fechar
            </button>
        </div>
    </div>
</div>
