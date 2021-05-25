<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Disciplina_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table = "BD_SICA.CL_DISCIPLINA";
        $this->view = "BD_SICA.VW_TURMA_DISCIPLINA";
    }

    /**
     * Lista os professores de uma determinada disciplina de um curso em um
     * periodo letivo.
     * 
     * @param int $curso
     * @param int $disciplina
     * @param string $periodo
     * @return array
     */
    public function listaProfessores($curso, $disciplina, $periodo) {
        $this->db->distinct();
        $this->db->select("P.CD_PROFESSOR, P.NM_PROFESSOR");
        $this->db->from("BD_SICA.CL_TURMA_PROFESSORES TP");
        $this->db->join("BD_SICA.TURMA T", "T.CD_TURMA = TP.CD_TURMA");
        $this->db->join("BD_SICA.CL_DISCIPLINA D", "D.CD_DISCIPLINA = TP.CD_DISCIPLINA");
        $this->db->join("BD_SICA.T_PROFESSOR P", "P.CD_PROFESSOR = TP.CD_PROFESSOR");
        $this->db->where("T.CD_CURSO", $curso);
        $this->db->where("TP.CD_DISCIPLINA", $disciplina);
        $this->db->where("TP.PERIODO", $periodo);
        $this->db->where("P.DT_DEMISSAO IS NULL");
        $this->db->order_by("NM_PROFESSOR ASC");

        $query = $this->db->get();
        return $query->result();
    }

}
