<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sistema extends CI_Controller {
    
     function __construct() {
        parent::__construct();
        
        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'session'));
        
    }
    
    function index($id) {
        $sess_array = array($id);
        $this->session->set_userdata('SGP_SISTEMA', $id);
        redirect(''.$this->session->userdata('SGP_SISTEMA').'/main', 'refresh');
    }

}