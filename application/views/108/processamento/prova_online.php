<? $this->load->view('home/header'); ?>

<script type='text/javascript'>//<![CDATA[
$(window).load(function(){
$(function(){
    $(".btn-toggle").click(function(e){
        e.preventDefault();
        el = $(this).data('element');
        $(el).toggle();
    });
    $("#formSearch").on('submit', function(e) {
        e.preventDefault();
        txtNumProvaFiltrar();
    });
});
});//]]>

    function txtNumProvaFiltrar() {
        $("#tblFiltro").html('<div class="text-center"><img src="http://server01.seculomanaus.com.br/academico/assets/images/loading-bars.svg" width="64" height="64" /></div>');
        $.post("<?=  base_url('/108/processamento/grdProvaReprocessar') ?>", {
            filtro: 2,
            numProva: $("#avalNumProva").val(),
        },
        function(valor) {
            $("#tblFiltro").html(valor);
        });
    };



    </script>



<div class="content animate-panel">
    <div class="row projects">
        <div class="hpanel hgreen">
            <div class="panel-footer">
                <form role="form" class="form-inline" id="formSearch">
                  <div class="row">
                    <div class="col-sm-12 col-md-6 col-md-offset-3 text-center">
                        <div class="form-group"><br>
                             <label class="form-control m-b" for="avalNumProva">Código da Prova</label>
                        </div>
                         <div class="input-group">
                           <input class="form-control m-b" type="number" id="avalNumProva" name="avalNumProva" value="">
                             <span class="input-group-btn">
                                 <button onclick="txtNumProvaFiltrar()" type="button" id="" class="btn btn-labeled btn-info">
                                     <span class="btn-label"><i class="fa fa-search"></i></span>
                                     Filtrar
                                 </button>
                             </span>
                         </div>
                    </div>
                  </div>



                </form>
            </div>
            <div class="panel-body" id="tblFiltro">
                <small>Faça primeiro o filtro</small>
            </div>
        </div>
    </div>
</div>


<? $this->load->view('home/footer'); ?>
