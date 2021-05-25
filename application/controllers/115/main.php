<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Main extends CI_Controller {
    
     function __construct() {
        parent::__construct();

        $this->load->model('geral/colegio_model', 'colegio', TRUE);
        $this->load->model('usuarios_model', 'users', TRUE);
        $this->load->model('geral/secretaria_model', 'secretaria', TRUE);
        
        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation','Menu_lib'));
        
    }
    
    function index() {
        
        $this->session->unset_userdata('SGP_TURMA');
        $this->session->unset_userdata('SGP_DISICPLINA');        
        
        $p = array('operacao' => 'LTP',
                    'professor' => $this->session->userdata('SGP_PROFESSOR')
                   );
        $data = array(
            'curso' => $this->secretaria->aluno_turma(array('operacao'=>'C')),
            'side_bar' => false,
            'TituloSistema' => 'DIÁRIO WEB',
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/home/index', $data);
    }

}