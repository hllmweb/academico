<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">
            <h5 class="modal-title">
                Registro(s) de Atendimento ao Docente
                <i class="fa fa-2x fa-graduation-cap"></i>
            </h5>
        </div>
        <div class="modal-body row">
            <table class="table table-hover">
                <thead>
                    <tr class="panel-footer">
                        <td><strong>DATA</strong></td>
                        <td><strong>MOTIVO</strong></td>
                        <td><strong>RESUMO</strong></td>
                        <td><strong>OBS</strong></td>
                        <td align="center"></td>
                    </tr>
                </thead>
                <tbody>
                    <? foreach ($lista as $row) { ?>
                        <tr>
                            <td><?=date('d/m/Y',strtotime(implode("-",array_reverse(explode("/",$row['DT_ORIENTACAO'])))))?> </td>
                            <td><?= $row['DC_MOTIVO']?></td>
                            <td><?= $row['DC_RESUMO']?></td>
                            <td><?= $row['DC_OBS']?></td>                            
                            <td width="5%">
                                <a data-toggle="frmSubModal" href="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/orientacao_docente/mdlRegistro/E-'.$row['CD_ORIENTACAO'].'')?>" class="btn btn-xs btn-block btn-info">
                                    <i class='fa fa-edit'></i> Editar
                                </a>
                                <a data-toggle="frmSubModal" href="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/orientacao_docente/mdlRegistro/D-'.$row['CD_ORIENTACAO'].'')?>" class="btn btn-xs btn-block btn-danger2">
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
