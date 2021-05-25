<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Monitor extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("pajela/aula_model", "aula", true);

        $this->load->model('academico_model', 'academico', TRUE);
        $this->load->model('geral/secretaria_model', 'secretaria', TRUE);
        $this->load->model('pajela_model', 'pajela', TRUE);
        $this->load->model('sica/t_periodos_model', 'periodos', TRUE);
        $this->load->model('rh/professor_model', 'professor', TRUE);
        $this->load->model('pajela/aula_diaria_model', 'aulaDiaria', TRUE);
        $this->load->model('sica/turma_tipo_model', 'tipo', TRUE);

        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'Menu_lib', 'diario_lib'));
    }

    function aula_diaria() {
        $professores = $this->professor->filtrar(array(
            array("campo" => "DT_DEMISSAO", "valor" => null),
            array("campo" => "CD_PROFESSOR !=", "valor" => 12)
        ));

        $data = array(
            'TituloSistema' => 'COORDENADORES',
            'titulo' => 'MONITOR DE COORDENAÇÃO',
            'SubTitulo' => 'AULA DIÁRIA',
            'curso' => $this->academico->consultas(array('operacao' => 'C')),
            'periodo' => $this->periodos->listar()
        );
        $this->load->view($this->session->userdata('SGP_SISTEMA') . '/monitor/aula_diaria/index', $data);
    }

    function grdAula() {
        $curso = $this->input->post('curso');
        $serie = $this->input->post('serie');
        $professor = $this->input->post('professor');
        $aux = explode("-", $this->input->post('data'));
        $pendente = $this->input->post("pendente");

        $params = array(
            array('campo' => 'CD_CURSO', 'valor' => (int) $curso),
            array('campo' => "TRUNC(DT_AULA) BETWEEN TO_DATE('" . trim($aux[0]) . "', 'DD/MM/YYYY') AND TO_DATE('" . trim($aux[1]) . "', 'DD/MM/YYYY')", "valor" => null),
        );

        if (!empty($serie)) {
            $params[] = array('campo' => 'CD_SERIE', 'valor' => $serie);
        }

        if (!empty($professor)) {
            $params[] = array('campo' => 'CD_PROFESSOR', 'valor' => $professor);
        }

        $aulas = null;
        if ($pendente === "S") {
            $aulas = $this->aula->listaPendencias($params);
        } else {
            $aulas = $this->aula->filtrar($params);
        }

        $data = array(
            'lista' => $aulas,
        );

        $this->load->view($this->session->userdata('SGP_SISTEMA') . '/monitor/aula_diaria/grdAula', $data);
    }

    function mdlRelatorio() {

        $data = array(
            'curso' => $this->academico->consultas(array('operacao' => 'C')),
            'periodo' => $this->periodos->listar(),
            'tipo' => $this->tipo->listar(),
            'professor' => $this->professor->listar(),
        );

        $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/monitor/aula_diaria/mdlRelatorio', $data);
    }

    function impRelatorio() {
        $aux = $this->input->post('Data');
        $aux = explode("-", $aux);

        $dataInicio = null;
        $dataFim = null;

        $dataInicio = new DateTime();
        $dataInicio = $dataInicio->createFromFormat('d/m/Y', trim($aux[0]));
        $dataInicio = $dataInicio->format('d-M-y');

        $dataFim = new DateTime();
        $dataFim = $dataFim->createFromFormat('d/m/Y', trim($aux[1]));
        $dataFim = $dataFim->format('d-M-y');

        $params = array(
            array('campo' => 'PERIODO', 'valor' => $this->input->post('Periodo')),
            array('campo' => 'TIPO', 'valor' => $this->input->post('Tipo')),
            array('campo' => 'DT_AULA >=', 'valor' => $dataInicio),
            array('campo' => 'DT_AULA <=', 'valor' => $dataFim),
        );

        $professor = $this->input->post('Professor');
        if (!empty($professor)) {
            $params[] = array('campo' => 'CD_PROFESSOR', 'valor' => $professor);
        }

        $pendente = $this->input->post("Pendente");

        $aulas = null;
        $titulo = "";
        if ($pendente == "S") {
            $titulo = "RELATÓRIO DE AULAS PENDENTES";
            $aulas = $this->aula->listaPendencias($params);
        } else {
            $titulo = 'RELATÓRIO DE AULAS DIÁRIAS';
            $aulas = $this->aula->filtrar($params);
        }

        $data = array(
            'titulo' => $titulo,
            'lista' => $aulas,
        );

        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF();
        $body = $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/monitor/aula_diaria/impRelatorio', $data, true);

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

}
