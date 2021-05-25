<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>
        
    </head>   
    <body>
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="5" >
            <tr>
                <td height="100" width="80%" align="left" style="font-family: 'Calibri'; font-size: 12px">
                    Curso: <?= $prova[0]['NM_CURSO_RED'] ?><br/>
                    Matrícula: <?= $aluno[0]['CD_ALUNO'] ?><br/>
                    Aluno(a): <?= $aluno[0]['NM_ALUNO'] ?><br/>
                    Sala: <?= $aluno[0]['SALA'] ?><br/>
                    Data: <?=(($prova[0]['DT_PROVA'] != '')? date('d/m/Y',strtotime(implode("-",array_reverse(explode("/",$prova[0]['DT_PROVA']))))):'')?><br/>
                    Professor(a): <?= $prova[0]['NM_PROFESSOR'] ?><br/>
                </td>
                <td width="100px" style="border:1px solid #000">
                    <? $img = $aluno[0]['CD_ALUNO'].$prova[0]['NUM_PROVA'] ?>
                    <img id="img" style="margin:0 auto;" height="100" src="<?= base_url('108/impressao/qrcode/' . $img . '') ?>" /><br/>
                </td>
            </tr>
            <tr>
                <td height="10" width="80%" align="left" style="font-family: 'Calibri'; font-size: 12px">
                    Assinatura do(a) Aluno(a): __________________________________________________________________________
                </td>
                <td width="10px" align="center" style="font-family: 'Calibri'; font-size: 10px">
                    <?= $prova[0]['NUM_PROVA'] ?>
                </td>
            </tr>
        </table>
        <h3 ALIGN="center" style="font-family: 'Calibri'; font-size: 14px;" >Caderno de Prova Objetiva</h3> 

        <br><br> 
        <table width="100%" align="center" cellpadding="1" cellspacing="0" style="border: 1px solid #000">
            <tr>
                <td height="20" align="center" style="font-family: 'Calibri';">
                    <?=strtoupper($prova[0]['TITULO'].'<BR/>'.$prova[0]['DISCIPLINAS'])?>
                </td>
            </tr>
        </table>
        <br/>
        <br/>
        <table width="100%" align="center" cellpadding="1" cellspacing="5" style="border: 1px solid #000">
            <tr>
                <td height="20" align="left" style="font-family: 'Calibri'">
                    <h3>LEIA ATENTAMENTE AS INSTRUÇÕES SEGUINTES:</h3>
                    <br/><br/>
                </td>
            </tr>
            <tr>
                <!-- <td height="20" align="left" style="font-family: 'Arial Narrow'; font-size: 14px"> -->
                <td height="20" style="font-family: 'Calibri'; font-size: 14px; text-align: justify; padding-bottom:10px; ">
                    <? #if($prova[0]['ORDEM_SERIE'] == 6 || $prova[0]['ORDEM_SERIE'] == 7 || $prova[0]['ORDEM_SERIE'] == 8){ ?>
                        <ol style="list-style-type:decimal; text-align: justify; width:100%">
                            <li>Confira seu nome e número de matrícula antes de iniciar a resolução das questões; </li>
                            <li>Esta avaliação é constituída de 20 (vinte) questões objetivas com valoração de pontos de acordo com a complexidade de cada questão;</li>
                            <li>O tempo para resolução da avaliação será demonstrado no sistema; haverá uma comunicação quando faltarem 15 minutos para o término e NÃO SERÁ CONCEDIDO TEMPO EXTRA para a finalização de eventuais pendências.</li>
                            <li>Utilize a folha de rascunho, quando necessário;  </li>
                            <li>É PROIBIDO pedir material emprestado como calculadora ou qualquer dispositivo eletrônico de comunicação; </li>
                            <li>PORTAR (mesmo que não consulte) ou USAR meios ilícitos (“cola”) são atos considerados TRANSGRESSÕES GRAVES. Nesse caso, o aluno será retirado da sala, terá sua avaliação encerrada e responderá às sanções regulamentares previstas;</li>
                            <li>Ao finalizar a avaliação, o aluno terá acesso ao resultado correspondente ao seu desempenho;</li>
                            <li>O download da avaliação estará disponível após 1h do término da avaliação;</li>
                            <li>Após a divulgação do gabarito no portal, o(a) aluno(a), se julgar conveniente, poderá, no prazo de 48h, requerer a revisão da sua avaliação na secretaria da escola.</li>
                            <li>Para as avaliações no ensino remoto, o(a) aluno(a) deverá realizar a prova acessando por meio de um computador ou chrome, pois o  uso do celular é proibido e, para que a avaliação seja validada, é necessária a ativação da câmera para o acompanhamento, monitoramento e auxílio do professor. </li>
                            <br><br>
                            <br><br>
                            <br><br>
                            <!-- <li>Nas questões de múltipla escolha, assinale apenas uma alternativa, preenchendo totalmente o espaço correspondente à alternativa correta: <img src="<?php #echo base_url('assets/images/quadrado-preto.jpg')?>" width="15px" height="15px" />;</li> -->
                            <!-- <li>Questões objetivas rasuradas ou com mais de uma alternativa marcada serão anuladas e computadas exclusivamente pelo gabarito (cartão-resposta) e não pelo caderno de provas; </li> -->
                            <!-- <li>
                                As questões discursivas deverão ser:
                                <ol style="list-style-type:decimal; text-align: justify">
                                <li>assinada no cabeçalho;</li>
                                <li>respondidas no caderno específico;</li>
                                <li>respondidas com LETRA LEGÍVEL e SEM RASURAS. Em caso de erro, fará um únicorisco, (ex: <span style="text-decoration: line-through">retificação</span>) e continuar em seguida; </li>
                                </ol>
                            </li>
                            <li>Após o recebimento da prova o(a) aluno(a), se julgar conveniente, poderá no prazo de 48h requerer a revisão da sua avaliação na secretaria da escola;</li> -->
                            <!-- <li>Após o recebimento da prova o (a) aluno (a) se julgar conveniente poderá no prazo de 48h requerer a revisão da sua avaliação na secretaria da escola.</li> -->
                        </ol>
                    <?# } else{ ?>
                        <!-- <ol style="list-style-type:decimal; text-align: justify; width:100%">
                            <li>Assine sua avaliação no campo acima, antes de iniciar a resolução das questões; </li>
                            <li>Esta avaliação consta de 10 (dez) questões discursivas, com valoração de pontos de acordo com a especificidade de cada questão;</li>
                            <li>Sua prova é um documento, sendo assim, não serão aceitos desenhos, símbolos ou outros não pertinentes às questões da avaliação; </li>
                            <li>Só serão aceitas as questões discursivas respondidas com caneta esferográfica azul ou preta; </li>
                            <li>O tempo para resolução da avaliação será informado pelo aplicador, o aluno poderá ausentar-se de sala após 1hora e 15 minutos, sendoavisado quando faltar 15 minutos para o término e NÃO SERÁ CEDIDO TEMPO EXTRA para preenchimento da resolução de questões; </li>
                            <li>O aluno deverá apresentar na prova discursiva, o desenvolvimento utilizado para a resolução da questão; </li>
                            <li>É PROIBIDO: pedir material emprestado, usar líquido corretor, calculadora ou qualquer meio eletrônico de comunicação;</li>
                            <li>PORTAR (mesmo que não consulte) ou USAR meios ilícitos ("cola") são considerados TRANSGRESSÕES GRAVES. Neste caso, o aluno será retirado de sala, terá sua avaliação recolhida e responderá às sanções regulamentares previstas;</li>
                            <li>
                                As questões discursivas deverão ser:
                                <ol style="list-style-type:decimal; text-align: justify">
                                <li>assinada no cabeçalho;</li>
                                <li>respondidas no caderno específico;</li>
                                <li>respondidas com LETRA LEGÍVEL e SEM RASURAS. Em caso de erro, fará um únicorisco, (ex: <span style="text-decoration: line-through">retificação</span>) e continuar em seguida; </li>
                                </ol>
                            </li>
                            <li>Após o recebimento da prova o(a) aluno(a), se julgar conveniente, poderá no prazo de 48h requerer a revisão da sua avaliação na secretaria da escola;</li>
                                                         -->
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
                    <? #} ?>
                    </div>
                </td>
            </tr>
        </table> 
        
        <?  #exit();?>