<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Funcionario extends CI_Controller {

     function __construct() {
        parent::__construct();

        $this->load->model('rh_model', 'rh', TRUE);
        $this->load->model('acesso_model', 'acesso', TRUE);

        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'session','tracert'));
                
        if($this->session->userdata('SGP_CODIGO')==''){ redirect(base_url(),'refresh');}
    }

    function aniversario() {
        
        $log = new Tracert();
        $log->validar_url();
        
        $p = array('operacao' => 'SIS',
                    'pessoa' => $this->session->userdata('SGP_CODIGO'));
        $data = array(
            'side_bar' => false,
            'TituloSistema' => 'RH',
            'titulo' => 'ANIVERSARIANTES',
            'SubTitulo' => 'ANIVERSARIANTES'
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/funcionario/aniversario/index', $data);
    }
    
    // Monta o grid através do filtro 
    function grdFuncionario() {
        
        $data = explode('-',$this->input->post('DTMes'));
        $param = array('operacao'=>'FAN','mes'=>$data[1]);
        
        $data = array(
            'listar' => $this->rh->funcionario($param),
            'mes' =>$data[1]
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/funcionario/aniversario/grdFuncionario', $data);
    }
    
    function meses($mes) {
        switch($mes){
            case 01: return('JANEIRO'); break;
            case 02: return('FEVEREIRO'); break;
            case 03: return('MARÇO'); break;
            case 04: return('ABRIL'); break;
            case 05: return('MAIO'); break;
            case 06: return('JUNHO'); break;
            case 07: return('JULHO'); break;
            case 08: return('AGOSTO'); break;
            case 09: return('SETEMBRO'); break;
            case 10: return('OUTUBRO'); break;
            case 11: return('NOVEMBRO'); break;
            case 12: return('DEZEMBRO'); break;
        }
    }
    
    function impGrdFuncionario($mes) {
        
        $param = array('operacao'=>'FAN','mes'=>$mes);
        
        $data = array(
            'listar' => $this->rh->funcionario($param),
               'mes' => $this->meses($mes)
        );
        
        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF();
        
        $body = $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/funcionario/aniversario/impGrdFuncionario', $data, true);

        $mpdf->SetHTMLHeader($this->load->view('impressao/header_doc', $data, true));
        $mpdf->AddPage('P', // L - landscape, P - portrait
                       '', 
                       '', 
                       9, 
                       '', 
                       2,  // margin_left
                       2,  // margin right
                       30, // margin top
                       30, // margin bottom
                       0,  // margin header
                       1); // margin footer
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHTMLFooter($this->load->view('impressao/footer_doc', $data, true));
        
        $mpdf->SetDefaultBodyCSS('line-height', 1.5);
        $mpdf->SetColumns(1,'J');
        
        $mpdf->WriteHTML($body);

        $mpdf->Output('Lista_Aniversariantes.pdf','I');
        
    }

}