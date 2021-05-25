<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">
            <h5 class="modal-title">Grupo(s) de Dependência</h5>
            <small>PROGRAMA: <?=$filtro->NM_PROGRAMA?></small>
        </div>
        <div class="modal-body no-margins">
            <table class="table table-hover table-striped table-bordered no-margins no-padding">
                <thead>
                    <tr>
                        <th>CÓDIGO</th>
                        <th>GRUPO</th>
                        <th>USUÁRIOS</th>
                    </tr>
                </thead>
                <tbody>
                    <? foreach ($listar as $row) { ?>
                        <tr>
                            <td><?= $row->CD_GRUPO?></td>
                            <td width="90%"><?= $row->DC_GRUPO?></td>
                            <td class="text-center"><?= $row->USUARIOS?></td>
                        </tr>
                    <? } ?>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default btn-outline pull-left" data-dismiss="modal">
                <i class="fa fa-close"></i> FECHAR
            </button>
        </div>
    </div>
</div>