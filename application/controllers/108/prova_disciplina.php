<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Prova_disciplina extends CI_Controller {
    
     function __construct() {
        parent::__construct();

        $this->load->model('prova_model', 'banco', TRUE);
        $this->load->model('cadastro_model', 'cadastro', TRUE);
        $this->load->model('geral/secretaria_model', 'secretaria', TRUE);
        $this->load->model('geral/colegio_model', 'colegio', TRUE);
        
        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'session','prova_lib'));
        
    }
    
      
      function mdlPesquisarTemaQuestoes() {
        
        $params = array('operacao' => 'FQP', 
                           'curso' => $this->input->get('avalCurso'),
                           'serie' => $this->input->get('avalSerie'),
                      'disciplina' => $this->input->get('avalDisciplina'),
                            'tema' => $this->input->get('avalTema')
                       );
        
        $questoes = $this->cadastro->questao($params);
       
        $lista = array();        
        foreach($questoes as $q){
            $lista[] = array(
                 'codigo' => $q['CD_QUESTAO'],
                'questao' => $q['DC_QUESTAO'],
                   'tipo' => $q['FLG_TIPO'],
                  'prova' => $this->input->post('txtFTProva'),
                  'opcao' => $this->cadastro->questao_resposta(array('operacao' => 'FK', 'questao' => $q['CD_QUESTAO'])),
               'conteudo' => $this->cadastro->questao_conteudo(array('operacao' => 'FK', 'questao' => $q['CD_QUESTAO'])),
            );
        }
        $data = array(
              'listar' => $lista,
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/provas/mdlPesquisarTemaQuestoes', $data);
    }
      
      
      
      function frmManterDespacho() {
        // RECEBE OS DADOS DO FORMULARIO
        $params = array(
                    'operacao' => $this->input->post('DPOperacao'),
                       'prova' => $this->input->post('DPProva'),
                        'flag' => (($this->input->post('DPStatus') == 2)? 'A': 'R'),
                      'motivo' => $this->input->post('DPMotivo'),
                 'complemento' => $this->input->post('DPComplemento'),
                      'status' => $this->input->post('DPStatus'),
                 );
        
        $p = array(
                    'operacao' => 'S',
                      'codigo' => $this->input->post('DPProva'),
                      'status' => $this->input->post('DPStatus'),
                 );
        
        $r = $this->banco->prova($p);
        $l = $this->banco->prova_despacho($params);
        
        echo 'Dados Registrados';
    }
    

}
