<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Abono_Aula extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("academico/justificativa_solicitacao_model", "solicitacao", true);
        $this->load->model("academico/justificativa_motivo_model", "motivo", true);
        $this->load->model("rh/configuracao_model", "configuracao", true);
        $this->load->model("rh/professor_model", "professor", true);

        $this->load->helper(array("url"));
        $this->load->library(array("session"));
    }

    public function index() {
        $configuracao = $this->configuracao->listar();
        $configuracao = $configuracao[0];

        $motivos = $this->motivo->listar();
        $professores = $this->professor->filtrar(array(
            array("campo" => "DT_DEMISSAO", "valor" => null),
            array("campo" => "CD_PROFESSOR !=", "valor" => 32),
        ));

        $data = array(
            'titulo' => 'ABONO DIÁRIO PROFESSOR',
            'SubTitulo' => 'PESQUISAR',
            'motivos' => $motivos,
            'professores' => $professores,
            'dataInicio' => date('d/m/Y', strtotime($configuracao->DT_INICIO_FOLHA)),
            'dataFim' => date('d/m/Y', strtotime($configuracao->DT_FIM_FOLHA))
        );

        $this->load->view("103/abono_aula/index", $data);
    }

    /**
     * Exibe os dados da pesquisa referentes ao usuário logado
     */
    public function gridRegistro() {
        $params = array();

        //adicionar filtros somente se valores foram preenchidos
        $motivo = $this->input->post("motivo");
        if (!empty($motivo)) {
            $params[] = array("campo" => "CD_MOTIVO", "valor" => $motivo);
        }

        $professor = $this->input->post("professor");
        if (!empty($professor)) {
            $params[] = array("campo" => "CD_PROFESSOR", "valor" => $professor);
        }

        $aux = explode("-", $this->input->post("data"));
        if (!empty($aux)) {
            $dataInicio = trim($aux[0]);
            $dataFim = trim($aux[1]);
            $params[] = array("campo" => "TRUNC(DT_PENDENCIA) BETWEEN TO_DATE('" . $dataInicio . "', 'DD/MM/YYYY') "
                . "AND TO_DATE('" . $dataFim . "','DD/MM/YYYY')", "valor" => null);
        }

        $situacao = $this->input->post("situacao");
        if (!empty($situacao)) {
            $params[] = array("campo" => "FL_STATUS", "valor" => $situacao);
        }

        $data = array(
            "registros" => $this->solicitacao->filtrar($params)
        );

        $this->load->view("103/abono_aula/gridRegistro", $data);
    }

    public function modalDeferir() {
        $solicitacao = $this->solicitacao->pesquisar_id(array(
            "campo" => "CD_SOLICITACAO",
            "valor" => $this->input->get("codigo"),
        ));

        $data = array(
            "solicitacao" => $solicitacao,
        );

        $this->load->view("103/abono_aula/modalDeferir", $data);
    }

    public function modalViewRegistro() {
        $solicitacao = $this->solicitacao->pesquisar_id(array(
            "campo" => "CD_SOLICITACAO",
            "valor" => $this->input->get("codigo")
        ));

        $aulas = $this->solicitacao->listaAulas($solicitacao->CD_SOLICITACAO);

        $data = array(
            "titulo" => "Solicitação de Abono",
            "solicitacao" => $solicitacao,
            "aulas" => $aulas,
        );

        $this->load->view("103/abono_aula/modalViewRegistro", $data);
    }

    public function formManterDeferir() {
        $result = array(
            "success" => false,
            "mensagem" => "Ocorreu um erro ao deferir a solicitação."
        );

        $params = array(
            "solicitacoes" => $this->input->post("solicitacoes"),
            "DS_RETORNO" => $this->input->post("descricao"),
            "FL_STATUS" => $this->input->post("status"),
            "CD_USU_RETORNO" => $this->session->userdata("SGP_CODIGO"),
        );

        if ($this->solicitacao->deferirRetorno($params)) {
            $result['success'] = true;

            //preparar mensagem de retorno
            switch ($params['FL_STATUS']) {
                case "A" :
                    $result['mensagem'] = "A solicitação foi aprovada.";
                    break;
                case "R" :
                    $result['mensagem'] = "A solicitação foi reprovada.";
                    break;
                case "I" :
                    $result['mensagem'] = "Foi solicitado mais informações.";
                    break;
            }
        }

        echo json_encode($result);
    }

    /**
     * Exibe um formulário para filtrar os dados do relatório
     */
    public function modalRelatorio() {
        $configuracao = $this->configuracao->listar();
        $configuracao = $configuracao[0];

        $motivos = $this->motivo->listar();

        $professores = $this->professor->filtrar(array(
            array("campo" => "DT_DEMISSAO", "valor" => null),
            array("campo" => "CD_PROFESSOR !=", "valor" => 32),
        ));

        $situacoes = array(
            "N" => "AGUARDANDO APROVAÇÃO",
            "I" => "AGUARDANDO INFORMAÇÕES",
            "A" => "APROVADA",
            "R" => "REPROVADA"
        );

        $data = array(
            "motivos" => $motivos,
            "professores" => $professores,
            "situacoes" => $situacoes,
            "titulo" => "GERAR RELATÓRIO",
            "dataInicio" => date('d/m/Y', strtotime($configuracao->DT_INICIO_FOLHA)),
            "dataFim" => date('d/m/Y', strtotime($configuracao->DT_FIM_FOLHA))
        );

        $this->load->view("103/abono_aula/modalRelatorio", $data);
    }

}
