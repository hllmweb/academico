<table class="display table table-hover" id="tblGrid">
    <thead>
        <tr class="panel-footer">
            <td width='10%'><strong></strong></td>
            <td width='10%'><strong>TURMA</strong></td>
            <td width='10%'><strong>MATRÍCULA</strong></td>
            <td><strong>ALUNO</strong></td>
            <td align="center"></td>
        </tr>
    </thead>
    <tbody>
        <? foreach ($lista as $row) { ?>
            <tr>
                <td>
                    <? if($row['CONT'] > 0){?>
                        <button href="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/termo/mdlRegistroAluno/'.$row['CD_ALUNO'].'')?>" data-toggle="frmModalInfo" type="button" id="" class="btn btn-xs btn-primary">
                            <?=(($row['CONT'] == 1)? '( '.$row['CONT'].' ) Termo' : '( '.$row['CONT'].' ) Termos')?> 
                        </button>
                    <? } ?>
                </td>
                <td><?= $row['TURMA_ATUAL']?></td>
                <td><?= $row['CD_ALUNO']?></td>
                <td><?= $row['NM_ALUNO']?></td>
                <td></td>
            </tr>
        <? } ?>
    </tbody>
    <tfoot>
        <tr class="panel-footer">
            <td colspan="11">
            </td>
        </tr>
    </tfoot>
</table>
<script src="<?=base_url('assets/js/jquery.min.js')?>"></script>
<script src="<?=base_url('assets/js/bootstrap.min.js')?>"></script>
<script type="text/javascript">
$('[data-toggle="frmModalInfo"]').on('click',
        function(e) {
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