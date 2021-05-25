<script src="<?= base_url('assets/js/daterangepicker.js') ?>"></script>

<div class="modal-dialog">
    <div class="color-line"></div>

    <div class="modal-content">
        <form id="formulario-relatorio" action="<?= site_url("103/relatorio/abonoAula") ?>" target="_blank" method="get">
            <div class="modal-header" style="padding: 15px">
                <h5 class="modal-title text-right"><?= $titulo ?></h5>
            </div>

            <div class="modal-body">             
                <div class="row">
                    <div class="form-group col-xs-6">
                        <label>DATA PENDÊNCIA</label>
                        <div class="input-group">
                            <input class="form-control input-sm multiselect" type="text" id="data" name="data" value="">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>                    
                        </div>                        
                    </div>                                                            


                    <div class="form-group col-xs-6">
                        <label>PROFESSOR</label>
                        <select name="professor" class="form-control input-sm multiselect" id="professor">
                            <option value="">TODOS</option>
                            <?php foreach ($professores as $row) : ?>
                                <option value="<?= $row->CD_PROFESSOR ?>"><?= $row->NM_PROFESSOR ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>                    

                    <div class="form-group col-xs-6">
                        <label>MOTIVO</label>
                        <select name="motivo" class="form-control multiselect" id="motivo">
                            <option value="">TODOS</option>
                            <?php foreach ($motivos as $row) : ?>
                                <option value="<?= $row->CD_MOTIVO ?>"><?= $row->NM_MOTIVO ?></option>
                            <? endforeach; ?>
                        </select>
                    </div>                    

                    <div class="form-group col-xs-6">
                        <label>SITUAÇÃO</label>
                        <select name="situacao" class="form-control multiselect" id="situacao">
                            <option value="">TODAS</option>
                            <?php foreach ($situacoes as $key => $value) : ?>
                                <option value="<?= $key ?>"><?= $value ?></option>
                            <? endforeach; ?>
                        </select>
                    </div>                    
                </div>                
            </div>

            <div class="modal-footer">
                <div id="resposta">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                    <i class="fa fa-times"></i> Fechar
                </button>                

                <button type="submit" class="btn btn-success pull-right">
                    <i class="fa fa-check"></i> Gerar
                </button>                
            </div>
        </form>        
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#professor").select2();
            $("#motivo").select2();
            $("#situacao").select2();
        });

        $("#data").daterangepicker({
            startDate: "<?= $dataInicio ?>",
            endDate: "<?= $dataFim ?>",
            locale: {
                format: "DD/MM/YYYY",
                applyLabel: "Ok",
                cancelLabel: "Cancelar"
            }
        });
    </script>
</div>