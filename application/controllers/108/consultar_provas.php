<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Consultar_provas extends CI_Controller {
    
     function __construct() {
        parent::__construct();

        // $this->load->model('prova_model', 'banco', TRUE);
        // $this->load->model('cadastro_model', 'cadastro', TRUE);
        // $this->load->model('geral/secretaria_model', 'secretaria', TRUE);
        // $this->load->model('geral/colegio_model', 'colegio', TRUE);
        
        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'session', 'prova_lib'));
        
    }
      
    function index() {
       $data = array(
            'titulo' => 'CONSULTAR PROVAS',
            'SubTitulo' => 'CONSULTAR PROVAS',
            'TituloSistema' => 'GESTOR DE PROVAS',
            //'listar' => $this->banco->banco_prova(array('operacao'=>'F', 'status' => 7)),
            'side_bar' => false
        );
        $this->load->view('108/provas/consultar_provas', $data);
    }


}