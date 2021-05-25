<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Caixa_postal extends CI_Controller {
    
     function __construct() {
        parent::__construct();

        $this->load->model('inicio_model', 'inicio', TRUE);
        $this->load->model('usuarios_model', 'users', TRUE);
        
        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation','Menu_lib'));
        
    }
    
    function index() {
        $p = array('operacao' => 'SIS',
                    'pessoa' => $this->session->userdata('SGP_CODIGO'));        
        //print_r($p);
        $data = array(
            'sistema' => $this->users->acesso($p),
            'side_bar' => true
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/home/index', $data);
    }

}