<table class="display table table-hover" id="tblGrid">
        <? 
        $al = '';
        foreach ($lista as $row) { 
            if($row['COMPOSTO'] != 1){
                
            if($al != $row['CD_ALUNO']){
                $al = $row['CD_ALUNO'];
            ?>
            
            <thead>
                <tr class="panel-footer">
                    <td colspan="8">
                        <strong><?= $row['CD_ALUNO'].' - '.$row['NM_ALUNO']?></strong>
                    </td>
                </tr>
                <tr class="panel-footer">
                    <td><strong>DISCIPLINA</strong></td>
                    <td align="center"><strong>GRADE</strong></td>
                    <td align="center"><strong>FALTA 1B</strong></td>
                    <td align="center"><strong>FALTA 2B</strong></td>
                    <td align="center"><strong>FALTA 3B</strong></td>
                    <td align="center"><strong>FALTA 4B</strong></td>
                    <td align="center"><strong>FALTAS</strong></td>
                    <td align="center"><strong>%</strong></td>
                </tr>
            </thead>
            </tbody>
            <? }
            
            $perc = number_format((($row['FALTAS'] * 100)/$row['CH_TOTAL']),1,'.','');
            
            ?>
            <tr class="bg-<?=(($perc >= 15.0)? 'danger' : 'success' )?>">
                <td><?= $row['NM_DISCIPLINA']?></td>
                <td align="center"><?= $row['CH_TOTAL']?></td>
                <td align="center"><?= $row['FALTA_1B']?></td>
                <td align="center"><?= $row['FALTA_2B']?></td>
                <td align="center"><?= $row['FALTA_3B']?></td>
                <td align="center"><?= $row['FALTA_4B']?></td>
                <td align="center"><?= $row['FALTAS']?></td>
                <td align="center"><?=$perc?></td>
            </tr>
        <? }} ?>
    </tbody>
</table>
<script src="<?=base_url('assets/js/jquery.min.js')?>"></script>
<script src="<?=base_url('assets/js/bootstrap.min.js')?>"></script>