<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Prova_correcao extends CI_Controller {
    
     function __construct() {
        parent::__construct();

        $this->load->model('prova_model', 'banco', TRUE);
        $this->load->model('cadastro_model', 'cadastro', TRUE);
        $this->load->model('geral/secretaria_model', 'secretaria', TRUE);
        $this->load->model('geral/colegio_model', 'colegio', TRUE);
        
        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'session','prova_lib'));
        
    }
    
    function index() {
        $data = array(
            'titulo' => 'PROVAS PARA CORREÇÃO',
            'SubTitulo' => 'PROVAS PARA CORREÇÃO',
            'TituloSistema' => 'GESTOR DE PROVAS',
            'listar' => $this->banco->banco_prova(array('operacao'=>'F', 'status' => 5)),
            'side_bar' => false
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/provas/correcoes/index',$data);
    }
    
    function frmCorrecao($id) {

        $prova = $this->banco->banco_prova(array('operacao'=>'VFC','prova'=>$id));
        $questoes = $this->banco->prova_questao(array('operacao'=> 'FK', 'prova' => $id));

        $lista = array();        
        foreach($questoes as $q){
            $lista[] = array(
                 'codigo' => $q['CD_QUESTAO'],
                'questao' => $q['DC_QUESTAO'],
                   'tipo' => $q['FLG_TIPO'],
                'posicao' => $q['POSICAO'],
                  'prova' => $prova[0]['CD_PROVA'],
                  'opcao' => $this->cadastro->questao_resposta(array('operacao' => 'FK', 'questao' => $q['CD_QUESTAO'])),
               'conteudo' => $this->cadastro->questao_conteudo(array('operacao' => 'FK', 'questao' => $q['CD_QUESTAO'])),
            );
        }        
        
        $data = array(
            'titulo' => 'PROVAS PARA CORREÇÃO',
            'SubTitulo' => 'PROVAS PARA CORREÇÃO',
            'TituloSistema' => 'GESTOR DE PROVAS',
            'prova' => $prova,
            'lista' => $lista,
            'side_bar' => false
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/provas/correcoes/frmCorrecao',$data);        
    }
    
}
