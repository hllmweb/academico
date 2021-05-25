<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>
    </head>


    
    <body>
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="5" >
            <tr>
                <td height="100" width="80%" align="left" style="font-family: 'Arial Narrow'; font-size: 12px">
                    Curso: <?= $aluno[0]['NM_CURSO'] ?><br/>
                    Matrícula: <?= $aluno[0]['CD_ALUNO'] ?><br/>
                    Aluno(a): <?= $aluno[0]['NM_ALUNO'] ?><br/>
                    Sala: <?= $aluno[0]['SALA'] ?><br/>
                    Data: <?= date('d/m/Y', strtotime(implode("-", array_reverse(explode("/", $aluno[0]['DT_PROVA']))))) ?><br/>
                    Professor(a): <?= $aluno[0]['NM_PROFESSOR'] ?><br/>
                </td>
                <td width="100px" style="border:1px solid #000">
                    <? $img = $aluno[0]['CD_ALUNO'].$aluno[0]['NUM_PROVA'] ?>
                    <img id="img" style="margin:0 auto;" height="100" src="<?= base_url('prova/qrcode/' . $img . '') ?>" /><br/>
                </td>
            </tr>
            <tr>
                <td height="10" width="80%" align="left" style="font-family: 'Arial Narrow'; font-size: 12px">
                    Assinatura do(ª) Aluno(ª): __________________________________________________________________________
                </td>
                <td width="10px" align="center" style="font-family: 'Arial Narrow'; font-size: 10px">
                    <?= $aluno[0]['NUM_PROVA'] ?>
                </td>
            </tr>
        </table>

        <br/>
        <br/><br/>
        <table width="100%" align="center" cellpadding="1" cellspacing="0" style="border: 1px solid #000">
            <tr>
                <td height="20" align="center">
                    <?=strtoupper($prova[0]['TITULO'])?>
                </td>
            </tr>
        </table>
        <br/>
        <br/><br/><br/>
        <table width="100%" align="center" cellpadding="1" cellspacing="5" style="border: 1px solid #000">
            <tr>
                <td height="20" align="left" style="font-family: 'Arial Narrow'; font-size: 14px">
            <!--        <img src="<?= base_url('assets/images/instrucao.png') ?>" />-->
                    
                        <ol style="list-style-type:decimal;">
                            <li>Sua prova é um documento, sendo assim, não serão aceitos desenhos, símbolos ou outros não pertinentes as questões da avaliação.</li>
                            <li>Esta avaliação consta de vinte (20) questões objetivas, valendo (0,3) cada e quatro (4) questões discursivas, valendo (1,0) cada, podendo estas últimas serem subdivididas e cada subdivisão receber pontuação proporcional.</li>
                            <li>Assine sua avaliação no campo acima, antes de iniciar a resolução das questões;</li>
                            <li>Só serão aceitas as questões objetivas e discursivas respondidas com caneta esferográfica azul ou preta;</li>
                            <li>As avaliações são elaboradas de acordo com o tempo estimado para a realização das mesmas, o aluno será avisado quando faltar 15 min para o término do tempo e NÃO SERÁ CEDIDO TEMPO EXTRA para preenchimento de gabarito ou resolução de questões;</li>
                            <li>Utilize o verso das folhas para rascunho, quando for o caso;</li>
                            <li>É PROIBIDO: pedir material emprestado, usar líquido corretor, calculadora ou qualquer meio eletrônico de comunicação;</li>
                            <li>PORTAR (mesmo que não consulte) ou USAR meios ilícitos (cola) são considerados TRANSGRESSÕES GRAVES. Neste caso, o aluno será retirado de sala, terá sua avaliação recolhida e responderá às sanções regulamentares previstas;</li>
                            <li>Nas questões de múltipla escolha, assinale apenas uma alternativa, preenchendo totalmente o espaço correspondente à alternativa correta;<img src="http://www.derly.com.br/wp-content/uploads/2012/05/quadrado-preto.jpg" width="15px" height="15px" /></li>
                            <li>As questões objetivas serão computadas exclusivamente pelo gabarito (cartão resposta) e não pelo caderno de provas.</li>
                            <li>Questões objetivas rasuradas ou com mais de uma alternativa marcada serão anuladas;</li>
                            <li>As questões discursivas deverão ser:</li>
                            <ol style="list-style-type:lower-alpha;">
                                <li>respondidas no caderno específico;</li>
                                <li>assinada no cabeçalho;</li>
                                <li>respondidas com letra legível e sem rasura. Em caso de erro, fará um único risco, ex: <strike> retificação. </strike></li>
                            </ol>
                            <li>Após o recebimento da prova o (a) aluno (a) se julgar conveniente poderá no prazo de 48h requerer a revisão da sua avaliação na secretária da escola.</li>
                            <li>O enunciado das questões, assim como suas alternativas, poderão ter continuidade na página seguinte. Leia com atenção.</li>
                        </ol>
                    </div>
                </td>
            </tr>
        </table>

        <?  //exit();?>