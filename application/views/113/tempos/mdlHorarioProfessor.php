<div class="modal-dialog">
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">
            <h5 class="modal-title pull-left">
                Selecione o Professor
            </h5>
            <i class="fa fa-4x fa-graduation-cap"></i>
        </div>
        <form id="frmProfessorHorario">
            <div class="modal-body row">
                <div class="row">
                    <div class="col-xs-12">
                        <label>CÓDIGO</label>
                        <select name="Professor" class="selectpicker form-control">
                            <option></option>
                            <? foreach($professor as $p){ ?>
                                <option value="<?=$p->CD_PROFESSOR?>" >
                                    <?=$p->CD_PROFESSOR.' - '.$p->NM_PROFESSOR?>
                                </option>
                            <? } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                    <i class="fa fa-times"></i> Fechar
                </button>
                <button id='btnEnviar' type="submit" class="btn btn-primary">
                    <i class="fa fa-list-ol"></i>
                    VER HORARIOS
                </button>
            </div>
        </form>
    </div>
    <script type="text/javascript">
        $(".selectpicker").select2();
        $("#btnEnviar").hide();
        $(".selectpicker").on("change", function (e) {
            $("#btnEnviar").show();
        });
        $("#frmProfessorHorario").on("submit", function(){
            var data = $("#frmProfessorHorario").serializeArray();
                data = JSON.stringify(data);
            var objeto = btoa( data );
            var url = '<?=base_url($this->session->userdata('SGP_SISTEMA') . '/tempos/frmHorarioProfessor?p=')?>' + objeto + '';
            window.location.href = url;
            return false;
        });
        
    </script>
</div>
