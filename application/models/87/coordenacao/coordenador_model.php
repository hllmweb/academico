<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Coordenador_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Executa a procedure para retornar informações de um determinados 
     * professor conforme a operação informada.
     * 
     * Operações:
     * TR - Lista todas as turmas regulares do professor.
     * 
     * @param array $dados
     * @return array
     */
    public function aes_professor($dados) {
        $params = array(
            array("name" => ":P_OPERACAO", "value" => $dados['operacao']),
            array("name" => ":P_CD_PROFESSOR", "value" => $dados['cd_professor']),
            array("name" => ":P_CD_TURMA", "value" => $dados['cd_turma']),
            array("name" => ":P_CD_DISCIPLINA", "value" => $dados['cd_disciplina']),
            array("name" => ":P_ORDEM_SERIE", "value" => $dados['ordem_serie']),
            array("name" => ":P_CD_CURSO", "value" => $dados['cd_curso']),
            array('name' => ':P_CURSOR', 'value' => "", 'type' => OCI_B_CURSOR)
        );

        return $this->db->procedure("BD_PORTAL", "AES_PROFESSOR", $params);
    }

}
