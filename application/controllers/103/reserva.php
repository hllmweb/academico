<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reserva extends CI_Controller {
    
     function __construct() {
        parent::__construct();

        $this->load->model('sica/cursos_model', 'curso', TRUE);
        $this->load->model('geral/secretaria_model', 'secretaria', TRUE);
        $this->load->model('pajela_model', 'pajela', TRUE);
        $this->load->model('sica/t_periodos_model', 'periodos', TRUE);
        $this->load->model('academico/reserva_solicitacao_model', 'reserva', TRUE);

        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation','Menu_lib','diario_lib', 'tracert'));

    }
    
    function index() {
        
        $log = new Tracert();
        $log->usuario = $this->session->userdata('USU_CODIGO');
        $log->validar_url();

        $data = array(
            'titulo' => 'INTRANET',
            'SubTitulo' => 'RESERVA DE ESPAÇO E LABORATÓRIO / SOLICITAÇÃO',
            'curso' => $this->curso->listar(),
            'side_bar' => false
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/reserva/index', $data);
    }
    
    function mdlfrmBuscaAvancada() {

        $data = array(
            'TituloSistema' => 'COORDENADORES',
            'titulo' => 'RESERVA DE LOCAL',
            'SubTitulo' => 'RESERVA DE LOCAL',
            'curso' => $this->curso->listar(),
            'side_bar' => false
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/reserva/mdlfrmBuscaAvancada', $data);
    }
    function formataData($string) {
        $date = date('Y/m/d', strtotime(implode("-", array_reverse(explode("/", $string)))));
        return($date);
    }
    
    
    function listview() {

        $p = array(
            'periodo' => $this->input->post('periodo'),
            'data'    => $this->input->post('data'),
            'local'   => $this->input->post('local')
        );
        $lista = $this->reserva->listar_filtro($p);

        $rs = array();
        foreach($lista as $l){
            
            $dt_fim = (($l['DT_PRATICA_FINAL'] != '')? ''.$this->formataData($l['DT_PRATICA_FINAL']).''  : ''.$this->formataData($l['DT_PRATICA']).'' );

            
            
            $rs[] = array(
                'id'    => $l['CD_RESERVA'],
                'title' => $l['NM_LOCAL'],
                'professor' => $l['NM_PROFESSOR'],
                'start' => ''.$this->formataData($l['DT_PRATICA']).(($dt_fim == $this->formataData($l['DT_PRATICA']))? ' '.($l['HR_INICIO']).':00 ' : '' ),
                'end'   => ''.$dt_fim.(($dt_fim == $this->formataData($l['DT_PRATICA']))? ' '.($l['HR_INICIO_FINAL']).':00 ' : '' ),
                'inicio' => date('d/m/Y', strtotime(implode("-", array_reverse(explode("/", $l['DT_PRATICA']))))),
                'final'   => date('d/m/Y', strtotime(implode("-", array_reverse(explode("/", $l['DT_PRATICA_FINAL']))))),
                'hr_inicio' => 'Início: '.$l['HR_INICIO'].':00 ',
                'hr_final' => (($l['HR_FINAL'] != '')? 'Término: '.$l['HR_FINAL'].':00 ': ''),
            );
        }
        print_r(json_encode($rs));
    }
    
    
    function grdRegistro() {

        $p = array(
            'periodo' => $this->input->post('periodo'),
            'data'    => $this->input->post('data'),
            'local'   => $this->input->post('local')
        );
        $data = array(
           'lista' => $this->reserva->listar_filtro($p)
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/reserva/grdRegistro', $data);

    }
    
    function mdlfrmSolicitacao($id) {
        $item = explode('-',$id);
        $data = array(
            'curso' => $this->curso->listar(),
            'periodo' => $this->periodos->listar(),
            'filtro' => $this->reserva->filtro(array('codigo' => $item[1])),
            'operacao' => $item[0],
            'side_bar' => false
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/reserva/mdlfrmSolicitacao', $data);

    }
    
    function frmResultado($id) {
        $item = explode('-',$id);
        $data = array(
            'curso' => $this->curso->listar(),
            'periodo' => $this->periodos->listar(),
            'operacao' => $item[0],
            'side_bar' => false
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/reserva/frmResultado', $data);
    }
    
    
    function frmEmailReserva($id) {

        // CONSULTA RESERVA GERADA
        $reseva = $this->reserva->filtro(array('codigo' => $id));
        
        $data = array(
            'turma'  => 'TURMA :: '.$this->session->userdata('SGP_TURMA').'',
            'filtro' => $reseva
        );

        $assunto = 'NOVA RESERVA DE ESPAÇO';
        $sistema = 'MÓDULO ACADÊMICO';
        $de = 'sistema.web@seculomanaus.com.br';
        $para = 'biblioteca@seculomanaus.com.br';
        //$para = 'emilly.nascimento@seculomanaus.com.br';

        $mensagem = $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/reserva/frmEmailReserva', $data, true);

        $this->load->library('email');
        $this->email->initialize();
        $this->email->from($de,$sistema);
        $this->email->to($para);
        $this->email->subject($assunto);
        $this->email->message($mensagem);
        $this->email->send();
    }
    
    
   function frmManter() {

        $param = array(
            'codigo' => $this->input->post('resCodigo'),
           'periodo' => $this->input->post('resPeriodo'),
         'professor' => $this->input->post('resProfessor'),
        'disciplina' => $this->input->post('resDisciplina'),
             'curso' => $this->input->post('resCurso'),
             'serie' => $this->input->post('resSerie'),
             'turma' => $this->input->post('resTurma'),
        'nr_pratica' => $this->input->post('resPratica'),
          'conteudo' => $this->input->post('resConteudo'),
          'objetivo' => $this->input->post('resObjetivo'),
          'material' => $this->input->post('resMaterial'),
            'metodo' => $this->input->post('resMetodo'),
         'resultado' => $this->input->post('resResultado'),
        'observacao' => $this->input->post('resObservacao'),
             'local' => $this->input->post('resLocal'),
          'dtInicio' => $this->input->post('ResInicio'),
             'dtFim' => $this->input->post('ResTermino'),
            'inicio' => $this->input->post('resHInicio'),
               'fim' => $this->input->post('resHFim'),
            'status' => 'N',
        );

        switch($this->input->post('operacao')){
            case 'A':
                // ADICIONA A SOLICITAÇÃO
                $id = $this->reserva->adicionar($param);
                // CHAMA A FUNÇÃO QUE ENVIARÁ O EMAIL DE NOVA SOLICITAÇÃO
                $this->frmEmailReserva($id);
                echo '<h3 class="text-success">Solicitação de Reserva Adicionada! </h3><script>window.location.reload();</script>';
            break;
            case 'L': 
                $param['status'] = 'F';
                $this->reserva->editar($param);
                echo '<h3 class="text-warning">Solicitação de Reserva Atualizada!</h3><script>window.location.reload();</script>';
            break;
            case 'E': 
                $this->reserva->editar($param);
                echo '<h3 class="text-warning">Solicitação de Reserva Atualizada!</h3><script>window.location.reload();</script>';
            break;
            case 'D': 
                $this->reserva->deletar($param);
                echo '<h3 class="text-danger">Solicitação de Reserva Excluída!</h3><script>window.location.reload();</script>';
            break;
        }
    }
    
        
    function aprovacao() {
        
        $log = new Tracert();
        $log->usuario = $this->session->userdata('USU_CODIGO');
        $log->validar_url();

        $data = array(
            'titulo' => 'INTRANET',
            'SubTitulo' => 'RESERVA DE ESPAÇO E LABORATÓRIO / APROVAÇÃO',
            'curso' => $this->curso->listar(),
            'side_bar' => false
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/reserva/aprovacao', $data);
    }
    
    
    function grdRegistroAprovacao() {

        $p = array(
               'data' => $this->input->post('data'),
              'local' => $this->input->post('local')
        );
        $data = array(
           'lista' => $this->reserva->listar_filtro($p)
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/reserva/grdRegistroAprovacao', $data);

    }
    
    function frmDeferir($id) {
        $item = explode('-',$id);
        
        $reserva = $this->reserva->filtro(array('codigo' => $item[1]));
        
        $data = array(
           'reserva' => $reserva
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/reserva/frmDeferir', $data);
    }
    
    function frmManterDeferir() {

        $param = array(
            'codigo' => $this->input->post('codigo'),
        'ocorrencia' => $this->input->post('ocorrencia'),
            'status' => $this->input->post('status'),
        );
        $this->reserva->editar_status($param);
    }
    
    
    /*************** PARTE DO PROFESSOR */
    function professor() {
        
        $log = new Tracert();
        $log->usuario = $this->session->userdata('USU_CODIGO');
        $log->validar_url();

        $data = array(
            'titulo' => 'INTRANET',
            'SubTitulo' => 'RESERVA DE ESPAÇO E LABORATÓRIO / AÇÃO DO PROFESSOR',
            'side_bar' => false
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/reserva/professor', $data);
    }
    
    function grdRegistroProfessor() {

        $p = array(
               'data' => $this->input->post('data'),
              'local' => $this->input->post('local')
        );
        $data = array(
           'lista' => $this->reserva->listar_filtro($p)
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/reserva/grdRegistroProfessor', $data);

    }

}