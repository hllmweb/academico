<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Parecer extends CI_Controller {

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
            array("campo" => "DT_DEMISSAO IS NULL"),
            array("campo" => "CD_PROFESSOR !=", "valor" => 32),
        ));

        $data = array(
            'titulo' => 'PARECER TÉCNICO SOLICITAÇÃO',
            'SubTitulo' => 'PESQUISAR',
            'motivos' => $motivos,
            'professores' => $professores,
            "dataInicio" => date('d/m/Y', strtotime($configuracao->DT_INICIO_FOLHA)),
            "dataFim" => date('d/m/Y', strtotime($configuracao->DT_FIM_FOLHA))
        );

        $this->load->view("103/parecer/index", $data);
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
            $params[] = array("campo" => "TRUNC(DT_PENDENCIA) BETWEEN TO_DATE('" . trim($aux[0]) . "','DD/MM/YYYY') "
                . "AND TO_DATE('" . trim($aux[1]) . "','DD/MM/YYYY')", "valor" => null);
        }

        $situacao = $this->input->post("situacao");
        if (!empty($situacao)) {
            $params[] = array("campo" => "FL_PARECER", "valor" => $situacao);
        }

        $params[] = array("campo" => "FL_REQUER_PARECER", "valor" => "S");

        $data = array(
            "registros" => $this->solicitacao->filtrar($params)
        );

        $this->load->view("103/parecer/gridRegistro", $data);
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
            "aulas" => $aulas
        );

        $this->load->view("103/parecer/modalViewRegistro", $data);
    }

    public function modalDeferir() {
        $solicitacao = $this->solicitacao->pesquisar_id(array(
            "campo" => "CD_SOLICITACAO",
            "valor" => $this->input->get("codigo"),
        ));

        $data = array(
            "solicitacao" => $solicitacao,
        );

        $this->load->view("103/parecer/modalDeferir", $data);
    }

    public function formManterDeferir() {
        //mensagem de retorno
        $result = array(
            "success" => false,
            "mensagem" => "Ocorreu um erro ao deferir a solicitação."
        );

        $params = array(
            "solicitacoes" => $this->input->post("solicitacoes"),
            "FL_PARECER" => $this->input->post("status"),
            "DS_PARECER" => $this->input->post("descricao"),
            "CD_USU_PARECER" => $this->session->userdata("SGP_CODIGO"),
        );

        if ($this->solicitacao->deferirParecer($params)) {
            $result['success'] = true;

            //preparar mensagem de retorno
            switch ($params['FL_PARECER']) {
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

}
