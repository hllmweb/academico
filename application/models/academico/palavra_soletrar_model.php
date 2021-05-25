<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Palavra_soletrar_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table = 'BD_ACADEMICO.PALAVRAS_SOLETRAR';
        $this->view = 'BD_ACADEMICO.VW_PALAVRAS_SOLETRAR';
    }

    /**
     * Adiciona um conjunto de palavras na base de dados do soletrando.
     * 
     * @param array $palavras Um vetor de palavras. Cada item do vetor é um 
     * registro a ser salvo.
     * @return boolean
     */
    public function adicionar($palavras) {
        $this->db->trans_start();

        foreach ($palavras as $row) {
            parent::inserir($row);
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

}
