<? $this->load->view('home/header'); ?>
<script src="<?= base_url('assets/js/daterangepicker.js') ?>"></script>

<script>
    function atualiza() {
        $("#tblFiltro").html('<?= LOAD ?>');
        $.post("<?= base_url('' . $this->session->userdata('SGP_SISTEMA') . '/monitor/grdAula') ?>", {
            data: $("#resData").val(),
            curso: $("#resCurso").val(),
            serie: $("#resSerie").val(),
            professor: $("#resProfessor").val(),
            pendente: $("#resPendente:checked").val()
        },
        function (valor) {
            $("#tblFiltro").html(valor);
        });
        setTimeout('atualiza()', 60000000);
    }
</script>

<div class="hpanel hgreen">
    <div class="panel-footer">
        <div class="row">
            <form action="<?= site_url($this->session->userdata('SGP_SISTEMA') . '/relatorio/aula_diaria') ?>" target="_blank" method="get">
                <div class="col-xs-2">
                    <label>Curso:</label>
                    <select name="curso" id="resCurso" class="form-control" required="">
                        <option></option>
                        <? foreach ($curso as $c) { ?>
                            <option value="<?= $c['CD_CURSO'] ?>"><?= $c['NM_CURSO_RED'] ?></option>
                        <? } ?>
                    </select>
                </div>

                <div class="col-sm-2">
                    <label>Série:</label>
                    <select name="serie" id="resSerie" class="form-control">
                        <option value="">TODAS</option>
                    </select>
                </div>                

                <div class="col-xs-2">
                    <label>Professor:</label>                                        
                    <select name="professor" id="resProfessor" class="form-control" style="display: table; table-layout: fixed">
                        <option value="">TODOS</option>                            
                    </select>                        
                </div>

                <div class="col-xs-3">
                    <label>Data:</label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>

                        <input required name="data" type="text" id="resData" class="form-control" />

                        <div class="input-group-btn">
                            <button onclick="atualiza()" type="button" id="" class="btn btn-labeled btn-warning">
                                <span class="btn-label"><i class="fa fa-search"></i></span>
                                Filtrar
                            </button>                            
                        </div>
                    </div>
                </div>

                <div class="col-xs-2">
                    <br>
                    <input type="checkbox" id="resPendente" name="pendente" value="S"> Exibir apenas aulas com pendência
                </div>

                <div class="col-xs-1 pull-right">
                    <br>
                    <button type="submit" class="btn btn-labeled btn-primary2 pull-right">
                        <span class="btn-label">
                            <i class="fa fa-file-pdf-o"></i>
                        </span>
                        Gerar PDF
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="panel-body no-padding" id="tblFiltro">
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        atualiza();
        $("#resProfessor").select2();

        $("#resData").daterangepicker({
            startDate: new Date(),
            endDate: new Date(),
            locale: {
                format: "DD/MM/YYYY",
                applyLabel: "Ok",
                cancelLabel: "Cancelar"
            }
        });
    });

    $("select[id=resCurso]").change(function () {
        $("#resSerie").html('<option>Carregando</option>');
        $("#resProfessor").html("<option>Carregando</option>");
        $("#resProfessor").select2("val", "");

        $.post("<?= base_url('comum/combobox/serie') ?>", {
            curso: $(this).val()
        },
        function (valor) {
            $("select[id=resSerie]").html(valor);
            $("#resSerie").find("option[value='']").text("TODAS");

            $("#resProfessor").html("<option value=''>TODOS</option>");
            $("#resProfessor").select2("val", "");
        });
    });

    $("select[id=resSerie]").change(function () {
        $("#resProfessor").html("");
        $("#resProfessor").select2("val", "");
        $.post("<?= base_url('comum/combobox/curso_serie_professor') ?>", {
            curso: $("select[id=resCurso]").val(),
            serie: $("select[id=resSerie]").val()
        },
        function (valor) {
            $("#resProfessor").html(valor);
            $("#resProfessor").find("option[value='']").text("TODOS");
            $("#resProfessor").select2("val", "");
        });
    });
</script>

<? $this->load->view('home/footer'); ?>