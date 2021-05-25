<div class="col-lg-12 animated-panel zoomIn no-padding" style="animation-delay: 0.5s;">
    <div class="hpanel hviolet">
        <div class="panel-footer text-right">
            <h4>NOTAS DA TURMA</h4>
        </div>
        <div class="panel-body">
            <table class='table table-hover'>
                    <thead>
                        <tr>
                            <td class='border-right' colspan='2' valign='center'></td>
                            <td class='border-right' colspan='5' align='center'>1º BIMESTRE</td>
                            <td class='border-right' colspan='5' align='center'>2º BIMESTRE</td>
                            <td class='border-right' colspan='5' align='center'>3º BIMESTRE</td>
                            <td class='border-right' colspan='5' align='center'>4º BIMESTRE</td>
                        </tr>
                        <tr>
                            <td valign='center'>MATRÍCULA</td>
                            <td class='border-right' valign='center' class="sorting_asc">ALUNO</td>
                            <td align='center' class="sorting_desc_disabled">P1</td>
                            <td align='center' class="sorting_desc_disabled">P2</td>
                            <td align='center' class="sorting_desc_disabled">MAIC</td>
                            <td class='sorting_desc_disabled' align='center'>NQ</td>
                            <td class='border-right bg-primary sorting_desc_disabled' align='center'>MBF</td>
                            <td align='center' class="sorting_desc_disabled">P1</td>
                            <td align='center' class="sorting_desc_disabled">P2</td>
                            <td align='center' class="sorting_desc_disabled">MAIC</td>
                            <td class='sorting_desc_disabled' align='center'>NQ</td>
                            <td class='border-right bg-primary sorting_desc_disabled' align='center'>MBF</td>
                            <td align='center' class="sorting_desc_disabled">P1</td>
                            <td align='center' class="sorting_desc_disabled">P2</td>
                            <td align='center' class="sorting_desc_disabled">MAIC</td>
                            <td class='sorting_desc_disabled' align='center'>NQ</td>
                            <td class='border-right bg-primary sorting_desc_disabled' align='center'>MBF</td>
                            <td align='center' class="sorting_desc_disabled">P1</td>
                            <td align='center' class="sorting_desc_disabled">P2</td>
                            <td align='center' class="sorting_desc_disabled">MAIC</td>
                            <td class='sorting_desc_disabled' align='center'>NQ</td>
                            <td class='border-right bg-primary sorting_desc_disabled' align='center'>MBF</td>
                        </tr>
                    </thead>
                    <tbody>
                        <? foreach ($lista as $l) {
                                ?>
                                <tr class="<?=(($l['STATUS'] == 1)? 'bg-success' : 'bg-danger')?>" style="font-size:12px">
                                    <td><?= $l['CD_ALUNO'] ?></td>
                                    <td class='border-right'><?= $l['NM_ALUNO'] ?></td>
                                    
                                    <td align='center' class="<?= (($l['BIMESTRE'][1]['P1'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][1]['P1'] != '') ? number_format($l['BIMESTRE'][1]['P1'], 1, '.', '') : '-') ?></strong></td>
                                    <td align='center' class="<?= (($l['BIMESTRE'][1]['P2'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][1]['P2'] != '') ? number_format($l['BIMESTRE'][1]['P2'], 1, '.', '') : '-') ?></strong></td>
                                    <td align='center' class="<?= (($l['BIMESTRE'][1]['MAIC'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][1]['MAIC'] != '') ? number_format($l['BIMESTRE'][1]['MAIC'], 1, '.', '') : '-') ?></strong></td>
                                    <td align='center' class="<?= (($l['BIMESTRE'][1]['NQ'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][1]['NQ'] != '') ? number_format($l['BIMESTRE'][1]['NQ'], 1, '.', '') : '-') ?></strong></td>
                                    <td align='center' class="bg-primary border-right" ><strong><?= (($l['BIMESTRE'][1]['MBF'] != '') ? number_format($l['BIMESTRE'][1]['MBF'], 1, '.', '') : '-') ?></strong></td>

                                    <td align='center' class="<?= (($l['BIMESTRE'][2]['P1'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][2]['P1'] != '') ? number_format($l['BIMESTRE'][2]['P1'], 1, '.', '') : '-') ?></strong></td>
                                    <td align='center' class="<?= (($l['BIMESTRE'][2]['P2'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][2]['P2'] != '') ? number_format($l['BIMESTRE'][2]['P2'], 1, '.', '') : '-') ?></strong></td>
                                    <td align='center' class="<?= (($l['BIMESTRE'][2]['MAIC'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][2]['MAIC'] != '') ? number_format($l['BIMESTRE'][2]['MAIC'], 1, '.', '') : '-') ?></strong></td>
                                    <td align='center' class="<?= (($l['BIMESTRE'][2]['NQ'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][2]['NQ'] != '') ? number_format($l['BIMESTRE'][2]['NQ'], 1, '.', '') : '-') ?></strong></td>
                                    <td align='center' class="bg-primary border-right" ><strong><?= (($l['BIMESTRE'][2]['MBF'] != '') ? number_format($l['BIMESTRE'][2]['MBF'], 1, '.', '') : '-') ?></strong></td>

                                    <td align='center' class="<?= (($l['BIMESTRE'][3]['P1'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][3]['P1'] != '') ? number_format($l['BIMESTRE'][3]['P1'], 1, '.', '') : '-') ?></strong></td>
                                    <td align='center' class="<?= (($l['BIMESTRE'][3]['P2'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][3]['P2'] != '') ? number_format($l['BIMESTRE'][3]['P2'], 1, '.', '') : '-') ?></strong></td>
                                    <td align='center' class="<?= (($l['BIMESTRE'][3]['MAIC'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][3]['MAIC'] != '') ? number_format($l['BIMESTRE'][3]['MAIC'], 1, '.', '') : '-') ?></strong></td>
                                    <td align='center' class="<?= (($l['BIMESTRE'][3]['NQ'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][3]['NQ'] != '') ? number_format($l['BIMESTRE'][3]['NQ'], 1, '.', '') : '-') ?></strong></td>
                                    <td align='center' class="bg-primary border-right" ><strong><?= (($l['BIMESTRE'][3]['MBF'] != '') ? number_format($l['BIMESTRE'][3]['MBF'], 1, '.', '') : '-') ?></strong></td>

                                    <td align='center' class="<?= (($l['BIMESTRE'][4]['P1'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][4]['P1'] != '') ? number_format($l['BIMESTRE'][4]['P1'], 1, '.', '') : '-') ?></strong></td>
                                    <td align='center' class="<?= (($l['BIMESTRE'][4]['P2'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][4]['P2'] != '') ? number_format($l['BIMESTRE'][4]['P2'], 1, '.', '') : '-') ?></strong></td>
                                    <td align='center' class="<?= (($l['BIMESTRE'][4]['MAIC'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][4]['MAIC'] != '') ? number_format($l['BIMESTRE'][4]['MAIC'], 1, '.', '') : '-') ?></strong></td>
                                    <td align='center' class="<?= (($l['BIMESTRE'][4]['NQ'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][4]['NQ'] != '') ? number_format($l['BIMESTRE'][4]['NQ'], 1, '.', '') : '-') ?></strong></td>
                                    <td align='center' class="bg-primary border-right" ><strong><?= (($l['BIMESTRE'][4]['MBF'] != '') ? number_format($l['BIMESTRE'][4]['MBF'], 1, '.', '') : '-') ?></strong></td>
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