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
        <td style="text-align: justify">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            Eu, <?=$dados->NM_RESPONSAVEL?> , portador (a) do RG: <?=$dados->RG_RESPONSAVEL?>, 
            Responsável pelo Aluno (a) <?=$dados->NM_ALUNO?>, matriculado no <?=$dados->ORDEM_SERIE?>º ano 
            do <?=$dados->NM_CURSO_RED?>, estou ciente das dificuldades apresentadas por meu(a) 
            dependente e das ações desenvolvidas pela escola para apoiá-lo(a) em sua aprendizagem, 
            tendo conhecimento que o(a) mesmo(a) necessita de maior apoio familiar.
            Assumo o compromisso junto a Escola de acompanhar o desenvolvimento acadêmico de meu (a) dependente 
            e me responsabilizo pelo apoio em casa quanto ao processo de aprendizagem, com atividades extras indicadas 
            pela escola e/ou com o apoio de profissionais indicados, conforme suas necessidades, possibilitando todo 
            apoio necessário fora da escola, em conformidade ao seu caso, para que o mesmo acompanhe as atividades 
            escolares estabelecidas.<br><br><br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            Comprometo-me também a apresentar no prazo de 30 dias o relatório de acompanhamento dos profissionais que atendem 
            meu dependente de acordo com as orientações apresentadas em seu laudo médico.
            Tenho ciência que se o (a) aluno (a) não tiver o acompanhamento necessário o resultado do bimestre em curso, em consequência 
            do ano letivo, poderá não ser satisfatório.
            <br><br><br>
        </td>
    </tr>
    <tr>
        <td align="center">
            <br><br><br>
            Manaus, <?=date('d')?>  de <? switch(date('m')){
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
            }?> de <?=date('Y')?><br><br><br>
     ________________________________________________________<br><br>
                   Assinatura do(a) Responsável

        </td>
    </tr>
</table>
</center>