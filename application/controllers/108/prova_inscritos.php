<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Prova_inscritos extends CI_Controller {
    
     function __construct() {
        parent::__construct();

        $this->load->model('prova_model', 'banco', TRUE);
        $this->load->model('cadastro_model', 'cadastro', TRUE);
        $this->load->model('geral/secretaria_model', 'secretaria', TRUE);
        $this->load->model('geral/colegio_model', 'colegio', TRUE);
        
        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'session', 'prova_lib'));
        
    }
      
    function mdlProvaInscritos($id)        {
        
        $prova = $this->banco->banco_prova(array('operacao'=>'VFC','prova'=>$id));

        $data = array(
            'prova' => $prova,
            'turma' => $this->secretaria->aluno_turma(array('operacao'=>'T','curso'=>$prova[0]['CD_CURSO'],'ordem'=>$prova[0]['ORDEM_SERIE'])),
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/provas/inscritos/mdlProvaInscritos', $data);
    }

    function mdlProvaInscritosAlinhamento($id){
        
        $data = array(
            'prova' => $id,
            'curso' => $this->secretaria->aluno_turma(array('operacao'=>'C')),
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/provas/inscritos/mdlProvaInscritosAlinhamento', $data);
    }
    
    function mdlProvaInscritosCliente($id) {
        
        $prova = $this->banco->banco_prova(array('operacao'=>'VFC','prova'=>$id));

        $data = array(
              'listar' => $prova,
            'conteudo' => $this->cadastro->conteudo(array('operacao' => 'F', 'tema' => $this->input->get('tema'))),
            'turma' => $this->secretaria->aluno_turma(array('operacao'=>'T','curso'=>$prova[0]['CD_CURSO'],'ordem'=>$prova[0]['ORDEM_SERIE'])),
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/provas/inscritos/mdlProvaInscritos', $data);
    }      
    function grdTurmaAlunos($id)           {
        
        $data = array(
            'lista' => $this->secretaria->aluno_turma(array('operacao'=>'A','turma'=>$id)),
            'prova' => $this->input->post('avalProva') 
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/provas/inscritos/grdTurmaAlunos', $data);
    }

    function frmManterInscritos($p){

        // RECEBE OS DADOS DO FORMULARIO
        $params = array(
            'operacao' => (($this->input->post('operacao')!= '')       ? $this->input->post('operacao')        : $p['operacao']        ),
               'prova' => (($this->input->post('avalProva')!= '')      ? $this->input->post('avalProva')       : $p['avalProva']       ),
               'aluno' => (($this->input->post('avalProvaAluno')!= '') ? $this->input->post('avalProvaAluno')  : $p['avalProvaAluno']  ),
               'curso' => (($this->input->post('avalCurso')!= '')      ? $this->input->post('avalCurso')       : $p['avalCurso']       ),
               'serie' => (($this->input->post('avalSerie')!= '')      ? $this->input->post('avalSerie')       : $p['avalSerie']       ),
              'versao' => (($this->input->post('avalProvaVersao')!= '')? $this->input->post('avalProvaVersao') : $p['avalProvaVersao'] ),
                'fila' => (($this->input->post('avalFila')!= '')       ? $this->input->post('avalFila')        : $p['avalFila']        ),
             'posicao' => (($this->input->post('avalPosicao')!= '')    ? $this->input->post('avalPosicao')     : $p['avalPosicao']     ),
        );
        //print_r($params);
        $l = $this->banco->prova_aluno_inscritos($params);
    }
    
     // **********************************************************  CANCEÇAMENTO DE INSCRIÇÃO DOS ALUNOS
    function frmCancelaInscricao()         {
        parse_str($_POST['aluno'], $params);
        foreach($params['listaDeleteInscrito'] as $a){
            $pr = array(
                'operacao' => 'D',
                'avalProva' => $_POST['prova'],
                'avalProvaAluno' => $a,
            );
            $this->frmManterInscritos($pr);
        }
        echo '<label class="label label-success">Cancelamento realizado com sucesso!</label>';
    }
    
     // **********************************************************  INSCRIÇÃO MANUAL DOS ALUNOS
    function frmNovaInscricao()         {
        parse_str($_POST['aluno'], $params);
        foreach($params['lstAlunos'] as $a){
            $pr = array(
                 'operacao' => 'I',
                'avalProva' => $_POST['avalProva'],
           'avalProvaAluno' => $a,
            );
            //print_r($pr);
            $this->frmManterInscritos($pr);
        }
        //echo '<label class="label label-success">Inscrições realizadas com sucesso!</label>';
    }
    
     // **********************************************************  INSCRIÇÃO DE ALINHAMENTO
    function frmNovaInscricaoAlinhamento(){
        $pr = array(
            'prova' => $_POST['avalProva'],
            'curso' => $_POST['avalCurso'],
            'serie' => $_POST['avalSerie'],
        );

        $l = $this->banco->prova_inscritos_alinhamento($pr);
        
        echo '<label class="label label-success">Inscrições realizadas com sucesso!</label>';
    }


    // **********************************************************  INSCRIÇÃO AUTOMÁTICA DOS ALUNOS
    // VERIFICA ATRAVÉS DO TIPO DE CHAMADA QUE ESTA SENDO PASSADO
    // QUAL SERÁ A FUNÇÃO DO BANCO QUE A PROCEDURE CHAMARÁ
    function frmInscricaoAutomatica(){
        $pr = array(
            'operacao' => (($this->input->post('avalChamada')== 1)? '1CH' : '2CH'),
           'avalProva' => $this->input->post('avalProva'),
        );
        $r = $this->frmManterInscritos($pr);
        echo '<label class="label label-success">Inscrições realizadas com sucesso!</label>';
    }
    // **********************************************************
    
    
    
    // **********************************************************  ASSOCIAÇÃO AUTOMÁTICA DOS ALUNOS
    function mdlProvaAlunoAssociar($id){
        $data = array(
            'prova' => $id 
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/provas/inscritos/mdlAssociarAluno', $data);
    }
    
    function mdlAssociar(){
        $c = new Prova_lib();
        $c->prova = $this->input->post('prova');
        echo $c->aluno_associar();
    }
    // **********************************************************

}