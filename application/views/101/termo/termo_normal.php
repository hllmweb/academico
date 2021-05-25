<center>
<table width="90%" style="width:90%"  align=center>
    <tr>
        <td align="center">
            <br><br><br><br>
            <h3>TERMO DE COMPROMISSO DE ACOMPANHAMENTO FAMILIAR</h3>
            <br><br><br><br>
        </td>
    </tr>
    <tr>
        <td  style="text-align: justify">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            Eu, <strong><?=$dados->NM_RESPONSAVEL?></strong>, portador (a) do CPF: <strong><?=$dados->CPF_RESPONSAVEL?></strong>, 
            Responsável pelo Aluno (a) <strong><?=$dados->NM_ALUNO?></strong>, matriculado(a) no <strong><?=$dados->ORDEM_SERIE?>º ano do <?=$dados->NM_CURSO?></strong>, estou ciente 
            das dificuldades apresentadas por meu(a) dependente e das ações desenvolvidas pela escola para 
            apoiá-lo(a) em sua aprendizagem, tendo conhecimento que o(a) mesmo(a) necessita de maior apoio 
            familiar.<br><br>
            
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            Assumo o compromisso junto a Escola de acompanhar o desenvolvimento acadêmico de meu(a) dependente 
            e me responsabilizo pelo acompanhamento em casa quanto ao processo de aprendizagem, possibilitando 
            todo apoio necessário fora da escola, em conformidade ao seu caso, para que o mesmo acompanhe as 
            atividades escolares estabelecidas.<br><br>
            
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            Tenho ciência que já fui convocado (a) anteriormente para conhecimento do rendimento escolar do 
            meu dependente e caso o (a) aluno (a) não obtenha o acompanhamento necessário para o resultado 
            do bimestre em curso, em consequência do ano letivo, poderá não ser satisfatório.
        </td>
    </tr>
    <tr>
        <td align="center">
            <br><br><br><br><br><br>
            Manaus, <?=date('d',strtotime(implode("-",array_reverse(explode("/",$dados->DT_EMISSAO)))))?>  
                de <? 
                $dt = date('m',strtotime(implode("-",array_reverse(explode("/",$dados->DT_EMISSAO)))));
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
            }?> de <?=date('Y',strtotime(implode("-",array_reverse(explode("/",$dados->DT_EMISSAO)))))?>
            <br><br><br>
            
            
            
    _______________________________________________________<br><br>
                   Assinatura do(a) Responsável

        </td>
    </tr>
</table> 
    
</center>