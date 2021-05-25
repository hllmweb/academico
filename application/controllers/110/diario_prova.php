<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Diario_prova extends CI_Controller {
    
     function __construct() {
        parent::__construct();
        
        $this->load->model('prova_model', 'banco', TRUE);
        $this->load->model('geral/colegio_model', 'colegio', TRUE);
        $this->load->model('geral/secretaria_model', 'secretaria', TRUE);
        $this->load->model('professor_model', 'professor', TRUE);
        
        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation','diario_lib'));
        
    }
    
    // MOSTRA O MODAL COM AS PROVAS QUE FORAM APLICADAS POR RESPONSABILIDADE DO PROFESSOR
    function mdlDiarioProva($id) {
        $data = array(
            'side_bar' => false,
              'titulo' => 'TURMA :: '.$this->session->userdata('SGP_TURMA').'',
              'provas' => $this->professor->aval_professor_provas(array('professor' => $this->session->userdata('SGP_PROFESSOR'), 'turma' => $id))
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/diario/provas/mdlDiarioProva', $data);
    }
    
    // RELAÇÃO DOS ALUNOS QUE FIZERAM A PROVA OBJETIVA E TIVERAM SEUS CARTÕES PROCESSADOS
    function mdlDiarioProvaAluno() {
        $prova = $this->banco->banco_prova(array('operacao'=>'VFC','prova'=>$this->input->post('prova')));
        if($prova[0]['FLG_PEND_PROCESSAMENTO'] == 0){
            $data = array(
                   'prova' => $prova,
                'side_bar' => false,
                  'titulo' => 'TURMA :: '.$this->session->userdata('SGP_TURMA').'',
                  'alunos' => $this->banco->prova_alunos(array('operacao'=>'LPA','prova'=>$this->input->post('prova'))),
            );
            $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/diario/provas/mdlDiarioProvaAluno', $data);
        }else{
            echo 0;
        }
    }
    
    // ROTINA QUE ATUALIZA NOTA DISSERTATIVA
    function frmLancarNotaAluno() {
        $data = array(
            'nota' => $this->input->post('nota'),
          'prova' => $this->input->post('prova'),
          'aluno' => $this->input->post('aluno'),
        );
        echo $this->professor->aval_prova_aluno_nota($data);
    }
    
    // LANÇA NOTA NA BD_SICA.CL_ALU_NOTA    
    function frmProcessaNota() {
        /*
         * FUNÇÃO QUE PROCESSA AS NOTAS LANÇADAS 
         * E INSERE NA BD_SICA.CL_ALU_NOTA
         *  ENVIA EMAIL PARA A COORDENAÇÃO
         */        
        $id = $this->input->post('prova');        
       $data = array(
               'prova' => $this->input->post('prova'),
          'disciplina' => $this->session->userdata('SGP_DISICPLINA')
        );
        $retorno = $this->professor->aval_processa_nota($data);
        echo $retorno;      
        
        /************************ ENVIO DE EMAIL PARA A COORDENAÇÃO ***********/
        $data = array(
            'prova' => $this->banco->banco_prova(array('operacao'=>'CHECK','prova'=>$id)),
            'turma' => 'TURMA :: '.$this->session->userdata('SGP_TURMA').'',
            'lista' => $this->banco->prova_alunos(array('operacao'=>'LEMAIL','prova'=>$id)),
            'retorno' => $retorno
        );
        
        $nemail = 'SISTEMA DE PROVAS';
        $assunto = 'SISTEMA DE PROVAS';
        $sistema = 'Acadêmico - Lançamento de Notas';
        $de = 'sistema.web@seculomanaus.com.br';
        $para = 'silvio.souza@seculomanaus.com.br';
        
        $mensagem = $this->load->view('emails/emlLancarNota', $data, true);

        $config = array();
        $config['protocol'] = "smtp";
        $config['smtp_host'] = "smtp.seculomanaus.com.br";
        $config['smtp_port'] = "25";
        $config['smtp_user'] = "sistema.web@seculomanaus.com.br";
        $config['smtp_pass'] = "SistemaWeb2015!";
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $config['smtp_crypto'] = 'TLS';
        $config['newline'] = "\r\n";
        $config['wordwrap'] = TRUE;

        $this->load->library('email');
        $this->email->initialize($config);

        $this->email->from($de,$sistema);
        $this->email->to($para);
        $this->email->subject($assunto);
        $this->email->message($mensagem);
        $this->email->send();
        //echo $this->email->print_debugger();        
        
    }

    // MOSTRA O MODAL OS TIPOS DE NOTAS
    function mdlDiarioLancarNota($id) {
        $data = array(
            'side_bar' => false,
              'titulo' => 'TURMA :: '.$this->session->userdata('SGP_TURMA').'',
          'tipo_nota' => $this->professor->aes_diario_notas(array('operacao' => 'LNT','turma'=>$this->session->userdata('SGP_TURMA'),'disciplina'=>$this->session->userdata('SGP_DISICPLINA')))
        );
        $this->load->view('110/diario/notas/mdlDiarioLancarNota', $data);
    }

    // MOSTRA O MODAL OS TIPOS DE NOTAS
    function mdlDiarioListarAluno() {
        $data = array(
        'side_bar' => false,
         'txtNota' => $this->input->post('mini'),
            'nota' => $this->input->post('nota'),
        'bimestre' => $this->input->post('bimestre'),
          'titulo' => 'TURMA :: '.$this->session->userdata('SGP_TURMA').'',
          'alunos' => $this->professor->aes_diario_notas($a = array('operacao' => 'LA','num_nota'=>$this->input->post('nota'), 'turma'=>$this->session->userdata('SGP_TURMA'),'disciplina'=>$this->session->userdata('SGP_DISICPLINA')))
        );
        $this->load->view('110/diario/notas/mdlDiarioListarAluno', $data);
    }
    
    // ROTINA LANÇA A NOTA NO SISTEMA
    function frmLancarNota() {
        $data = array(
           'nota' => $this->input->post('nota'),
        'numNota' => $this->input->post('numNota'),
          'aluno' => $this->input->post('aluno'),
        );
        //print_r($data);
        echo $this->professor->aes_diario_lancar_nota($data);
    }

    function emlLancarNota() {

        /*
         *  FUNÇÃO QUE ENVIA EMAIL PARA A COORDENAÇÃO
         *  COM A RELAÇÃO DAS NOTAS QUE FORAM INSERIDAS PELO PROFESSOR
         */

        /************************ ENVIO DE EMAIL PARA A COORDENAÇÃO ***********/
        $lista = $this->professor->aes_diario_notas($a = array('operacao' => 'NDT',
                                                             'disciplina' => $this->session->userdata('SGP_DISICPLINA'),
                                                                  'turma' => $this->session->userdata('SGP_TURMA'),
                                                               'bimestre' => $this->input->get('b'),
                                                               'num_nota' => $this->input->get('n')
                ));

        $data = array(
            'turma' => 'TURMA :: '.$this->session->userdata('SGP_TURMA').'',
            'lista' => $lista
        );
         $nemail = 'SISTEMA DE PROVAS';
        $assunto = 'LANÇAMENTO DE NOTAS DE '.$lista[0]['NM_DISCIPLINA'].' BIMESTRE Nº '.$lista[0]['BIMESTRE'].' - '.$lista[0]['NM_MINI'].'';
        $sistema = 'Acadêmico - Lançamento de Notas';
             $de = 'sistema.web@seculomanaus.com.br';
           $para = 'silvio.souza@seculomanaus.com.br';
        
        $mensagem = $this->load->view('emails/emlLancarNota', $data, true);

        $config = array();
        $config['protocol']  = "smtp";
        $config['smtp_host'] = "smtp.seculomanaus.com.br";
        $config['smtp_port'] = "25";
        $config['smtp_user'] = "sistema.web@seculomanaus.com.br";
        $config['smtp_pass'] = "SistemaWeb2015!";
        $config['mailtype']  = 'html';
        $config['charset']   = 'utf-8';
        $config['smtp_crypto'] = 'TLS';
        $config['newline']  = "\r\n";
        $config['wordwrap'] = TRUE;

        $this->load->library('email');
        $this->email->initialize($config);

        $this->email->from($de,$sistema);
        $this->email->to($para);
        $this->email->subject($assunto);
        $this->email->message($mensagem);
        $this->email->send();
        //echo $this->email->print_debugger();        
        redirect('110/diario/frmDiarioNota', 'refresh');
    }
    
    
}