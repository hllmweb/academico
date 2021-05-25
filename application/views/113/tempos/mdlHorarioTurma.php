<div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">
            <h5 class="modal-title pull-left">
                Horário
            </h5>
            <i class="fa fa-4x fa-graduation-cap"></i>
        </div>
        <form id="frmTurmaHorario">
            <div class="modal-body row">
                <div class="row">
                    <div class="col-xs-12">
                        <label>Selecione a Turma</label>
                        <select name="Turma" class="selectpicker form-control">
                            <option></option>
                            <? foreach($lista as $p){ print_r($p);?>
                                <option value="<?=$p->CD_TURMA?>" >
                                    <?=$p->CD_TURMA?>
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
        $("#frmTurmaHorario").on("submit", function(){
            var data = $("#frmTurmaHorario").serializeArray();
                data = JSON.stringify(data);
            var objeto = btoa( data );
            var url = '<?=base_url($this->session->userdata('SGP_SISTEMA') . '/tempos/frmHorarioTurma?p=')?>' + objeto + '';
            window.location.href = url;
            return false;
        });
        
    </script>
</div>
