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
  </style>
  <script type='text/javascript' src="<?=base_url('assets/js/jquery.isotope.min.js')?>"></script>
  

   
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-body no-padding">
            <div class="panel-footer">
                <h3>Questão:</h3>
                <hr/>
             
              <?php // foreach ($listar as $q) { ?>

              <?php 

              	 
                        /*        $new = new Prova_lib();
                                $new->disciplina = $q['disciplina'];
                                $new->prova = $q['prova'];
                                $new->tipo = $q['tipo'];
                                $new->selecao = $q['posicao'];*/
                               
                                
              ?>

              <div style="font-size:12px; text-align: left">
              	Prova de: <?=$q['nomeDisciplina'];  ?>
                <br />Cadastro: <?=$q['usuario'].' <br /> Em: '.$q['dia']?> 
                <br/>Nível: <?=$q['nivel']?>
                <br/>Tema: <?=strip_tags( $q['conteudo'][0]['DC_TEMA'] )?>
                <br/>Conteúdo: <?=strip_tags( $q['conteudo'][0]['DC_CONTEUDO'] )?>
                <br/>Questão :  <?= $new->formata_texto_com_richtext_alternativa(substr($q['questao'],0,100))."...."; ?>
               </div>
               <br>
               <div class="hpanel hgreen"></div>
               <?php } ?>

              
            </div>
            
            <div class="row-table" id="grid">
            
               <div class="animated-panel zoomIn element-item transition " data-category="transition">
               <div class="hpanel">
            </div>
            
            <div class="modal-footer">
  				<a onClick="window.location.reload()" class="btn btn-danger btn-sm pull-right" ><i class="fa fa-times-circle-o"></i> Fechar</a>
            </div>
        </div>
    </div>
  
 </div>