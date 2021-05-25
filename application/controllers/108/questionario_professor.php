<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Questionario_professor extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('sica/cursos_model', 'cursos', TRUE);
        $this->load->model('quest/web_resultado_professor_model', 'resultado', TRUE);
        $this->load->model('quest/web_questionario_model', 'quest', TRUE);
        $this->load->model('sica/t_periodos_model', 'periodos', TRUE);

        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'session', 'tracert'));

        $this->lang->load('sistema', $this->session->userdata('SGP_LANG'));
    }

    function index() {

        //$log = new Tracert();
        //$log->usuario = $this->session->userdata('USU_CODIGO');
        //$log->validar_url();

        $data = array(
            'titulo' => 'GERENCIADOR DE AVALIAÇÃO',
            'SubTitulo' => 'AVALIAÇÃO INSTITUCIONAL DO PROFESSOR',
            'side_bar' => false,
            'curso' => $this->cursos->listar(),
            'periodo' => $this->periodos->listar(),
            'quest' => $this->quest->listar(),
        );
        $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/questionario_professor/index', $data);
    }

    function grdRegistro() {

        $param = array(
            'quest'      => $this->input->post('quest'),
            'curso'      => $this->input->post('curso'),
            'serie'      => $this->input->post('serie'),
            'turma'      => $this->input->post('turma'),
            'periodo'    => $this->input->post('periodo'),
            'disciplina' => $this->input->post('disciplina'),
            'bimestre'   => $this->input->post('bimestre'),
        );

        switch ($this->input->post('quest')){
            // AVALIAÇÃO DO ALUNO
            case 5:
                if ($this->input->post('tipo') == 'P') {
                    $data['lista'] = $this->resultado->web_resultado_pergunta($param);
                    $url = site_url("108/relatorio_avaliacao_institucional/perguntas");
                    $url .= "?quest=" . $this->input->post('quest');
                    $url .= "&curso=" . $this->input->post('curso');
                    $url .= "&serie=" . $this->input->post('serie');
                    $url .= "&turma=" . $this->input->post('turma');
                    $url .= "&periodo=" . $this->input->post('periodo');
                    $url .= "&disciplina=" . $this->input->post('disciplina');
                    $url .= "&bimestre=" . $this->input->post('bimestre');
                    $data['urlRelatorio'] = $url;
                    $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/questionario_professor/grdRegistro', $data);
                } else {
                    $data['lista'] = $this->resultado->web_resultado_divisao($param);
                    $url = site_url("108/relatorio_avaliacao_institucional/topicos");
                    $url .= "?quest=" . $this->input->post('quest');
                    $url .= "&curso=" . $this->input->post('curso');
                    $url .= "&serie=" . $this->input->post('serie');
                    $url .= "&turma=" . $this->input->post('turma');
                    $url .= "&periodo=" . $this->input->post('periodo');
                    $url .= "&disciplina=" . $this->input->post('disciplina');
                    $url .= "&bimestre=" . $this->input->post('bimestre');
                    $data['urlRelatorio'] = $url;
                    $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/questionario_professor/grdRegistroDisciplina', $data);
                }
                break;
            // AUTO AVALIAÇÃO DO PROFESSOR
            case 6:
                if ($this->input->post('tipo') == 'P') {
                    $data['listar'] = $this->resultado->web_resultado_pergunta_auto($param);
                    $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/questionario_professor/grdAutoProf', $data);
                } else {
                    $listar = $this->resultado->web_resultado_divisao($param);
                }
                break;
            // AVALIAÇÃO DO COORDENADOR
            case 7:

            break;
        }
    }

}
