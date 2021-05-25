<div class="col-lg-12 animated-panel zoomIn no-padding" style="animation-delay: 0.5s;">
    <div class="hpanel hviolet">
        <div class="panel-footer text-right">
            <h4>ACOMPANHAMENTO INFANTIL</h4>
        </div>
        <div class="panel-body">
            <table class='table table-hover'>
                <thead>
                    <tr>
                        <td class="bg-primary" valign='center'>MATRÍCULA</td>
                        <td class='border-right bg-primary ' valign='center' class="sorting_asc">ALUNO</td>
                        <td class='border-right bg-primary sorting_desc_disabled' align='center'>COLAÇÃO</td>
                        <td class='border-right bg-primary sorting_desc_disabled' align='center'>ALMOÇO</td>
                        <td class='border-right bg-primary sorting_desc_disabled' align='center'>LANCHE</td>
                        <td class='border-right bg-primary sorting_desc_disabled' align='center'>SONO</td>
                        <td class='border-right bg-primary sorting_desc_disabled' align='center'>EVACUAÇÃO</td>
                    </tr>
                </thead>
                <tbody>
                    <? foreach ($lista as $l) {
                    ?>
                    <tr style="font-size:12px" class="<?= (($l['STATUS'] != 1 || $l['TIPO'] != 'C') ? 'bg-danger' : '') ?>">
                        <td><?= $l['CD_ALUNO'] ?></td>
                        <td class='border-right'><?= $l['NM_ALUNO'] ?></td>
                        <td align='center' class="border-right" ><strong><?= (($l['COLACAO'] != '')   ? $l['COLACAO'] : 'NÃO INFORMADO') ?></strong></td>
                        <td align='center' class="border-right" ><strong><?= (($l['ALMOCO'] != '')    ? $l['ALMOCO'] : 'NÃO INFORMADO') ?></strong></td>
                        <td align='center' class="border-right" ><strong><?= (($l['LANCHE'] != '')    ? $l['LANCHE'] : 'NÃO INFORMADO') ?></strong></td>
                        <td align='center' class="border-right" ><strong><?= (($l['SONO'] != '')      ? $l['SONO'] : 'NÃO INFORMADO') ?></strong></td>
                        <td align='center' class="border-right" ><strong><?= (($l['EVACUACAO'] != '') ? $l['EVACUACAO'] : 'NÃO INFORMADO') ?></strong></td>
                    </tr>
                    <? } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>