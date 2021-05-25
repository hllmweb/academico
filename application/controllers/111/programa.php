<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Programa extends CI_Controller {
    
     function __construct() {
        parent::__construct();
        $this->load->model('sica/sistema_model', 'sistema', TRUE);
        $this->load->model('sica/programa_model', 'programa', TRUE);
        $this->load->model('sica/gpermissoes_model', 'permissao', TRUE);

        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation'));
        
    }
    
    function index() {
        
        $data = array(
            'side_bar' => false,
            'TituloSistema' => 'CONTROLE DE ACESSO',
            'titulo' => 'CONTROLE DE ACESSO',
            'SubTitulo' => 'PROGRAMA',
            'listar'   => $this->programa->listar(array('campo'=>'NM_PROGRAMA', 'ordem'=>'ASC')),
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/programa/index', $data);
    }
    
    
    function frmDependencia($id) {
        $data = array(            
            'operacao' => $item[0],
            'id'       => $item[1],
            'listar'   => $this->permissao->filtrar(array(array('campo'=>'CD_PROGRAMA', 'valor'=>$id))),
            'filtro'   => $this->programa->pesquisar_id(array('campo'=>'CD_PROGRAMA', 'valor'=>$id)),
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/programa/frmDependencia',$data);
    }
    
    
    function frmCadastro($id) {
        $item = explode('-',$id); 
        $data = array(            
            'operacao' => $item[0],
            'id'       => $item[1],
            'filtro'   => $this->programa->pesquisar_id(array('campo'=>'CD_PROGRAMA', 'valor'=>$item[1])),
            'sistema'   => $this->sistema->listar(array('campo'=>'DC_SISTEMA', 'ordem'=>'ASC')),
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/programa/frmCadastro',$data);
    }
    
    function frmManter() {
        
        switch($this->input->post('Operacao')){
            case 'I': 
                $param = array(
                    'CD_PROGRAMA' => $this->programa->max('CD_PROGRAMA')+1,
                    'NM_PROGRAMA' => $this->input->post('Nome'),
                    'SISTEMA'     => $this->input->post('Sistema'),
                    'FORMULARIO'  => $this->input->post('Formulario'),
                    'OBSERVACAO'  => $this->input->post('Observacao'),
                );
                $retorno = $this->programa->inserir($param);
            break;
            case 'U':
                $param = array(
                    array('campo' => 'NM_PROGRAMA', 'valor' => $this->input->post('Nome')),
                    array('campo' => 'SISTEMA',     'valor' => $this->input->post('Sistema')),
                    array('campo' => 'FORMULARIO',  'valor' => $this->input->post('Formulario')),
                    array('campo' => 'OBSERVACAO',  'valor' => $this->input->post('Observacao')),
                );
                $key = array(
                    array('campo' => 'CD_PROGRAMA', 'valor' => $this->input->post('Codigo')),
                );
                $retorno = $this->programa->editar($key,$param);
            break;
            case 'D': 
                $key = array(
                    array('campo' => 'CD_PROGRAMA', 'valor' => $this->input->post('Codigo'))
                );
                $retorno = $this->programa->deletar($key);
            break;
        }
        echo $retorno;
        sleep(2);
        echo '<script>window.location.reload();</script>';
    }
    
    function comboPrograma() {
        
        $programa = $this->programa->filtrar(
            array(array('campo'=>'SISTEMA', 'valor'=> $this->input->post('sistema')))
        );

        $combo = '<option></option>';
        foreach($programa as $p){
            $combo .= '<option value="'.$p->CD_PROGRAMA.'">'.$p->NM_PROGRAMA.'</option>';
        }
        echo $combo;
    }

}