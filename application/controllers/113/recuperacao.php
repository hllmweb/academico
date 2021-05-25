<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Recuperacao extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('academico_model', 'academico', TRUE);
        $this->load->model('professor_model', 'professor', TRUE);

        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'Menu_lib', 'diario_lib'));
    }

    function index() {
        $data = array(
            'TituloSistema' => 'COORDENADORES',
            'titulo' => 'ACADÊMICO',
            'SubTitulo' => 'PROFESSORES',
            'curso' => $this->academico->consultas(array('operacao' => 'C')),
            'side_bar' => false
        );
        //$this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/recuperacao/index', $data);
        $this->load->view('113/recuperacao/index', $data);
    }

    function grdRecuperacao() {

        /* Chama a biblioteca Diario */
        $Diario_lib = new Diario_lib();
        /* passando parametros para a biblioteca */
        $Diario_lib->disciplina = $this->input->post('disciplina');
        $Diario_lib->turma = $this->input->post('turma');

        $data = array(
            'lista' => $Diario_lib->notas_turma_disciplina()
        );
        //$this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/professores/grdRecuperacao', $data);
        $this->load->view('113/recuperacao/grdRecuperacao', $data);
    }

}