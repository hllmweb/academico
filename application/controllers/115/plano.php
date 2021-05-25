<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Plano extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('acesso_model', 'acesso', TRUE);
        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'session'));
    }

    function index() {
        $data = array(
            'titulo' => 'GRUPOS',
            'SubTitulo' => 'CONTROLE DE ACESSO',
            'TituloSistema' => 'CONTROLE DE ACESSO',
            'listar' => $this->acesso->grupo(array('operacao' => 'L')),
            'side_bar' => false
        );
        $this->load->view('111/grupos/index', $data);
    }
    
}