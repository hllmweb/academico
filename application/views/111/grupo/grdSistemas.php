<table id="tbl" class="table table-hover table-striped" cellpadding="0" cellspacing="5" width="100%">
    <thead>
        <tr>
            <th>CÓDIGO</th>
            <th>SISTEMA</th>
            <th>TIPO</th>
            <th>TEMA</th>
            <th><style>img { height: 20px; width:auto}</style></th>
        </tr>
    </thead>
    <tbody>
        <? foreach ($listar as $row) { ?>
            <tr>

                <td width="50px"><?= $row['SISTEMA'] ?></td>
                <td><?= $row['DC_SISTEMA'] ?></td>
                <td><?= substr((strip_tags($row['DC_QUESTAO'])), 0, 100)//$row['NM_CURSO'].' - '.$row['ORDEM_SERIE'].'º Série - '.$row['NM_DISCIPLINA'] ?></td>
                <td><?= $row['UTILIZADO'] ?></td>
                <td>
                    <a id="btnTemaView" class="btn btn-primary btn-xs" href="<?= base_url('108/questoes/mdlQuestaoView/' . $row['CD_QUESTAO'] . '') ?>" data-toggle="frmModalUpdate">
                        <i class="fa fa-eye"></i>
                    </a>
                    |
                    <a class="btn btn-info btn-xs" href="<?= base_url('108/questoes/frmQuestao/E-' . $row['CD_QUESTAO'] . '') ?>">
                        <i class="fa fa-edit"></i>
                    </a>
                    <?  
                      if ($row['UTILIZADO'] > 0) { ?>
                    |
                        <a id="btnTemaView" class="btn btn-success btn-xs" href="<?= base_url('108/questoes/mdlQuestaoProvas/' . $row['CD_QUESTAO'] . '') ?>" data-toggle="frmModal">
                            <i class="fa fa-check"></i>
                        </a>
                    <? }else{ ?>
                     |
                        <a id="btnTemaView" class="btn btn-danger btn-xs" href="<?= base_url('108/questoes/mdlQuestaoDelete/' . $row['CD_QUESTAO'] . '') ?>" data-toggle="frmModalDanger">
                            <i class="fa fa-trash"></i>
                        </a>
                    <? }?>
                </td>
            </tr>
        <? } ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" class="panel-footer">
            </td>
        </tr>
    </tfoot>
</table>
<script src="<?=base_url('assets/js/modal.js')?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
        // Datatables
        $('#tbl').DataTable();
    });
</script>