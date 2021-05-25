<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Faltas extends CI_Controller {
    
     function __construct() {
        parent::__construct();
        
        $this->load->model('sica/aluno_model', 'aluno', TRUE);
        $this->load->model('sica/cursos_model', 'cursos', TRUE);

        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->lang->load('sistema', $this->session->userdata('SGP_LANG'));
        $this->load->library(array('form_validation', 'session', 'tracert'));
    }
    
    function index() {
        
        $log = new Tracert();
        $log->usuario = $this->session->userdata('USU_CODIGO');
        $log->validar_url();
        
        $data = array(
              'titulo' => 'MÓDULO DE ORIENTAÇÃO',
           'SubTitulo' => 'ACOMPANHAMENTO DE FALTAS',
               'curso' => $this->cursos->listar(),
            'side_bar' => false
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/faltas/index', $data);
    }
    
    function grdRegistro() {
        $param = array(
            'curso' => $this->input->post('curso'),
            'serie' => $this->input->post('serie'),
            'turma' => $this->input->post('turma'),
        );

        $data = array(
             'lista' => $this->aluno->listar_faltas($param)
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/faltas/grdRegistro',$data);        
    }
    
    function impRegistro() {
        $param = array(
            'curso' => $this->input->post('FTCurso'),
            'serie' => $this->input->post('FTSerie'),
            'turma' => $this->input->post('FTTurma'),
        );

        $data = array(
             'lista' => $this->aluno->listar_faltas($param),
            'titulo' => 'RELATÓRIO DE FALTAS DA TURMA : '.$this->input->post('FTTurma').''
        );

        $body = $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/faltas/impRegistro',$data, TRUE);
        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF('','A4',9,'Arial Narrow');

        $mpdf->SetHTMLHeader($this->load->view('impressao/header_doc', $data, true));
        $mpdf->AddPage('P', // L - landscape, P - portrait
                       '', 
                       '', 
                       '', 
                       '', 
                       0,  // margin_left
                       0,  // margin right
                       30, // margin top
                       30, // margin bottom
                       0,  // margin header
                       0); // margin footer
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHTMLFooter($this->load->view('impressao/footer_doc', $data, true));
        $mpdf->WriteHTML($body);
        $mpdf->Output('RELATÓRIO-DE-FALTAS-'.$this->input->post('FTTurma').'.pdf','I');
        
    }

}