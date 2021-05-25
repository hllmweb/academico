<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">
            <h5 class="modal-title">
                Registro(s) de Suspensão
                <i class="fa fa-2x fa-graduation-cap"></i>
            </h5>
        </div>
        <div class="modal-body row">
            <table class="table table-hover">
                <thead>
                    <tr class="panel-footer">
                        <td><strong>MATRÍCULA</strong></td>
                        <td><strong>ALUNO</strong></td>
                        <td><strong>DT. INÍCIO</strong></td>
                        <td><strong>DT. FIM</strong></td>
                        <td><strong>MOTIVO</strong></td>
                        <td><strong>ENVIADA NOTIFICAÇÃO</strong></td>
                        <td><strong>NOTIFICAÇÃO LIDA</strong></td>
                        <td align="center"></td>
                    </tr>
                </thead>
                <tbody>
                    <? foreach ($lista as $row) { ?>
                        <tr>
                            <td><?= $row['CD_ALUNO']?></td>
                            <td><?= $row['NM_ALUNO']?></td>
                            <td><?=date('d/m/Y',strtotime(implode("-",array_reverse(explode("/",$row['DT_INICIO'])))))?> </td>
                            <td><?=date('d/m/Y',strtotime(implode("-",array_reverse(explode("/",$row['DT_FIM'])))))?> </td>
                            <td><?= $row['MOTIVO']?></td>
                            <td><?= $row['FLG_NOTIFICAR'] == "S" ? "SIM" : "NÃO" ?></td>
                            <td><?= $row['FLG_LIDO'] == "S" ? "SIM" : "NÃO" ?></td>
                            <td>
                                <a target='_blank' href="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/suspensao/termo/'.$row['CD_SUSPENSAO'].'')?>" class="btn btn-xs btn-block  btn-warning">
                                    <i class='fa fa-eye'></i> Ver
                                </a>
                                <a data-toggle="frmSubModal" href="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/suspensao/mdlRegistro/E-'.$row['CD_SUSPENSAO'].'')?>" class="btn btn-xs btn-block btn-info">
                                    <i class='fa fa-edit'></i> Editar
                                </a>
                                <a data-toggle="frmSubModal" href="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/suspensao/mdlRegistro/D-'.$row['CD_SUSPENSAO'].'')?>" class="btn btn-xs btn-block btn-danger2">
                                    <i class='fa fa-trash-o'></i> Deletar
                                </a>
                            </td>
                        </tr>
                    <? } ?>
                </tbody>
            </table>
        </div>
        <div class="modal-footer" id="resp"></div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger2 pull-left" data-dismiss="modal">
                <i class="fa fa-times"></i> Fechar
            </button>
        </div>
    </div>
    <script type="text/javascript">
    $('[data-toggle="frmSubModal"]').on('click',
            function(e) {
                $('#frmSubModal').remove();
                e.preventDefault();
                var $this = $(this)
                        , $remote = $this.data('remote') || $this.attr('href')
                        , $modal = $('<div class="modal fade hmodal-warning no-padding"  id="frmSubModal"  tabindex="-1" role="dialog" ><div class="modal-dialog no-padding" ><div class="modal-content no-padding"></div></div></div>');
                $('body').append($modal);
                $modal.modal({backdrop: 'static', keyboard: false});
                $modal.load($remote);
            }
    );
    </script>
</div>
