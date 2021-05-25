<table width="90%" align="center" style="font-size: 9px">
    <?
    $data = '';
    $professor = null;
    foreach ($lista as $l) {
        if ($l->DT_AULA != $data || $l->CD_PROFESSOR != $professor) {
            $data = $l->DT_AULA;
            $professor = $l->CD_PROFESSOR;s
            ?>    
            <tr>
                <th colspan="8" height="30"></th>
            </tr>
            
            <tr>
                <th align='left' colspan="8" height="50" style="font-size: 11px">
                    PROFESSOR(A): <?= $l->NM_PROFESSOR ?><br>
                    DATA DA AULA: <?= date('d/m/Y', strtotime(implode("-", array_reverse(explode("/", $l->DT_AULA))))); ?><br>
                </th>
            </tr>
            
            <tr>
                <th align='left' style="border-bottom: 1px solid #000">COD. AULA</th>
                <th align='left' style="border-bottom: 1px solid #000">TURMA</th>
                <th align='left' style="border-bottom: 1px solid #000">DISCIPLINA</th>
                <th align='center' style="border-bottom: 1px solid #000">TEMPO</th>
                <th align='center' style="border-bottom: 1px solid #000">ABERTURA</th>
                <th align='center' style="border-bottom: 1px solid #000">FECHAMENTO</th>
                <th align='center' style="border-bottom: 1px solid #000">CHAMADA</th>
                <th align='left' style="border-bottom: 1px solid #000">CONTEÚDO</th>
            </tr>            
        <? } ?>
            
        <tr style="font-size:12px" class="bg-<?= $status ?> ">
            <td style="border-bottom: 1px solid #CCC; " align='left' height="40px"><?= $l->CD_CL_AULA ?></td>
            <td style="border-bottom: 1px solid #CCC" align='left'><?= $l->CD_TURMA ?></td>
            <td style="border-bottom: 1px solid #CCC" align='left'><?= $l->NM_DISCIPLINA ?></td>
            <td style="border-bottom: 1px solid #CCC"><?= (($l->TURNO == 'A') ? 'MANHÃ' : 'TARDE' ) ?> / <?= $l->TEMPO_AULA ?>º</td>
            <td style="border-bottom: 1px solid #CCC" align='center'><?= $l->HR_ABERTURA ?></td>
            <td style="border-bottom: 1px solid #CCC" align='center'><?= $l->HR_FECHAMENTO ?></td>
            <td style="border-bottom: 1px solid #CCC" align='center'>
                <?php
                if ($l->REQUER_CHAMADA == "N") {
                    echo "NÃO PRECISA";
                } else if ($l->REQUER_CHAMADA == "S" && $l->REALIZOU_CHAMADA == "S") {
                    echo "SIM";
                } else {
                    echo "NÃO";
                }
                ?>                    
            </td>
            <td style="border-bottom: 1px solid #CCC" align='left'><?= nl2br($l->CONTEUDO) . '<br>' . nl2br($l->LISTA) ?></td>
        </tr>
    <? } ?>
</table>