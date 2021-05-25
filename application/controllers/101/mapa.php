<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mapa extends CI_Controller {

     function __construct() {
        parent::__construct();

        $this->load->model('sica/cursos_model', 'cursos', TRUE);
        $this->load->model('sica/aluno_model', 'aluno', TRUE);
        $this->load->model('sica/t_periodos_model', 'periodos', TRUE);

        $this->load->model('sica/turma_mapa_model', 'mapa', TRUE);

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
            'SubTitulo' => 'MAPA DE SALA',
            'curso' => $this->cursos->listar(),
            'periodo' => $this->periodos->listar(),
            'side_bar' => false
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/mapa/index',$data);
    }
    
    function grdRegistro() {
        $param = array(
          'periodo' => $this->input->post('periodo'),
            'curso' => $this->input->post('curso'),
            'serie' => $this->input->post('serie'),
            'turma' => $this->input->post('turma'),
        );
        $posicao = $this->mapa->listar_turma($param);
        array_walk($posicao, function(&$value, $key, $return) {
            $value = $value['NR_FILA'].'-'.$value['NR_POSICAO'];
        }, array('NR_FILA','NR_POSICAO'));
        
        $data = array(
            'lista' => $this->mapa->listar_turma($param),
          'posicao' => $posicao,
          'periodo' => $this->input->post('periodo'),
            'curso' => $this->input->post('curso'),
            'serie' => $this->input->post('serie'),
            'turma' => $this->input->post('turma'),
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/mapa/grdRegistro',$data);        
    }
    
    function mdlAlocacaoAluno($dados) {
        $campo = explode('-', $dados);
        $param = array(
          'periodo' => $this->session->userdata('SGP_PERIODO'),
            'curso' => $campo[0],
            'serie' => $campo[1],
            'turma' => $campo[2],
        );
        $data = array(
            'lista' => $this->mapa->listar_turma($param),
             'fila' => $campo[3],
          'posicao' => $campo[4],
            'turma' => $campo[2],
          'periodo' => $this->session->userdata('SGP_PERIODO'),
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/mapa/mdlAlocacaoAluno',$data);        
    }
    
    function mdlDesalocacaoAluno($dados) {
        $campo = explode('-', $dados);
        $data = array(
          'periodo' => $this->session->userdata('SGP_PERIODO'),
            'aluno' => $campo[0],
            'turma' => $campo[1],
        );
        print_r($data);
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/mapa/mdlDesalocacaoAluno',$data);        
    }
    
    
    function frmManter() {
        
        $param = array(
           'periodo' => $this->input->post('periodo'),
             'aluno' => $this->input->post('aluno'),
             'turma' => $this->input->post('turma'),
              'fila' => $this->input->post('fila'),
           'posicao' => $this->input->post('posicao'),
        );
        switch($this->input->post('operacao')){
            case 'A':                
                $retorno = $this->mapa->adicionar($param);
                $retorno = '<h3 class="text-success">Aluno Alocado!';
            break;
            case 'E': 
                $retorno = $this->mapa->editar($param);
                $retorno = '<h3 class="text-warning">Atualização realizada!</h3>';
            break;
            case 'D': 
                $retorno = $this->mapa->deletar($param);
                $retorno = '<h3 class="text-danger">Aluno Removido!</h3>';
            break;
        }
        echo $retorno;
    }
    
    function termo($id) {
        $item = explode('-',$id); 
        $data = array(
            'dados' => $this->adverter->filtro($item[0])
        );
        $body = $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/mapa/termo_pedagogico', $data, true);
        
        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF();
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