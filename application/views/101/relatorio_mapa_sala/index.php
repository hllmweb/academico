<div style="margin-left: 30px; margin-right: 30px;">
    <table style="width: 100%; border-collapse: collapse">
        <thead>
            <tr>
                <?php for ($i = 1; $i <= 5; $i++) { ?>
                    <th style="border-collapse: collapse;height: 40px;background: gainsboro; font-weight: bold; border: 1px solid black">FILA 0<?= $i ?></th>
                <?php } ?>
            </tr>
        </thead>

        <tbody>
            <?php for ($linha = 1; $linha <= 5; $linha++) { ?>
                <tr>
                    <?php
                    for ($coluna = 1; $coluna <= 5; $coluna++) {
                        $p = '';
                        $p = array_search('' . $coluna . '-' . $linha . '', $posicoes);
                        $p = ((!is_numeric($p)) ? -1 : $p);
                        ?>
                        <td style="width: 20%; vertical-align: baseline; -moz-box-align: start; text-align: center; padding-bottom: 20px; border: 1px solid black; border-collapse: collapse">                            
                            <span style="font-weight: bold;">0<?= $linha ?></span>
                            <p><?= $alunos[$p]['NR_FILA'] != '' ? $alunos[$p]['NM_ALUNO'] : "&nbsp;" ?></p>                            
                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>