<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Orientacao_docente extends CI_Controller {

     function __construct() {
        parent::__construct();

        $this->load->model('sica/cursos_model', 'cursos', TRUE);
        $this->load->model('sica/aluno_model', 'aluno', TRUE);
        $this->load->model('academico/orientacao_docente_model', 'docente', TRUE);

        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'session', 'tracert'));
                
    }

    function index() {
        
        $log = new Tracert();
        $log->usuario = $this->session->userdata('USU_CODIGO');
        $log->validar_url();

        $data = array(
              'titulo' => 'MÓDULO DE ORIENTAÇÃO',
           'SubTitulo' => 'ATENDIMENTO AO DOCENTE',
               'curso' => $this->cursos->listar(),
            'side_bar' => false
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/orientacao_docente/index',$data);

    }

    function grdRegistro() {

        $param = array(
            'curso' => $this->input->post('curso'),
            'serie' => $this->input->post('serie'),
            'turma' => $this->input->post('turma'),
        );

        $data = array(
             'lista' => $this->docente->listar_turma($param)
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/orientacao_docente/grdRegistro', $data);

    }

    function mdlRegistro($id){
        
        $item = explode('-', $id);
        
        $data = array(
            'operacao' => $item[0],
            'codigo'   => (($item[1] != '')? $item[1] : 0),
            'filtro'   => $this->docente->filtro(array('codigo'=>$item[1])),
            'curso'    => $this->cursos->listar(),
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/orientacao_docente/mdlRegistro', $data);

    }
    
    function mdlRegistroProfessor($id) {

        $item = explode('-', $id);
        $param = array(
            'professor' => $item[0],
           'disciplina' => $item[1],
                'turma' => $item[2]
                );
        $data = array(
             'lista' => $this->docente->listar($param)
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/orientacao_docente/mdlRegistroProfessor',$data);        
    }
    
    
    function frmManter(){
        

        $data = array(
          'operacao' => $this->input->post('operacao'),
            'codigo' => $this->input->post('codigo'),
             'turma' => $this->input->post('turma'),
           'periodo' => $this->session->userdata('SGP_PERIODO'),
        'disciplina' => $this->input->post('disciplina'),
         'professor' => $this->input->post('professor'),
              'data' => $this->input->post('data'),
              'hora' => $this->input->post('hora'),
            'motivo' => $this->input->post('motivo'),
            'resumo' => $this->input->post('resumo'),
               'obs' => $this->input->post('obs'),
        );        
        
        switch($this->input->post('operacao')){
            case 'A':
                $this->docente->adicionar($data);
                echo $retorno = '<h3 class="text-warning">Registros Adicionados</h3><script>window.location.reload();</script>';
            break;

            case 'E':
                $this->docente->editar($data);
                //echo $retorno = '<h3 class="text-warning">Registros Editados</h3><script>window.location.reload();</script>';
            break;

            case 'D':
                $this->docente->deletar($data);
                echo $retorno = '<h3 class="text-danger">Registros Excluídos</h3><script>window.location.reload();</script>';
            break;
        }
    }

}