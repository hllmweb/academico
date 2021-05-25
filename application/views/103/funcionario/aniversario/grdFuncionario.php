<table class="display table table-striped table-hover" id="tblGrid">
    <thead>
        <tr class="panel-footer">
            <td align="center"><strong>ANIVERSÁRIO</strong></td>
            <td><strong>FUNCIONÁRIO</strong></td>
            <td><strong>FUNÇÃO</strong></td>
            <td><strong>TELEFONE</strong></td>
            <td><strong>EMAIL</strong></td>
        </tr>
    </thead>
    <tbody>
        <?
        foreach ($listar as $row) {
            ?>
            <tr>
                <td width="20px"><?= $row['DT_ANIVERSARIO'] ?></td>
                <td><?= $row['NM_PESSOA'] ?></td>
                <td><?= $row['NM_FUNCAO'] ?></td>
                <td><?= $row['TELEFONE'] ?></td>
                <td><?= $row['EMAIL'] ?></td>                
            </tr>
        <? }  ?>
    </tbody>
    <tfoot>
        <tr colspan="3">
            <td>
                <a target="_blank" class="btn btn-labeled btn-info" href="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/funcionario/impGrdFuncionario/'.$mes.'')?>">
                    <span class="btn-label"><i class="fa fa-print"></i></span>
                    Imprimir
                </a>
            </td>
        </tr>
    </tfoot>
</table>
<script>
    $(function () {
        $('#tblGrid').dataTable();
    });
</script>