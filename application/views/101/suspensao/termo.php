<center>
<table width="90%" style="width:90%"  align=center>
    <tr>
        <td align="center">
            <br><br><br><br>
            <h3>TERMO DE SUSPENSÃO</h3>
            <br><br><br><br>
        </td>
    </tr>
    <tr>
        <td align="left" style="text-align: justify">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            A Direção de Ensino do Centro Educacional Século, de acordo com as normas estabelecidas em 
            Regimento Escolar e Manual do Aluno, registrados no Conselho Estadual de Educação do Amazonas, resolve:<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <strong>Suspender</strong> no período de 
            <strong><?=date('d/m/Y',strtotime(implode("-",array_reverse(explode("/",$dados->DT_INICIO)))))?></strong> a 
            <strong><?=date('d/m/Y',strtotime(implode("-",array_reverse(explode("/",$dados->DT_FIM)))))?></strong> 
             ( <?=number_format($dados->DIAS,0,',','')?> ) dia (s) da (s) atividade (s) escolar (es) o (a) 
            aluno (a) <strong><?=$dados->NM_ALUNO?></strong> – Turma <strong><?=$dados->TURMA_ATUAL?></strong> do (a) <strong><?=$dados->ORDEM_SERIE?>º Ano do <?=$dados->NM_CURSO_RED?></strong>, pelo seguinte motivo: <br>
            <br>
        </td>
    </tr>
    <tr>
        <td style="text-align:left; font-style: italic">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <strong><?=$dados->MOTIVO?></strong>
        </td>
    </tr>
    <tr>
        <td align="left">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            Foi aplicada a suspensão para a correção do (s) ato (s) realizado (s) pelo (a) aluno (a). Caso haja 
            reincidência, a Escola estará adotando outras providências conforme Regimento Interno e legislação vigente. <br>
        </td>
    </tr>
    <tr>
        <td align="center">
            <br><br><br><br><br><br>
            Manaus, <?=date('d',strtotime(implode("-",array_reverse(explode("/",$dados->DT_CADASTRO)))))?>  
                de <? 
                $dt = date('m',strtotime(implode("-",array_reverse(explode("/",$dados->DT_CADASTRO)))));
                switch($dt){
                case 1; echo 'Janeiro'; break;
                case 2; echo 'Fevereiro'; break;
                case 3; echo 'Março'; break;
                case 4; echo 'Abril'; break;
                case 5; echo 'Maio'; break;
                case 6; echo 'Junho'; break;
                case 7; echo 'Julho'; break;
                case 8; echo 'Agosto'; break;
                case 9; echo 'Setembro'; break;
                case 10; echo 'Outubro'; break;
                case 11; echo 'Novembro'; break;
                case 12; echo 'Dezembro'; break;
            }?> de <?=date('Y',strtotime(implode("-",array_reverse(explode("/",$dados->DT_CADASTRO)))))?>
            <br><br><br>
            
            
            
    _______________________________________________________<br><br>
                   Direção de Ensino

        </td>
    </tr>
</table>
    
<br><br><br>    
<hr>
<br><br><br>

<table width="90%" style="width:90%"  align=center>
    <tr>
        <td style="text-align: justify">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;            
            Eu,_______________________________________________________________, 
            responsável pelo (a) aluno (a) <strong><?= $dados->NM_ALUNO?></strong>
            turma <strong><?= $dados->TURMA_ATUAL?></strong> do (a) <strong><?= $dados->ORDEM_SERIE?>º Ano 
            do <?= $dados->NM_CURSO_RED?></strong>, tomei ciência da suspensão de meu (minha) dependente e do (s) motivo (s) 
            que o (a) levaram a ser suspenso no período de 
            <strong><?=date('d/m/Y',strtotime(implode("-",array_reverse(explode("/",$dados->DT_INICIO)))))?></strong> a 
            <strong><?=date('d/m/Y',strtotime(implode("-",array_reverse(explode("/",$dados->DT_FIM)))))?></strong> 
             ( <?=number_format($dados->DIAS,0,',','')?> ) dias. 
        </td>
    </tr>
    <tr>
        <td align="center">
            <br><br>
            Manaus, <?=date('d',strtotime(implode("-",array_reverse(explode("/",$dados->DT_CADASTRO)))))?>  
                de <? 
                $dt = date('m',strtotime(implode("-",array_reverse(explode("/",$dados->DT_CADASTRO)))));
                switch($dt){
                case 1; echo 'Janeiro'; break;
                case 2; echo 'Fevereiro'; break;
                case 3; echo 'Março'; break;
                case 4; echo 'Abril'; break;
                case 5; echo 'Maio'; break;
                case 6; echo 'Junho'; break;
                case 7; echo 'Julho'; break;
                case 8; echo 'Agosto'; break;
                case 9; echo 'Setembro'; break;
                case 10; echo 'Outubro'; break;
                case 11; echo 'Novembro'; break;
                case 12; echo 'Dezembro'; break;
            }?> de <?=date('Y',strtotime(implode("-",array_reverse(explode("/",$dados->DT_CADASTRO)))))?>
            <br><br><br>
            
            
            
    _______________________________________________________<br><br>
                   Assinatura do Responsável

        </td>
    </tr>
</table>
</center>