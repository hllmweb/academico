<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pasta_virtual extends CI_Controller {
    
     function __construct() {
        parent::__construct();

        
        $this->load->helper(array('form', 'url', 'html', 'directory', 'cookie'));
        $this->load->library(array('form_validation','ftp'));
        
        
        $config['hostname'] = '10.228.20.30';
        $config['username'] = 'bianca.rocha';//$this->input->cookie('user');
        $config['password'] = 'biancarocha';
        $config['port']     = 21;
        $config['passive']  = FALSE;
        $config['debug']    = TRUE;

        $this->ftp->connect($config);
    }
    
    function index() {
        
        $data = array(
            'titulo' => 'PASTA VIRTUAL',
            'SubTitulo' => 'PASTA VIRTUAL',
            'TituloSistema' => 'PASTA VIRTUAL',
            'usuario' => 'bianca.rocha',
            'pastas' => $this->ftp->list_files('/'),
            'side_bar' => false
        );
        $this->load->view('110/pasta_virtual/index',$data);
    }
    
    function frmPasta() {
        
        $pasta = unserialize(urldecode($this->input->get('pasta')));
        
        $this->session->set_userdata('SGP_PASTA_ATUAL', $pasta['pasta']);
        $data = array(
            'titulo' => strtoupper(''.$this->session->userdata('SGP_PASTA_ATUAL').''),
            'SubTitulo' => 'PASTA VIRTUAL',
            'TituloSistema' => 'PASTA VIRTUAL',
            'pastas' => $this->ftp->list_files('/'),
            'aberta' => $this->ftp->list_files(''.$this->session->userdata('SGP_PASTA_ATUAL').''), // pasta aperta
            'side_bar' => false
        );
        $this->load->view('110/pasta_virtual/frmPasta',$data);
        
    }
    
    function fctCriarPasta() {
        $this->ftp->mkdir(''.$this->session->userdata('SGP_PASTA_ATUAL').'/'.$this->input->post('novaPasta').'', DIR_WRITE_MODE);        
    }
    
    function fctEnviarArquivo() {
        $this->ftp->upload(''.$_FILES['arquivo']['tmp_name'].'', ''.$this->session->userdata('SGP_PASTA_ATUAL').'/'.$_FILES['arquivo']['name'].'', 'ascii', 0775);
    }
    
    function fctBaixarArquivo() {
        $this->ftp->download(''.$_FILES['arquivo']['tmp_name'].'', ''.$this->session->userdata('SGP_PASTA_ATUAL').'/'.$_FILES['arquivo']['name'].'', 'ascii');
    }
    
    
    function frmFechar() {
        $this->ftp->close();      
    }

}