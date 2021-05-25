<table class="display table table-hover" id="tblGrid">
    <thead>
        <tr class="panel-footer">
            <td width='10%'><strong></strong></td>
            <td width='10%'><strong>TURMA</strong></td>
            <td><strong>PROFESSOR</strong></td>
            <td><strong>DISCIPLINA</strong></td>
            <td align="center"></td>
        </tr>
    </thead>
    <tbody>
        <? foreach ($lista as $row) { ?>
            <tr>
                <td>
                    <? if($row['CONT'] > 0){?>
                        <button href="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/orientacao_docente/mdlRegistroProfessor/'.$row['CD_PROFESSOR'].'-'.$row['CD_DISCIPLINA'].'-'.$row['CD_TURMA'].'')?>" data-toggle="frmModalInfo" type="button" id="" class="btn btn-xs btn-primary">
                            <?=(($row['CONT'] == 1)? '( '.$row['CONT'].' ) Registro' : '( '.$row['CONT'].' ) Registros')?> 
                        </button>
                    <? } ?>
                </td>
                <td><?= $row['CD_TURMA']?></td>
                <td><?= $row['CD_PROFESSOR'].' - '.$row['NM_PROFESSOR']?></td>
                <td><?= $row['CD_DISCIPLINA'].' - '.$row['NM_DISCIPLINA']?></td>
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