<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sistema extends CI_Controller {
    
     function __construct() {
        parent::__construct();
        $this->load->model('sica/sistema_model', 'sistema', TRUE);
        $this->load->model('sica/programa_model', 'programa', TRUE);
        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation'));
        
    }
    
    function index() {
        
        $data = array(
            'side_bar' => false,
            'TituloSistema' => 'CONTROLE DE ACESSO',
            'titulo' => 'CONTROLE DE ACESSO',
            'SubTitulo' => 'SISTEMAS',
            'listar'   => $this->sistema->listar(array('campo'=>'DC_SISTEMA', 'ordem'=>'ASC')),
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/sistema/index', $data);
    }

    function frmPrograma($id) {
        $data = array(            
            'operacao' => $item[0],
            'id'       => $item[1],
            'listar'   => $this->programa->filtrar(array(array('campo'=>'SISTEMA', 'valor'=>$id))),
            'filtro'   => $this->sistema->pesquisar_id(array('campo'=>'SISTEMA', 'valor'=>$id)),
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/sistema/frmPrograma',$data);
    }
    
    
    function frmCadastro($id) {
        $item = explode('-',$id); 
        $data = array(            
            'operacao' => $item[0],
            'id'       => $item[1],
            'filtro'   => $this->sistema->pesquisar_id(array('campo'=>'SISTEMA', 'valor'=>$item[1])),
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/sistema/frmCadastro',$data);
    }
    
    function frmManter() {
        
        switch($this->input->post('Operacao')){
            case 'I': 
                $param = array(
                    'SISTEMA'    => $this->sistema->max('SISTEMA')+1,
                    'DC_SISTEMA' => $this->input->post('Nome'),
                    'TITULO'     => $this->input->post('Titulo'),
                    'VERSAO'     => $this->input->post('Versao'),
                    'ATIVO'      => $this->input->post('Status'),
                );
                $retorno = $this->sistema->inserir($param);
            break;
            case 'U':
                $param = array(
                    array('campo' => 'DC_SISTEMA', 'valor' => $this->input->post('Nome')),
                    array('campo' => 'TITULO',     'valor' => $this->input->post('Titulo')),
                    array('campo' => 'VERSAO',     'valor' => $this->input->post('Versao')),
                    array('campo' => 'ATIVO',     'valor' => $this->input->post('Status')),
                );
                
                $key = array(
                    array('campo' => 'SISTEMA', 'valor' => $this->input->post('Codigo')),
                );
                $retorno = $this->sistema->editar($key,$param);
            break;
            case 'D': 
                $key = array(
                    array('campo' => 'SISTEMA', 'valor' => $this->input->post('Codigo'))
                );
                $retorno = $this->sistema->deletar($key);
            break;
        }
        echo $retorno;
        sleep(2);
        echo '<script>window.location.reload();</script>';
    }
    
    

}