<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cardapio_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table = "BD_SICA.CL_CARDAPIO";
        $this->view = "BD_SICA.VW_CL_CARDAPIO";
    }

    /**
     * Lista o cardapio da semana informada por parametro.
     * 
     * @param array $params
     * @return object[]
     */
    public function listaPorSemana($params) {
        $this->db->from($this->view);

        foreach ($params as $row) {
            if ($row['valor'] != "") {
                $this->db->where($row['campo'], $row['valor']);
            } else {
                $this->db->where($row['campo']);
            }
        }

        $this->db->order_by("CD_TIPO_CARDAPIO, CD_OPCAO_CARDAPIO");

        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Obtem apenas as datas do cardapios da semana informada
     * 
     * @param array $params
     * @return object[]
     */
    public function listaDiasSemana($params) {
        $this->db->select("DT_CARDAPIO");
        $this->db->from($this->view);

        foreach ($params as $row) {
            if ($row['valor'] != "") {
                $this->db->where($row['campo'], $row['valor']);
            } else {
                $this->db->where($row['campo']);
            }
        }

        $this->db->order_by("DT_CARDAPIO");

        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Verifica se os dados informados por parametro são repetidos ou não.
     * 
     * @param array $params
     * @throws Exception
     */
    public function verificarComidaRepetida($params) {
        $this->db->from($this->view);

        $this->db->where("CD_TIPO_CARDAPIO", $params['CD_TIPO_CARDAPIO']);
        $this->db->where("CD_OPCAO_CARDAPIO", $params['CD_OPCAO_CARDAPIO']);
        $this->db->where("CD_MATERIAL", $params['CD_MATERIAL']);
        $this->db->where("DT_CARDAPIO", $params['DT_CARDAPIO']);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            throw new Exception("A opção informada já foi adicionada ao cardapio");
        }
    }

    /**
     * Inserção de um registro.
     * 
     * @param array $data
     * @return boolean
     */
    public function inserir($data) {
        $this->verificarComidaRepetida($data);
        return parent::inserir($data);
    }

}
