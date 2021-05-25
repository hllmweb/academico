<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Avaliacao extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('prova_model', 'prova', TRUE);
        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'session'));
        
        $this->lang->load('sistema', $this->session->userdata('SGP_LANG'));
    }

    function aberta() {
        $data = array(
            'titulo' => strtoupper($this->lang->line('PGAVALTESTLIB')),
            'SubTitulo' => strtoupper($this->lang->line('RFSISAVALIACAOONLINE')),
            'TituloSistema' => strtoupper($this->lang->line('RFSISAVALIACAOONLINE')),
            'side_bar' => false
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/avaliacao/aberta/index', $data);
    }
    
    
    function validar() {

        // remove a sessão do ID da PROVA
        $this->session->unset_userdata('TST_ID_PROVA');

        $data = array(
            'titulo' => strtoupper($this->lang->line('PGAVALTESTLIB')),
            'SubTitulo' => strtoupper($this->lang->line('RFSISAVALIACAOONLINE')),
            'TituloSistema' => strtoupper($this->lang->line('RFSISAVALIACAOONLINE')),
            'side_bar' => false
        );

        $this->form_validation->set_rules('tstlibid', ' ', 'numeric|required|callback_validar_prova');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/avaliacao/aberta/index');
        } else {
            redirect(''.$this->session->userdata('SGP_SISTEMA').'/avaliacao/frmIniciar', 'refresh');
        }
    }

    function validar_prova($tstlibid) {

        $p = array(
         'operacao' => 'P',
          'aluno' => $this->session->userdata('SGP_USER'),
          'prova' => $tstlibid,
        );
        $result = $this->prova->prova_online($p);
        if ($result == FALSE) {
            $this->form_validation->set_message('validar_prova', "usuário/senha inválidos");
            return FALSE;
        } else {
            $this->session->set_userdata('TST_NUM_PROVA', $result[0]['NUM_PROVA']);
            return TRUE;
        }
    }
    
     function frmIniciar() {
         
         if($this->session->userdata('SGP_USER') == '' || $this->session->userdata('TST_NUM_PROVA') == ''){
             redirect(''.$this->session->userdata('SGP_SISTEMA').'/main', 'refresh');
         }
         
         
         $p = array(
         'operacao' => 'P',
          'aluno' => $this->session->userdata('SGP_USER'),
          'prova' => $this->session->userdata('TST_NUM_PROVA'),
        );
         
        $data = array(
            'titulo' => strtoupper($this->lang->line('PGAVALTESTLIB')),
            'SubTitulo' => strtoupper($this->lang->line('RFSISAVALIACAOONLINE')),
            'TituloSistema' => strtoupper($this->lang->line('RFSISAVALIACAOONLINE')),
            'avaliacao' => $this->prova->prova_online($p),
            'side_bar' => false
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/avaliacao/aberta/frmIniciar', $data);
    }
    
}