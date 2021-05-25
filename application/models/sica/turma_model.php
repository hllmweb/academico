<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Turma_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table = "BD_SICA.TURMA";
        $this->view = "BD_SICA.VW_CL_TURMA_DETALHES";
    }

    /**
     * Exibe todas as turmas normais e mistas para o conjunto de cursos e series
     * informados.
     * 
     * @param array $cursos
     * @param array $series
     * @return object[]
     */
    public function turmas($cursos, $series) {
        $this->db->select("PERIODO, CD_TURMA, TIPO");
        $this->db->from($this->view);
        $this->db->where("TIPO = 'N'");
        $this->db->where_in('CD_CURSO', $cursos);
        $this->db->where_in('CD_SERIE', $series);
        $this->db->where("PERIODO = (SELECT CL_PERIODO_ATUAL FROM BD_SICA.CONFIGURACAO)");

        $query = $this->db->get();
        return $query->result();
    }

}
