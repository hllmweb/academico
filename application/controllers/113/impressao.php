<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Impressao extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('academico_model', 'academico', TRUE);
        $this->load->model('geral/secretaria_model', 'secretaria', TRUE);
        $this->load->model('pajela_model', 'pajela', TRUE);
        
        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation','session'));
    }
    
    
    function impAcompanhamentoInfantil($id) {
        
        $pmt = explode('-',$id);
        
        $data = array(
            'aluno' => $this->secretaria->aluno_turma(array('operacao'=> 'ALUNO','aluno'=>$pmt[0])),
           'listar' => $this->pajela->aes_questionario_infantil(array('operacao'=> 'L','aluno'=>$pmt[0],'questionario'=> $pmt[1])),
        );
        
        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF();
        
        $body = $this->load->view('113/infantil/mdlViewAcompanhamento', $data, true);     

        $mpdf->SetHTMLHeader($this->load->view('impressao/cartao_resposta/cabecalho', $data, true));
        $mpdf->AddPage('P', // L - landscape, P - portrait
                       '', 
                       '', 
                       9, 
                       '', 
                       5,  // margin_left
                       5,  // margin right
                       30, // margin top
                       30, // margin bottom
                       0,  // margin header
                       1); // margin footer
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHTMLFooter($this->load->view('impressao/cartao_resposta/rodape', $data, true));
        
        $mpdf->SetDefaultBodyCSS('line-height', 1.5);
        $mpdf->SetColumns(1,'J');
        
        $mpdf->WriteHTML($body);

        $mpdf->Output('CARTAO_RESPOSTAS-01.pdf','I');
        
    }

}