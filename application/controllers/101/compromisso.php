<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Compromisso extends CI_Controller {
    
     function __construct() {
        parent::__construct();

        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'session', 'tracert'));
        $this->lang->load('sistema', $this->session->userdata('SGP_LANG'));
    }
    
    function index() {
        
        $log = new Tracert();
        $log->usuario = $this->session->userdata('USU_CODIGO');
        $log->validar_url();
        
        $data = array(
            'side_bar' => false,
            'TituloSistema' => 'RESERVA DE LOCAL',
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/compromisso/index', $data);
    }
    
    function termo() {
        
        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF();
        
        $body = $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/compromisso/termo', $data, true);

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
        $mpdf->Output('TERMO-DE-SUSPESAO.pdf','I');
        
    }

}