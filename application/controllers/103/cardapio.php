<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cardapio extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model("financeiro/material_model", "material", true);
        $this->load->model("sica/cardapio_model", "cardapio", true);
        $this->load->model("sica/tipo_cardapio_model", "tipo", true);
        $this->load->model("sica/opcao_cardapio_model", "opcao", true);

        $this->load->library(array("session", "lang", "tracert"));

        $this->lang->load('calendar', $this->session->userdata('SGP_LANG'));
    }

    public function index() {
        $log = new Tracert();
        $log->usuario = $this->session->userdata('USU_CODIGO');
        $log->validar_url();
        
        $data = array(
            'titulo' => 'CARDÁPIO',
            'SubTitulo' => 'PESQUISAR',
        );

        $this->load->view($this->session->userdata("SGP_SISTEMA") . "/cardapio/index", $data);
    }

    public function gridRegistro() {
        $semana = $this->input->post("semana");

        $aux = explode("-", $semana);

        $params = array(
            array("campo" => "DT_CARDAPIO BETWEEN "
                . "TO_DATE('" . trim($aux[0]) . "','DD/MM/YYYY') AND "
                . "TO_DATE('" . trim($aux[1]) . "','DD/MM/YYYY')", "valor" => "")
        );

        $datas = $this->cardapio->listaDiasSemana($params);
        $cardapio = $this->cardapio->listaPorSemana($params);
        
        //print_r($cardapio);

        //obter quantas colunas terá o cardapio
        $dias = array("" => "");
        foreach ($datas as $row) {
            if (array_search($row->DT_CARDAPIO, $dias) === false) {
                $dia = $row->DT_CARDAPIO;
                $nome = $this->lang->line(strtolower("cal_" . date('l', strtotime($dia))));
                $dias[$dia] = $nome . "<br>(" . date("d/m/Y", strtotime($dia)) . ")";
            }
        }

        //montar uma matriz com todas as informações do cardapio         
        $registros = array();
        foreach ($cardapio as $row) {
            $tipo = $row->DC_TIPO_CARDAPIO;
            $opcao = $row->DC_OPCAO_CARDAPIO;
            $dia = $row->DT_CARDAPIO;
            $registros[$tipo][$opcao][$dia][] = $row;
        }
        
        $data = array(
            "dias" => $dias,
            "registros" => $registros,
            "inicio" => trim($aux[0]),
            "fim" => trim($aux[1]),
        );

        $this->load->view($this->session->userdata('SGP_SISTEMA') . "/cardapio/gridRegistro", $data);
    }

    public function formRegistro() {
        $aux = explode("-", $this->input->post('semana'));

        $data = array(
            'titulo' => 'CARDÁPIO',
            'SubTitulo' => 'MONTAR CARDÁPIO',
            "tipos" => $this->tipo->listar(),
            "opcoes" => $this->opcao->listar(),
            "inicio" => trim($aux[0]),
            "fim" => trim($aux[1]),
            "materiais" => $this->material->filtrar(array(
                array("campo" => "CD_DESTINACAO", "valor" => 1861)
            )),
            "operacao" => "I"
        );

        $this->load->view($this->session->userdata('SGP_SISTEMA') . "/cardapio/formRegistro", $data);
    }

    public function modalRegistro($id) {
        $aux = explode("-", $id);

        $operacao = $aux[0];
        $codigo = $aux[1];

        $data = array(
            "operacao" => $operacao,
            "tipos" => $this->tipo->listar(),
            "opcoes" => $this->opcao->listar(),
            "materiais" => $this->material->filtrar(array(
                array("campo" => "CD_DESTINACAO", "valor" => 1861)
            )),
            "registro" => $this->cardapio->filtro_id(array(
                array("campo" => "CD_CARDAPIO", "valor" => $codigo)
            ))
        );

        switch ($operacao) {
            case "E" :
                $data['titulo'] = "Editar Opção do Cardápio";
                break;
            case "D" :
                $data['titulo'] = "Remover Opção do Cardápio";
                break;
        }

        $this->load->view($this->session->userdata('SGP_SISTEMA') . "/cardapio/modalRegistro", $data);
    }

    public function manterRegistro() {
        $operacao = $this->input->post("operacao");

        $response = array(
            "success" => false,
            "mensagem" => "Ocorreu um erro ao atualizar o cardápio"
        );

        try {
            switch ($operacao) {
                case "I" :
                    $dataCardapio = new DateTime();
                    $dataCardapio = $dataCardapio->createFromFormat("d/m/Y", $this->input->post("data"));

                    $params = array(
                        "CD_TIPO_CARDAPIO" => $this->input->post("tipo"),
                        "CD_OPCAO_CARDAPIO" => $this->input->post("opcao"),
                        "CD_MATERIAL" => $this->input->post("material"),
                        "DT_CARDAPIO" => $dataCardapio->format("d-M-y"),
                        "CD_USUARIO" => $this->session->userdata("SGP_CODIGO"),
                        "FL_ATIVO" => true
                    );

                    if ($this->cardapio->inserir($params)) {
                        $response['success'] = true;
                        $response['mensagem'] = "Opção adicionada com sucesso";
                    }

                    break;
                case "E" :
                    $keys = array(
                        array("campo" => "CD_CARDAPIO", "valor" => $this->input->post("codigo"))
                    );

                    $params = array(
                        array("campo" => "CD_MATERIAL", "valor" => $this->input->post("material")),
                    );

                    if ($this->cardapio->editar($keys, $params)) {
                        $response['success'] = true;
                        $response['mensagem'] = "Opção salva com sucesso";
                    }

                    break;
                case "D" :
                    $keys = array(
                        array("campo" => "CD_CARDAPIO", "valor" => $this->input->post("codigo"))
                    );

                    if ($this->cardapio->deletar($keys)) {
                        $response['success'] = true;
                        $response['mensagem'] = "Opção removida com sucesso";
                    }

                    break;
            }
        } catch (Exception $ex) {
            $response['success'] = false;
            $response['mensagem'] = $ex->getMessage();
        }

        echo json_encode($response);
    }

}
