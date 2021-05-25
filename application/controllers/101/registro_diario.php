<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Registro_diario extends CI_Controller {

     function __construct() {
        parent::__construct();

        $this->load->model('sica/cursos_model', 'cursos', TRUE);

        $this->load->model('sica/aluno_model', 'aluno', TRUE);
        $this->load->model('academico/aes_tipo_registro_model', 'tipo', TRUE);
        $this->load->model('113/registro_diario_model', 'registro', TRUE);
        $this->load->model('sica/t_periodos_model', 'periodos', TRUE);

        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'session', 'tracert'));
                
    }

    function index() {
        
        /*$log = new Tracert();
        $log->usuario = $this->session->userdata('USU_CODIGO');
        $log->validar_url();*/

        $data = array(
              'titulo' => 'MÓDULO DA COORDENAÇÃO',
           'SubTitulo' => 'REGISTRO DIÁRIO',
               'curso' => $this->cursos->listar(),
             'periodo' => $this->periodos->listar(),
            'side_bar' => false
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/registro_diario/index',$data);

    }

    function grdRegistro() {

        $param = array(
            'periodo' => $this->input->post('periodo'),
            'curso' => $this->input->post('curso'),
            'serie' => $this->input->post('serie'),
            'turma' => $this->input->post('turma'),
        );
     
        if ($this->input->post('tipoFiltro') == 0){
            $busca = $this->registro->listar_turma($param);
        } else{
            $busca = $this->registro->listar_pendencias();
        }
        
        $data = array(
            'tipoFiltro' => $this->input->post('tipoFiltro'),
            'lista' => $busca
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/registro_diario/grdRegistro', $data);

    }

    function mdlRegistro($id){
        
        $item = explode('-', $id);
        
        $data = array(
        'operacao' => $item[0],
          'codigo' => (($item[1] != '')? $item[1] : 0),
           'curso' => $this->cursos->listar(),
            'tipo' => $this->tipo->listar(),
            'serie'=>$item[2],
          'filtro' => $this->registro->filtro(array('codigo'=>$item[1])),
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/registro_diario/mdlRegistro', $data);

    }
    
    function mdlRegistroAluno() {
        $data = array(
             'lista' => $this->registro->listar(array('aluno'=>$this->input->get('aluno'), 'periodo'=>$this->input->get('periodo'),'filtro'=>$this->input->get('filtro')))
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/registro_diario/mdlRegistroAluno',$data);        
    }
    
    
    function frmManter(){

        $data = array(
          'operacao' => $this->input->post('operacao'),
            'codigo' => $this->input->post('codigo'),
             'aluno' => $this->input->post('aluno'),
              'tipo' => 7,
              'data' => $this->input->post('data'),
         'descricao' => $this->input->post('descricao'),
            'periodo' => $this->session->userdata('SGP_PERIODO'),
            'usuario' => $this->session->userdata('SGP_CODIGO'),
        );
        switch($this->input->post('operacao')){
            case 'A':
  
                $al = $this->input->post('aluno');

                if($al[0] == ''){
                   echo  $retorno = '<label class="text-danger">Selecione o(s) ALUNO(s) </label>';exit;
                }
                foreach($this->input->post('aluno') as $al){
                    $data = array(
                        'operacao' => $this->input->post('operacao'),
                        'codigo' => $this->input->post('codigo'),
                        'tipo' => 7,
                        'aluno' => $al,
                        'sms' => 'N',
                        'data' => $this->input->post('data'),
                        'periodo' => $this->session->userdata('SGP_PERIODO'),
                        'usuario' => $this->session->userdata('SGP_CODIGO'),
                        'descricao' => $this->input->post('descricao'),
                     );
                    $this->registro->adicionar($data);
                }
         
                echo $retorno = '<h3 class="text-warning">Registros Adicionados</h3><script>window.location.reload();</script>';
            break;

            case 'E':
                $this->registro->editar($data);
                echo $retorno = '<h3 class="text-warning">Registros Editados</h3>';
            break;

            case 'D':
                $data = array(
                    'operacao' => $this->input->post('operacao'),
                    'codigo' => $this->input->post('codigo')
                );
                $this->registro->deletar($data);
                echo $retorno = '<h3 class="text-danger">Registros Excluídos</h3><script>window.location.reload();</script>';
            break;
        
            case 'L':
                $st = explode('-', $this->input->post('status'));
                $data = array(
                    'operacao' => $this->input->post('operacao'),
                    'codigo' => $this->input->post('codigo'),
                    'status' => $st[0]
                );
                $this->registro->liberar($data);
                echo $retorno = '<h3 class="text-danger">A visibilidade do registro pelo responsável foi atualizada</h3><script>window.location.reload();</script>';
            break;
        }
    }

}