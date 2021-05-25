<div class="col-lg-12 animated-panel zoomIn no-padding" style="animation-delay: 0.5s;">
    <div class="hpanel hviolet">
        <div class="panel-footer text-right">
            <h4>BOLETIM DE NOTAS DA TURMA</h4>
        </div>
        <div class="panel-body">
            <table class='table table-hover'>
                    <thead>
                        <tr>
                            <td class='border-right' colspan='2' valign='center'></td>
                            <td class='border-right' colspan='2' align='center'>1º BIMESTRE</td>
                            <td class='border-right' colspan='2' align='center'>2º BIMESTRE</td>
                            <td class='border-right' colspan='2' align='center'>3º BIMESTRE</td>
                            <td class='border-right' colspan='2' align='center'>4º BIMESTRE</td>
                        </tr>
                        <tr>
                            <td valign='center'>MATRÍCULA</td>
                            <td class='border-right' valign='center' class="sorting_asc">ALUNO</td>
                            <td class='sorting_desc_disabled' align='center'>FALTAS</td>
                            <td class='border-right bg-primary sorting_desc_disabled' align='center'>MBF</td>
                            <td class='sorting_desc_disabled' align='center'>FALTAS</td>
                            <td class='border-right bg-primary sorting_desc_disabled' align='center'>MBF</td>
                            <td class='sorting_desc_disabled' align='center'>FALTAS</td>
                            <td class='border-right bg-primary sorting_desc_disabled' align='center'>MBF</td>
                            <td class='sorting_desc_disabled' align='center'>FALTAS</td>
                            <td class='border-right bg-primary sorting_desc_disabled' align='center'>MBF</td>
                        </tr>
                    </thead>
                    <tbody>
                        <? foreach ($lista as $l) {
                                ?>
                                <tr class="<?=(($l['STATUS'] == 1)? 'bg-success' : 'bg-danger')?>" style="font-size:12px">
                                    <td><?= $l['CD_ALUNO'] ?></td>
                                    <td class='border-right'><?= $l['NM_ALUNO'] ?></td>
                                    
                                    <td align='center' class="<?= (($l['BIMESTRE'][1]['NQ'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['FALTAS_1B'] != '') ? $l['FALTAS_1B'] : '-') ?></strong></td>
                                    <td align='center' class="bg-primary border-right" ><strong><?= (($l['BIMESTRE'][1]['MB'] != '') ? number_format($l['BIMESTRE'][1]['MB'], 1, '.', '') : '-') ?></strong></td>

                                    <td align='center' class="<?= (($l['BIMESTRE'][1]['NQ'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['FALTAS_2B'] != '') ? $l['FALTAS_2B'] : '-') ?></strong></td>
                                    <td align='center' class="bg-primary border-right" ><strong><?= (($l['BIMESTRE'][2]['MB'] != '') ? number_format($l['BIMESTRE'][2]['MB'], 1, '.', '') : '-') ?></strong></td>

                                    <td align='center' class="<?= (($l['BIMESTRE'][1]['NQ'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['FALTAS_3B'] != '') ? $l['FALTAS_3B'] : '-') ?></strong></td>
                                    <td align='center' class="bg-primary border-right" ><strong><?= (($l['BIMESTRE'][3]['MB'] != '') ? number_format($l['BIMESTRE'][3]['MB'], 1, '.', '') : '-') ?></strong></td>

                                    <td align='center' class="<?= (($l['BIMESTRE'][1]['NQ'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['FALTAS_4B'] != '') ? $l['FALTAS_4B'] : '-') ?></strong></td>
                                    <td align='center' class="bg-primary border-right" ><strong><?= (($l['BIMESTRE'][4]['MB'] != '') ? number_format($l['BIMESTRE'][4]['MB'], 1, '.', '') : '-') ?></strong></td>
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