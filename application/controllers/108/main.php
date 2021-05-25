<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Main extends CI_Controller {
    
     function __construct() {
        parent::__construct();

        $this->load->model('usuarios_model', 'users', TRUE);
        
        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation','session'));
    }

    function index() {
        $p = array('operacao' => 'SIS',
                    'pessoa' => $this->session->userdata('SGP_CODIGO'));
        
        $data = array(
            'titulo' => 'GERENCIADOR DE AVALIAÇÕES',
            'SubTitulo' => 'INÍCIO',
            'sistema' => $this->users->acesso($p),
            'side_bar' => true
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/home/index', $data);
    }

}