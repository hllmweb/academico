<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Liberacao extends CI_Controller {

     function __construct() {
        parent::__construct();

        $this->load->model('prova_model', 'banco', TRUE);
        $this->load->model('cadastro_model', 'cadastro', TRUE);
        $this->load->model('geral/secretaria_model', 'secretaria', TRUE);
        $this->load->model('geral/colegio_model', 'colegio', TRUE);
        $this->load->model('sica/t_periodos_model', 'periodo', TRUE);

        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'session', 'prova_lib','tracert'));
        
        if($this->session->userdata('SGP_CODIGO')==''){ redirect(base_url(),'refresh');}        
    }

    function index() {
        
        $log = new Tracert();
        $log->validar_url();
        
        $data = array(
            'curso' => $this->secretaria->aluno_turma(array('operacao'=>'C')),
            'titulo' => 'GERENCIADOR DE AVALIAÇÕES',
            'SubTitulo' => 'LIBERAÇÃO WEB',
            'tipo_prova' => $this->banco->banco_prova(array('operacao'=>'TP')),
            'periodo' => $this->periodo->listar(),
            'side_bar' => false
        );
        
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/liberacao/index',$data);
    }

    /*
     * FUNÇÃO QUE MOSTRA O RESULTADO DA CONSULTA DA PAGINA INDEX DO BANCO DE PROVAS
     */
    function grdProva() {
        if($this->input->post('filtro') == 0){
            $p = array(
                'operacao' => (($this->input->post('tipo') == 2) ? 'FCN_DISCURSIVA': 'FCNA_DISCURSIVA'),//'FCN',
                'periodo' => $this->input->post('periodo'),
                'tipo_prova' => $this->input->post('tipo'),
                'curso' => $this->input->post('curso'),
                'serie' => $this->input->post('serie'),
                'disciplina' => (($this->input->post('disciplina') == '') ? NULL : $this->input->post('disciplina')),
                'bimestre' => (($this->input->post('bimestre') == '') ? NULL : $this->input->post('bimestre')),
                'tipo_nota' => (($this->input->post('tipo_nota') == '') ? NULL : $this->input->post('tipo_nota')),
                'chamada' => (($this->input->post('chamada') == '') ? NULL : $this->input->post('chamada')),
            );
        }elseif($this->input->post('filtro') == 1){
            $p = array(
                'operacao' => 'CHECK_DISCURSIVA',
                'num_prova' => $this->input->post('numProva'),
            );
        }elseif($this->input->post('filtro') == 2){
            $p = array(
                'operacao' => 'LDATA',
                'data_prova' => $this->input->post('data_prova')
            );
        }
        
        $data = array(
            'resultado' => $this->banco->banco_prova($p),
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/liberacao/grdProva',$data);        
    }
    
    function frmLiberacao() {
        parse_str($_POST['prova'], $params);
        foreach($params['prova'] as $p){
          $param = array(
                'operacao'  => 'LBWEB',
                'prova'     => $p,
                'flg_web'   => $this->input->post('tipo'),
            );

          $this->banco->banco_prova($param);
        }
    }


    function frmLiberaNota(){
      parse_str($_POST['prova'], $params);
      foreach ($params['prova'] as $p) {
        $param = array(
          'operacao' => 'LNOTA',
          'prova' => $p,
          'flg_web' => $this->input->post('flg_lib_nota_portal')
        );

        $this->banco->banco_prova($param);

      }
    }
    
    
}
