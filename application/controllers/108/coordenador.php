<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Coordenador extends CI_Controller {

     function __construct() {
        parent::__construct();

        $this->load->model('prova_model', 'banco', TRUE);
        $this->load->model('cadastro_model', 'cadastro', TRUE);
        $this->load->model('geral/secretaria_model', 'secretaria', TRUE);
        $this->load->model('geral/colegio_model', 'colegio', TRUE);
        $this->load->model('sica/t_periodos_model', 'periodo', TRUE);

        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'session', 'prova_lib'));

    }

    function index() {
        $data = array(
            'curso' => $this->secretaria->aluno_turma(array('operacao'=>'C')),
            'titulo' => 'ÁREA DO COORDENADOR',
            'SubTitulo' => 'ÁREA DO COORDENADOR',
            'TituloSistema' => 'GESTOR DE PROVAS',
            'tipo_prova' => $this->banco->banco_prova(array('operacao'=>'TP')),
            'periodo' => $this->periodo->listar(),
            'side_bar' => false
        );
        
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/coordenador/index',$data);
    }

    /*
     * FUNÇÃO QUE MOSTRA O RESULTADO DA CONSULTA DA PAGINA INDEX DO BANCO DE PROVAS
     */
    function grdProva() {
        if($this->input->post('filtro') == 0){
            $p = array(
            'operacao' => (($this->input->post('tipo') == 2) ? 'FCN': 'FCNA'),//'FCN',
                'periodo' => $this->input->post('periodo'),
          'tipo_prova' => $this->input->post('tipo'),
               'curso' => $this->input->post('curso'),
               'serie' => $this->input->post('serie'),
          'disciplina' => (($this->input->post('disciplina') == '')? NULL : $this->input->post('disciplina')),
            'bimestre' => (($this->input->post('bimestre') == '')? NULL : $this->input->post('bimestre')),
            'tipo_nota' => (($this->input->post('tipo_nota') == '')? NULL : $this->input->post('tipo_nota')),
            'chamada' => (($this->input->post('chamada') == '')? NULL : $this->input->post('chamada')),
            );
        }else{
            $p = array(
            'operacao' => 'CHECK',
          'num_prova' => $this->input->post('numProva'),
            );
        }
        
        $data = array(
            'resultado' => $this->banco->banco_prova($p),
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/coordenador/grdProva',$data);        
    }
    
}
