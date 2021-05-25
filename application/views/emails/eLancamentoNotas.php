$mensagem = 'Olá, venho informar que o Profº(ª) '.$this->session->userdata('SGP_NOME').' realizou 
                        '.$retorno.'';
        $mensagem .= '<br>Relatório de Lançamento de Notas<br>';
        $mensagem .= '<table border="1" width="100%" style="font-size:10px" cellpadding="5" cellspacing="0">';
        $mensagem .= '<tr>';
        $mensagem .= '<td>ALUNO</td>';
        $mensagem .= '<td align="center">OBJETIVA</td>';
        $mensagem .= '<td align="center">DISSERTATIVA</td>';
        $mensagem .= '<td align="center">TOTAL</td>';
        $mensagem .= '<td align="center">SITUAÇÃO</td>';
        $mensagem .= '</tr>';
        
        foreach($lista as $l){
            $mensagem .= '<tr>';
            $mensagem .= '<td>'.$l['NM_ALUNO'].'</td>';
            $mensagem .= '<td align="center">'.$l['TOTAL_PONTOS'].'</td>';
            $mensagem .= '<td align="center">'.$l['TOTAL_PONTOS_DISSERTATIVAS'].'</td>';
            $mensagem .= '<td align="center">'.$l['NOTA_LANCADA'].'</td>';
            $mensagem .= '<td align="center">'.(($l['NOTA_LANCADA'] != '')? 'PROCESSADA' : 'NÃO PROCESSADA').'</td>';
            $mensagem .= '</tr>';
        }
        $mensagem .= '</table>';
        
        
        $mensagem .= '<br/><br/><br/><br/>
                      IMPORTANTE<br/>
                      Esse email faz parte de um sistema integrado e não deve ser respondido.<br/><br/>

                      Atenciosamente<br/>
                      Tecnologia da Informação';