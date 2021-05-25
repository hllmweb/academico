
<table style="font-size:10px; width:96%" align="center" >
    <tr>
        <td colspan="5" height="30px" style="background: #BBB" align="center">
            <h5>RELAÇÃO DE ANIVERSÁRIANTES - MÊS <?=$mes?></h5>
        </td>
    </tr>
    <tr>
        <td height="30px" style="background: #BBB" align="center"><strong>ANIVERSÁRIO</strong></td>
        <td height="30px" style="background: #BBB"><strong>FUNCIONÁRIO</strong></td>
        <td height="30px" style="background: #BBB"><strong>FUNÇÃO</strong></td>
        <td height="30px" style="background: #BBB"><strong>TELEFONE</strong></td>
        <td height="30px" style="background: #BBB"><strong>EMAIL</strong></td>
    </tr>
    <?
    foreach ($listar as $row) {
        ?>
        <tr>
            <td style="border-bottom:1px solid #000" align="center" width="20px"><?= $row['DT_ANIVERSARIO'] ?></td>
            <td style="border-bottom:1px solid #000"><?= $row['NM_PESSOA'] ?></td>
            <td style="border-bottom:1px solid #000"><?= $row['NM_FUNCAO'] ?></td>
            <td style="border-bottom:1px solid #000"><?= $row['TELEFONE'] ?></td>
            <td style="border-bottom:1px solid #000"><?= $row['EMAIL'] ?></td>
        </tr>
    <? }  ?>
</table>