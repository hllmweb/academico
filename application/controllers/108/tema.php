<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tema extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("academico/tema_model", "tema", true);
        $this->load->model("sica/cursos_model", "curso", true);
        $this->load->model("sica/serie_model", "serie", true);
        $this->load->model("sica/disciplina_model", "disciplina", true);

        $this->load->helper(array('url'));
        $this->load->library(array('session'));
    }

    /**
     * Direciona para tela inicial do módulo para inserir filtros de pesquisa
     */
    function index() {
        $data = array(
            'titulo' => 'TEMAS E CONTEÚDOS',
            'SubTitulo' => 'PESQUISAR',
            'cursos' => $this->curso->listarRegular()
        );

        $this->load->view('108/tema/index', $data);
    }

    /**
     * exibe os dados da pesquisa realizada
     */
    function grdTema() {
        $params = null;

        if ($this->input->post("codigo") != null) {
            $params = array(
                array(
                    "campo" => "CD_TEMA",
                    "valor" => $this->input->post("codigo")
                ),
            );
        } else if ($this->input->post("disciplina") != null) {
            $params = array(
                array(
                    "campo" => "CD_CURSO",
                    "valor" => $this->input->post("curso")
                ),
                array(
                    "campo" => "ORDEM_SERIE",
                    "valor" => $this->input->post("serie")
                ),
                array(
                    "campo" => "CD_DISCIPLINA",
                    "valor" => $this->input->post("disciplina")
                ),
            );
        }

        $data = array(
            'temas' => $this->tema->filtrar($params),
            "gerar" => $this->input->post("gerar")
        );

        $this->load->view('108/tema/grdTema', $data);
    }

    /**
     * Exibe o formulário de cadastro do tema de acordo com o tipo de operação
     */
    function modalTema() {
        $operacao = $this->input->get('operacao');

        $series = null;
        $disciplinas = null;
        if ($operacao == "E" || $operacao == "D") {
            //obter dados do tema caso exista
            $paramsTema = array(
                'campo' => 'CD_TEMA',
                'valor' => $this->input->get('codigo')
            );
            $tema = $this->tema->pesquisar_id($paramsTema);

            //obter dados dos campos de acordo com o tema
            $paramsSerie = array(
                array(
                    'campo' => 'CD_CURSO',
                    'valor' => $tema->CD_CURSO,
                ),
            );

            $paramsDisciplina = array(
                array(
                    'campo' => 'CD_CURSO',
                    'valor' => $tema->CD_CURSO,
                ),
                array(
                    'campo' => 'CD_SERIE',
                    'valor' => $tema->ORDEM_SERIE
                ),
                array(
                    'campo' => 'PERIODO',
                    'valor' => $this->session->userdata("SGP_PERIODO")
                ),
                array(
                    'campo' => 'TIPO',
                    'valor' => "N"
                ),
            );

            $series = $this->serie->filtrar($paramsSerie);
            $disciplinas = $this->disciplina->filtrar($paramsDisciplina);
        }

        //definir o titulo do modal
        if ($operacao == 'E') {
            $titulo = 'EDITAR TEMA :: ' . $tema->DC_TEMA;
        } elseif ($operacao == 'I') {
            $titulo = 'NOVO TEMA';
        } elseif ($operacao == 'D') {
            $titulo = 'DELETAR TEMA :: ' . $tema->DC_TEMA;
        }

        $data = array(
            'tema' => $tema,
            'titulo' => $titulo,
            'operacao' => $operacao,
            'cursos' => $this->curso->listarRegular(),
            'series' => $series,
            'disciplinas' => $disciplinas,
        );

        $this->load->view('108/tema/modalTema', $data);
    }

    /**
     * Finaliza a ação do modal de acordo com o tipo de operação
     */
    function frmManter() {
        //obter código do tema para edição ou exclusão
        $keys = array(
            array(
                'campo' => 'CD_TEMA',
                'valor' => $this->input->post("avalCodigo")
            ),
        );

        //obter valores para inserção e edição
        $params = array(
            'CD_CURSO' => $this->input->post('avalCurso'),
            'ORDEM_SERIE' => $this->input->post('avalSerie'),
            'CD_DISCIPLINA' => $this->input->post('avalDisciplina'),
            'DC_TEMA' => $this->input->post('avalTema'),
            'FLG_ATIVO' => $this->input->post('avalVisivel'),
        );

        if ($this->input->post("avalOperacao") == "I") {
            $params['CD_USU_CADASTRO'] = $this->session->userdata('SGP_CODIGO');
        }

        //definir qual operação será realizada
        $result = array(
            "success" => false,
            "mensagem" => "Ocorreu um erro ao realizar a operação."
        );
        switch ($this->input->post("avalOperacao")) {
            case 'I';
                if ($this->tema->inserir($params)) {
                    $result['success'] = true;
                    $result['mensagem'] = "Tema salvo com sucesso.";
                    $result['operacao'] = "I";
                }
                break;
            case 'E';
                //preparar parametros para edição
                $valores = array();
                foreach ($params as $key => $value) {
                    $aux = array(
                        'campo' => $key,
                        'valor' => $value
                    );
                    $valores[] = $aux;
                }

                if ($this->tema->editar($keys, $valores)) {
                    $result['success'] = true;
                    $result['mensagem'] = "Tema salvo com sucesso.";
                    $result['operacao'] = "E";
                }
                break;
            case 'D';
                if (!$this->tema->isApagavel($this->input->post('avalCodigo'))) {
                    $result['success'] = false;
                    $result['mensagem'] = "Este tema não pode ser apagado. Existem conteúdos associados a ele.";
                } else if ($this->tema->deletar($keys)) {
                    $result['success'] = true;
                    $result['mensagem'] = "Tema excluído com sucesso.";
                    $result['operacao'] = "D";
                }
                break;
        }

        echo json_encode($result);
    }

    function relatorioTemaConteudo() {
        $params = array(
            'CD_CURSO' => $this->input->get("curso"),
            'ORDEM_SERIE' => $this->input->get("serie"),
            'CD_DISCIPLINA' => $this->input->get("disciplina"),
        );
        
        $data = array(
            'temas' => $this->tema->listaTemaConteudo($params)
        );
        
        $relatorio = $this->load->view('108/relatorio_tema_conteudo/tema_conteudo', $data, TRUE);

        include_once APPPATH . '/third_party/mpdf/mpdf.php';

        $mpdf = new mPDF('', 'A4', 10);
        $mpdf->SetHTMLHeader($this->load->view('impressao/header_doc', array("titulo" => "RELATÓRIO DE TEMAS"), true));
        $mpdf->AddPage('P', // L - landscape, P - portrait
                'A4', '', '', '', 5, // margin_left
                5, // margin right
                30, // margin top
                30, // margin bottom
                0, // margin header
                5); // margin footer

        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHTMLFooter($this->load->view('impressao/footer_doc', $data, true));
        $mpdf->WriteHTML($relatorio, 2);
        $mpdf->Output('Temas-Conteudos.pdf', 'I');
    }

}
