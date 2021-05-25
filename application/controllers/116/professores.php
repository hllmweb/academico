<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Professores extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('rh/professor_model', 'professor', TRUE);
        $this->load->model('quest/web_resultado_professor_auto_model', 'resultado', TRUE);
        $this->load->model('quest/web_resultado_docente_model', 'docente', TRUE);
        $this->load->model('prova_model', 'prova', TRUE);
        $this->load->model('pajela_model', 'pajela', TRUE);
        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'session'));
        
        $this->lang->load('sistema', $this->session->userdata('SGP_LANG'));
    }
    
    
    function docente() {
        
        $data = array(
                   'titulo' => 'AVALIAÇÃO INSTITUCIONAL',
                'SubTitulo' => 'AVALIAÇÃO INSTITUCIONAL',
            'TituloSistema' => 'AVALIAÇÃO ONLINE',
                  'docente' => $this->docente->listar_professores(),
                 'side_bar' => false
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/professores/docente', $data);
    }
    
    
    
    function index() {
        
        if($this->session->userdata('SGP_FUNCAO') == 'colaborador'){
            redirect(''.$this->session->userdata('SGP_SISTEMA').'/professores/docente', 'refresh');
        }
        $param = array(
            'periodo' => '2016/1',
            'aluno' => $this->session->userdata('SGP_USER'),
            'questionario' => 5,
            'bimestre' => 4,
        );

        $data = array(
                   'titulo' => 'AVALIAÇÃO INSTITUCIONAL',
                'SubTitulo' => 'AVALIAÇÃO INSTITUCIONAL',
            'TituloSistema' => 'AVALIAÇÃO ONLINE',
                  'docente' => $this->professor->aluno_professor($param),
                 'side_bar' => false
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/professores/index', $data);
    }

    function questionario() {
        
        $data = array(
            'titulo' => 'AVALIAÇÃO INSTITUCIONAL',
            'SubTitulo' => 'AVALIAÇÃO INSTITUCIONAL',
            'TituloSistema' => 'AVALIAÇÃO ONLINE',
            'professor' => $this->professor->pesquisar_id(array('campo' => 'CD_PROFESSOR', 'valor' => base64_decode($this->input->get('token')))),
            'questionario' => $this->resultado->listar(6),
            'resposta' => $this->pajela->aes_questionario_infantil(array('operacao'=>'RP','questionario'=> 5)),
            'side_bar' => false
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/professores/questionario', $data);
    }
    
    function frmValidar() {
        
        $validar = $this->input->post('resposta');
        
        foreach($validar as $r){
            $item = explode('-',$r);
            $p = array(
                    'questionario' => 6,
                    'bimestre'     => 4,
                    'professor'    => $this->input->post('professor'),
                    'periodo'      => $this->session->userdata('SGP_PERIODO'),
                    'pergunta'     => $item[0],
                    'resposta'     => $item[1],
                    'usuario'      => $this->session->userdata('SGP_CODIGO'),
            );
            $this->resultado->adicionar($p);
        }

        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/professores/frmValidar', $data);
    }
    
    
}