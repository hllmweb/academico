<? $this->load->view('home/header'); ?>
<div class="panel-footer no-margins">
    <a href="<?= base_url('' . $this->session->userdata('SGP_SISTEMA') . '/main') ?>" class="btn btn-xs btn-primary2 "><i class="fa fa-refresh fa-2x"></i> <br/>Outra Turma</a>
    | 
    <span style="font-size:15px">TURMA: <?= $this->session->userdata('SGP_TURMA') ?> | DISCIPLINA: <?= $info[0]['NM_DISCIPLINA'] ?></span>
    <div class="panel-tools">
        <button data-toggle="frmModal" class="btn btn-info" type="none" href="<?= base_url('110/diario_prova/mdlDiarioProva/' . $this->session->userdata('SGP_TURMA') . '') ?>">
            <i class="fa fa-check-circle-o fa-2x"></i>
            Lançar Nota Discursiva
        </button>
        <button data-toggle="frmModal" class="btn btn-info " type="button" href="<?= base_url('110/diario_prova/mdlDiarioLancarNota/' . $this->session->userdata('SGP_TURMA') . '') ?>">
            <i class="fa fa-check-circle-o fa-2x"></i>
            Lançar Nota
        </button>
        <button type="button" class="btn btn-warning btn-circle" data-container="body" data-toggle="popover" data-placement="left" data-title="" data-content="<table><tr><td><img src='<?= base_url('assets/images/simbolo.png') ?>' width='80%'></td><td valign='top'><strong>Lançar Nota Discursiva: </strong><br/>Lançamento de nota complementar de uma avaliação objetiva. <br/> <strong>Lançar Nota: </strong><br/>Lançamento de nota direto, sem haver uma prova objetiva</td></tr></table>" data-original-title="" data-html="true" title="">?</button>
    </div>
</div>
<div class="content animate-panel">    
    <div class="row">
        <div class="col-lg-12 animated-panel zoomIn" style="animation-delay: 0.5s;">
            <div class="hpanel hviolet">
                <div class="panel-footer text-right">
                    <h4>NOTAS DA TURMA</h4>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class='table table-hover' id="tblGrid">
                            <thead>
                                <tr>
                                    <td class='border-right' colspan='2' valign='center'></td>
                                    <td class='border-right' colspan='4' align='center'>1º BIMESTRE</td>
                                    <td class='border-right' colspan='4' align='center'>2º BIMESTRE</td>
                                    <td class='border-right' colspan='4' align='center'>3º BIMESTRE</td>
                                    <td class='border-right' colspan='4' align='center'>4º BIMESTRE</td>
                                </tr>
                                <tr>
                                    <td valign='center'>MATRÍCULA</td>
                                    <td class='border-right' valign='center' class="sorting_asc">ALUNO</td>
                                    <td align='center' class="sorting_desc_disabled">P1</td>
                                    <td align='center' class="sorting_desc_disabled">P2</td>
                                    <td align='center' class="sorting_desc_disabled">MAIC</td>
                                    <td class='border-right sorting_desc_disabled' align='center'>NQ</td>
                                    <td align='center' class="sorting_desc_disabled">P1</td>
                                    <td align='center' class="sorting_desc_disabled">P2</td>
                                    <td align='center' class="sorting_desc_disabled">MAIC</td>
                                    <td class='border-right sorting_desc_disabled' align='center'>NQ</td>
                                    <td align='center' class="sorting_desc_disabled">P1</td>
                                    <td align='center' class="sorting_desc_disabled">P2</td>
                                    <td align='center' class="sorting_desc_disabled">MAIC</td>
                                    <td class='border-right sorting_desc_disabled' align='center'>NQ</td>
                                    <td align='center' class="sorting_desc_disabled">P1</td>
                                    <td align='center' class="sorting_desc_disabled">P2</td>
                                    <td align='center' class="sorting_desc_disabled">MAIC</td>
                                    <td class='border-right sorting_desc_disabled' align='center'>NQ</td>
                                </tr>
                            </thead>
                            <tbody>
                                <? foreach ($lista as $l) {
                                    if ($l['STATUS'] == 1) { ?>
                                        <tr style="font-size:12px">
                                            <td><?= $l['CD_ALUNO'] ?></td>
                                            <td class='border-right'><?= $l['NM_ALUNO'] ?>
                                                <? if ($l['STATUS'] <> 1) { ?>
                                                    <button type="button" class="btn btn-warning btn-xs btn-circle no-padding" data-container="body" data-toggle="popover" data-placement="top" data-title="<img src='<?= base_url('assets/images/simbolo.png') ?>' width='10%'><strong> Alerta!</strong>" data-content="<strong>Aluno Transferido</strong>" data-original-title="" data-html="true" title="">?</button>
        <? } ?>    
                                            </td>

                                            <td align='center' class="<?= (($l['BIMESTRE'][1]['P1'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][1]['P1'] != '') ? number_format($l['BIMESTRE'][1]['P1'], 1, '.', '') : '-') ?></strong></td>
                                            <td align='center' class="<?= (($l['BIMESTRE'][1]['P2'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][1]['P2'] != '') ? number_format($l['BIMESTRE'][1]['P2'], 1, '.', '') : '-') ?></strong></td>
                                            <td align='center' class="<?= (($l['BIMESTRE'][1]['MAIC'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][1]['MAIC'] != '') ? number_format($l['BIMESTRE'][1]['MAIC'], 1, '.', '') : '-') ?></strong></td>
                                            <td align='center' class="border-right <?= (($l['BIMESTRE'][1]['NQ'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][1]['NQ'] != '') ? number_format($l['BIMESTRE'][1]['NQ'], 1, '.', '') : '-') ?></strong></td>

                                            <td align='center' class="<?= (($l['BIMESTRE'][2]['P1'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][2]['P1'] != '') ? number_format($l['BIMESTRE'][2]['P1'], 1, '.', '') : '-') ?></strong></td>
                                            <td align='center' class="<?= (($l['BIMESTRE'][2]['P2'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][2]['P2'] != '') ? number_format($l['BIMESTRE'][2]['P2'], 1, '.', '') : '-') ?></strong></td>
                                            <td align='center' class="<?= (($l['BIMESTRE'][2]['MAIC'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][2]['MAIC'] != '') ? number_format($l['BIMESTRE'][2]['MAIC'], 1, '.', '') : '-') ?></strong></td>
                                            <td align='center' class="border-right <?= (($l['BIMESTRE'][2]['NQ'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][2]['NQ'] != '') ? number_format($l['BIMESTRE'][2]['NQ'], 1, '.', '') : '-') ?></strong></td>

                                            <td align='center' class="<?= (($l['BIMESTRE'][3]['P1'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][3]['P1'] != '') ? number_format($l['BIMESTRE'][3]['P1'], 1, '.', '') : '-') ?></strong></td>
                                            <td align='center' class="<?= (($l['BIMESTRE'][3]['P2'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][3]['P2'] != '') ? number_format($l['BIMESTRE'][3]['P2'], 1, '.', '') : '-') ?></strong></td>
                                            <td align='center' class="<?= (($l['BIMESTRE'][3]['MAIC'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][3]['MAIC'] != '') ? number_format($l['BIMESTRE'][3]['MAIC'], 1, '.', '') : '-') ?></strong></td>
                                            <td align='center' class="border-right <?= (($l['BIMESTRE'][3]['NQ'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][3]['NQ'] != '') ? number_format($l['BIMESTRE'][3]['NQ'], 1, '.', '') : '-') ?></strong></td>

                                            <td align='center' class="<?= (($l['BIMESTRE'][4]['P1'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][4]['P1'] != '') ? number_format($l['BIMESTRE'][4]['P1'], 1, '.', '') : '-') ?></strong></td>
                                            <td align='center' class="<?= (($l['BIMESTRE'][4]['P2'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][4]['P2'] != '') ? number_format($l['BIMESTRE'][4]['P2'], 1, '.', '') : '-') ?></strong></td>
                                            <td align='center' class="<?= (($l['BIMESTRE'][4]['MAIC'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][4]['MAIC'] != '') ? number_format($l['BIMESTRE'][4]['MAIC'], 1, '.', '') : '-') ?></strong></td>
                                            <td align='center' class="border-right <?= (($l['BIMESTRE'][4]['NQ'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][4]['NQ'] != '') ? number_format($l['BIMESTRE'][4]['NQ'], 1, '.', '') : '-') ?></strong></td>
                                        </tr>
    <? }
} ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        // Initialize Example 2
        $('#tblGrid').dataTable();
    });
</script>
<? $this->load->view('home/footer'); ?>