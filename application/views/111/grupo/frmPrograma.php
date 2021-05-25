<div class="modal-dialog modal-lg">
    <script src="<?=base_url('assets/js/bootstrap-select.min.js')?>"></script>
    <link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/bootstrap-select.css')?>">
    <script type="text/javascript">
        function inserir() {
            $("#mdlBodyPrograma").html('Atualizando datagrid');
            $.post("<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/grupo/frmManterPrograma')?>", {
                Operacao: 'I',
                  Perfil: $('input[name=FTPerfil]').val(),
                 Sistema: $('select[name=FTSistema]').val(),
                Programa: $('select[name=FTPrograma]').val(),
                    Acao: $('select[id=FTAcao]').val(),
            },
            function(valor) {
                $("#mdlBodyPrograma").html(valor);
            });
        };
        function deletar(perfil,programa) {
            $("#mdlBodyPrograma").html('Atualizando datagrid');
            $.post("<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/grupo/frmManterPrograma')?>", {
                Operacao: 'D',
                  Codigo: perfil,
                Programa: programa,
            },
            function(valor) {
                $("#mdlBodyPrograma").html(valor);
            });
        };
    </script>
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">
            <h5 class="modal-title"><?=$filtrar->DC_GRUPO?></h5>
            <small>Lista de Programas</small>
        </div>
        <div class="modal-footer">
            <div class="row">
                <div class="col-sm-3 text-left">
                    <input type="hidden" name="FTPerfil" id="FTPerfil" value="<?=$filtrar->CD_GRUPO?>">
                    <label>Sistema</label>
                    <select name="FTSistema" id="FTSistema" class="form-control">
                        <option></option>
                        <? foreach($sistema as $s){  ?>
                        <option value="<?=$s->SISTEMA?>"><?=$s->DC_SISTEMA?></option>
                        <? } ?>
                    </select>
                </div>
                <div class="col-sm-4 text-left" style="padding-left: 0px">
                    <label>Programa</label>
                    <select name="FTPrograma" id="FTPrograma" class="form-control" data-live-search="true">
                        <option></option>
                    </select>
                </div>
                <div class="col-sm-3 text-left" style="padding-left: 0px">
                    <label>Ação</label>
                    <div class="form-group">
                        <select name="FTAcao[]" id="FTAcao" class="selectpicker" multiple title="Ação" data-selected-text-format="static">
                            <option value="I">Incluir</option>
                            <option value="A">Alterar</option>
                            <option value="E">Excluir</option>
                            <option value="I">Imprimir</option>
                            <option value="E1">Especial 1</option>
                            <option value="E2">Especial 2</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-2 text-left">
                    <button onclick="javascript:inserir();" type="submit" class="btn btn-primary pull-right" style="margin-top:20px">
                        Adicionar
                    </button>
                </div>
            </div>
        </div>
        <div class="modal-body no-margins no-padding" style="overflow: auto; height: 250px" id="mdlBodyPrograma">
            <? 
                $sistema = array();
                foreach ($listar as $row) { 
                    $sistema[] = $row->DC_SISTEMA;
                }
                $sistema = array_keys(array_flip($sistema));
            ?>
            <? foreach ($sistema as $sis) { ?>
            <table class="table table-hover table-striped" style="margin:5px; width:98%">
                <thead>
                    <tr class="panel-footer">
                        <td colspan="4" class="panel-footer">
                            SISTEMA { <strong><?=$sis?></strong> }
                        </td>
                    </tr>
                    <tr>
                        <th>CÓDIGO</th>
                        <th>PROGRAMA</th>
                        <th>FORMULÁRIO</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <? foreach ($listar as $row) { 
                        if($sis == $row->DC_SISTEMA){ ?>
                        <tr>
                            <td><?= $row->CD_PROGRAMA?></td>
                            <td width="70%"><?= $row->NM_PROGRAMA?></td>
                            <td width="25%"><?= $row->FORMULARIO ?></td>
                            <td width="5%">
                                <button type="button" onclick="deletar(<?=$row->CD_GRUPO?>,<?=$row->CD_PROGRAMA?>)" class="btn btn-danger btn-xs">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <? } } ?>
                </tbody>                
            </table>
            <? } ?>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default btn-outline pull-left" data-dismiss="modal">
                <i class="fa fa-close"></i> FECHAR
            </button>
            <a target="_blank" href="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/grupo/pntPrograma/'.$filtrar->CD_GRUPO.'')?>" class="btn btn-primary2 pull-right">
                <i class="fa fa-print"></i>
                Imprimir
            </a>
        </div>
    </div>
    
   <script>

    $('.selectpicker').selectpicker();
    $('#FTPrograma').select();
    
    $(function() {
        $("#FTSistema").select2();
        $("#FTPrograma").select2();
    });
    

    $("select[name=FTSistema]").change(function() {
        $("select[name=FTPrograma]").html('<option>Carregando</option>');
        $.post("<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/programa/comboPrograma')?>", {
            sistema: $('select[name=FTSistema]').val(),
        },
        function(valor) {
            $("select[name=FTPrograma]").html(valor);
            $("#FTPrograma").select2();
        });
    });
   </script> 
</div>