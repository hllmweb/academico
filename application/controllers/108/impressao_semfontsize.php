<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Impressao extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('cadastro_model', 'cadastro', TRUE);
        $this->load->model('prova_model', 'banco', TRUE);

        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'session', 'prova_lib'));
    }

    function qrcode($id) {
        include_once APPPATH . '/third_party/qrcode/qrlib.php';
        ob_start("callback");
        // here DB request or some processing 
        $codeText = $id;
        // end of processing here 
        $debugLog = ob_get_contents();
        ob_end_clean();
        //echo '&block;';
        // outputs image directly into browser, as PNG stream 
        QRcode::png($codeText);
        ob_start("callback");
    }

    function index() {

        clearstatcache();


        $new = new Prova_lib();
        $params = array(
            'prova' => $this->input->get_post('id'),
            'aluno' => $this->input->get_post('aluno')
        );

        if ($this->input->get_post('aluno') != '') {
            $aluno = $this->banco->cabecalho($params);
        }

        $prova_re = $this->banco->banco_prova(array('operacao' => 'VFC', 'prova' => $this->input->get_post('id')));

        if ($prova_re[0]['CD_TIPO_PROVA'] == 1 || $prova_re[0]['CD_TIPO_PROVA'] == 5) {
            redirect('108/impressao/simulado?id=' . $this->input->get_post('id') . '&aluno=' . $this->input->get_post('aluno') . '', 'refresh');
        }

        $lista = $this->banco->prova_questao(array('operacao' => 'FK', 'prova' => $this->input->get_post('id')));
        $prova_atual = $this->banco->banco_prova(array('operacao' => 'FC', 'codigo' => $this->input->get_post('id')));
        
        $data = array(
            'aluno' => $aluno,
            'prova' => $prova_re,
            'listar' => $lista,
        );

        $objetiva .= '<div style="border-right:1px solid #999; padding: 0px 15px 0px 0px; margin:0px; min-height:100%; bottom:0px">';

        foreach ($data['listar'] as $row) {
         if(!in_array($row['CD_QUESTAO'],$ids)){
            if ($row['FLG_TIPO'] == 'O') {
                // ENUNCIADO DA QUESTÃO
                $objetiva .= '<strong>' . $row['POSICAO'] . ') ' . $new->formata_texto_com_richtext($row['DC_QUESTAO']) . '</strong><br/>';

                // VRIFICA SE É UMA PROVA ORIGINAL OU UMA VERSÃO
                if ($prova_re[0]['CD_PROVA_PAI'] == '') {
                    // ALTERNATIVAS DA QUESTÃO
                    $opcao = $this->cadastro->questao_resposta(array('operacao' => 'FK', 'questao' => $row['CD_QUESTAO']));
                } else {
                    // ALTERNATIVAS DA QUESTÃO DE VERSÕES
                    $opcao = $this->cadastro->questao_resposta(array('operacao' => 'FKV', 'questao' => $row['CD_QUESTAO'], 'prova' => $this->input->get_post('id')));
                }

                $opcao1 = $new->formata_texto_com_richtext_alternativa($opcao[0]['DC_OPCAO']);
                $opcao2 = $new->formata_texto_com_richtext_alternativa($opcao[1]['DC_OPCAO']);
                $opcao3 = $new->formata_texto_com_richtext_alternativa($opcao[2]['DC_OPCAO']);
                $opcao4 = $new->formata_texto_com_richtext_alternativa($opcao[3]['DC_OPCAO']);
                $opcao5 = $new->formata_texto_com_richtext_alternativa($opcao[4]['DC_OPCAO']);

                $objetiva .= '<table style="margin-top:5px">';
                $objetiva .= '<tr><td valign="top">A)</td><td style="text-align:justify">' . $opcao1 . '</td></tr>';
                $objetiva .= '<tr><td valign="top">B)</td><td style="text-align:justify">' . $opcao2 . '</td></tr>';
                $objetiva .= '<tr><td valign="top">C)</td><td style="text-align:justify">' . $opcao3 . '</td></tr>';
                $objetiva .= '<tr><td valign="top">D)</td><td style="text-align:justify">' . $opcao4 . '</td></tr>';
                $objetiva .= '<tr><td valign="top">E)</td><td style="text-align:justify">' . $opcao5 . '</td></tr>';
                $objetiva .= '</table>';
                // sleep(1);
                // usleep(250000);

                if ($row['POSICAO'] != 20) {
                    $objetiva .= '<br/>';
                }
                if ($row['QTD_ESPACO'] > 0) {
                    for ($i = 0; $i <= $row['QTD_ESPACO']; $i++) {
                        $objetiva .= "<br/>";
                    }
                }
                 $ids[] = $row['CD_QUESTAO'];
            }}
        }
        $objetiva .= '</div>';


        // echo $objetiva;

        // exit();


        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF('', 'A4', 10, 'Arial Narrow');

        $mpdf->debug = false;
        $mpdf->allow_output_buffering = false;
        // $mpdf->showImageErrors = true;


        $mpdf->list_indent_first_level = 0;
        $mpdf->max_colH_correction = 1.1;

        /* PÁGINA DE ROSTO :: INICIO */

        $mpdf->SetHTMLHeader($this->load->view('108/impressao/header', $data, true));
        $mpdf->AddPage('P', // L - landscape, P - portrait
                'A4', '', '', '', 10, // margin_left
                10, // margin right
                30, // margin top
                30, // margin bottom
                0, // margin header
                5); // margin footer        
        /* GERA O QRCODE */

        //$qr = $this->load->view('prova/qrcode', array('codigo'=>$data['listar'][0]['NUM_PROVA']), true);
        //$mpdf->WriteHTML($qr);
        /* GERA O CABEÇALHO DA PROVA */
        
        
        $cabeca = $this->load->view('108/impressao/cabecalho', $data, TRUE);
        $mpdf->WriteHTML($cabeca);

        /* INCLUI O RODAPÉ DA PROVA */
        $mpdf->SetHTMLFooter($this->load->view('108/impressao/footer', $data, true));
        /* PÁGINA DE ROSTO :: FINAL */

        $mpdf->SetHTMLHeader($this->load->view('108/impressao/header', $data, true));
        $mpdf->AddPage('P', // L - landscape, P - portrait
                'A4', '', '', '', 10, // margin_left
                10, // margin right
                30, // margin top
                29, // margin bottom
                0, // margin header
                5); // margin footer
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHTMLFooter($this->load->view('108/impressao/footer', $data, true));

        $mpdf->SetDefaultBodyCSS('line-height', 1.5);
        $mpdf->SetDefaultBodyCSS('text-align', 'justify');
        $mpdf->SetColumns(2, 'J');

        $mpdf->WriteHTML($objetiva);
        //$mpdf->Output('PROVA_'.$this->input->get_post('id').'_'.$this->input->get_post('aluno').'.pdf','I');
        $mpdf->Output('PROVA_' . $this->input->get_post('id') . '.pdf', 'I');
    }

    function discursiva() {

        clearstatcache();


        $new = new Prova_lib();

        $params = array(
            'prova' => $this->input->get_post('id'),
            'aluno' => $this->input->get_post('aluno')
        );

        $prova_re = $this->banco->banco_prova(array('operacao' => 'VFC', 'prova' => $this->input->get_post('id')));

        if ($this->input->get_post('aluno') != '') {
            $aluno = $this->banco->cabecalho($params);
        }

        $data = array(
            'aluno' => $aluno,
            'prova' => $prova_re,
            'listar' => $this->banco->prova_questao(array('operacao' => 'FK', 'prova' => $this->input->get_post('id'))),
        );

        $discursiva = $this->load->view('108/impressao/D_cabecalho', $data, TRUE);



        $i = 0;
        foreach ($data['listar'] as $row) {

            if ($row['FLG_TIPO'] == 'D') {
                if ($i <> 0) {
                    $questao .= '<pagebreak type="ADD-EVEN" resetpagenum="" pagenumstyle="1" suppress="off" />';
                }
                $questao .= '<div style="font-family: Arial Narrow; font-size: 12px; padding: 0px 15px 0px 0px; text-align:justify">';
                $questao .= '<strong>' . $row['POSICAO'] . ') ' . $new->formata_texto_com_richtext($row['DC_QUESTAO']) . '</strong><br/>';
                // VERIFICA SE EXISTE UM RODAPE
                //if($row['DC_QUESTAO_RODAPE'] !=  ''){
                //    $questao .= '<div style="text-align: right; color: #0075b0; font-size:8px">Fonte: '.($row['DC_QUESTAO_RODAPE']).'</div><br/>';
                // }
                $questao .= '<br />';


                if ($i == 0) {

                    for ($i = 0; $i <= 10; $i++) {
                        $questao .= '<hr><br/>';
                    }
                } else {
                    for ($i = 0; $i <= 10; $i++) {
                        $questao .= '<hr><br/>';
                    }
                }



                $questao .= '</div>';
                $i = $i + 1;
            }
        }
        if ($questao != "") {

            $discursiva = $discursiva . $questao;
            include_once APPPATH . '/third_party/mpdf/mpdf.php';
            $mpdf = new mPDF('', 'A4', 9, 'Arial Narrow');
            $mpdf->list_indent_first_level = 0;
            $mpdf->max_colH_correction = 1.1;

            /* PÁGINA DE ROSTO :: INICIO */
            //echo $discursiva; exit;
            $mpdf->SetHTMLHeader($this->load->view('108/impressao/D_header', $data, true));
            /* PÁGINA DE ROSTO :: FINAL */

            $mpdf->AddPage('P', // L - landscape, P - portrait
                    'A4', '', '', '', 10, // margin_left
                    10, // margin right
                    30, // margin top
                    30, // margin bottom
                    0, // margin header
                    5); // margin footer
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->SetHTMLFooter($this->load->view('108/impressao/D_footer', $data, true));

            //$mpdf->SetColumns(2, 'J');
            sleep(5);
            $mpdf->WriteHTML($discursiva);
            //$mpdf->AddPage();
            $mpdf->Output();
        }
    }

    function simulado() {

        clearstatcache();

        $new = new Prova_lib();

        $params = array(
            'prova' => $this->input->get_post('id'),
            'aluno' => $this->input->get_post('aluno')
        );

        if ($this->input->get_post('aluno') != '') {
            $aluno = $this->banco->cabecalho($params);
        }

        $data = array(
            'aluno' => $aluno,
            'prova' => $this->banco->banco_prova(array('operacao' => 'VFC', 'prova' => $this->input->get_post('id'))),
            'listar' => $this->banco->prova_questao(array('operacao' => 'FK', 'prova' => $this->input->get_post('id'))),
        );

        $input = array();
        foreach ($data['listar'] as $r) {
            $input[] = $r['NM_DISCIPLINA'];
        }

        $topico = array_keys(array_flip($input));

        $j = 1;

        $prova_atual = $this->banco->banco_prova(array('operacao' => 'FC', 'codigo' => $this->input->get_post('id')));

        $objetiva .= '<div style="border-right:1px solid #999; padding: 0px 15px 0px 0px; margin:0px; min-height:100%; bottom:0px">';
        foreach ($topico as $t) {

            $objetiva .= '<strong style="font-size:15px; color: #08C"> :: ' . $t . '</strong><hr/>';

            foreach ($data['listar'] as $row) {

                if ($row['NM_DISCIPLINA'] == $t) {
                    // ENUNCIADO DA QUESTÃO
                    $objetiva .= '<strong>' . (($row['POSICAO'] != '') ? $row['POSICAO'] : $j) . ') ' . $new->formata_texto_com_richtext($row['DC_QUESTAO']) . '</strong><br/>';

                    // VERIFICA SE EXISTE UM RODAPE
                    //if($row['DC_QUESTAO_RODAPE'] !=  ''){
                    //    $objetiva .= '<div style="text-align: right; color: #0075b0; font-size:8px">Fonte: '.($row['DC_QUESTAO_RODAPE']).'</div><br/>';
                    // }


                    if ($prova_atual[0]['CD_PROVA_PAI'] == '') {
                        // ALTERNATIVAS DA QUESTÃO
                        $opcao = $this->cadastro->questao_resposta(array('operacao' => 'FK', 'questao' => $row['CD_QUESTAO']));
                    } else {
                        // ALTERNATIVAS DA QUESTÃO DE VERSÕES
                        $opcao = $this->cadastro->questao_resposta(array('operacao' => 'FKV', 'questao' => $row['CD_QUESTAO'], 'prova' => $this->input->get_post('id')));
                    }
                    $objetiva .= '<table style="margin-top:5px">';
                    $objetiva .= '<tr><td valign="top">A)</td><td style="text-align:justify">' . $new->formata_texto_com_richtext_alternativa($opcao[0]['DC_OPCAO']) . '</td></tr>';
                    $objetiva .= '<tr><td valign="top">B)</td><td style="text-align:justify">' . $new->formata_texto_com_richtext_alternativa($opcao[1]['DC_OPCAO']) . '</td></tr>';
                    $objetiva .= '<tr><td valign="top">C)</td><td style="text-align:justify">' . $new->formata_texto_com_richtext_alternativa($opcao[2]['DC_OPCAO']) . '</td></tr>';
                    $objetiva .= '<tr><td valign="top">D)</td><td style="text-align:justify">' . $new->formata_texto_com_richtext_alternativa($opcao[3]['DC_OPCAO']) . '</td></tr>';
                    $objetiva .= '<tr><td valign="top">E)</td><td style="text-align:justify">' . $new->formata_texto_com_richtext_alternativa($opcao[4]['DC_OPCAO']) . '</td></tr>';
                    $objetiva .= '</table>';
                    // $objetiva .= '<div style="transform: rotate(90deg); transform-origin: left top 0;"><small>'.$row['CD_QUESTAO'].'</small></div>';
                    if ($row['QTD_ESPACO'] > 0) {
                        for ($i = 0; $i <= $row['QTD_ESPACO']; $i++) {
                            $objetiva .= "<br/>";
                        }
                    } else {
                        $objetiva .= "<br/>";
                    }$j = 1 + $j;
                }
            }
            $objetiva .= '<br><br>';
        }
        $objetiva .= '</div>';
        //echo $objetiva;
        //exit();

        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF('', 'A4', 9, 'Arial Narrow');

        $mpdf->debug = false;
        $mpdf->allow_output_buffering = false;

        $mpdf->list_indent_first_level = 0;
        $mpdf->max_colH_correction = 1.1;

        /* PÁGINA DE ROSTO :: INICIO */

        $mpdf->SetHTMLHeader($this->load->view('108/impressao/header_ingresso', $data, true));
        $mpdf->AddPage('P', // L - landscape, P - portrait
                'A4', '', '', '', 10, // margin_left
                10, // margin right
                30, // margin top
                30, // margin bottom
                0, // margin header
                5); // margin footer   

        /* GERA O CABEÇALHO DA PROVA */
        $cabeca = $this->load->view('108/impressao/cabecalho_ingresso', $data, TRUE);
        $mpdf->WriteHTML($cabeca);

        /* INCLUI O RODAPÉ DA PROVA */
        $mpdf->SetHTMLFooter($this->load->view('108/impressao/footer', $data, true));
        /* PÁGINA DE ROSTO :: FINAL */

        $mpdf->SetHTMLHeader($this->load->view('108/impressao/header', $data, true));
        $mpdf->AddPage('P', // L - landscape, P - portrait
                'A4', '', '', '', 10, // margin_left
                10, // margin right
                30, // margin top
                29, // margin bottom
                0, // margin header
                5); // margin footer
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHTMLFooter($this->load->view('108/impressao/footer', $data, true));

        $mpdf->SetDefaultBodyCSS('line-height', 1.5);
        $mpdf->SetDefaultBodyCSS('text-align', 'justify');
        $mpdf->SetColumns(2, 'J');

        sleep(5);
        $mpdf->WriteHTML($objetiva);
        //$mpdf->Output('PROVA_'.$this->input->get_post('id').'_'.$this->input->get_post('aluno').'.pdf','I');
        $mpdf->Output('PROVA_' . $this->input->get_post('id') . '.pdf', 'I');
    }

}
