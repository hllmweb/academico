<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Atendimento extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('academico/orientacao_atendimento_model', 'atendimento', TRUE);
        $this->load->model('sica/aluno_model', 'aluno', TRUE);
        $this->load->model('sica/cursos_model', 'cursos', TRUE);
        $this->load->model('sica/responsavel_model', 'responsavel', TRUE);
        $this->load->model('sica/t_periodos_model', 'periodos', TRUE);

        $this->load->helper(array('url'));
        $this->load->library(array('session', 'tracert'));

        $this->lang->load('sistema', $this->session->userdata('SGP_LANG'));
    }

    function index() {
        $log = new Tracert();
        $log->usuario = $this->session->userdata('USU_CODIGO');
        $log->validar_url();

        $data = array(
            'titulo' => 'MÓDULO DE ORIENTAÇÃO',
            'SubTitulo' => 'ATENDIMENTO',
            'curso' => $this->cursos->listar(),
            'periodo' => $this->periodos->listar(),
        );
        $this->load->view($this->session->userdata('SGP_SISTEMA') . '/atendimento/index', $data);
    }

    function gridRegistro() {
        $param = array(
            'curso' => $this->input->post('curso'),
            'serie' => $this->input->post('serie'),
            'turma' => $this->input->post('turma'),
            'periodo' => $this->input->post('periodo'),
        );

        $data = array(
            'lista' => $this->atendimento->listar_turma($param)
        );

        $this->load->view($this->session->userdata('SGP_SISTEMA') . '/atendimento/gridRegistro', $data);
    }

    function modalRegistro($id) {
        $item = explode('-', $id);

        $operacao = $item[0];
        $codigo = $item[1];

        $data = array(
            'operacao' => $operacao,
            'codigo' => empty($codigo) ? 0 : $codigo,
            'curso' => $this->cursos->listar(),
            'registro' => $this->atendimento->filtro_id(array(
                array("campo" => "CD_REGISTRO", "valor" => $codigo)
            )),
        );

        $this->load->view($this->session->userdata('SGP_SISTEMA') . '/atendimento/modalRegistro', $data);
    }

    function modalRegistroAluno($id) {
        $aux = explode("-", $id);

        $data = array(
            'registros' => $this->atendimento->filtrar(array(
                array("campo" => "ID_RESPONSAVEL", "valor" => $aux[0]),
                array("campo" => "CD_ALUNO", "valor" => $aux[1])
            ))
        );

        $this->load->view($this->session->userdata('SGP_SISTEMA') . '/atendimento/modalRegistroAluno', $data);
    }

    function formManter() {
        $operacao = $this->input->post('operacao');
        $retorno = "<h3 class='text-danger'>Ocorreu um erro ao processar o Antedimento!</h3>";

        //obter o responsavel e o aluno a qual ele está representando e data do atendimento
        $aluno = null;
        $responsavel = null;
        $data = new DateTime();
        if ($operacao == "I" || $operacao == "E") {
            $aux = explode("-", $this->input->post("responsavelAluno"));
            $responsavel = $aux[0];
            $aluno = $aux[1];

            $data = $data->createFromFormat('d/m/Y', $this->input->post('data'));
            $data = $data->format("d-M-y");
        }

        switch ($operacao) {
            case 'I':
                $params = array(
                    'PERIODO' => $this->session->userdata('SGP_PERIODO'),
                    'ID_RESPONSAVEL' => $responsavel,
                    'CD_ALUNO' => $aluno,
                    'DS_ATENDIMENTO' => $this->input->post("atendimento"),
                    'DS_OBSERVACAO' => $this->input->post("observacao"),
                    'DT_ATENDIMENTO' => $data,
                    'CD_USUARIO' => $this->session->userdata('SGP_CODIGO')
                );

                if ($this->atendimento->inserir($params)) {
                    $retorno = "<h3 class='text-success'>Atendimento Processado!</h3><script>window.location.reload()</script>";
                }
                break;
            case 'E':
                $keys = array(
                    array("campo" => 'CD_REGISTRO', "valor" => $this->input->post("codigo"))
                );

                $params = array(
                    //array("campo" => "DT_ATENDIMENTO", "valor" => $data),
                    array("campo" => "DS_ATENDIMENTO", "valor" => $this->input->post("atendimento")),
                    array("campo" => "DS_OBSERVACAO", "valor" => $this->input->post("observacao"))
                );

                if ($this->atendimento->editar($keys, $params)) {
                    $retorno = "<h3 class='text-warning'>Atendimento Atualizado!</h3><script>window.location.reload()</script>";
                }

                break;
            case 'D':
                $keys = array(
                    array("campo" => 'CD_REGISTRO', "valor" => $this->input->post("codigo"))
                );

                if ($this->atendimento->deletar($keys)) {
                    $retorno = "<h3 class='text-danger'>Atendimento Excluído!</h3><script>window.location.reload()</script>";
                }
                break;
        }

        echo $retorno;
    }

    function termo($id) {
        $data = array(
            'dados' => $this->atendimento->filtro_id(array(
                array("campo" => "CD_REGISTRO", "valor" => $id)
            ))
        );

        $body = $this->load->view($this->session->userdata('SGP_SISTEMA') . '/atendimento/termo', $data, true);

        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF();
        $mpdf->SetHTMLHeader($this->load->view('impressao/header_doc', $data, true));
        $mpdf->AddPage('P', // L - landscape, P - portrait
                '', '', '', '', 0, // margin_left
                0, // margin right
                30, // margin top
                30, // margin bottom
                0, // margin header
                0); // margin footer
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHTMLFooter($this->load->view('impressao/footer_doc', $data, true));
        $mpdf->WriteHTML($body);
        $mpdf->Output('TERMO DE ATENDIMENTO.pdf', 'I');
    }

}
