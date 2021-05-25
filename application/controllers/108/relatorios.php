<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Relatorios extends CI_Controller {
    
     function __construct() {
        parent::__construct();
        $this->load->model('relatorios_model', 'rel', TRUE);
        $this->load->model('geral/secretaria_model', 'secretaria', TRUE);
        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'session'));
        
    }
    
    function frmRelTema() {
        $data = array(
            'curso' => $this->secretaria->aluno_turma(array('operacao'=>'C')),
        );
         $this->load->view('relatorios/frmRelTema/index',$data);
    }
    
    function frmRelTblTema() {
        $data = array(
            'total' => $this->rel->relTema(
                    array('operacao' => 'FTEMAT', 
                             'curso' => $this->input->post('curso'), 
                             'serie' => $this->input->post('serie'), 
                        'disciplina' => $this->input->post('disciplina'))
                    ),
            'livres' => $this->rel->relTema(
                    array('operacao' => 'FTEMAL', 
                             'curso' => $this->input->post('curso'), 
                             'serie' => $this->input->post('serie'), 
                        'disciplina' => $this->input->post('disciplina'))
                    ),
            'usadas' => $this->rel->relTema(
                    array('operacao' => 'FTEMAU', 
                             'curso' => $this->input->post('curso'), 
                             'serie' => $this->input->post('serie'), 
                        'disciplina' => $this->input->post('disciplina'))
                    ),
        );
         $this->load->view('relatorios/frmRelTema/frmRelTblTema',$data);
    }   

}