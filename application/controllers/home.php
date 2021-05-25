<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {
    
     function __construct() {
        parent::__construct();

        $this->load->model('inicio_model', 'inicio', TRUE);
        $this->load->model('usuarios_model', 'users', TRUE);
        
        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('session', 'menu_lib'));
        
        $sess_array = array();
        $this->lang->load('sistema', $this->session->userdata('SGP_LANG'));
        
    }
    
    function index() {
        $p = array('operacao' => 'SIS',
                    'pessoa' => $this->session->userdata('SGP_CODIGO'));
        //echo phpinfo();
        $data = array(
            'sistema' => $this->users->acesso($p),
        );
        $this->load->view('home/index', $data);
    }
    
}