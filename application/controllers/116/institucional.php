<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Institucional extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('rh/professor_model', 'professor', TRUE);
        $this->load->model('quest/web_resultado_professor_model', 'resultado', TRUE);
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
                  'docente' => $this->docente->listar_docente(),
                 'side_bar' => false
        );

        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/institucional/docente', $data);
    }
        
    
    function index() {
        
        if($this->session->userdata('SGP_FUNCAO') == 'colaborador'){
            redirect(''.$this->session->userdata('SGP_SISTEMA').'/institucional/docente', 'refresh');
        }

        $param = array(
            'periodo' => '2017/1',
            'aluno' => $this->session->userdata('SGP_USER'),
            'questionario' => '5,304,305',
            'bimestre' => 4,
        );

        $data = array(

                   'titulo' => 'AVALIAÇÃO INSTITUCIONAL',
                   'SubTitulo' => 'AVALIAÇÃO INSTITUCIONAL',
                    'TituloSistema' => 'AVALIAÇÃO ONLINE',
                
                  'docente' => $this->professor->aluno_professor($param),
                 'side_bar' => false
        );

        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/institucional/index', $data);
    }

    function questionario() {
         //musica 103 EDUCAÇÂO FISICA = 5
        $questionario = 5;

       if(base64_decode($this->input->get('tokName')) == 103 || base64_decode($this->input->get('tokName')) == 40 ){

            $questionario = 305;

        }elseif(base64_decode($this->input->get('tokName')) == 5 || base64_decode($this->input->get('tokName')) == 31){

            $questionario = 304;
        } 

         $param = array(
            'periodo' => '2017/1',
            'aluno' => $this->session->userdata('SGP_USER'),
            'professor' => base64_decode($this->input->get('token')),
            'disciplina' => base64_decode($this->input->get('tokName')),
        );
        
        $parametro = array('operacao'=> 'X',
                           'questionario'=> $questionario,
                           'bimestre'=> 4,
                           'professor'=> base64_decode($this->input->get('token'))
                            );
      
        $data = array(
            'titulo'        => 'AVALIAÇÃO INSTITUCIONAL',
            'SubTitulo'     => 'AVALIAÇÃO INSTITUCIONAL',
            'TituloSistema' => 'AVALIAÇÃO ONLINE',
            'professor'     => $this->professor->professor_filtro($param),
            'questionario'  => $this->pajela->aes_questionario_infantil($parametro),
            'resposta'      => $this->pajela->aes_questionario_infantil(array('operacao'=>'RP','questionario'=> 5)),
            'side_bar'      => false
        );
        
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/institucional/questionario', $data);
    }
    
    function frmValidar() {
        
          $validar = $this->input->post('resposta');
          $questionario = 5;
       if(base64_decode($this->input->get('tokName')) == 103 || base64_decode($this->input->get('tokName')) == 40 ){

            $questionario = 305;

        }elseif(base64_decode($this->input->get('tokName')) == 5 || base64_decode($this->input->get('tokName')) == 31){

            $questionario = 304;
        } 

        
        foreach($validar as $r){
            $item = explode('-',$r);
            $p = array(
                    'questionario' => $questionario,
                    'bimestre'     => 4,
                    'professor'    => $this->input->post('professor'),
                    'disciplina'   => $this->input->post('disciplina'),
                    'aluno'        => $this->session->userdata('SGP_USER'),
                    'periodo'      => $this->session->userdata('SGP_PERIODO'),
                    'pergunta'     => $item[0],
                    'resposta'     => $item[1],
                    'usuario'      => $this->session->userdata('SGP_USER'),
                    'tipo'         => 'A',
            );
            $this->resultado->adicionar($p);
        }

        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/institucional/frmValidar', $data);
    }
    
    
}