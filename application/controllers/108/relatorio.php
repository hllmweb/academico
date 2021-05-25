<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Relatorio extends CI_Controller {
    
    private $tela;
    
    function __construct() {
        parent::__construct();
        $this->load->model('sica/cursos_model', 'curso', true);
        $this->load->model('prova_model', 'banco', TRUE);
        $this->load->model('geral/secretaria_model', 'secretaria', TRUE);
        $this->load->model('sica/aes_cartoes_lidos_model', 'cartoes', TRUE);

        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'session', 'prova_lib'));
        
        $this->tela = $this->session->userdata('SGP_SISTEMA') . '/relatorio/';
    }

    function index() {
        $data = array(
            'tela' => $this->tela,
            'curso' => $this->secretaria->aluno_turma(array('operacao' => 'C')),
            'titulo' => 'BANCO DE PROVAS',
            'SubTitulo' => 'RELATÓRIO DE AVALIAÇÕES',
            'tipo_prova' => $this->banco->banco_prova(array('operacao' => 'TP')),
            'side_bar' => false
        );

        $this->load->view($this->tela.'index', $data);
    }

    function grdProva() {
        if ($this->input->post('filtro') == 0) {
            $p = array(
                'operacao' => (($this->input->post('tipo') == 2) ? 'FCN' : 'FCNA'), //'FCN',
                'periodo' => $this->input->post('periodo'),
                'tipo_prova' => $this->input->post('tipo'),
                'curso' => $this->input->post('curso'),
                'serie' => $this->input->post('serie'),
                'disciplina' => (($this->input->post('disciplina') == '') ? NULL : $this->input->post('disciplina')),
                'bimestre' => (($this->input->post('bimestre') == '') ? NULL : $this->input->post('bimestre')),
                'tipo_nota' => (($this->input->post('tipo_nota') == '') ? NULL : $this->input->post('tipo_nota')),
                'chamada' => (($this->input->post('chamada') == '') ? NULL : $this->input->post('chamada')),
            );
        }elseif($this->input->post('filtro') == 1) {
            $p = array(
                'operacao' => 'CHECK',
                'num_prova' => $this->input->post('numProva'),
            );
        }elseif($this->input->post('filtro') == 2){
            $p = array(
                'operacao' => 'LRDATA',
                'data_prova' => $this->input->post('data_prova')
            );
        }

        $data = array(
            'tela' => $this->tela,
            'resultado' => $this->banco->banco_prova($p),
        );
        $this->load->view($this->tela. '/grdProva', $data);
    }
    
    function frmRelatorio() {

        $row = json_decode(base64_decode($this->input->get('p') ) );
        $aluno = $this->cartoes->prova_detalhe($row->CD_PROVA);
        
        $param = array(
            array('campo' => "(CD_PROVA = ".$row->CD_PROVA." OR CD_PROVA_PAI = ".$row->CD_PROVA.")", 'valor' => '')
        );
        
        $rsquestao = $this->curso->auxiliar('BD_SICA.VW_PROVA_RESULTADO_QUESTAO',$param);
        
        
        $pprova = array(
            array('campo' => 'CD_PROVA', 'valor' => $row->CD_PROVA),
        );
        
        $questao = $this->curso->auxiliar('BD_SICA.VW_PROVA_RESULTADO_OPCAO',$pprova);
        

        $data = array(
            'tela' => $this->tela,
            'titulo' => 'BANCO DE PROVAS',
            'SubTitulo' => 'RELATÓRIO DE AVALIAÇÕES',
            'row' => $row,
            'aluno' => $aluno, // RESULTADO GERAL
            'rsquestao' => $rsquestao, // RESULTADO DAS QUESTOES POR PROVA
            'questao' => $questao
        );

        $this->load->view($this->tela.'frmRelatorio', $data);
    }
    
    
    
    

}
