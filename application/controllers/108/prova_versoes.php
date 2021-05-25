<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Prova_versoes extends CI_Controller {
    
     function __construct() {
        parent::__construct();

        $this->load->model('prova_model', 'banco', TRUE);
        $this->load->model('cadastro_model', 'cadastro', TRUE);
        $this->load->model('geral/secretaria_model', 'secretaria', TRUE);
        $this->load->model('geral/colegio_model', 'colegio', TRUE);
        
        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'session', 'prova_lib'));
        
    }
      
    function mdlProvaGerarVersoes($id) {
        
        $prova = $this->banco->banco_prova(array('operacao'=>'VFC','prova'=>$id));

        $data = array(
              'filtro' => $prova,
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/provas/versoes/mdlProvaGerarVersoes', $data);
    }
    
    
    function GerarVersoes() {
       
        $c = new Prova_lib();
        $c->prova = $this->input->post('prova');
        $c->qtdprovas = $this->input->post('qtd');
        echo $c->gerar_espelho();
        
    }
    

}
