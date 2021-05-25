<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Termo extends CI_Controller {

     function __construct() {
        parent::__construct();

        $this->load->model('sica/cursos_model', 'cursos', TRUE);
        $this->load->model('sica/aluno_model', 'aluno', TRUE);
        $this->load->model('sica/t_periodos_model', 'periodos', TRUE);

        $this->load->model('sica/responsavel_termo_model', 'termo', TRUE);

        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'session', 'tracert'));

        $this->lang->load('sistema', $this->session->userdata('SGP_LANG'));
                
    }

    function index() {
        
        $log = new Tracert();
        $log->usuario = $this->session->userdata('USU_CODIGO');
        $log->validar_url();
        
        $data = array(
            'titulo' => 'MÓDULO DE ORIENTAÇÃO',
            'SubTitulo' => 'TERMO DE COMPROMISSO FAMILIAR',
            'curso' => $this->cursos->listar(),
            'periodo' => $this->periodos->listar(),
            'side_bar' => false
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/termo/index',$data);
    }
    
    function grdRegistro() {
        $param = array(
            'curso' => $this->input->post('curso'),
            'serie' => $this->input->post('serie'),
            'turma' => $this->input->post('turma'),
          'periodo' => $this->input->post('periodo'),
        );
        $data = array(
             'lista' => $this->termo->listar_turma($param)
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/termo/grdRegistro',$data);        
    }
    
    function mdlRegistro($id) {
        $item = explode('-',$id); 
        $data = array(
            'curso' => $this->cursos->listar(),
            //'lista' => $this->suspender->listar(array('aluno'=>$item[1])),
         'operacao' => $item[0]
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/termo/mdlRegistro',$data);        
    }
    
    function mdlRegistroAluno($id) {
        
        $data = array(
             'lista' => $this->termo->listar(array('aluno'=>$id))
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/termo/mdlRegistroAluno',$data);        
    }
    
    
    function frmManter() {
        
        $param = array(
            'codigo' => $this->input->post('codigo'),
           'periodo' => $this->session->userdata('SGP_PERIODO'),
             'aluno' => $this->input->post('aluno'),
              'tipo' => $this->input->post('tipo'),
       'responsavel' => $this->input->post('responsavel')
        );
        
        switch($this->input->post('operacao')){
            case 'A':
                $retorno = $this->termo->adicionar($param);
                $retorno = '<h3 class="text-success">Termo Gerado! </h3><script>window.location.reload();</script>';
            break;
            case 'E': 
                $retorno = $this->termo->editar($param);
                $retorno = '<h3 class="text-warning">Termo Atualizado!</h3><script>window.location.reload();</script>';
            break;
            case 'D': 
                $retorno = $this->termo->deletar($param);
                $retorno = '<h3 class="text-danger">Termo Excluído!</h3><script>window.location.reload();</script>';
            break;
        }
        echo $retorno;
    }
    
    function imprimir($id) {
        $item = explode('-',$id); 
        $data = array(
            'dados' => $this->termo->filtro($item[0])
        );
        
        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF();
        
        if($item[1] == 1){
            $body = $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/termo/termo_normal', $data, true);
        }elseif($item[1] == 2){
            $body = $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/termo/termo_reincidencia', $data, true);
        }

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
        $mpdf->Output('TERMO-DE-ADVERTENCIA-'.str_replace(' ','_',$data['dados']->NM_ALUNO).'.pdf','I');
        
    }
    
}