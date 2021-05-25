<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Main extends CI_Controller {
    
     function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->lang->load('sistema', $this->session->userdata('SGP_LANG'));
        
    }
    
    function index() {
        
        $data = array(
            'side_bar' => false,
            'TituloSistema' => 'RESERVA DE LOCAL',
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/home/index', $data);
    }

}