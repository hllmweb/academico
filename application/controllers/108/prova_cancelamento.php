<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Prova_cancelamento extends CI_Controller {
    
     function __construct() {
        parent::__construct();

        $this->load->model('prova_model', 'banco', TRUE);
        $this->load->model('cadastro_model', 'cadastro', TRUE);
        $this->load->model('geral/secretaria_model', 'secretaria', TRUE);
        $this->load->model('geral/colegio_model', 'colegio', TRUE);
        
        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'session', 'prova_lib'));
        
    }
      
    function index($id) {
        $data = array(
            'titulo' => 'SOLICITAÇÕES & CANCELAMENTOS',
            'SubTitulo' => 'GESTOR DE PROVAS',
            'TituloSistema' => 'GESTOR DE PROVAS',
            'tipo_prova' => $this->banco->banco_prova(array('operacao'=>'TP')),
            'side_bar' => false
        );
        $this->load->view('108/provas/cancelamento/index', $data);
    }
    
    function frmNovaSolicitacao($id) {
        $data = array(
            'tipo' => $this->banco->aval_prova_cancenlamento(array('operacao'=>'LM')),
            'para' => $this->banco->aval_prova_cancenlamento(array('operacao'=>'LU')),
        );
        $this->load->view('108/provas/cancelamento/frmNovaSolicitacao', $data);
    }
    
    function frmManter() {
        
        $this->form_validation->set_rules('prova', ' ', 'trim|required|xss_clean|callback_validar_prova');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'operacao' => $this->input->post('operacao'),
                  'codigo' => $this->input->post('codigo'),
                   'prova' => $this->input->post('prova'),
                  'motivo' => $this->input->post('motivo'),
               'aprovador' => $this->input->post('aprovador'),
               'nr_provas' => $this->input->post('qtdProvas'),
               'nr_cartao' => $this->input->post('qtdCartao'),
            );
            //print_r($data);
            echo true;
            //$res = $this->banco->aval_prova_cancenlamento($data);
        }else{
            echo false;
        }
    }
    
    function callback_validar_prova($prova) {
        $p = array(
         'operacao' => 'FC',
          'prova' => $prova,
        );
        $result =  $this->banco->banco_prova($p);
        
        if ($result[0]['CD_PROVA'] != '') {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    

}
