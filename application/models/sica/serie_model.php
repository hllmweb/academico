<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Serie_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table = "BD_SICA.SERIES";
        $this->view = "BD_SICA.VW_SERIES";
    }

    /**
     * Lista todas as séries conforme o conjunto de cursos informados.
     * 
     * @param array $cursos
     */
    public function series($cursos) {
        $this->db->select(" 
            CD_CURSO,
            NM_CURSO_RED,
            ORDEM_SERIE,
            NM_SERIE
        ");
        $this->db->from($this->view);
        $this->db->where_in("CD_CURSO", $cursos);

        $query = $this->db->get();
        return $query->result();
    }

}
