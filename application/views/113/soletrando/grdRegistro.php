<table class="display table table-hover" id="tblGrid">
    <thead>
        <tr class="panel-footer">
            <th width='5%'><strong>PERÍODO</strong></th>
            <th width='15%'><strong>CURSO</strong></th>
            <th width='5%'><strong>SÉRIE</strong></th>
            <th width='5%'><strong>BIMESTRE</strong></th>
            <th width='5%'><strong>NÍVEL</strong></th>
            <th width='15%'><strong>PALAVRA</strong></th>
            <th><strong>APLICAÇÃO FRASE</strong></th>
            <th><strong>DICA</strong></th>
            <th align="center"></th>
        </tr>
    </thead>

    <tbody>
        <? foreach ($lista as $row) { ?>
            <tr>
                <td class='text-center'><?= $row->PERIODO ?></td>
                <td class='text-center'><?= $row->NM_CURSO_RED ?></td>
                <td class='text-center'><?= $row->ORDEM_SERIE ?>º</td>
                <td class='text-center'><?= $row->BIMESTRE ?>º</td> 
                <td><?= $row->DS_DIFICULDADE ?></td>
                <td><strong><?= $row->DC_PALAVRA ?></strong></td>
                <td><?= $row->DC_DICA_APLICACAO_FRASE ?></td>
                <td><?= $row->DC_DICA_EXEMPLO ?></td>
                <td>
                    <button class='btn btn-xs btn-info' href="<?= base_url($this->session->userdata('SGP_SISTEMA') . '/soletrando/mdlRegistro/E-' . $row->CD_PALAVRA) ?>" data-toggle="frmModalInfo">
                        <i class='fa fa-edit'></i>
                    </button>
                </td>
            </tr>
        <? } ?>
    </tbody>
</table>

<script type="text/javascript">
    $(function () {
        $('#tblGrid').dataTable();
    });

    $("#tblGrid").on('click', '[data-toggle="frmModalInfo"]',
            function (e) {
                $('#frmModalInfo').remove();
                e.preventDefault();
                var $this = $(this)
                        , $remote = $this.data('remote') || $this.attr('href')
                        , $modal = $('<div class="modal fade hmodal-danger no-padding"  id="frmModalInfo"  tabindex="-1" role="dialog" ><div class="modal-dialog no-padding" ><div class="modal-content no-padding"></div></div></div>');
                $('body').append($modal);
                $modal.modal({backdrop: 'static', keyboard: false});
                $modal.load($remote);
            }
    );
</script>