<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Relatorio_Aluno extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("sica/aluno_model", "aluno", true);        

        //$this->load->model('relatorio_model', 'relatorio', TRUE);
        //$this->load->model('secretaria/secretaria_model', 'secretaria', TRUE);

        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'session', 'grafico_lib', 'prova_lib', 'tracert'));
    }

    function index() {

        $data = array(
            'titulo' => 'GRÁFICO DE PROVAS'
        );
        $this->load->view('grafico/aluno/index', $data);
    }

    function frmGabaritos() {
        $in = $this->input->get('token');
        $data = array(
            'titulo' => 'GABARITOS',
            'id' => $in,
            'aluno' => $this->relatorio->aluno(array('operacao' => 'A', 'aluno' => $in)),
            'provas' => $this->relatorio->aluno(array('operacao' => 'L', 'aluno' => $in, 'bimestre' => 4))
        );
        $aluno = $this->load->view('grafico/aluno/frmAluno', $data, true);

        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF('', 'A4', 8, 'Arial Narrow');

        $cabeca = $this->load->view('prova/frmSalaCabecalho', $data, TRUE);

        $mpdf->SetHTMLHeader($this->load->view('impressao/header', $data, true));
        $mpdf->AddPage('P', // L - landscape, P - portrait
                'A4', '', '', '', 1, // margin_left
                1, // margin right
                22, // margin top
                22, // margin bottom
                0, // margin header
                1); // margin footer
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHTMLFooter($this->load->view('impressao/footer', $data, true));

        $mpdf->SetDefaultBodyCSS('line-height', 1.5);

        $mpdf->SetColumns(1, 'J');
        $mpdf->WriteHTML($aluno);

        $mpdf->Output('ALUNO-' . $id . '.pdf', 'I');
    }

    function gabaritosProvas() {
        $token = $this->input->get("token");
        $bimestre = $this->input->get("bimestre");
        $aluno = base64_decode($token);

        $provas = $this->aluno->listaGabaritosProvas($aluno, $bimestre);

        $data = array(
            'titulo' => 'GABARITOS',
            'aluno' => $this->aluno->consultar($aluno),
            'provas' => $provas
        );

        if (count($provas) == 0) {
            echo "<script>alert('Sem gabaritos para o bimestre informado.');</script>";
            exit();
        }

        $relatorio = $this->load->view('108/relatorio_aluno/gabaritosProvas', $data, true);

        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF('', 'A4', 8, 'Arial Narrow');
        $mpdf->SetHTMLHeader($this->load->view('108/relatorio_aluno/header', $data, true));
        $mpdf->AddPage('P', // L - landscape, P - portrait
                'A4', '', '', '', 1, // margin_left
                1, // margin right
                22, // margin top
                22, // margin bottom
                0, // margin header
                1); // margin footer
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHTMLFooter($this->load->view('108/relatorio_aluno/footer', $data, true));
        $mpdf->SetDefaultBodyCSS('line-height', 1.5);
        $mpdf->SetColumns(1, 'J');
        $mpdf->WriteHTML($relatorio);
        $mpdf->Output('ALUNO-' . $aluno . '.pdf', 'I');
    }

    function gabaritosProvasOnline() {
        $token = $this->input->get("token");
        $bimestre = $this->input->get("bimestre");
        $aluno = base64_decode($token);

        $aux = $this->aluno->listaGabaritosProvasOnline($aluno, $bimestre);

        //montar um vetor de provas em que um dos elementos é um vetor com todas
        //as resposta, gabarito e tempo de resolução
        $provas = array();
        $codigoProva = null;
        $i = -1;
        foreach ($aux as $row) {
            if ($codigoProva != $row['CD_PROVA']) {
                $i++;
                $codigoProva = $row['CD_PROVA'];
                $provas[$i] = $row;
            }

            if ($codigoProva == $row['CD_PROVA']) {
                $provas[$i]['QUESTOES'][] = array(
                    'POSICAO' => $row['POSICAO'],
                    'CORRETA' => $row['CORRETA'],
                    'RESPOSTA' => $row['RESPOSTA'],
                    'NR_TEMPO_RESPOSTA' => $row['NR_TEMPO_RESPOSTA']
                );
            }
        }

        if (count($provas) == 0) {
            echo "<script>alert('Não existem gabaritos para este tipo de prova.');</script>";
            exit();
        }

        $data = array(
            'titulo' => 'GABARITOS',
            'aluno' => $this->aluno->consultar($aluno),
            'provas' => $provas
        );

        $relatorio = $this->load->view('108/relatorio_aluno/gabaritosProvasOnline', $data, true);

        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF('', 'A4', 10, 'Arial Narrow');
        $mpdf->SetHTMLHeader($this->load->view('108/relatorio_aluno/header', $data, true));
        $mpdf->AddPage('P', // L - landscape, P - portrait
                'A4', '', '', '', 1, // margin_left
                1, // margin right
                22, // margin top
                22, // margin bottom
                0, // margin header
                1); // margin footer
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHTMLFooter($this->load->view('108/relatorio_aluno/footer', $data, true));
        $mpdf->SetDefaultBodyCSS('line-height', 1.5);
        $mpdf->SetColumns(1, 'J');
        $mpdf->WriteHTML($relatorio);
        $mpdf->Output('ALUNO-' . $aluno . '.pdf', 'I');
    }

}
