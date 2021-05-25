<div class="col-lg-12 animated-panel zoomIn no-padding" style="animation-delay: 0.5s;">
    <div class="hpanel hviolet">
        <div class="panel-footer text-right">
            <h4>NOTAS DA TURMA</h4>
        </div>
        <div class="panel-body">
            <table class='table table-hover' id="tblGrid">
                    <thead>
                        <tr>
                            <td class='border-right bg-success' colspan='2' valign='center'></td>
                            <td class='border-right bg-success' align='center'>1º BIMESTRE</td>
                            <td class='border-right bg-success' align='center'>2º BIMESTRE</td>
                            <td class='border-right bg-success' align='center'>3º BIMESTRE</td>
                            <td class='border-right bg-success' align='center'>4º BIMESTRE</td>
                            <td class='border-right bg-success' colspan='2' valign='center'></td>
                        </tr>
                        <tr>
                            <td class="bg-primary" valign='center'>MATRÍCULA</td>
                            <td class='border-right bg-primary ' valign='center' class="sorting_asc">ALUNO</td>
                            <td class='border-right bg-primary sorting_desc_disabled' align='center'>MBF</td>
                            <td class='border-right bg-primary sorting_desc_disabled' align='center'>MBF</td>
                            <td class='border-right bg-primary sorting_desc_disabled' align='center'>MBF</td>
                            <td class='border-right bg-primary sorting_desc_disabled' align='center'>MBF</td>
                            <td class='border-right bg-primary sorting_desc_disabled' align='center'>MF</td>
                            <td class='border-right bg-primary sorting_desc_disabled' align='center'>MS</td>
                        </tr>
                    </thead>
                    <tbody>
                        <? foreach ($lista as $l) {
                                ?>
                                <tr style="font-size:12px" class="<?=(($l['STATUS'] != 1 || $l['TIPO'] != 'C')? 'bg-danger' : '')?>">
                                    <td><?= $l['CD_ALUNO'] ?></td>
                                    <td class='border-right'><?= $l['NM_ALUNO'] ?></td>
                                    <td align='center' class="border-right" ><strong><?= (($l['BIMESTRE'][1]['MBF'] != '') ? number_format($l['BIMESTRE'][1]['MBF'], 1, '.', '') : '-') ?></strong></td>
                                    <td align='center' class="border-right" ><strong><?= (($l['BIMESTRE'][2]['MBF'] != '') ? number_format($l['BIMESTRE'][2]['MBF'], 1, '.', '') : '-') ?></strong></td>
                                    <td align='center' class="border-right" ><strong><?= (($l['BIMESTRE'][3]['MBF'] != '') ? number_format($l['BIMESTRE'][3]['MBF'], 1, '.', '') : '-') ?></strong></td>
                                    <td align='center' class="border-right" ><strong><?= (($l['BIMESTRE'][4]['MBF'] != '') ? number_format($l['BIMESTRE'][4]['MBF'], 1, '.', '') : '-') ?></strong></td>
                                    <td align='center' class="border-right" ><strong><?= (($l['BIMESTRE'][4]['MBF'] != '') ? number_format($l['BIMESTRE'][4]['MBF'], 1, '.', '') : '-') ?></strong></td>
                                    <td align='center' class="border-right" ><strong><?= (($l['BIMESTRE'][4]['MBF'] != '') ? number_format($l['BIMESTRE'][4]['MBF'], 1, '.', '') : '-') ?></strong></td>
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