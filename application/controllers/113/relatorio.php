<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Relatorio extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("academico/justificativa_solicitacao_model", "solicitacao", true);

        $this->load->model("academico_model", "academico", true);
        $this->load->model("professor_model", "professor", true);
        $this->load->model("geral/secretaria_model", "secretaria", true);
        $this->load->model("113/relatorio_model", "relatorio", true);
    }

    /**
     * Gera o relatório de solicitações de abonos
     * 
     * @param string $data Intervalo de tempo que deve ser filtrado o relatorio
     * @param string $motivo
     * @param string $professor
     * @param string $situacao
     */
    public function solicitacaoAbono() {
        $aux = explode('-', $this->input->get('data'));
        $motivo = $this->input->get("motivo");
        $professor = $this->input->get("professor");
        $situacao = $this->input->get("situacao");

//preparar filtros
        $params = array(
            array("campo" => "TRUNC(DT_PENDENCIA) BETWEEN TO_DATE('" . trim($aux[0]) . "','DD/MM/YYYY') "
                . "AND TO_DATE('" . trim($aux[1]) . "','DD/MM/YYYY')", "valor" => null),
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
            "titulo" => "RELATÓRIO DE SOLICITAÇÕES DE ABONO (" . $aux[0] . " - " . $aux[1] . ")"
        );

        include_once APPPATH . '/third_party/mpdf/mpdf.php';

        $mpdf = new mPDF('', 'A4', 8);

        $css = file_get_contents(base_url("assets/css/bootstrap.css"));
        $header = $this->load->view('impressao/header_doc', $dataHeader, true);
        $body = $this->load->view($this->session->userdata("SGP_SISTEMA") . "/relatorio/solicitacao_abono", $data, true);
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

    /**
     * Gerar o relatório com todas as aulas pendentes de acordo com os parametros
     * enviados.
     * 
     * @param string $Periodo
     * @param string $Professor
     * @param string $Tipo
     * @param string $Data     
     * 
     * @return string
     */
    public function aula_pendente() {
        $aux = $this->input->post('Data');
        $aux = explode("-", $aux);

        $params = array(
            array('campo' => 'PERIODO', 'valor' => $this->input->post('Periodo')),
            array('campo' => "TRUNC(DT_AULA) BETWEEN TO_DATE('" . trim($aux[0]) . "', 'DD/MM/YYYY') AND TO_DATE('" . trim($aux[1]) . "', 'DD/MM/YYYY')", "valor" => null),
        );

        /*$tipo = $this->input->post('Tipo');
        if (!empty($tipo)) {
            $params[] = array('campo' => 'TIPO', 'valor' => $tipo);
        }*/

        $professor = $this->input->post('Professor');
        if (!empty($professor)) {
            $params[] = array('campo' => 'CD_PROFESSOR', 'valor' => $professor);
        }

        $data = array(
            'titulo' => "RELATÓRIO DE AULAS PENDENTES",
            'lista' => $this->aula->listaPendencias($params),
        );

     
        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF();
        $body = $this->load->view('113/relatorio/aula_pendente', $data, true);

        $mpdf->SetHTMLHeader($this->load->view('impressao/header_doc', $data, true));
        $mpdf->AddPage('P', // L - landscape, P - portrait
                '', '', '', '', 0, // margin_left
                0, // margin right
                30, // margin top
                30, // margin bottom
                0, // margin header
                0); // margin footer
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHTMLFooter($this->load->view('impressao/footer_doc', $data, true));
        $mpdf->WriteHTML($body);
        $mpdf->Output('RELATÓRIO DE AULAS.pdf', 'I');
    }

    /**
     * Gera um PDF de acordo com os filtros aplicados na tela de aula diária.     
     *      
     * @param string $curso
     * @param string $serie
     * @param string $Professor     
     * @param string $Data Data de inicio e fim     
     * 
     * @return string
     */
    public function aula_diaria() {
        $curso = $this->input->get("curso");
        $serie = $this->input->get("serie");
        $professor = $this->input->get("professor");
        $pendente = $this->input->get("pendente");
        $aux = $this->input->get('data');
        $aux = explode("-", $aux);

        //parametros da consulta
        $params = array(
            array("campo" => "CD_CURSO", "valor" => $curso),
            array('campo' => "TRUNC(DT_AULA) BETWEEN TO_DATE('" . trim($aux[0]) . "', 'DD/MM/YYYY') AND TO_DATE('" . trim($aux[1]) . "', 'DD/MM/YYYY')", "valor" => null),
        );

        //adicionar filtros conforme preenchimento dos campos
        if (!empty($serie)) {
            $params[] = array("campo" => "CD_SERIE", "valor" => $serie);
        }

        if (!empty($professor)) {
            $params[] = array("campo" => "CD_PROFESSOR", "valor" => $professor);
        }

        $aulas = null;
        $titulo = "";
        if ($pendente == "S") {
            $titulo = "RELATÓRIO DE AULAS PENDENTES <br>(" . $this->input->get("data") . ")";
            $aulas = $this->aula->listaPendencias($params);
        } else {
            $titulo = "RELATÓRIO DE AULAS <br>(" . $this->input->get("data") . ")";
            $aulas = $this->aula->filtrar($params);
        }

        $data = array(
            'titulo' => $titulo,
            'lista' => $aulas,
        );

        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF();
        $body = $this->load->view('113/relatorio/aula_diaria', $data, true);

        $mpdf->SetHTMLHeader($this->load->view('impressao/header_doc', $data, true));
        $mpdf->AddPage('P', // L - landscape, P - portrait
                '', '', '', '', 0, // margin_left
                0, // margin right
                30, // margin top
                30, // margin bottom
                0, // margin header
                0); // margin footer
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHTMLFooter($this->load->view('impressao/footer_doc', $data, true));
        $mpdf->WriteHTML($body);
        $mpdf->Output('RELATÓRIO DE AULAS.pdf', 'I');
    }

    public function conteudo_ministrado() {
        $periodos = $this->secretaria->aluno_turma(array("operacao" => "PRD"));
        $bimestres = array();

        //hardcoded devido o número de bimestres ser fixo para consulta de conteudo
        $j = 0;
        foreach ($periodos as $periodo) {
            for ($i = 1; $i <= 4; $i++) {
                $bimestres[$j]['CODIGO'] = $periodo['DC_PERIODO'] . "-" . $i;
                $bimestres[$j]['DESCRICAO'] = $periodo['DC_PERIODO'] . " - " . $i . "° Bimestre";
                $j++;
            }
        }

        $data = array(
            "TituloSistema" => "COORDENAÇÃO",
            "titulo" => "RELATÓRIOS",
            "SubTitulo" => "CONTEÚDOS MINISTRADOS",
            "side_bar" => false,
            "cursos" => $this->academico->consultas(array("operacao" => "C")),
            "bimestres" => $bimestres,
        );

        $this->load->view("113/relatorio/conteudo_ministrado", $data);
    }

    public function grid_conteudo_ministrado() {
        $periodoBimestre = $this->input->post("bimestre");
        $aux = explode("-", $periodoBimestre);

        $periodo = $aux[0];
        $bimestre = $aux[1];

        $parametros = array(
            'turma' => $this->input->post("turma"),
            'disciplina' => $this->input->post("disciplina"),
            'periodo' => $periodo,
            'bimestre' => $bimestre,
        );

        $conteudos = $this->relatorio->conteudo_ministrado($parametros);
        $tamanho = count($conteudos);

        for ($i = 0; $i < $tamanho; $i++) {
            $assuntos = $this->professor->aes_diario_online(array(
                'aula' => $conteudos[$i]['CD_CL_AULA'],
                'operacao' => 'LAL'
            ));

            $conteudos[$i]['AULA_ASSUNTO_LIVRO'] = $assuntos;
        }

        $data = array(
            'conteudos' => $conteudos,
        );

        $this->load->view("113/relatorio/grid_conteudo_ministrado", $data);
    }

}
