<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">
            <h5 class="modal-title">
                Registro(s) Diário(s)
                <i class="fa fa-2x fa-graduation-cap"></i>
            </h5>
        </div>
        <div class="modal-body row">
            <table class="table table-hover">
                <thead>
                    <tr class="panel-footer">
                        <td align="center"><strong>MATRÍCULA</strong></td>
                        <td align="center"><strong>ALUNO</strong></td>
                        <td align="center"><strong>DATA</strong></td>
                        <td align="center"><strong>PROFESSOR</strong></td>
                        <td align="center"><strong>AÇÕES</strong></td>
                        <td align="center"></td>
                    </tr>
                </thead>
                <tbody>
                    <? foreach ($lista as $row) { ?>
                        <tr>
                            <td align="center"><?= $row['CD_ALUNO']?></td>
                            <td align="center"><?= $row['NM_ALUNO']?></td>
                            <td align="center"><?=date('d/m/Y',strtotime(implode("-",array_reverse(explode("/",$row['DT_REGISTRO'])))))?> </td>
                            <td align="center"><?= $row['NM_USUARIO']?></td>
                            <td align="center">
                                <!-- <button class="btn btn-warning btn-circle" title="Visualizar" href="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/registro_diario/mdlRegistro/V-'.$row['CD_REGISTRO'].'')?>" data-toggle="frmModalAluno">
                                    <i class="fa fa-search"></i>
                                </button>
                                <button class="btn btn-info btn-circle" title="Editar" href="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/registro_diario/mdlRegistro/E-'.$row['CD_REGISTRO'].'')?>" data-toggle="frmModalAluno">
                                    <i class="fa fa-edit"></i>
                                </button> -->

                                 <button class="btn btn-warning btn-circle" title="Visualizar" href="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/registro_diario/mdlRegistro/V-'.$row['CD_REGISTRO'].'-'.$row['ORDEM_SERIE'].'')?>" data-toggle="frmModalAluno">
                                    <i class="fa fa-search"></i>
                                </button>
                                <button class="btn btn-info btn-circle" title="Editar" href="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/registro_diario/mdlRegistro/E-'.$row['CD_REGISTRO'].'-'.$row['ORDEM_SERIE'].'')?>" data-toggle="frmModalAluno">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-success btn-circle" title="<?=(($row['STATUS'] == 1)? 'Liberar' : 'Retirar liberação')?>" href="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/registro_diario/mdlRegistro/L-'.$row['CD_REGISTRO'].'-'.$row['ORDEM_SERIE'].'')?>" data-toggle="frmModalAluno">
                                    <i class="<?=(($row['STATUS'] == 1)? 'fa fa-lock' : 'fa fa-unlock')?>"></i>
                                </button>
                                <button class="btn btn-danger btn-circle" title="Excluir" href="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/registro_diario/mdlRegistro/D-'.$row['CD_REGISTRO'].'-'.$row['ORDEM_SERIE'].'')?>" data-toggle="frmModalAluno">
                                    <i class="fa fa-trash-o"></i>
                                </button>
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
    $('[data-toggle="frmModalAluno"]').on('click',
            function(e) {
                $('#frmModalAluno').remove();
                e.preventDefault();
                var $this = $(this)
                        , $remote = $this.data('remote') || $this.attr('href')
                        , $modal = $('<div class="modal fade hmodal-danger no-padding"  id="frmModalAluno"  tabindex="-1" role="dialog" ><div class="modal-dialog no-padding" ><div class="modal-content no-padding"></div></div></div>');
                $('body').append($modal);
                $modal.modal({backdrop: 'static', keyboard: false});
                $modal.load($remote);
            }
    );
    </script>
</div>
