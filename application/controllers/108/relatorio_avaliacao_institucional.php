<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Relatorio_Avaliacao_Institucional extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('quest/web_resultado_professor_model', 'resultado', TRUE);
    }

    public function topicos() {
        $params = array(
            'quest' => $this->input->get_post('quest'),
            'curso' => $this->input->get_post('curso'),
            'serie' => $this->input->get_post('serie'),
            'turma' => $this->input->get_post('turma'),
            'periodo' => $this->input->get_post('periodo'),
            'disciplina' => $this->input->get_post('disciplina'),
            'bimestre' => $this->input->get_post('bimestre'),
        );

        $resultado = $this->resultado->web_resultado_divisao($params);

        $data['resultado'] = $resultado;
        $data['professor'] = $resultado[0]['NM_PROFESSOR'];
        $data['disciplina'] = $resultado[0]['NM_DISCIPLINA'];
        $data['turma'] = $this->input->get_post('turma');

        $css = file_get_contents(base_url("assets/css/bootstrap.css"));
        $corpo = $this->load->view("108/relatorio_avaliacao_institucional/topicos", $data, true);

        include_once APPPATH . '/third_party/mpdf/mpdf.php';

        $mpdf = new mPDF('', 'A4', 8);
        $mpdf->SetHTMLHeader($this->load->view('impressao/header', $data, true));
        $mpdf->AddPage('P', // L - landscape, P - portrait
                'A4', '', '', '', 2, // margin_left
                2, // margin right
                30, // margin top
                30, // margin bottom
                0, // margin header
                2); // margin footer
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHTMLFooter($this->load->view('impressao/footer', $data, true));
        $mpdf->WriteHTML($css, 1);
        $mpdf->WriteHTML($corpo, 2);
        $mpdf->Output('Avaliação - ' . $resultado[0]['NM_PROFESSOR'] . '.pdf', 'I');
    }

    public function perguntas() {
        $params = array(
            'quest' => $this->input->get_post('quest'),
            'curso' => $this->input->get_post('curso'),
            'serie' => $this->input->get_post('serie'),
            'turma' => $this->input->get_post('turma'),
            'periodo' => $this->input->get_post('periodo'),
            'disciplina' => $this->input->get_post('disciplina'),
            'bimestre' => $this->input->get_post('bimestre'),
        );

        $resultado = $this->resultado->web_resultado_pergunta($params);

        $data['resultado'] = $resultado;
        $data['professor'] = $resultado[0]['NM_PROFESSOR'];
        $data['disciplina'] = $resultado[0]['NM_DISCIPLINA'];
        $data['turma'] = $this->input->get_post('turma');

        $css = file_get_contents(base_url("assets/css/bootstrap.css"));
        $corpo = $this->load->view("108/relatorio_avaliacao_institucional/perguntas", $data, true);

        include_once APPPATH . '/third_party/mpdf/mpdf.php';

        $mpdf = new mPDF('', 'A4', 8);
        $mpdf->SetHTMLHeader($this->load->view('impressao/header', $data, true));
        $mpdf->AddPage('P', // L - landscape, P - portrait
                'A4', '', '', '', 2, // margin_left
                2, // margin right
                30, // margin top
                30, // margin bottom
                0, // margin header
                2); // margin footer
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHTMLFooter($this->load->view('impressao/footer', $data, true));
        $mpdf->WriteHTML($css, 1);
        $mpdf->WriteHTML($corpo, 2);
        $mpdf->Output('Avaliação - ' . $resultado[0]['NM_PROFESSOR'] . '.pdf', 'I');
    }

}
