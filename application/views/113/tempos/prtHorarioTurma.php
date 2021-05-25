<style type="text/css" media="all">
    .cell{
        height: 70px;
    }
    .cell td{
        vertical-align: middle;
        text-align: center;
        cursor: pointer;
        font-size: 10px
    }
    table{
        margin:5px; 
        width:98%;
    }
    table tr{
        height: 25px
    }
    table thead tr td{
        padding: 3px;
        background-color: #999999
    }
    table tbody tr td{
        padding: 2px;
        background-color:#C9DFFF;
        height: 60px
    }
</style>
<table style="width: 100%">
    <caption><strong>HORÁRIOS DA MANHÃ</strong></caption>
    <thead>
        <tr>
            <td>#</td>
            <td>Segunda</td>
            <td>Terça</td>
            <td>Quarta</td>
            <td>Quinta</td>
            <td>Sexta</td>
            <td>Sábado</td>
        </tr>
    </thead>
    <tbody>
        <? for ($i = 1; $i <= 7; $i++) { ?>
            <tr class="cell">
                <td width="4%"><?= $i ?>º</td>
                <? for ($j = 1; $j <= 6; $j++) { ?>
                    <td style="<?=$cor['A'][$j][$i] ?>" width="16%">
                        <?= $manha['A'][$j][$i] ?>
                    </td>
                <? } ?>
            </tr>
        <? } ?>
    </tbody>
</table>
<br/>
<table style="width: 100%">
    <caption><strong>HORÁRIOS DA TARDE</strong></caption>
    <thead>
        <tr style="height: 30px; text-align: center">
            <td>#</td>
            <td>Segunda</td>
            <td>Terça</td>
            <td>Quarta</td>
            <td>Quinta</td>
            <td>Sexta</td>
            <td>Sábado</td>
        </tr>
    </thead>
    <tbody>
        <? for ($i = 1; $i <= 5; $i++) { ?>
            <tr class="cell">
                <td width="4%"><?= $i ?>º</td>
                <? for ($j = 1; $j <= 6; $j++) { ?>
                    <td style="background: <?= $tardecor['B'][$j][$i] ?>"
                        width="16%">
                            <?= $tarde['B'][$j][$i] ?>
                    </td>
                <? } ?>
            </tr>
        <? } ?>
    </tbody>
</table>