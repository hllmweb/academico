<table class="display table table-hover" id="tblGrid">
    <thead>
        <tr class="panel-footer">
            <td><strong>ID</strong></td>
            <td width="5%"><strong>N. PROVA</strong></td>
            <td width="10%" align="center"><strong>NOTA</strong></td>
            <td><strong>DISCIPLINA</strong></td>
            <td align="center"><strong>CH</strong></td>
            <td align="center"><strong>INSCRITOS</strong></td>
            <td align="center"><strong>PRESENTES</strong></td>
            <td align="center"><strong>ARQUIVO</strong></td>
            <td align="center"></td>
        </tr>
    </thead>
    <tbody>
        <? foreach ($resultado as $row) { ?>
            <tr class="<?=(($row['FLG_PEND_PROCESSAMENTO'] == 0)? 'text-info' : 'text-danger')?> font-bold">
                <td><?= $row['CD_PROVA'] ?></td>
                <td><?= $row['NUM_PROVA'] ?></td>
                <td align="center"><?= $row['NM_MINI'] ?></td>
                <td><?= $row['DISCIPLINAS'] ?></td>
                <td align="center"><?= $row['CHAMADA'].'ª'?></td>
                <td align="center"><?= $row['ALUNOS'] ?></td>
                <td align="center"><?= $row['ALUNOS'] ?></td>
                <td align="center"><?= $row['VERSOES'] ?></td>
                <td>
                    <? if($row['FLG_PEND_PROCESSAMENTO'] == 1){?>
                        <? if($row['RESPOSTAS'] != '' || $row['CARTOES'] > 0){ ?>
                            <a class="btn btn-success btn-xs" href="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/processamento/mdlProcessar/'.$row['CD_PROVA'].'')?>" data-toggle="frmModalFull">
                                <i class="fa fa-check-circle"></i> Processar
                            </a>
                        <? }elseif($row['CARTOES'] == 0 && $row['RESPOSTAS'] != ''){ ?>
                            <a class="btn btn-primary2 btn-xs">
                                <i class="fa fa-check"></i> Aguardando cartões
                            </a>
                        <? }elseif($row['RESPOSTAS'] == ''){ ?>
                            <a class="btn btn-danger btn-xs">
                                <i class="fa fa-check-circle"></i> Sem gabarito
                            </a>
                        <? } }else{ ?>
                        <a class="btn btn-warning btn-xs" href="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/processamento/mdlDetalhes/'.$row['CD_TIPO_PROVA'].'-'.$row['CD_PROVA'].'')?>"  data-toggle="frmModalFull">
                            <i class="fa fa-search"></i> Detalhes
                        </a>
                    <? } ?>
                </td>
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
    
$('[data-toggle="frmModalFull"]').on('click',
        function(e) {
            $('#frmModalFull').remove();
            e.preventDefault();
            var $this = $(this)
                    , $remote = $this.data('remote') || $this.attr('href')
                    , $modal = $('<div class="modal fade hmodal-danger no-padding"  id="frmModalFull"  tabindex="-1" role="dialog" ><div class="modal-dialog" ><div class="modal-content"></div></div></div>');
            $('body').append($modal);
            $modal.modal({backdrop: 'static', keyboard: false});
            $modal.load($remote);
        }
);
</script>