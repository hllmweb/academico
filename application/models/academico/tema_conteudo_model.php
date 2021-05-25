<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tema_Conteudo_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table = 'BD_ACADEMICO.AVAL_TEMA_CONTEUDO';
        $this->view = 'BD_ACADEMICO.AVAL_TEMA_CONTEUDO';
    }

    /**
     * Verifica se o conteudo pode ser apagado
     * 
     * @param int $conteudo
     * @return boolean 
     */
    public function isApagavel($conteudo) {
        $this->db->from("BD_ACADEMICO.AVAL_TEMA_CONTEUDO");
        $this->db->where("CD_CONTEUDO", $conteudo);

        $query = $this->db->get();
        return $query->num_rows() == 0;
    }

}
