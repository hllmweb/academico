<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tema_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table = 'BD_ACADEMICO.AVAL_TEMA';
        $this->view = 'BD_SICA.VW_TEMA_DISCIPLINA';
    }

    /**
     * Verifica se o registro informado de tema pode ser deletado.
     * 
     * @param int $tema Codigo do tema
     * @return boolean TRUE caso possa ser deletado. FALSE caso contrário
     */
    public function isApagavel($tema) {
        $this->db->from("BD_ACADEMICO.AVAL_TEMA_CONTEUDO");
        $this->db->where("CD_TEMA", $tema);

        $query = $this->db->get();
        return $query->num_rows() == 0;
    }

    /**
     * Lista de temas e conteudos
     * 
     * @param array $params
     * @return array
     */
    public function listaTemaConteudo($params) {
        $this->db->select("C.NM_CURSO, "
                . "S.NM_SERIE, "
                . "D.NM_DISCIPLINA, "
                . "TE.DC_TEMA, "
                . "TC.DC_CONTEUDO"
        );
        $this->db->from("BD_ACADEMICO.AVAL_TEMA TE");
        $this->db->join("BD_ACADEMICO.AVAL_TEMA_CONTEUDO TC", "TC.CD_TEMA = TE.CD_TEMA", "LEFT");
        $this->db->join("BD_SICA.CURSOS C", "C.CD_CURSO = TE.CD_CURSO");
        $this->db->join("BD_SICA.SERIES S", "S.CD_CURSO = TE.CD_CURSO "
                . "AND S.ORDEM_SERIE = TE.ORDEM_SERIE");
        $this->db->join("BD_SICA.CL_DISCIPLINA D", "D.CD_DISCIPLINA = TE.CD_DISCIPLINA");
        $this->db->where("TE.CD_CURSO", $params['CD_CURSO']);
        $this->db->where("TE.ORDEM_SERIE", $params['ORDEM_SERIE']);
        $this->db->where("TE.CD_DISCIPLINA", $params['CD_DISCIPLINA']);
        $this->db->order_by("TE.DC_TEMA");

        $query = $this->db->get();
        return $query->result();
    }

}
