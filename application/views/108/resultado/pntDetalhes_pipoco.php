            
            <table width="90%" align="center" style="font-size: 14px">
                <tr>
                    <td><?=$listar[0]['CD_TURMA'].' - '.$listar[0]['NM_DISCIPLINA']?></td>
                </tr>
                <tr>
                    <td>Valor por Questão: <?=number_format($listar[0]['VL_QUESTAO'],4,'.','')?></td>
                </tr>
                <tr>
                    <td>Max Objetiva: <?=number_format($listar[0]['NOTA_OBJETIVA'],1,'.','')?></td>
                </tr>
                <tr>
                    <td>Max Discursiva: <?=number_format($listar[0]['NOTA_DISSERTATIVA'],1,'.','')?></td>
                </tr>
            </table>
            
           
            <?php // print_r($listar); ?>
            <hr>
            
            
            
            <table width="90%" align="center" style="font-size: 11px">
                <tr>
                    <td style="border-bottom: 1px solid #000">ALUNO</td>
                    <td style="border-bottom: 1px solid #000">VERSÃO</td>
                    <td style="border-bottom: 1px solid #000">ACERTOS</td>
                    <td style="border-bottom: 1px solid #000">VL QUESTÃO</td>
                    <td style="border-bottom: 1px solid #000">OBJETIVA</td>
                    <td style="border-bottom: 1px solid #000">DISCURSIVA</td>
                    <td style="border-bottom: 1px solid #000">NOTA</td>
                </tr>
                <? 
                
                $nO = number_format($listar[0]['VL_T_OBJETIVA'],1,'.','');
                $nD = number_format($listar[0]['VL_T_DISCURSIVA'],1,'.','');
               foreach($listar as $l){
                ?><!--
                <tr>
                    <td height="20" style="font-size: 11px; border-bottom: 1px solid #000"><?=substr($l['CD_ALUNO'].' - '.$l['NM_ALUNO'],0,50)?></td>
                    <td style="border-bottom:1px solid #000" align="center"><?=$l['CD_PROVA_VERSAO']?></td>
                    <td style="border-bottom: 1px solid #000" align="center"><?=$l['ACERTOS']?></td>
                    <td style="border-bottom: 1px solid #000" align="center"><?='x'.number_format($l['VL_QUESTAO'],4,'.','')?></td>
                    <td style="border-bottom: 1px solid #000" align="center"><?=(($l['P_OBJETIVA'] == '')? '-' : number_format($l['P_OBJETIVA'],1,'.',''))?></td>
                    <td style="border-bottom: 1px solid #000" align="center"><?=(($l['P_DISCURSIVA'] == '')? '-' : number_format($l['P_DISCURSIVA'],1,'.',''))?></td>
                    <td style="border-bottom: 1px solid #000" align="center"><?=(($l['NOTA'] == '')? '-' : number_format($l['NOTA'],1,'.',''))?></td>
                </tr>-->

                  <tr>
                    <td height="20" style="font-size: 11px; border-bottom: 1px solid #000"><?=substr($l['CD_ALUNO'].' - '.$l['NM_ALUNO'],0,50)?></td>
                    <td style="border-bottom:1px solid #000" align="center"><?=$l['CD_PROVA_VERSAO']?></td>
                    <td style="border-bottom: 1px solid #000" align="center"><?=$l['NR_ACERTO']?> / <?=$l['NOTA_OBJETIVA']*2; ?></td>
                     <td style="border-bottom: 1px solid #000" align="center"><?='x'.number_format($l['VALOR_QUESTAO'],4,'.','')?></td>
                    
                    <td style="border-bottom: 1px solid #000" align="center"><?=(($l['NR_NOTA'] == '')? '-' : number_format($l['NR_NOTA'],1,'.',''))?></td>
                    <td style="border-bottom: 1px solid #000" align="center"><?=(($l['NR_NOTA_DISCURSIVA'] == '')? '-' : number_format($l['NR_NOTA_DISCURSIVA'],1,'.',''))?></td>
                    <td style="border-bottom: 1px solid #000" align="center"><?=(($l['NOTA'] == '')? '-' : number_format($l['NOTA'],1,'.',''))?></td>
                </tr>
                <? } ?>
            </table>
          
