<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Prova_online extends CI_Controller {
    
     function __construct() {
        parent::__construct();

        $this->load->model('sica/cursos_model', 'cursos', TRUE);
        $this->load->model('sica/t_periodos_model', 'periodos', TRUE);
        //$this->load->model('sica/aes_prova_model', 'prova', TRUE);
        $this->load->model('sica/aes_prova_inscritos_model', 'inscritos', TRUE);
        
        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'session', 'prova_lib'));       
    }
      
    function index() {
        $data = array(
            'titulo' => 'GERENCIADOR DE AVALIAÇÕES',
         'SubTitulo' => 'PROVA ONLINE',
          'side_bar' => false,
             'curso' => $this->cursos->listarCursosOrdem(),
           'periodo' => $this->periodos->listar(),
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/prova_online/index', $data);
    }
    
    function grdRegistro() {

        //$prova = 3717;
        $prova = $this->input->post('prova'); //3997
        $listar_disciplinas = $this->inscritos->disciplinasPorProva($prova);
        $listar = $this->inscritos->listar_aluno($prova); 
        
        $qtdeRespondidas = $this->inscritos->verificarRespondidas($prova);      
        $quantidade = $qtdeRespondidas[0]['QUANTIDADE'];
     
        $this->session->set_userdata('quantidadeRespondidas', $quantidade);
      
        $lt = array();
        $respDisc = array();
        foreach($listar as $l){
            $lt[$l['CD_ALUNO']]['aluno'] =  $l;
            foreach($listar_disciplinas as $ld){
               // $lt[$l['CD_ALUNO']][$ld['CD_DISCIPLINA']]['respostas'] =  $this->inscritos->listar_questoesRespondidas(array('prova'=>$l['CD_PROVA_VERSAO'],'aluno'=>$l['CD_ALUNO'],'disciplina'=>$ld['CD_DISCIPLINA'] ));
                $lt[$l['CD_ALUNO']][$ld['CD_DISCIPLINA']]['respostas'] =  $this->inscritos->acompanhamento(array('prova'=>$prova,'aluno'=>$l['CD_ALUNO'],'disciplina'=>$ld['CD_DISCIPLINA'] ));
                
            }
        }
        
        foreach($listar_disciplinas as $ld){
            $respDisc[$ld['CD_DISCIPLINA']]= $this->inscritos->listar_questoesRespondidasPorTempo(array('prova'=>$prova,'disciplina'=>$ld['CD_DISCIPLINA'] ));
        }
     
        $data = array(
            'disciplinas' => $listar_disciplinas,
            'listar' => $lt,
            'ranking' => $this->inscritos->ranking(array('prova'=>$prova)),
            'listarResp' => $respDisc
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/prova_online/grdRegistro',$data);        
    }
    
    //Função para verificar se foi finalizada mais alguma avaliação para atualizar a tela de acompanhamento da prova online  By: Mônica
    function verificarRespondidas() {
        
        $prova = $this->input->post('prova');
        
        $qtdeRespondidas = $this->inscritos->verificarRespondidas($prova);
        
        $quantidade = 0;
        
        $aux = 0;
      
        foreach($qtdeRespondidas as $qtde){
            $quantidade = $qtde['QUANTIDADE'];
        }    
        if (($quantidade == $this->session->userdata('quantidadeRespondidas'))){
            $aux = 0;
        }else{     
            $this->session->set_userdata('quantidadeRespondidas', $quantidade);
            $aux = 1;
        }
        
        echo $aux;
    }

}
