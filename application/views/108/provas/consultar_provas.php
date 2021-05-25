<? $this->load->view('home/header'); ?>
<div class="content animate-panel">
    <div class="row projects">
        <div class="hpanel hgreen">
            <div class="panel-footer">
                <div class="row">

	                <div class="col-sm-5">
	                    Num. Prova:
	                    <div class="input-group btn-group">   

	                    	<div class="input-group date" id="avalDataProva">
                                <input value="00/00/0000" name="avalDataProva" type="text" class="form-control">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            </div>


	                        <!-- <input placeholder="00/00/0000" class="form-control input-group-addon" type="date" name="avalNumProva" id="avalNumProva" /> -->
	                        <span class="input-group-btn">
	                            <button onclick="txtNumProvaFiltrar()" type="button" id="" class="btn btn-labeled btn-info">
	                                <span class="btn-label"><i class="fa fa-search"></i></span>
	                                Filtrar
	                            </button>
	                        </span>
	                        <span class="input-group-btn">
	                            <button type="button" class="btn-toggle btn btn-labeled btn-warning2" data-element="#BuscaAvancada">
	                                <span class="btn-label"><i class="fa fa-gear"></i></span>
	                                Busca Avançada
	                            </button>
	                        </span>
	                    </div>
	                </div>




                </div>
            </div>
        </div>
    </div>
</div>
<?= $titulo; ?>

<? $this->load->view('home/footer'); ?>