<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">
            <h5 class="modal-title">Lista de Programas</h5>
            <small></small>
        </div>
        <div class="modal-body" >
            
            <? 
                $sistema = array();
                foreach ($listar as $row) { 
                  //  $sistema[] = $row->DC_SISTEMA;
                }
                //$sistema = array_keys(array_flip($sistema));
            ?>
            <? foreach ($sistema as $sis) { ?>
            <table id="tbl" class="table table-hover table-striped" cellpadding="0" cellspacing="5" width="100%">
                <thead>
                    <tr class="panel-footer">
                        <td colspan="3" class="panel-footer">
                            SISTEMA { <strong><?=$sis?></strong> }
                        </td>
                    </tr>
                    <tr>
                        <th>CÓDIGO</th>
                        <th>PROGRAMA</th>
                        <th>FORMULÁRIO</th>
                    </tr>
                </thead>
                <tbody>
                    <? foreach ($listar as $row) { 
                        if($sis == $row->DC_SISTEMA){ ?>
                        <tr>
                            <td><?= $row->CD_PROGRAMA?></td>
                            <td width="70%"><?= $row->NM_PROGRAMA?></td>
                            <td width="25%"><?= $row->FORMULARIO ?></td>
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
        </div>
    </div>
</div>