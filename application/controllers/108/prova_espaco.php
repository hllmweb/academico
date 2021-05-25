<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Prova_espaco extends CI_Controller {
    
     function __construct() {
        parent::__construct();

        $this->load->model('prova_model', 'banco', TRUE);
        $this->load->model('cadastro_model', 'cadastro', TRUE);
        $this->load->model('geral/secretaria_model', 'secretaria', TRUE);
        $this->load->model('geral/colegio_model', 'colegio', TRUE);
        
        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'session', 'prova_lib'));
        
    }
      
    function mdlProvaEspaco($id) {
        
        $prova = $this->banco->banco_prova(array('operacao'=>'FPV', 'prova'=>$id));
        
        $data = array(
              'listar' => $prova,
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/provas/espaco/mdlProvaEspaco', $data);
    }
    
    function frmManterQuestaoProva($p) {
        // RECEBE OS DADOS DO FORMULARIO
        $params = array(
                    'operacao' => $this->input->post('txtPQOperacao'),
                       'prova' => $this->input->post('txtPQProva'),
                     'questao' => $this->input->post('txtPQQuestao'),
                     'posicao' => $this->input->post('txtPQPosicao'),
                       'valor' => $this->input->post('txtPQValor'),
                     'anulada' => $this->input->post('txtPQAnulada'),
                 );
        $l = $this->banco->prova_questao($params);
        echo '<label class="label label-success">Dados Registrados</label>';
      }

}
