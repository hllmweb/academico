<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Diario extends CI_Controller {
    
     function __construct() {
        parent::__construct();

        $this->load->model('geral/colegio_model', 'colegio', TRUE);
        $this->load->model('geral/secretaria_model', 'secretaria', TRUE);
        $this->load->model('professor_model', 'professor', TRUE);
        
        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation','diario_lib'));
        
    }
    
    function index() {
        
        if($this->session->userdata('SGP_TURMA') == ''){
            $p = explode(':',$this->input->get_post('frmSelTurma'));
            $sess_array = array();
            $this->session->set_userdata('SGP_TURMA'     , $p[0]);
            $this->session->set_userdata('SGP_DISICPLINA', $p[1]);
        }
        
        $fdisc = $this->professor->aes_diario_online(
             $a = array('operacao' => 'DT',
                         'periodo' => '2015/1',
                           'turma' => $this->session->userdata('SGP_TURMA'),
                      'disciplina' => $this->session->userdata('SGP_DISICPLINA'))
                );
        $p = array('operacao' => 'SIS',
                     'pessoa' => $this->session->userdata('SGP_CODIGO'));
        $data = array(
            'side_bar' => true,
            'info' => $fdisc,
            'TituloSistema' => 'DIÁRIO WEB',
            'titulo' => 'TURMA :: '.$this->session->userdata('SGP_TURMA').'',
            'SubTitulo' => 'DISCIPLINA :: '.$fdisc[0]['NM_DISCIPLINA'].'',
            'alunos' => $this->secretaria->aluno_turma(array('operacao'=>'A','turma'=>$this->session->userdata('SGP_TURMA')))
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/diario/index', $data);
    }
    
    function frmDiarioNota() {
        
        
        $fdisc = $this->professor->aes_diario_online(
                $a=array('operacao' => 'DT',
                          'periodo' => '2015/1',
                            'turma' => $this->session->userdata('SGP_TURMA'),
                       'disciplina' => $this->session->userdata('SGP_DISICPLINA'))
                );
        /* Chama a biblioteca Diario */
        $Diario_lib = new Diario_lib();
        /* passando parametros para a biblioteca */
        $Diario_lib->disciplina = $fdisc[0]['CD_DISCIPLINA'];
        $Diario_lib->turma = $fdisc[0]['CD_TURMA'];

        $data = array(
            'side_bar' => false,
            'info' => $fdisc,
            'TituloSistema' => 'DIÁRIO WEB',
            'titulo' => 'TURMA :: '.$this->session->userdata('SGP_TURMA').'',
            'SubTitulo' => 'DISCIPLINA :: '.$fdisc[0]['NM_DISCIPLINA'].'',
            'lista' => $Diario_lib->notas_turma_disciplina()
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/diario/frmDiarioNota', $data);
    }
    
    function frmDiarioFrequencia() {

        $fdisc = $this->professor->aes_diario_online(
                $a=array('operacao' => 'DT',
                         'periodo' => '2015/1',
                         'turma' => $this->session->userdata('SGP_TURMA'),
                    'disciplina' => $this->session->userdata('SGP_DISICPLINA'))
                );

        $p = array(
          'periodo' => '2015/1',
            'curso' => $fdisc[0]['CD_CURSO'],
            'serie' => $fdisc[0]['ORDEM_SERIE'],
            'turma' => $fdisc[0]['CD_TURMA'],
       'disciplina' => $fdisc[0]['CD_DISCIPLINA'],
        'professor' => $fdisc[0]['CD_PROFESSOR'],
                );

        $data = array(
            'side_bar' => false,
            'info' => $fdisc,
            'TituloSistema' => 'DIÁRIO WEB',
            'titulo' => 'TURMA :: '.$this->session->userdata('SGP_TURMA').'',
            'SubTitulo' => 'DISCIPLINA :: '.$fdisc[0]['NM_DISCIPLINA'].'',
            'lista' => $this->professor->cl_gera_diario_classe($p)
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/diario/frmDiarioFrequencia', $data);
    }

}