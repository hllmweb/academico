<center>    
    <table width="90%" style="width:90%"  align=center>
        <tr>
            <td align="center">
                <br><br>
                <h3>REGISTRO DE ATENDIMENTO</h3>
                <br><br><br><br>
            </td>
        </tr>
        <tr>
            <td  style="text-align: justify;">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                A Coordenação do Centro Educacional Século, realizou o atendimento ao responsável 
                <strong><?= $dados->NM_RESPONSAVEL ?></strong> do(a) aluno(a) 
                <strong><?= $dados->NM_ALUNO ?></strong> da turma <strong><?= $dados->TURMA_ATUAL ?></strong><br/>
                do <strong><?= $dados->ORDEM_SERIE ?>º Ano do <?= $dados->NM_CURSO ?></strong> 
                quanto ao seguinte assunto:                
                <br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;            
            </td>
        </tr>        
        <tr>
            <td style="text-align:justify; font-style: italic">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <strong><?= $dados->DS_ATENDIMENTO ?></strong>                
            </td>
        </tr>
        <tr>
            <td  style="text-align: justify;">
                <br><br>
                Ressaltando as seguintes observações:                
            </td>
        </tr>        
        <tr>        
            <td style="text-align:justify; font-style: italic">
                <br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <strong><?= $dados->DS_OBSERVACAO == null ? "Nenhuma observação foi registrada." : $dados->DS_OBSERVACAO ?></strong>
            </td>
        </tr>    
        <tr>
            <td style="text-align: left; font-weight: bold">
                <br><br><br>
                Continuamos à disposição!
            </td>
        </tr>
        <tr>
            <td align="center">
                <br><br><br>
                Manaus, <?= date('d', strtotime($dados->DT_ATENDIMENTO)) ?>  
                de <?
                $dt = date('m', strtotime($dados->DT_ATENDIMENTO));
                switch ($dt) {
                    case 1;
                        echo 'Janeiro';
                        break;
                    case 2;
                        echo 'Fevereiro';
                        break;
                    case 3;
                        echo 'Março';
                        break;
                    case 4;
                        echo 'Abril';
                        break;
                    case 5;
                        echo 'Maio';
                        break;
                    case 6;
                        echo 'Junho';
                        break;
                    case 7;
                        echo 'Julho';
                        break;
                    case 8;
                        echo 'Agosto';
                        break;
                    case 9;
                        echo 'Setembro';
                        break;
                    case 10;
                        echo 'Outubro';
                        break;
                    case 11;
                        echo 'Novembro';
                        break;
                    case 12;
                        echo 'Dezembro';
                        break;
                }
                ?> de <?= date('Y', strtotime($dados->DT_ATENDIMENTO)) ?>
                <br><br><br>



                _______________________________________________________<br><br>
                Coordenação de Ensino
            </td>
        </tr>
        <tr>
            <td align="center">                
                <br><br><br>



                _______________________________________________________<br><br>
                Assinatura do Responsável

            </td>
        </tr>    
    </table>
</center>