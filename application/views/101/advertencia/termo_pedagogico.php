<center>    
<table width="90%" style="width:90%"  align=center>
    <tr>
        <td align="center">
            <br><br><br><br>
            <h3>REGISTRO DE ADVERTÊNCIA PEDAGÓGICA</h3>
            <br><br><br><br>
        </td>
    </tr>
    <tr>
        <td  style="text-align: justify">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            A Direção de Ensino do Centro Educacional Século, de acordo com as normas estabelecidas 
            em Regimento Escolar e Manual do Aluno, registrados no Conselho Estadual de Educação do 
            Amazonas, resolve: <br><br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <strong>Advertir</strong> o (a) aluno (a) <strong><?=$dados->NM_ALUNO?></strong> da turma <strong><?=$dados->TURMA_ATUAL?> </strong>
            por não estar cumprindo com as normas disciplinares e orientações quanto aos estudos, 
            estando no bimestre vigente, até a presente data, com (________) Registros Pedagógicos, 
            referentes ao seu comportamento e não cumprimento com as atividades propostas, comprometendo 
            desta forma seu rendimento escolar. <br><br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            Foi aplicada a advertência para a correção do (s) ato (s) realizado (s) pelo (a) aluno (a). 
            Caso haja reincidência, a Escola estará adotando outras providências conforme Regimento 
            Interno e legislação vigente. 
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
                   Direção de Ensino

        </td>
    </tr>
</table>
<pagebreak page-break-type="clonebycss" />
<br><br><br>    

<br><br><br>
<table width="90%" style="width:90%"  align=center>
    <tr>
        <td style="text-align: justify">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            Eu,_______________________________________________________________, 
            responsável pelo (a) aluno (a) <strong><?=$dados->NM_ALUNO?></strong>
            da turma <strong><?=$dados->TURMA_ATUAL?></strong>/série <strong><?= $dados->ORDEM_SERIE?></strong>º, estou ciente do número de Registros Pedagógicos 
            do meu(a) dependente e que está sendo advertido(a) por não estar 
            cumprindo com as normas disciplinares e orientações quanto aos 
            estudos e me comprometo a acompanhá-lo(a) para apoiar sua mudança de postura.
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