<? $this->load->view('home/header'); ?>
<script type='text/javascript'>//<![CDATA[
    $(window).load(function () {
        $(function () {
            $(".btn-toggle").click(function (e) {
                e.preventDefault();
                el = $(this).data('element');
                $(el).toggle();
            });
        });
    });//]]> 

    function txtFiltrar(paginado) {
        var pagina = 0;
        if (paginado && $("#tblGrid").find("tr").length > 0) {
            pagina = $("#tblGrid").DataTable().page();
        }
        
        $("#tblFiltro").html('<?= LOAD ?>');        

        $.post("<?= base_url('' . $this->session->userdata('SGP_SISTEMA') . '/soletrando/grdRegistro') ?>", {
            periodo: $("#FTPeriodo").val(),
            bimestre: $("#FTBimestre").val(),
            curso: $("#FTCurso").val(),
            serie: $("#FTSerie").val()
        },
        function (valor) {            
            $("#tblFiltro").html(valor);
            $("#tblGrid").DataTable().page(pagina).draw(false);
        });
    }
</script>

<div class="content animate-panel">
    <div class="row projects">
        <div class="hpanel hgreen">
            <div class="panel-footer">
                <div class="row">
                    <div class="col-xs-2">
                        <button href="<?= base_url('' . $this->session->userdata('SGP_SISTEMA') . '/soletrando/mdlRegistro/I') ?>" data-toggle="frmModal" type="button" id="" class="btn btn-labeled btn-primary2">
                            <span class="btn-label"><i class="fa fa-plus"></i></span>
                            Nova Palavra
                        </button>
                    </div>
                    <div class="form-inline col-xs-10 text-right">
                        <div class="form-group">
                            <label>PERÍODO</label><br>
                            <select name="FTPeriodo" id="FTPeriodo" class="form-control m-b" style="width:150px">
                                <? foreach ($periodo as $per) { ?>
                                    <option value="<?= $per['DC_PERIODO'] ?>"><?= $per['DC_PERIODO'] ?></option>
                                <? } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>CURSO</label><br>
                            <select name="FTCurso" id="FTCurso" class="form-control m-b" style="width:150px">
                                <option value=""></option>
                                <? foreach ($curso as $row) { ?>
                                    <option value="<?= $row['CD_CURSO'] ?>"><?= $row['NM_CURSO_RED'] ?></option>
                                <? } ?>
                            </select>
                        </div> 
                        <div class="form-group">
                            <label>SÉRIE</label><br>
                            <select name="FTSerie" id="FTSerie" class="form-control m-b" style="width:120px">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>BIMESTRE</label><br>
                            <select name="FTBimestre" id="FTBimestre" class="form-control m-b" style="width:120px">
                                <option value=""></option>
                                <option value="1">1º BIMESTRE</option>
                                <option value="2">2º BIMESTRE</option>
                                <option value="3">3º BIMESTRE</option>
                                <option value="4">4º BIMESTRE</option>
                            </select>
                        </div> 
                        <div class="input-group">
                            <span class="input-group-btn">
                                <button onclick="txtFiltrar()" type="button" id="" class="btn btn-labeled btn-info">
                                    <span class="btn-label"><i class="fa fa-search"></i></span>
                                    Filtrar
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body" id="tblFiltro">
                <small>Faça primeiro o filtro</small>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    $("select[id=FTCurso]").change(function () {
        $("select[id=FTSerie]").html('<option>Carregando</option>');
        $.post("<?= base_url('/comum/combobox/serie') ?>", {
            curso: $(this).val()
        },
        function (valor) {
            $("select[id=FTSerie]").html(valor);
        });
    });
</script>
<? $this->load->view('home/footer'); ?>