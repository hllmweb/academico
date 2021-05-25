<div class="col-lg-12 animated-panel zoomIn no-padding" style="animation-delay: 0.5s;">
    <div class="hpanel hviolet">
        <div class="panel-body">
            <table class='table table-hover' id="tblGrid">
                <thead>
                    <tr class="panel-footer">
                        <td></td>
                        <td align='left'>TURMA</td>
                        <td align='left'>PROFESSOR</td>
                        <td align='left'>DISCIPLINA</td>
                        <td align='left'>LOCAL</td>
                        <td align='left'>DATA</td>
                        <td align='left'>INÍCIO</td>
                        <td align='left'>FIM</td>
                        <td align='left'></td>
                    </tr>
                </thead>
                <tbody>
                    <? foreach ($lista as $l) {
                        if($l['FL_STATUS'] != 'N'){
                        switch ($l['FL_STATUS']){
                            case 'R': // REPROVADO
                                $p = 'text-danger';
                            break;
                            case 'A': // APROVADO
                                $p = 'text-warning';
                            break;
                            case 'F': // FECHADO PELO PROFESSOR
                                $p = 'text-success';
                            break;
                        }
                        
                            ?>
                            <tr style="font-size:12px">
                                <td><i class="fa fa-circle <?=$p?>"></i></td>
                                <td><?= $l['CD_TURMA'] ?></td>
                                <td><?= $l['CD_PROFESSOR'].' - '.$l['NM_PROFESSOR'] ?></td>
                                <td><?= $l['CD_DISCIPLINA'].' - '.$l['NM_DISCIPLINA'] ?></td>
                                <td><?= (($l['TP_LOCAL'] == 'L')? 'LABORATÓRIO' : 'ESPAÇO').' - '.$l['NM_LOCAL'] ?></td>
                                <td><?= date('d/m/Y',strtotime(implode("-",array_reverse(explode("/",$l['DT_PRATICA']))))) ?></td>
                                <td><?= $l['HR_INICIO'] ?></td>
                                <td><?= $l['HR_FINAL'] ?></td>
                                <td>
                                    <div class="btn-group">
                                        <button data-toggle="dropdown" class="btn btn-info btn-xs dropdown-toggle" aria-expanded="true">
                                            Ações <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <? if($l['FL_STATUS'] == 'A'){ ?>
                                            <li>
                                                <a data-toggle="frmModalInfo" href="<?=base_url('' . $this->session->userdata('SGP_SISTEMA') . '/reserva/mdlfrmSolicitacao/L-'.$l['CD_RESERVA'].'')?>">
                                                    <i class="fa fa-edit text-info"></i> Deferir
                                                </a>
                                            </li>
                                            <? } ?>
                                            <li>
                                                <a data-toggle="frmModalInfo" href="<?=base_url('' . $this->session->userdata('SGP_SISTEMA') . '/reserva/mdlfrmSolicitacao/V-'.$l['CD_RESERVA'].'')?>">
                                                    <i class="fa fa-search-plus text-info"></i> Visualizar
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                    <? } } ?>
                </tbody>
                <thead>
                    <tr>
                        <td colspan="10"></td>
                    </tr>
                    <tr>
                        <td colspan="10">
                            <i class="fa fa-circle text-danger"></i> REPROVADA | 
                            <i class="fa fa-circle text-warning"></i> APROVADA | 
                            <i class="fa fa-circle text-success"></i> FECHADA PELO PROFESSOR | 
                        </td>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
$('[data-toggle="frmModalInfo"]').on('click',
    function(e) {
        $('#frmModalInfo').remove();
        e.preventDefault();
        var $this = $(this)
                , $remote = $this.data('remote') || $this.attr('href')
                , $modal = $('<div class="modal fade hmodal-warning no-padding"  id="frmModalInfo"  tabindex="-1" role="dialog" ><div class="modal-dialog no-padding" ><div class="modal-content no-padding"></div></div></div>');
        $('body').append($modal);
        $modal.modal({
            backdrop: 'static', 
            keyboard: false
        });
        $modal.load($remote);
    }
);
</script>