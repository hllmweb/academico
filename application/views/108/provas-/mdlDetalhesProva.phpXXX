<div class="modal-dialog no-padding no-margins" style="width:100%">
    <style type='text/css'>

.isotope-item {
    z-index: 2;
}
.isotope-hidden.isotope-item {
    pointer-events: none;
    z-index: 1;
}
.isotope,
.isotope .isotope-item {
  /* change duration value to whatever you like */

    -webkit-transition-duration: 0.8s;
    -moz-transition-duration: 0.8s;
    transition-duration: 0.8s;
}
.isotope {
    -webkit-transition-property: height, width;
    -moz-transition-property: height, width;
    transition-property: height, width;
}
.isotope .isotope-item {
    -webkit-transition-property: -webkit-transform, opacity;
    -moz-transition-property: -moz-transform, opacity;
    transition-property: transform, opacity;
}
#print_detalhe{

  font-family: Arial;
}


  </style>
  <meta charset="utf-8">
  <script type='text/javascript' src="<?=base_url('assets/js/jquery.isotope.min.js')?>"></script>
  

  <div id="print_detalhe"> 
    <div class="modal-content modal_detalhe_prova">
        <div class="color-line"></div>
        <div class="modal-body no-padding">
            <div class="panel-footer">
                <h3>Detalhes</h3>
                <hr/>
             
              <?php $i = 0;  foreach ($listar as $q) { $lista[$i] = $q['codigo']; if($q['codigo'] != $lista[$i-1]){ ?>
  
              <?php 

                 
                                $new = new Prova_lib();
                                $new->disciplina = $q['disciplina'];
                                $new->prova = $q['prova'];
                                $new->tipo = $q['tipo'];
                                $new->selecao = $q['posicao'];
                               
                                
              ?>

              <div style="font-size:12px; text-align: left">
                Prova de: <?=$q['nomeDisciplina'];  ?>
            
                <br/>Nível: <?=$q['nivel']?>
                <br/>Tema: <?=strip_tags( $q['conteudo'][0]['DC_TEMA'] )?>
                <br/>Conteúdo: <?=strip_tags( $q['conteudo'][0]['DC_CONTEUDO'] )?>
                <br/>Questão :  <?= $new->formata_texto_com_richtext_alternativa(substr($q['questao'],0,100))."...."; ?>
               </div>
               <br>
               <div class="hpanel hgreen"></div>
               <?php $i++; }} ?>

              
            </div>
            
            <div class="row-table" id="grid">
            
               <div class="animated-panel zoomIn element-item transition " data-category="transition">
               <div class="hpanel">
            </div>
            
            <div class="modal-footer">
            <a href="#" id="id_imprimir" class="btn btn-success">Imprimir</a>

           <a onClick="window.location.reload()" class="btn btn-danger btn-sm pull-right" >

            <i class="fa fa-times-circle-o"></i> 
            Fechar</a>
            </div>
        </div>
    </div>
  
 </div>
 </div>
 <?php 
$currentURL = current_url(); //http://myhost/main

$params   = $_SERVER['QUERY_STRING']; //my_id=1,3

$fullURL = $currentURL . '?' . $params; 


  ?>
 <script type="text/javascript">
   

 $('#id_imprimir').click(function(){   
   window.open('<?=$fullURL; 
 ?>', '_blank');
});

 </script>