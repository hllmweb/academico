<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Prova_despacho extends CI_Controller {
    
     function __construct() {
        parent::__construct();

        $this->load->model('prova_model', 'banco', TRUE);
        $this->load->model('cadastro_model', 'cadastro', TRUE);
        $this->load->model('geral/secretaria_model', 'secretaria', TRUE);
        $this->load->model('geral/colegio_model', 'colegio', TRUE);
        
        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'session', 'prova_lib'));
        
    }
    
    function frmManterStatus() {
        // RECEBE OS DADOS DO FORMULARIO
        $params = array(
                    'operacao' => $this->input->post('operacao'),
                       'prova' => $this->input->post('avalProva'),
                     'questao' => $this->input->post('avalQuestao'),
                     'posicao' => $this->input->post('avalPosicao'),
                       'valor' => $this->input->post('avalValor'),
                     'anulada' => $this->input->post('avalAnulada'),
                 );
        //print_r($params);;
        $l = $this->banco->prova_questao($params);
        echo '<label class="label label-success">Dados Registrados</label>';
      }
    

}
