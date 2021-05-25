<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">
            <h5 class="modal-title">Lista de Programas</h5>
            <small><?=$prova[0]['TITULO']?></small>
        </div>
        <div class="modal-body" >
            <table id="tbl" class="table table-hover table-striped" cellpadding="0" cellspacing="5" width="100%">
                <thead>
                    <tr>
                        <th>CÓDIGO</th>
                        <th>SISTEMA</th>
                        <th>FORMULÁRIO</th>
                    </tr>
                </thead>
                <tbody>
                    <? foreach ($listar as $row) { ?>
                        <tr>
                            <td><?= $row->CD_PROGRAMA?></td>
                            <td width="70%"><?= $row->NM_PROGRAMA?></td>
                            <td width="25%"><?= $row->FORMULARIO ?></td>
                        </tr>
                    <? } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="panel-footer">
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default btn-outline pull-left" data-dismiss="modal">
                <i class="fa fa-close"></i> FECHAR
            </button>
        </div>
    </div>
</div>