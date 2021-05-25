<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Conteudo extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model("academico/tema_conteudo_model", "conteudo", true);
        $this->load->model("academico/tema_model", "tema", true);

        $this->load->helper(array('url'));
        $this->load->library(array('session'));
    }

    /**
     * Exibe um modal dos conteudo de um determinado tema
     */
    function index() {
        $params = array(
            'campo' => 'CD_TEMA',
            'valor' => $this->input->get("tema")
        );
        $tema = $this->tema->pesquisar_id($params);

        $params = array($params);
        $conteudos = $this->conteudo->filtrar($params);

        $data = array(
            "tema" => $tema,
            "conteudos" => $conteudos,
            "titulo" => "CONTEÚDOS DO TEMA"
        );

        $this->load->view("108/conteudo/index", $data);
    }

    /**
     * Método que retorna a grid de conteudos
     */
    function gridConteudo() {
        $params = array(
            "campo" => "CD_TEMA",
            "valor" => $this->input->post("tema")
        );
        $tema = $this->tema->pesquisar_id($params);

        $params = array($params);
        $conteudos = $this->conteudo->filtrar($params);

        $data = array(
            "conteudos" => $conteudos,
            "tema" => $tema
        );

        $this->load->view("108/conteudo/gridConteudo", $data);
    }

    /**
     * exibe em um modal o formulário para cadastro, edição e exclusão
     */
    function modalConteudo() {
        $operacao = $this->input->get("operacao");

        $params = array(
            "campo" => "CD_TEMA",
            "valor" => $this->input->get("tema")
        );
        $tema = $this->tema->pesquisar_id($params);

        if ($operacao == "E" || $operacao == "D") {
            $codigo = $this->input->get("codigo");

            $params = array(
                "campo" => 'CD_CONTEUDO',
                "valor" => $codigo
            );
            $conteudo = $this->conteudo->pesquisar_id($params);
            $descricao = strip_tags($conteudo->DC_CONTEUDO->read($conteudo->DC_CONTEUDO->size()));
        }

        if ($operacao == "I") {
            $titulo = "NOVO CONTEÚDO";
        } else if ($operacao == "E") {
            $titulo = "EDITAR CONTEÚDO :: " . $descricao;
        } else {
            $titulo = "DELETAR CONTEÚDO :: " . $descricao;
        }

        $data = array(
            "tema" => $tema,
            "operacao" => $operacao,
            "conteudo" => $conteudo,
            "descricao" => $descricao,
            "titulo" => $titulo
        );

        $this->load->view("108/conteudo/modalConteudo", $data);
    }

    /**
     * Função para finalizar a ação de cada operação de cada inclusão, edição
     * ou exclusão
     */
    function frmManterConteudo() {
        //obter as chaves para edição ou exclusão
        $keys = array(
            array(
                "campo" => "CD_CONTEUDO",
                "valor" => $this->input->post("codigo")
            )
        );

        //obter os valores do formulário
        $params = array(
            "DC_CONTEUDO" => $this->input->post("descricao"),
            "CD_TEMA" => $this->input->post("tema"),
        );

        //somente obter o usuário quando for inserção
        if ($this->input->post("operacao") == "I") {
            $params['CD_USUARIO'] = $this->session->userdata('SGP_CODIGO');
        }

        $result = array(
            "success" => false,
            "mensagem" => "Ocorreu um erro ao realizar a operação."
        );
        switch ($this->input->post("operacao")) {

            case "I":
                if ($this->conteudo->inserir($params)) {
                    $result['success'] = true;
                    $result['mensagem'] = "Conteúdo salvo com sucesso.";
                    $result['operacao'] = "I";
                }
                break;

            case "E":
                $valores = array();
                foreach ($params as $key => $value) {
                    $valores[] = array(
                        "campo" => $key,
                        "valor" => $value
                    );
                }

                if ($this->conteudo->editar($keys, $valores)) {
                    $result['success'] = true;
                    $result['mensagem'] = "Conteúdo salvo com sucesso.";
                    $result['operacao'] = "E";
                }
                break;

            case "D":
                if (!$this->conteudo->isApagavel()) {
                    $result['success'] = false;
                    $result['mensagem'] = "Conteúdo não pode ser excluído. Existem questões associadas ao este conteúdo.";
                } else if ($this->conteudo->deletar($keys)) {
                    $result['success'] = true;
                    $result['mensagem'] = "Conteúdo deletado com sucesso.";
                    $result['operacao'] = "D";
                }
                break;
        }

        echo json_encode($result);
    }

}
