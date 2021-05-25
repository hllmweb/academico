<table width="90%" align="center" cellpadding="0" cellspacing="0">
        <? 
        $al = '';
        foreach ($lista as $row) {

            if($al != $row['CD_ALUNO']){
                $al = $row['CD_ALUNO'];
            ?>
                <tr>
                    <td colspan="8" style="padding:5px">
                        
                    </td>
                </tr>
                <tr style="background: #909295;">
                    <td colspan="2"><strong><?= $row['CD_ALUNO'].' - '.$row['NM_ALUNO']?></strong></td>
                    <td colspan="5" align="center" style="padding:5px"><strong>FALTA 1B</strong></td>
                    <td rowspan="3" align="center"><strong>%</strong></td>
                </tr>
                <tr style="background:#909295;">
                    <td rowspan="2" style="padding:5px"><strong>DISCIPLINA</strong></td>
                    <td rowspan="2" align="center"><strong>GRADE</strong></td>
                    <td colspan="4" align="center"><strong>BIMESTRES</strong></td>
                    <td rowspan="2" align="center"><strong>TOTAL</strong></td>
                </tr>
                <tr style="background:#909295;">
                    <td align="center"><strong>1º</strong></td>
                    <td align="center"><strong>2º</strong></td>
                    <td align="center"><strong>3º</strong></td>
                    <td align="center"><strong>4º</strong></td>
                </tr>
            <? }
            $perc = number_format((($row['FALTAS'] * 100)/$row['CH_TOTAL']),1,'.','');            
            ?>
            <tr  style="background:<?=(($perc >= 15.0)? '#fff000' : '#dff0d8' )?>;">
                <td style="padding:3px 5px"><?= $row['NM_DISCIPLINA']?></td>
                <td align="center"><?= $row['CH_TOTAL']?></td>
                <td align="center"><?= $row['FALTA_1B']?></td>
                <td align="center"><?= $row['FALTA_2B']?></td>
                <td align="center"><?= $row['FALTA_3B']?></td>
                <td align="center"><?= $row['FALTA_4B']?></td>
                <td align="center"><?= $row['FALTAS']?></td>
                <td align="center"><?=$perc?></td>
            </tr>
        <? } ?>
</table>