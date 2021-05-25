<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Prova_cartao extends CI_Controller {
    
     function __construct() {
        parent::__construct();

        $this->load->model('prova_model', 'banco', TRUE);
        $this->load->model('cadastro_model', 'cadastro', TRUE);
        $this->load->model('geral/secretaria_model', 'secretaria', TRUE);
        $this->load->model('geral/colegio_model', 'colegio', TRUE);
        
        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'session', 'prova_lib'));
        
    }
      
    function index() {
            $data = array(
                'cartao' => $this->banco->prova_alunos(array('operacao'=>'FCT','prova'=>$this->input->get('prova'), 'aluno'=>$this->input->get('aluno'))),
            );
        $this->load->view('cartao/aluno', $data);
    }
    

}
