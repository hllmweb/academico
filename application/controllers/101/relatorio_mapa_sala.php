<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Relatorio_Mapa_Sala extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('sica/turma_mapa_model', 'mapa', TRUE);
    }

    public function index() {
        $param = array(
            'periodo' => $this->input->get('FTPeriodo'),
            'curso' => $this->input->get('FTCurso'),
            'serie' => $this->input->get('FTSerie'),
            'turma' => $this->input->get('FTTurma'),
        );

        $posicoes = $this->mapa->listar_turma($param);

        array_walk($posicoes, function(&$value, $key, $return) {
            $value = $value['NR_FILA'] . '-' . $value['NR_POSICAO'];
        }, array('NR_FILA', 'NR_POSICAO'));

        $corpo = $this->load->view("101/relatorio_mapa_sala/index", array(
            'posicoes' => $posicoes,
            'alunos' => $this->mapa->listar_turma($param),
            'titulo' => "Mapa de Sala - " . $param['turma']
                ), true);

        include_once APPPATH . '/third_party/mpdf/mpdf.php';

        $mpdf = new mPDF('', 'A4', 12, "Arial");
        $mpdf->SetHTMLHeader($this->load->view('impressao/header_doc', $data, true));
        $mpdf->AddPage('L', // L - landscape, P - portrait
                'A4', '', '', '', 2, // margin_left
                2, // margin right
                30, // margin top
                30, // margin bottom
                0, // margin header
                2); // margin footer
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHTMLFooter($this->load->view('impressao/footer_doc', $data, true));
        $mpdf->WriteHTML($corpo);
        $mpdf->Output('Mapa de Sala - ' . $param['turma'] . '.pdf', 'I');
    }

}
