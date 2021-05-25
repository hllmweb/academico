<table width="600px" style="font-size: 12px"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="50" align="center">
        <br/>
        <img src="<?=base_url('assets/images/logo_relatorio.png')?>" />
        <br/>
        <h4>NOVA SOLICITAÇÃO DE RESERVA DE ESPAÇO</h4>
        <br/>
    </td>
  </tr>
</table>
<hr>
<h5>DADOS DA SOLICITAÇÃO</h5>
<table width="600px" style="font-size: 12px"  border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td>RESERVA</td>
        <td><?=$filtro->CD_RESERVA?></td>
    </tr>
    <tr>
        <td>SOLICITANTE</td>
        <td><?=$filtro->NM_USUARIO?></td>
    </tr>
    <tr>
        <td>PROFESSOR</td>
        <td><?=$filtro->CD_PROFESSOR.' - '.$filtro->NM_PROFESSOR?></td>
    </tr>
    <tr>
        <td>DISCIPLINA</td>
        <td><?=$filtro->CD_DISCIPLINA.' - '.$filtro->NM_DISCIPLINA?></td>
    </tr>
    <tr>
        <td>LOCAL</td>
        <td><?=(($filtro->TP_LOCAL == 'L')? 'LABORATÓRIO' : 'ESPAÇO' ).' / '.$filtro->NM_LOCAL?></td>
    </tr>
    <tr>
        <td>DATA</td>
        <td><?=date('d/m/Y',strtotime(implode("-",array_reverse(explode("/",$filtro->DT_PRATICA)))))?></td>
    </tr>
    <tr>
        <td>HORÁRIO</td>
        <td><?=$filtro->HR_INICIO.' até '.$filtro->HR_FINAL?></td>
    </tr>
</table>
<hr>
<h5>O QUE SERÁ FEITO?</h5>
<table width="600px" style="font-size: 12px"  border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            CONTEÚDO A SER MINISTRADO:<br>
            <?=$filtro->CONTEUDO?>
        </td>
    </tr>
    <tr>
        <td>
            OBJETIVO DA AULA:<br>
            <?=$filtro->OBJETIVO?>
        </td>
    </tr>
    <tr>
        <td>
            MATERIAL A SER UTILIZADO:<br>
            <?=$filtro->MATERIAL?>
        </td>
    </tr>
</table>
<hr>
<h5>O QUE O PROFESSOR FEZ?</h5>
<table width="600px" style="font-size: 12px"  border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            MÉTODO QUE FOI UTILIZADO:<br>
            <?=$filtro->METODO?>
        </td>
    </tr>
    <tr>
        <td>
            RESULTADO:<br>
            <?=$filtro->RESULTADO?>
        </td>
    </tr>
    <tr>
        <td>
            OBSERVAÇÕES DA AULA:<br>
            <?=$filtro->OBSERVACAO?>
        </td>
    </tr>
</table>
<br>
<br>
<br>
<br>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <caption style="text-align: right; font-size:8px;"><?=$this->session->userdata('SGP_NOME').' - '.date('d/m/Y h:m:s').' - '.$this->session->userdata('ip_address') ?></caption>
  <tr>
    <td height="80" align="center" bgcolor="#000F07" style="color:#FFF; font-size:11px">
      Av. Coronel Teixeira, Nº 4371 Ponta Negra - CEP: 69030-040, Manaus, Fone: (92) 3211-3953<br />
      E-mail: contato@seculomanaus.com.br | Site: www.seculomanaus.com.br<br />
      Centro Educacional Século - EPP | CNPJ : 18621.830/0001-00</td>
  </tr>
  <tr>
</table>