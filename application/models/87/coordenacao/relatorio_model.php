<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Relatorio_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Executa uma procedure que retorna uma listagem de todos os conteúdos
     * ministrados por um professor conforme parametros de entrada
     * 
     * @param array $dados
     * @return array
     */
    function aes_conteudo_ministrado($dados) {        
        $params = array(
            array('name' => ':P_CD_DISCIPLINA', 'value' => $dados['disciplina']),
            array('name' => ':P_BIMESTRE', 'value' => $dados['bimestre']),
            array('name' => ':P_CD_TURMA', 'value' => $dados['turma']),
            array('name' => ':P_PERIODO', 'value' => $dados['periodo']),
            array('name' => ':P_CURSOR', 'value' => '', 'type' => OCI_B_CURSOR)
        );

        return $this->db->procedure("BD_PORTAL", "AES_CONTEUDO_MINISTRADO", $params);
    }

}
