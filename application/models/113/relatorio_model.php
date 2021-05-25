<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Relatorio_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function conteudo_ministrado($dados) {
        $cursor = "";

        $params = array(
            //array('name' => ':P_OPERACAO', 'value' => $dados['operacao']),
            array('name' => ':P_CD_DISCIPLINA', 'value' => $dados['disciplina']),
            array('name' => ':P_BIMESTRE', 'value' => $dados['bimestre']),
            array('name' => ':P_CD_TURMA', 'value' => $dados['turma']),
            array('name' => ':P_PERIODO', 'value' => $dados['periodo']),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );

        return $this->db->procedure("BD_PORTAL", "AES_CONTEUDO_MINISTRADO", $params);
    }

}
