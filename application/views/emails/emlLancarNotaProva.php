<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="50" align="center">
        <br/><br/>
        <img src="<?=base_url('assets/images/logo_relatorio.png')?>" />
        <br/><br/>
    </td>
  </tr>
</table>

<table width="100%" style="font-size:10px" cellpadding="2" cellspacing="0">
    <tr>
        <td width="15%">PROFº(ª)</td>
        <td align="left"><?= $this->session->userdata('SGP_NOME') ?></td>
    </tr>
    <tr>
        <td>PROVA:</td>
        <td align="left"><?= $prova[0]['NUM_PROVA'] ?></td>
    </tr>
    <tr>
        <td>CURSO:</td>
        <td align="left"><?= $prova[0]['NM_CURSO'] ?></td>
    </tr>
    <tr>
        <td>SÉRIE:</td>
        <td align="left"><?= $prova[0]['NM_SERIE'] ?></td>
    </tr>
    <tr>
        <td>DISCIPLINA:</td>
        <td align="left"><?= $prova[0]['DISCIPLINAS'] ?></td>
    </tr>
    <tr>
        <td>BIMESTRE:</td>
        <td align="left"><?= $prova[0]['BIMESTRE'] ?></td>
    </tr>
    <tr>
        <td>NOTA:</td>
        <td align="left"><?= $prova[0]['NM_MINI'] ?></td>
    </tr>
    <tr>
        <td>TURMA:</td>
        <td align="left"><?= $this->session->userdata('SGP_TURMA') ?></td>
    </tr>
    <tr>
        <td>DATA:</td>
        <td align="left"><?= date('d/m/Y h:m:s') ?></td>
    </tr>
</table>


<br>Notas Lançadas<br>
<table border="1" width="100%" style="font-size:10px" cellpadding="5" cellspacing="0">
    <tr>
        <td>ALUNO</td>
        <td align="center">OBJETIVA</td>
        <td align="center">DISSERTATIVA</td>
        <td align="center">TOTAL</td>
        <td align="center">PROCESSADA?</td>
    </tr>
    <?
    foreach ($lista as $l) {
        echo '<tr>';
        echo '<td>' . $l['NM_ALUNO'] . '</td>';
        echo '<td align="center">' . number_format($l['TOTAL_PONTOS'],2,'.','') . '</td>';
        echo '<td align="center">' . number_format($l['TOTAL_PONTOS_DISSERTATIVAS'],2,'.','') . '</td>';
        echo '<td align="center">' . number_format($l['TOTAL_SISTEMA'],2,'.',''). '</td>';
        echo '<td align="center">' . (($l['TOTAL_SISTEMA'] != '') ? 'SIM' : 'NÃO') . '</td>';
        echo '</tr>';
    }
    ?>
</table>
<br/><br/><br/><br/>
<i>IMPORTANTE<br/>
Esse email faz parte de um sistema integrado e não deve ser respondido.<br/><br/>

Atenciosamente<br/>
Tecnologia da Informação</i>