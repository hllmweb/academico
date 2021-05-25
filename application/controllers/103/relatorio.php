<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Relatorio extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("academico/justificativa_solicitacao_model", "solicitacao", true);
    }

    /**
     * Gera o relatório de solicitações de abonos
     * 
     * @param string $data Intervalo de tempo que deve ser filtrado o relatorio
     * @param string $motivo
     * @param string $professor
     * @param string $situacao
     */
    public function abonoAula() {
        $aux = $this->input->get('data');
        $motivo = $this->input->get("motivo");
        $professor = $this->input->get("professor");
        $situacao = $this->input->get("situacao");

        //preparar datas para filtro
        $aux = explode('-', $aux);

        $params = array(
            array("campo" => "TRUNC(DT_PENDENCIA) BETWEEN TO_DATE('" . trim($aux[0]) . "','DD/MM/YYYY') "
                . "AND TO_DATE('" . trim($aux[1]) . "','DD/MM/YYYY')", "valor" => NULL),
        );

        if (!empty($motivo)) {
            $params[] = array("campo" => "CD_MOTIVO", "valor" => $motivo);
        }

        if (!empty($professor)) {
            $params[] = array("campo" => "CD_PROFESSOR", "valor" => $professor);
        }

        if (!empty($situacao)) {
            $params[] = array("campo" => "FL_STATUS", "valor" => $situacao);
        }

        $solicitacoes = $this->solicitacao->filtrar($params);

        $data = array(
            "registros" => $solicitacoes,
            "inicio" => $aux[0],
            "fim" => $aux[1]            
        );

        $dataHeader = array(
            "titulo" => "RELATÓRIO DE ABONO DE AULAS (" . $aux[0] . " - " . $aux[1] . ")"
        );

        include_once APPPATH . '/third_party/mpdf/mpdf.php';

        $mpdf = new mPDF('', 'A4', 8);

        $css = file_get_contents(base_url("assets/css/bootstrap.css"));
        $header = $this->load->view('impressao/header_doc', $dataHeader, true);
        $body = $this->load->view("103/relatorio/abono_aula", $data, true);
        $footer = $this->load->view('impressao/footer_doc', null, true);

        $mpdf->SetHTMLHeader($header);
        $mpdf->AddPage('P', // L - landscape, P - portrait
                'A4', '', '', '', 2, // margin_left
                2, // margin right
                30, // margin top
                30, // margin bottom
                0, // margin header
                2); // margin footer
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHTMLFooter($footer);
        $mpdf->WriteHTML($css, 1);
        $mpdf->WriteHTML($body, 2);
        $mpdf->Output('Relatório Solicitações ' . $aux[0] . ' - ' . $aux[1] . '.pdf', 'I');
    }

}
