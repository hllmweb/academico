<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>
      
    <style>
      .vertical-img,
      .vertical-img p{

      }
      .vertical-img img{
          vertical-align: middle !important;
          color:red !important;
          display:block;
          margin-top:30px;
      }

     
    </style>

    </head>    
    <body>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="5" >
  <tr>
    <td height="100" width="80%" align="left" style="font-family: 'Calibri'; font-size: 12px">
        Curso: <?=$prova[0]['NM_CURSO_RED']?><br/>
        Matrícula: <?=$aluno[0]['CD_ALUNO']?><br/>
        Aluno(a): <?=$aluno[0]['NM_ALUNO']?><br/>
        Sala: <?=$aluno[0]['SALA']?><br/>
        Data: <?=(($prova[0]['DT_PROVA'] != '')? date('d/m/Y',strtotime(implode("-",array_reverse(explode("/",$prova[0]['DT_PROVA']))))):'')?><br/>
        Professor(a): <?=$prova[0]['NM_PROFESSOR']?><br/>
    </td>
    <td width="100px" style="border:1px solid #000;">
       
        <table width="100px" borde="0" >
            <tr  ALIGN="center" style="text-align:center !important; text-transform:uppercase;">
                <td  ALIGN="center" style="font-weight:bold; text-align:center !important; text-transform:uppercase;">Nota</td>
            </tr>
            <tr style="">
                <td height="80px" ></td>
            </tr>
        </table>
        
    </td>

    <td width="100px" style="border:1px solid #000">
        <? $img = $aluno[0]['CD_ALUNO'].$prova[0]['NUM_PROVA'] ?>
        <img id="img" style="margin:0 auto;" height="100" src="<?=base_url('108/impressao/qrcode/'.$img.'')?>" /><br/>

    </td>
    </tr>
    <tr>
    <td height="10" width="80%" align="left" style="font-family: 'Calibri'; font-size: 12px">
        Assinatura do(a) Aluno(a): __________________________________________________________________________
    </td>
    <td></td>
    <td width="10px" align="center" style="font-family: 'Calibri'; font-size: 10px">
        <?=$prova[0]['NUM_PROVA'] ?>
    </td>
  </tr>
</table>
    <h3 ALIGN="center" style="font-family: 'Calibri'; font-size: 14px;" >Caderno de Prova Discursiva</h3> 

    <br><br> 
    <table width="100%" align="center" cellpadding="1" cellspacing="0" style="border: 1px solid #000">
            <tr>
                <td height="20" align="center">
                    <?=strtoupper($prova[0]['TITULO'].'<BR/>'.$prova[0]['DISCIPLINAS'])?>
                </td>
            </tr>
        </table>
        <br/>
        <br/>
        <table width="100%" align="center" cellpadding="1" cellspacing="5" style="border: 1px solid #000; margin-bottom: 60px;">
            <tr>
                <td height="20" align="left" style="font-family: 'Calibri'">
                    <h3>LEIA ATENTAMENTE AS INSTRUÇÕES SEGUINTES:</h3>
                    <br/><br/>
                </td>
            </tr>
            <tr>
                <!-- <td height="20" align="left" style="font-family: 'Arial Narrow'; font-size: 14px"> -->
                <td height="20" style="font-family: 'Calibri'; font-size: 14px; text-align: justify;">
                    <? if($prova[0]['ORDEM_SERIE'] == 6 || $prova[0]['ORDEM_SERIE'] == 7 || $prova[0]['ORDEM_SERIE'] == 8){ ?>
                        <ol style="list-style-type:decimal; text-align: justify; width:100%">
                            <li>Assine sua avaliação no campo acima, antes de iniciar a resolução das questões;</li>
                            <li>Esta avaliação é constituída de 10 (dez) questões discursivas, com valoração de pontos de acordo com a complexidade de cada questão.</li>
                            <li>Sua prova é um documento, sendo assim, não serão aceitos desenhos, símbolos ou outros não pertinentes ou não relacionados às questões da avaliação;</li>
                            <li>Só serão aceitas as questões discursivas respondidas com caneta esferográfica azul ou preta; </li>
                            <li>O tempo para resolução da avaliação será informado pelo aplicador; o aluno poderá ausentar-se da sala após 1 hora e 15 minutos do início da prova; haverá uma comunicação quando faltarem 15 minutos para o término e NÃO SERÁ CONCEDIDO TEMPO EXTRA para a resolução de questões pendentes;</li>
                            <li>Na prova discursiva, o aluno deverá apresentar o desenvolvimento utilizado para a resolução da questão;</li>
                            <li>É PROIBIDO pedir material emprestado, usar líquido corretor, calculadora ou qualquer dispositivo eletrônico de comunicação;</li>
                            <li>PORTAR (mesmo que não consulte) ou USAR meios ilícitos ("cola") são atos considerados TRANSGRESSÕES GRAVES. Nesse caso, o aluno será retirado de sala, terá sua avaliação recolhida e responderá às sanções regulamentares previstas;</li>                           
                            <!-- <li>Nas questões de múltipla escolha, assinale apenas uma alternativa, preenchendo totalmente o espaço correspondente à alternativa correta: <img src="<?php #echo base_url('assets/images/quadrado-preto.jpg')?>" width="15px" height="15px" />;</li> -->
                            <!-- <li>Questões objetivas rasuradas ou com mais de uma alternativa marcada serão anuladas e computadas exclusivamente pelo gabarito (cartão-resposta) e não pelo caderno de provas; </li> -->
                            <li>
                                As questões discursivas deverão ser:
                                <ol style="list-style-type:decimal; text-align: justify">
                                <li>assinadas no cabeçalho;</li>
                                <li>respondidas no caderno específico;</li>
                                <li>respondidas com LETRA LEGÍVEL e SEM RASURAS. Em caso de erro, fará um único traço na(s) palavra(s) a ser(em) desconsiderada(s), (ex: <span style="text-decoration: line-through">retificação</span>) e continuar em seguida; </li>
                                </ol>
                            </li>
                            <li>Após o recebimento da prova o(a) aluno(a), se julgar necessário, poderá, no prazo de 48h, requerer a revisão da sua avaliação na secretaria da escola.</li>
                            <!-- <li>Após o recebimento da prova o (a) aluno (a) se julgar conveniente poderá no prazo de 48h requerer a revisão da sua avaliação na secretaria da escola.</li> -->
                        </ol>
                    <? } else{ ?>
                        <ol style="list-style-type:decimal; text-align: justify; width:100%">
                            <li>Assine sua avaliação no campo acima, antes de iniciar a resolução das questões;</li>
                            <li>Esta avaliação é constituída de 10 (dez) questões discursivas, com valoração de pontos de acordo com a complexidade de cada questão.</li>
                            <li>Sua prova é um documento, sendo assim, não serão aceitos desenhos, símbolos ou outros não pertinentes ou não relacionados às questões da avaliação;</li>
                            <li>Só serão aceitas as questões discursivas respondidas com caneta esferográfica azul ou preta; </li>
                            <li>O tempo para resolução da avaliação será informado pelo aplicador; o aluno poderá ausentar-se da sala após 1 hora e 15 minutos do início da prova; haverá uma comunicação quando faltarem 15 minutos para o término e NÃO SERÁ CONCEDIDO TEMPO EXTRA para a resolução de questões pendentes;</li>
                            <li>Na prova discursiva, o aluno deverá apresentar o desenvolvimento utilizado para a resolução da questão;</li>
                            <li>É PROIBIDO pedir material emprestado, usar líquido corretor, calculadora ou qualquer dispositivo eletrônico de comunicação;</li>
                            <li>PORTAR (mesmo que não consulte) ou USAR meios ilícitos ("cola") são atos considerados TRANSGRESSÕES GRAVES. Nesse caso, o aluno será retirado de sala, terá sua avaliação recolhida e responderá às sanções regulamentares previstas;</li>                           
                            <!-- <li>Nas questões de múltipla escolha, assinale apenas uma alternativa, preenchendo totalmente o espaço correspondente à alternativa correta: <img src="<?php #echo base_url('assets/images/quadrado-preto.jpg')?>" width="15px" height="15px" />;</li> -->
                            <!-- <li>Questões objetivas rasuradas ou com mais de uma alternativa marcada serão anuladas e computadas exclusivamente pelo gabarito (cartão-resposta) e não pelo caderno de provas; </li> -->
                            <li>
                                As questões discursivas deverão ser:
                                <ol style="list-style-type:decimal; text-align: justify;">
                                <li>assinadas no cabeçalho;</li>
                                <li>respondidas no caderno específico;</li>
                                <li>respondidas com LETRA LEGÍVEL e SEM RASURAS. Em caso de erro, fará um único traço na(s) palavra(s) a ser(em) desconsiderada(s), (ex: <span style="text-decoration: line-through">retificação</span>) e continuar em seguida; </li>
                                </ol>
                            </li>
                            <li>Após o recebimento da prova o(a) aluno(a), se julgar conveniente, poderá, no prazo de 48h, requerer a revisão da sua avaliação na secretaria da escola.</li>
                            <!-- <li>Após o recebimento da prova o (a) aluno (a) se julgar conveniente poderá no prazo de 48h requerer a revisão da sua avaliação na secretaria da escola.</li> -->
                                                        
                            <!-- 
                            <li>Assine sua avaliação no campo acima, antes de iniciar a resolução das questões; </li>
                            <li>Esta avaliação consta de 20 (vinte) questões valendo 0,5 cada;</li>
                            <li>Sua prova é um documento, sendo assim, não serão aceitos desenhos, símbolos ou outros não pertinentes às questões da avaliação; </li>
                            <li>Só serão aceitas as questões objetivas respondidas com caneta esferográfica azul ou preta; </li>
                            <li>O tempo para resolução da avaliação será determinado pelo aplicador, o aluno será avisado quando faltar 15 minutos para o término e NÃO SERÁ CEDIDO TEMPO EXTRA para preenchimento do gabarito; </li>
                            <li>Utilize o verso das folhas para rascunho, quando for o caso; </li>
                            <li>É PROIBIDO: pedir material emprestado, usar líquido corretor, calculadora ou qualquer meio eletrônico de comunicação;</li>
                            <li>PORTAR (mesmo que não consulte) ou USAR meios ilícitos ("cola") são considerados TRANSGRESSÕES GRAVES. Neste caso, o aluno será retirado de sala, terá sua avaliação recolhida e responderá às sanções regulamentares previstas;</li>
                            <li>Nas questões de múltipla escolha, assinale apenas uma alternativa, preenchendo totalmente o espaço correspondente à alternativa correta: <img src="<?= base_url('assets/images/quadrado-preto.jpg')?>" width="15px" height="15px" />; </li>
                            <li>Questões objetivas rasuradas ou com mais de uma alternativa marcada serão anuladas e computadas exclusivamente pelo gabarito (cartão-resposta) e não pelo caderno de provas; </li>
                            <li>O enunciado das questões, assim como suas alternativas, poderá ter continuidade na página seguinte;</li>
                            <li>Após o recebimento da prova, o(a) aluno(a), se julgar conveniente, poderá no prazo de 48h requerer a revisão da sua avaliação na secretaria da escola.</li>
                        </ol> -->
                    <? } ?>
                    </div>
                </td>
            </tr>
        </table> 
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>