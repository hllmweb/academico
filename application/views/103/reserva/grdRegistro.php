<div class="col-lg-12 animated-panel zoomIn no-padding" style="animation-delay: 0.5s;">
    <div class="hpanel hviolet">
        <div class="panel-body">
            <table class='table table-hover' id="tblGrid">
                <thead>
                    <tr>
                        <td align='left'></td>
                        <td align='left'>TURMA</td>
                        <td align='left'>PROFESSOR</td>
                        <td align='left'>DISCIPLINA</td>
                        <td align='left'>LOCAL</td>
                        <td align='left'>DATA</td>
                        <td align='left'>INÍCIO</td>
                        <td align='left'>FIM</td>
                        <td align='left'>DT. CADASTRO</td>
                    </tr>
                </thead>
                <tbody>
                    <? foreach ($lista as $l) {
                            ?>
                            <tr class="<?=(($l['STATUS'] == 1)? 'bg-success' : 'bg-warning')?>" style="font-size:12px">
                                <td>
                                    <div class="btn-group">
                                        <button data-toggle="dropdown" class="btn btn-info btn-xs dropdown-toggle" aria-expanded="true">
                                            Ações <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <? if($l['CD_USUARIO'] == $this->session->userdata('SGP_CODIGO')){ ?>
                                            <li>
                                                <a data-toggle="frmModalInfo" href="<?=base_url('' . $this->session->userdata('SGP_SISTEMA') . '/reserva/mdlfrmSolicitacao/E-'.$l['CD_RESERVA'].'')?>">
                                                    <i class="fa fa-edit text-info"></i> Editar
                                                </a>
                                            </li>
                                            <? } if($l['FL_STATUS'] == 'A'){ ?>
                                            <li class="divider"></li>
                                            <li>
                                                <a data-toggle="frmModalDanger" href="<?=base_url('' . $this->session->userdata('SGP_SISTEMA') . '/reserva/mdlfrmSolicitacao/D-'.$l['CD_RESERVA'].'')?>">
                                                    <i class="fa fa-trash text-danger"></i> Cancelar Reserva
                                                </a>
                                            </li>
                                            <? } ?>
                                            <li>
                                                <a data-toggle="frmModalDanger" href="<?=base_url('' . $this->session->userdata('SGP_SISTEMA') . '/reserva/mdlfrmSolicitacao/V-'.$l['CD_RESERVA'].'')?>">
                                                    <i class="fa fa-eye text-danger"></i> Visualizar
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                                <td><?= $l['CD_TURMA'] ?></td>
                                <td><?= $l['CD_PROFESSOR'].' - '.$l['NM_PROFESSOR'] ?></td>
                                <td><?= $l['CD_DISCIPLINA'].' - '.$l['NM_DISCIPLINA'] ?></td>
                                <td><?= (($l['TP_LOCAL'] == 'L')? 'LABORATÓRIO' : 'ESPAÇO').' - '.$l['NM_LOCAL'] ?></td>
                                <td><?= date('d/m/Y',strtotime(implode("-",array_reverse(explode("/",$l['DT_PRATICA']))))) ?></td>
                                <td><?= (($l['DT_PRATICA_FINAL'] != '')? date('d/m/Y',strtotime(implode("-",array_reverse(explode("/",$l['DT_PRATICA_FINAL']))))) : '') ?></td>
                                <td><?= $l['HR_INICIO'] ?></td>
                                <td><?= $l['HR_FINAL'] ?></td>
                                <td>
                                    <?=$l['DT_SOLICITACAO'];?>
                                </td>
                            </tr>
                        <? } ?>
                </tbody>
                </table>
        </div>
    </div>
</div>
<script>
    $(function() {
        // Initialize Example 2
        $('#tblGrid').dataTable();
    });
</script>
<script type="text/javascript">
$('[data-toggle="frmModalInfo"]').on('click',
        function(e) {
            $('#frmModalInfo').remove();
            e.preventDefault();
            var $this = $(this)
                    , $remote = $this.data('remote') || $this.attr('href')
                    , $modal = $('<div class="modal fade hmodal-warning no-padding"  id="frmModalInfo"  tabindex="-1" role="dialog" ><div class="modal-dialog no-padding" ><div class="modal-content no-padding"></div></div></div>');
            $('body').append($modal);
            $modal.modal({backdrop: 'static', keyboard: false});
            $modal.load($remote);
        }
);
$('[data-toggle="frmModalDanger"]').on('click',
        function(e) {
            $('#frmModalDanger').remove();
            e.preventDefault();
            var $this = $(this)
                    , $remote = $this.data('remote') || $this.attr('href')
                    , $modal = $('<div class="modal fade hmodal-danger no-padding"  id="frmModalDanger"  tabindex="-1" role="dialog" ><div class="modal-dialog no-padding" ><div class="modal-content no-padding"></div></div></div>');
            $('body').append($modal);
            $modal.modal({backdrop: 'static', keyboard: false});
            $modal.load($remote);
        }
);
</script>