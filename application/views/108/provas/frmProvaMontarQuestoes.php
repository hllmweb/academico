<?
$this->load->view('home/header');
?>


<script type="text/javascript">
    function AvalProvaQuestaoPosicao(questao, posicao, prova) {
        $.post("<?= base_url('108/prova_questoes/frmManterProvaQuestao') ?>", {
            operacao: 'EP',
            avalProva: prova,
            avalQuestao: questao,
            avalPosicao: posicao,
        },
        function(data) {
            location.reload(); 
             
        });
    };


    /*function AvalProvaQuestaoNota(questao, valor, prova) {*/
        //console.log("cod_questao: "+questao+" cod_prova: "+prova);
       /* $.post("", {
            operacao: 'EN',
            avalProva: prova,
            avalQuestao: questao,
            avalValor: valor,
        },
         function(data) {
            // console.log(data);
            //location.reload(); 
         });*/
    
    
         /*$.ajax({
            url: "",
            type: "POST",
            data: {
                operacao: 'EN',
                avalProva: prova,
                avalQuestao: questao,
                avalValor: valor,
            }*/
            /*,
            beforeSend: function(){
                $(".avalPosicaoNota").val("salvando...");
            }*/
            /*,
            success: function(data){
                location.reload(); 
                //$(".avalPosicaoNota").val(valor);  */
          /*  }
         });
    
    };*/



    function AvalProvaQuestaoExcluir(prova, questao) {
        $.post("<?= base_url('108/prova_questoes/frmManterProvaQuestao') ?>", {
            operacao: 'X',
            avalProva: prova,
            avalQuestao: questao
        },
        function(data) {
            location.reload(); 
        });
    };


    $(document).on("change",".avalPosicaoNota",function(e){
        
        questao = $(this).data("questao");
        valor   = $(this).val();
        prova   = $(this).data("prova");
        
        
        
        $.ajax({
            url: "<?= base_url('108/prova_questoes/frmManterProvaQuestao') ?>",
            type: "POST",
            data: {
                operacao: 'EN',
                avalProva: prova,
                avalQuestao: questao,
                avalValor: valor,
            },
            beforeSend: function(){
                $(this).val("salvando...");
            },
            success: function(data){
                console.log(data);
                //location.reload(); 
                $(this).val(valor);  
            }
         });
    

        e.preventDefault();
    });


    $(document).on("keyup",".avalPosicaoNota",function(e){
        e.preventDefault();
        that = $(this).val().replace(",",".");
        //console.log(that);
        $(this).val(that);
        //$(this).val(that.toFixed(4));

    });

    $(function(){

        /*var total = 0;
        $(".avalPosicaoNota").each(function(index,element){
            //if($(element).val()){
                total += Number.parseFloat($(element).val());
            //}
            console.log(parseFloat($(element).val()));
            //console.log($(element).val());
        });
        $(".show-total").text(total);*/

        function toFloat(numero) {
            var numero = numero.replace(".","");
                numero = numero.replace(",",".");
            return parseFloat(numero);
        }

        var total = 0;
        $(".avalPosicaoNota").each(function(index,element){
            total += toFloat($(element).val());
        });
        //console.log(total);
        $(".show-total").text(total.toFixed(1));
    });

    $(document).on("keyup",".avalPosicaoNota",function(e){
        e.preventDefault();

        var total = 0;
        $(".avalPosicaoNota").each(function(index,element){
            if($(element).val()){
                total += Number.parseFloat($(element).val());
            }
            //total += toFloat($(element).val());
        });
        $(".show-total").text(total.toFixed(1));
    });



</script>
<?php 
function moeda($valor){
	return number_format($valor, 2, ',','.');
}

#GRAVA NO BANCO TIPO FLOAT
function vfloat($valor)
{
	$array = explode(",",$valor);
	
	$um 	= str_replace(".","",$array[0]);
	
	$novo = $um.'.'.$array[1];
	
	return $novo;
}


?>


<div class="row projects no-margins">
    <form name="frmProva" id="frmProva">        
        <div class="col-lg-12 animated-panel zoomIn ">  
            <div class="hpanel hviolet">
                <div class="panel-heading">
                    <a href="<?= base_url('108/prova/frmNovaProvaConfiguracao/' . $prova[0]['CD_PROVA'] . '') ?>" class="btn btn-info"><i class="fa fa-dot-circle-o"></i> Voltar</a>
                    <a href="<?= base_url('108/prova_questoes/detalheProva/' . $prova[0]['CD_PROVA'] . '/'.$_GET['disciplina'].'') ?>" class="btn btn-warning modal-detalhes" data-toggle="frmModal"><i class="fa fa-eye"></i> Detalhes</a>    
                    Total de Pontos: <label class="show-total"></label>
                </div>
            </div>

           
        </div>
        <div class="col-lg-3 animated-panel zoomIn ">  
            <div class="hpanel hviolet">
                <div class="panel-body no-padding">
                    <div class="users-list ">
                        <? foreach ($tema as $t) { ?>
                            <div class="chat-user no-padding">
                                <div class="chat-user-name">
                                    <small>
                                        <a data-toggle="frmModal" href="<?= base_url('108/prova_questoes/mdlTemaQuestoes?prova=' . $prova[0]['CD_PROVA'] . '&tema=' . $t['CD_TEMA'] . '&disciplina=' . $disciplina . '&curso=' . $prova[0]['CD_CURSO'] . '&serie=' . $prova[0]['ORDEM_SERIE'] . '') ?>">
                                            <?= $t['DC_TEMA'] ?>
                                        </a>
                                    </small>
                                </div>
                            </div>
                        <? } ?>
                    </div>
                </div>
            </div>
        </div>        

        <div class="col-lg-9 animated-panel zoomIn">
            <?$i = 0; foreach ($listar as $q){ $lista[$i] = $q['codigo']; if($q['codigo'] != $lista[$i-1]){?>
               

                
                <div class="col-lg-6 animated-panel zoomIn" style="animation-delay: 0.1s; width:<?=(($q['tipo'] == 'O')? '49' : '98')?>%">
                    <div class="hpanel <?=(($q['tipo'] == 'O')? 'hgreen' : 'hyellow')?> ">
                        <div class="panel-footer">
                            <span class="btn btn-sm btn-<?=(($q['tipo'] == 'O')? 'success' : 'warning')?>"> Nº <?= $q['codigo'] ?> </span>
                            <select class="btn btn-default" name="avalPosicaoQuestao" style="padding:2px" onchange="AvalProvaQuestaoPosicao(<?= $q['codigo'] ?>, this.value,<?= $q['prova'] ?>)">
                                <?
                                $new = new Prova_lib();
                                $new->disciplina = $q['disciplina'];
                                $new->prova = $q['prova'];
                                $new->tipo = $q['tipo'];
                                $new->selecao = $q['posicao'];
                                echo $new->posicao();
                                ?>
                            </select>
                            <?php 
                        
                            //$result = $this->db->preapre("SELECT valor FROM BD_SICA.AVAL_PROVA_QUESTOES WHERE cd_questao = {$q['codigo']}  AND cd_prova = {$q['prova']}");    
                            //var_dump($result->fetch());                                

                            //$this->get("BD_SICA.AVAL_PROVA_QUESTOES");
                            //$this->where("cd_questao = {$q['codigo']}  AND cd_prova = {$q['prova']}");
                            $filtro = "cd_questao =" . $q['codigo'] ." AND cd_prova = ". $q['prova'].""; 
                            $query = $this->db->query("SELECT valor FROM bd_sica.aval_prova_questoes WHERE ".$filtro."");   
                            $result = $query->result_array();

                            //$query->execute();
                           // $row = $query->fetch();
                            //print_r($result);

                            //echo $result['valor'];
                            ?>
                            <input type="text" class="avalPosicaoNota" id="avalPosicaoNota" name="avalPosicaoNota" value="<?= moeda($result[0]['VALOR']) ?>" data-questao="<?= $q['codigo']?>" data-valor="<?= moeda($result[0]['VALOR']) ?>" data-prova="<?= $q['prova'] ?>">
                            <button class="btn btn-sm btn-danger2 pull-right" type="button" onclick="AvalProvaQuestaoExcluir(<?= $q['prova'] ?>,<?= $q['codigo'] ?>)"><i class="fa fa-trash"></i> Excluir</button>
                        </div>
                        <div class="modal-footer no-margins">
                            <div style="font-size:10px; text-align: left">
                                Cadastro: <?=$q['usuario'].' <br /> Em: '.$q['dia']?> 
                                <br/>Nível: <?=$q['nivel']?>
                                <br/>Tema: <?=strip_tags( $q['conteudo'][0]['DC_TEMA'] )?>
                                <br/>Conteúdo: <?=strip_tags( $q['conteudo'][0]['DC_CONTEUDO'] )?>
                            </div>
                        </div>
                        <div class="panel-body" style="text-align: justify; height:200px; overflow: scroll; word-wrap: break-word; overflow-x: hidden;">
                            <small contenteditable="true" spellcheck="true">
                                <?= $new->formata_texto_com_richtext_alternativa($q['questao']) ?>
                            </small>
                        </div>
                        <?
                        if ($q['tipo'] == 'O') {
                            echo '<div class="panel-footer" contenteditable="true" spellcheck="true"> A) ' . $new->formata_texto_com_richtext_alternativa($q['opcao'][0]['DC_OPCAO']) . '</div>';
                            echo '<div class="panel-footer" contenteditable="true" spellcheck="true"> B) ' . $new->formata_texto_com_richtext_alternativa($q['opcao'][1]['DC_OPCAO']) . '</div>';
                            echo '<div class="panel-footer" contenteditable="true" spellcheck="true"> C) ' . $new->formata_texto_com_richtext_alternativa($q['opcao'][2]['DC_OPCAO']) . '</div>';
                            echo '<div class="panel-footer" contenteditable="true" spellcheck="true"> D) ' . $new->formata_texto_com_richtext_alternativa($q['opcao'][3]['DC_OPCAO']) . '</div>';
                            // echo '<div class="panel-footer" contenteditable="true" spellcheck="true"> E) ' . $new->formata_texto_com_richtext_alternativa($q['opcao'][4]['DC_OPCAO']) . '</div>';
                        }
                        ?>
                    </div>
                </div>
            <? $i++;}} ?>

            <?php //print_r($cd); ?>
        </div>

        <input type="hidden" name="txtOperacao" value="U" />
        <input type="hidden" name="avalEstrutura"  value="<?= $prova[0]['CD_ESTRUTURA'] ?>" />
        <input type="hidden" name="avalNumNota"  value="<?= $prova[0]['NUM_NOTA'] ?>" />
    </form>
</div>

<div style="padding-bottom: 150px"></div>

<? $this->load->view('home/footer'); ?>
