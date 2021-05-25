<?php
    function moeda($valor){
        return number_format($valor, 2, ',','.');
    }
   // var_dump($nota);
   // var_dump($listar); 
?>
<div class="modal-dialog modal-lg" id="mdlAtualizar">

    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">
            <h5 class="modal-title">[Detalhes do Processamento]</h5>            
        </div>
        <div class="modal-body" style="height: 350px; overflow: auto">
            <div vclass="well row">
                <!-- <div class="col-xs-1">
                    <i class="fa fa-4x fa-graduation-cap"></i>
                </div> -->
                <div class="col-xs-11">
                    <h6><strong><?=$listar[0]['CD_TURMA'].' - '.$listar[0]['NM_DISCIPLINA']?></strong></h6>
                   <!--  <h6>Qtd. Questão: <?=$listar[0]['QTD']?></h6>
                    <h6>Valor por Questão: <?=$listar[0]['VL_QUESTAO']?></h6>
                    <h6>Max Objetiva: <?=$listar[0]['VL_T_OBJETIVA']?></h6>
                    <h6>Max Discursiva: <?=$listar[0]['VL_T_DISCURSIVA']?></h6> -->
                </div>
            </div> 
            <table class="table table-bordered table-hover" id="resultado-prova">
                <tr class="font-bold panel-footer">
                    <td>ALUNO</td>
                    <td>VERSÃO</td>
                    <td>ACERTOS</td>
                   <!-- <td>VL QUESTÃO</td> -->
                    <td class="text-center">OBJETIVA</td>
                    <td class="text-center">Enviada p/ RM</td>
                    <!-- <td class="bg-warning text-center">DISCURSIVA</td> -->
                    <!-- <td class="bg-success text-center">NOTA</td> -->
                    <td class="text-center"></td>
                </tr>
                <?                 
                    foreach($listar as $key => $l){            
                ?>
                <tr>
                    <td style="font-size: 11px"><?=substr($l['CD_ALUNO'].' - '.$l['NM_ALUNO'],0,50)?></td>
                    <td class="text-center"> <?=$l['CD_PROVA_VERSAO']?></td>
                    <td class="text-center"><?=$l['NR_ACERTO'].' / '.($l['NR_ACERTO'] + $l['NR_ERRO'])?></td>
                  
                    <td class="<?= (($l['NR_NOTA'] == '')? 'bg-warning' : 'bg-success'); ?> text-center">
                          <?=(($l['NR_NOTA'] == '')? '-' : moeda($l['NR_NOTA']) )?>
                    </td>

                    <td class="text-center">
                        <?= (empty($nota[$key]['NOTA']) && $nota[$key]['NOTA'] != $l['NR_NOTA']) ?  "<i class='fa fa-close' style='color:red;'></i>" :  "<i class='fa fa-check' style='color:green;'></i>"; ?>
                    </td>

                    <!-- <td class="bg-warning text-center">  -->
                        
                        <?php #echo $l['CD_DISCIPLINA']; #echo(($l['NR_NOTA_DISCURSIVA'] == '')? '-' : $l['NR_NOTA_DISCURSIVA'])?> 
                        <?php 
                            /*if($l['NR_NOTA_DISCURSIVA'] == '' ){ ?>
                            -
                            <?php }else{ */?>

                        <!-- <div class="calc_nota"> -->
                        <!--
                            <input type="hidden" id="prova_o_<?= $l['CD_ALUNO']; ?>" class="nota_objetiva" value="<?= $l['NR_NOTA']?>">

                            <input type="text" id="prova_d_<?= $l['CD_ALUNO']; ?>" class="nota_discursiva" value="<?= moeda($l['NR_NOTA_DISCURSIVA']); ?>" data-nota="<?= $l['NR_NOTA_DISCURSIVA'] ?>" data-aluno="<?= $l['CD_ALUNO']; ?>" data-prova-versao="<?= $l['CD_PROVA_VERSAO']; ?>" data-disciplina="<?= $l['CD_DISCIPLINA']; ?>" style="width:25%; display: inline-block;" disabled/>

                            <button type="button" class="btn btn-primary btn-xs edit-discursiva" rel="<?= $l['CD_ALUNO']; ?>" id="prova_<?= $l['CD_ALUNO']; ?>" data-discursiva="<?= $l['NR_NOTA_DISCURSIVA']; ?>" data-objetiva="<?= $l['NR_NOTA']; ?>">Editar</button> -->

                        <!--     <button type="button" class="btn btn-success btn-xs up-nota" rel="<?= $l['CD_ALUNO']; ?>" data-versao="<?= $l['CD_PROVA_VERSAO']; ?>" data-disciplina="<?= $l['CD_DISCIPLINA']; ?>"><i class="fa fa-refresh"></i></button> -->
                       <!-- </div> -->

                    <!-- </td> -->

<!--                     <td class="bg-success text-center"> 
                        <div class="nota_geral">
                            <div id="ref_<?= $l['CD_ALUNO']; ?>">   
                                <input type="hidden" id="input_<?= $l['CD_ALUNO']; ?>" value="<?= moeda($l['NOTA']); ?>">
                                
                                <?=(($l['NOTA'] == '')? '-' : moeda($l['NOTA']))?>    
                              
                            </div>   
                          </div>                                     
                    </td> -->

                    <td class="text-center">
                        <button type="button" class="btn btn-info btn-xs" data-remote="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/resultado/frmDetalhesAluno/'.$l['CD_ALUNO'].'-'.$l['CD_PROVA_VERSAO'].'')?>" data-toggle="frmModalDetalhe">
                            <i class="fa fa-search"></i> Visualizar
                        </button>
                    </td>
                </tr>
                <? } ?>
            </table>
            <br>
            <br>

            <!-- <table class="table">
                <tr style="background-color: red; color:#FFF;">
                    <td><strong>ALUNOS QUE NÃO FIZERAM AS PROVAS</strong></td>
                </tr>   
                <tr style="background-color: #CCC; color:#000;">
                    <td><?php #echo $listar_nao_fez[0]['NM_ALUNO']; ?></td>
                </tr>
            </table>
             -->

        </div>
        <div class="modal-footer">
          
            <button class="btn btn-success" id="exporta-nota" data-cdprovapai="<?= $original; ?>"><i class="fa fa-file-export"></i> Exportar Nota</button>
          
            <a class="btn btn-primary2" target="_blank" href="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/resultado/pntDetalhes/'.$listar[0]['CD_TIPO_PROVA'].'-'.$listar[0]['CD_PROVA'].'')?>">
                <i class="fa fa-print"></i> Imprimir
            </a>
                        
            <button type="button" class="btn btn-danger2" data-dismiss="modal">
                <i class="fa fa-times"></i> Fechar
            </button>


        </div>
    </div>
<script type="text/javascript">

//formatando nota discursiva
// $(document).on("keyup",".nota_discursiva",function(e){
//     e.preventDefault();
//     that = $(this).val().replace(",",".");
//     console.log(that);
//     $(this).val(that);
// });  

$(document).on("click", "#exporta-nota", function(e){
    cd_prova_pai = $(this).data('cdprovapai');

    $.ajax({
        url: "<?php echo base_url('108/resultado/exporta_nota'); ?>",
        type: "POST",
        data: {
            cd_prova_pai: cd_prova_pai
        },
        success: function(data){
            alert(data);
            $("#mdlAtualizar").load("http://server01/academico/108/resultado/mdlDetalhes/2-"+cd_prova_pai+"");
            //console.log(data);
        }

    });


    e.preventDefault();
});

//habilitando campo da nota discursiva
$(document).on("click",".edit-discursiva",function(e){
    self            = $(this).attr("rel");
    n_objetiva      = $(this).data("data-objetiva");
    n_discursiva    = $(this).data("data-discursiva"); 
    prova           = $(this).attr("id");

    $("#prova_d_"+self).removeAttr("disabled","");

    $("#prova_d_"+self).keyup(function(){
        var prova_discursiva = $(this).val().replace(",",".");
        var prova_objetiva = $("#prova_o_"+self).val();
        var calcular = parseFloat(prova_objetiva) + parseFloat(prova_discursiva);
        $("#ref_"+self).html(calcular.toFixed(2));
    });


    e.preventDefault();
});


//editando nota discursiva
$(document).on("change",".nota_discursiva",function(e){
    e.preventDefault();


    $invalid = $(this);
    nota_discursiva = $(this).val();
    cd_aluno        = $(this).data("aluno");
    cd_prova_versao = $(this).data("prova-versao");
    cd_disciplina   = $(this).data("disciplina");

    //console.log("nota: "+nota_discursiva+" cd aluno: "+cd_aluno+" cd prova versao"+cd_prova_versao+" cd disciplina:"+cd_disciplina);

    $.ajax({
        url: "<?= base_url('108/prova_questoes/upNotaDiscursiva') ?>",
        type: "POST",
        data: {
            nota_discursiva: nota_discursiva,
            cd_aluno: cd_aluno,
            cd_prova_versao: cd_prova_versao,
            cd_disciplina: cd_disciplina
        }
        /*,
        beforeSend: function(){
            $invalid.val("Atualizando Nota...");
        }*/
        ,
        success: function(data){
            if(data == "ok"){
                $invalid.val(nota_discursiva);
            }
        }

    });


});




//atualizando nota total 
// $(document).on("keyup",".calc_nota",function(e){

    // self        = $(this).attr("rel");
    // disciplina  = $(this).data("disciplina");
    // versao      = $(this).data("versao");
    //$("#ref_"+self).html("atualizado");

    //$("#input_"+self).attr("value",$("#input_"+self).val());
    // $("#"+self).val();

    // console.log(disciplina);
    // console.log(versao);

    // $(".calc_nota").keyup(function(){
        //objetiva = parseFloat($(this).val());
        //discursiva = parseFloat($(this).val());

         // recalcular();

            // valor_total = 0;
            
            // nota_objetiva = $(this).find(".nota_objetiva").val();
            // nota_discursiva = $(this).find(".nota_discursiva").val();
            //  console.log("nota objetiva"+nota_objetiva);
            // console.log("nota discursiva"+nota_discursiva);
            // n = parseFloat(nota_discursiva) + parseFloat(nota_discursiva);    

            // console.log(n);
            // $(".nota_geral").html(n);
        //e.preventDefault();
    // });

    /*$.ajax({
        url: "<?php #echo base_url('108/prova_questoes/refreshNotaDiscursiva') ?>",
        type: "POST",
        data: {
            cd_aluno: self,
            cd_disciplina: disciplina,
            cd_prova_versao: versao
        },
        success: function(data){
            //$("#rel_"+self).html(data);
            
            console.log(data);
            $("#ref_"+self).html(data.replace(".",","));
            

           // console.log(self);
            $("#"+self).attr("disabled","disabled");
        }

    });*/
//     e.preventDefault();
// });




$('[data-toggle="frmModalDetalhe"]').on('click',
    function(e) {
        $('#frmModalDetalhe').remove();
        e.preventDefault();
        var $this = $(this)
                , $remote = $this.data('remote') || $this.attr('href')
                , $modal = $('<div class="modal fade hmodal no-padding"  id="frmModalDetalhe"  tabindex="-1" role="dialog" ><div class="modal-dialog no-padding" ><div class="modal-content no-padding"></div></div></div>');
        $('body').append($modal);
        $modal.modal({backdrop: 'static', keyboard: true });
        $modal.load($remote);
    }
);
</script>

</div>
