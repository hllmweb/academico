<div class="modal-dialog" id="frmNovaSolicitacao">
    <div class="modal-content">
        <div class="color-line"></div>

        <div class="modal-footer">
            <h4 class="modal-title">Relatório de Aulas</h4>
        </div>

        <form target="_black" action="<?= base_url('' . $this->session->userdata('SGP_SISTEMA') . '/monitor/impRelatorio'); ?>" method="POST">                
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-xs-3">
                        <label>Período:</label>
                        <select name="Periodo" id="Periodo" class="form-control input-sm">
                            <? foreach ($periodo as $p) { ?>
                                <option <?= $this->session->userdata('SGP_PERIODO') == $p['DC_PERIODO'] ? 'selected' : "" ?> value="<?= $p['DC_PERIODO'] ?>"><?= $p['DC_PERIODO'] ?></option>
                            <? } ?>
                        </select>
                    </div>

                    <div class="form-group col-xs-9">
                        <label>Professor:</label>
                        <select name="Professor" id="Professor" class="form-control input-sm">
                            <option></option>
                            <? foreach ($professor as $p) { ?>
                                <option value="<?= $p['CD_PROFESSOR'] ?>"><?= $p['CD_PROFESSOR'] . ' - ' . $p['NM_PROFESSOR'] ?></option>
                            <? } ?>
                        </select>
                    </div>

                    <div class="form-group col-xs-6">
                        <label>Tipo Turma:</label>
                        <select required="required" name="Tipo" id="Tipo" class="form-control input-sm">
                            <option></option>
                            <? foreach ($tipo as $t) { ?>
                                <option value="<?= $t['TIPO'] ?>"><?= strtoupper($t['TIPO'] . ' - ' . $t['DC_TIPO']) ?></option>
                            <? } ?>
                        </select>
                    </div>

                    <div class="form-group col-xs-6" id="datepicker" style="padding-left:0px">
                        <label>Data:</label>
                        <div class="input-daterange input-group" id="datepicker">
                            <input required="required" type="text" class="input-sm form-control" name="Data" id="Data" />
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>                            
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <input type="checkbox" name="Pendente" id="pendente" value="S"> Exibir apenas aulas com pendência 
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger2 pull-left" data-dismiss="modal">
                    <i class="fa fa-times-circle"></i> Fechar
                </button>
                <button type="submit" class="btn btn-info btnSubmit" >
                    <i class="fa fa-search-minus"></i> Gerar Relatório
                </button>
            </div>
        </form>

        <script type="text/javascript">
            var data = new Date();
            var dataInicio;
            var dataFim;

            if (data.getDate() >= 21) {
                dataInicio = new Date(data.getFullYear(), data.getMonth(), 21);

                if (data.getMonth() === 11) {
                    dataFim = new Date(data.getFullYear() + 1, 0, 20);
                } else {
                    dataFim = new Date(data.getFullYear(), data.getMonth() + 1, 20);
                }
            } else {
                dataFim = new Date(data.getFullYear(), data.getMonth(), 20);

                if (data.getMonth() === 1) {
                    dataInicio = new Date(data.getFullYear() - 1, 11, 21);
                } else {
                    dataInicio = new Date(data.getFullYear(), data.getMonth() - 1, 21);
                }
            }

            $("#Data").daterangepicker({
                startDate: dataInicio,
                endDate: dataFim,
                locale: {
                    format: "DD/MM/YYYY",
                    applyLabel: "Ok",
                    cancelLabel: "Cancelar"
                }
            });

            $("#Professor").select2();
        </script>
    </div>
</div>
