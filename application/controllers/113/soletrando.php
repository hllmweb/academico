<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Soletrando extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('sica/cursos_model', 'curso', TRUE);
        $this->load->model('sica/t_periodos_model', 'periodos', TRUE);
        $this->load->model('academico/palavra_soletrar_model', 'soletrar', TRUE);

        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'tracert'));
        $this->lang->load('sistema', $this->session->userdata('SGP_LANG'));
    }

    function index() {

        $log = new Tracert();
        $log->usuario = $this->session->userdata('USU_CODIGO');
        $log->validar_url();

        $data = array(
            'titulo' => 'ACADÊMICO',
            'SubTitulo' => 'PALAVRAS PARA O SOLETRANDO',
            'curso' => $this->curso->listar(),
            'periodo' => $this->periodos->listar(),
            'side_bar' => false
        );
        $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/soletrando/index', $data);
    }

    function grdRegistro() {
        $periodo = $this->input->post('periodo');
        $curso = $this->input->post('curso');
        $bimestre = $this->input->post('bimestre');
        $serie = $this->input->post('serie');

        $params = array();
        if (!empty($periodo)) {
            $params[] = array("campo" => 'PERIODO', 'valor' => $periodo);
        }

        if (!empty($curso)) {
            $params[] = array("campo" => 'CD_CURSO', 'valor' => $curso);
        }

        if (!empty($serie)) {
            $params[] = array("campo" => 'ORDEM_SERIE', 'valor' => $serie);
        }

        if (!empty($bimestre)) {
            $params[] = array("campo" => 'BIMESTRE', 'valor' => $bimestre);
        }

        $data = array(
            'lista' => $this->soletrar->filtrar($params)
        );

        $this->load->view($this->session->userdata('SGP_SISTEMA') . '/soletrando/grdRegistro', $data);
    }

    /**
     * 
     * @param string $id Uma string contendo a operacao a ser realizada e o 
     * código do registor a ser manipulado no formato <string>-<int>.
     * 
     * As operações podem ser:
     * 
     * I - cadastro em lote;
     * E - edição de um registro;
     * D - deletar um registro;
     */
    function mdlRegistro($id) {
        $item = explode('-', $id);
        $data = array(
            'curso' => $this->curso->listar(),
            'periodo' => $this->periodos->listar(),
        );

        if ($item[0] == 'I') {
            $this->load->view($this->session->userdata('SGP_SISTEMA') . '/soletrando/modalRegistroLote', $data);
        } else {
            $data['operacao'] = $item[0];
            $data['filtro'] = $this->soletrar->filtro_id(array(
                array('campo' => "CD_PALAVRA", "valor" => $item[1])
            ));
            $this->load->view($this->session->userdata('SGP_SISTEMA') . '/soletrando/mdlRegistro', $data);
        }
    }

    function frmManter() {
        $keys = array(
            array("campo" => "CD_PALAVRA", "valor" => $this->input->post('codigo'))
        );

        switch ($this->input->post('operacao')) {
            case 'E':
                $params = array(
                    array('campo' => 'CD_PALAVRA', "valor" => $this->input->post('codigo')),
                    array('campo' => 'PERIODO', "valor" => $this->session->userdata('SGP_PERIODO')),
                    array('campo' => 'BIMESTRE', "valor" => $this->input->post('bimestre')),
                    array('campo' => 'CD_CURSO', "valor" => $this->input->post('curso')),
                    array('campo' => 'ORDEM_SERIE', "valor" => $this->input->post('serie')),
                    array('campo' => 'FLG_DIFICULDADE', "valor" => $this->input->post('nivel')),
                    array('campo' => 'DC_PALAVRA', "valor" => $this->input->post('palavra')),
                    array('campo' => 'DC_DICA_EXEMPLO', "valor" => $this->input->post('dica')),
                    array('campo' => 'DC_DICA_APLICACAO_FRASE', "valor" => $this->input->post('aplicacao')),
                );

                $this->soletrar->editar($keys, $params);
                $retorno = '<h3 class="text-warning">Palavra Editada!!</h3>';
                break;
            case 'D':
                if ($this->soletrar->deletar($keys)) {
                    $retorno = '<h3 class="text-danger">Palavra Deletada!!</h3>';
                }
                break;
        }

        echo $retorno;
    }

    /**
     * Salva a lista de palavras enviadas do formulário de cadastro de palavras.
     * 
     * @return json
     */
    function formManterLote() {
        $lista = $this->input->post("palavra");

        $palavras = array();
        foreach ($lista as $row) {
            $palavras[] = array(
                'CD_USUARIO' => $this->session->userdata('SGP_CODIGO'),
                'PERIODO' => $this->session->userdata('SGP_PERIODO'),
                'CD_CURSO' => $this->input->post('curso'),
                'ORDEM_SERIE' => $this->input->post('serie'),
                'BIMESTRE' => $this->input->post('bimestre'),
                'FLG_DIFICULDADE' => $row['nivel'],
                'DC_PALAVRA' => $row['descricao'],
                'DC_DICA_EXEMPLO' => $row['dica'],
                'DC_DICA_APLICACAO_FRASE' => $row['aplicacao']
            );
        }

        $result = array(
            "success" => false,
            "mensagem" => "Ocorreu um erro ao salvar as palavras"
        );

        if ($this->soletrar->adicionar($palavras)) {
            $result['success'] = true;
            $result['mensagem'] = "<h3 class='text-success'>Palavra(s) Cadastrada(s)</h3>";
        }

        echo json_encode($result);
    }

    function impAcompanhamentoInfantil($id) {

        $pmt = explode('-', $id);

        $data = array(
            'aluno' => $this->secretaria->aluno_turma(array('operacao' => 'ALUNO', 'aluno' => $pmt[0])),
            'listar' => $this->pajela->aes_questionario_infantil(array('operacao' => 'L', 'aluno' => $pmt[0], 'questionario' => $pmt[1])),
        );

        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF();

        $body = $this->load->view('113/infantil/impAcompanhamentoInfantil', $data, true);
        $mpdf->AddPage('P', // L - landscape, P - portrait
                '', '', 9, '', 5, // margin_left
                5, // margin right
                30, // margin top
                30, // margin bottom
                0, // margin header
                1); // margin footer
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetDefaultBodyCSS('line-height', 1.5);
        $mpdf->SetColumns(1, 'J');

        $mpdf->WriteHTML($body);

        $mpdf->Output('CARTAO_RESPOSTAS-01.pdf', 'I');
    }

}
