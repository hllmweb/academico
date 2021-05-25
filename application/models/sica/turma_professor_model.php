<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Turma_professor_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table = "BD_SICA.CL_TURMA_PROFESSOR";
        $this->view = "BD_SICA.VW_CL_TURMA_PROFESSORES";
    }
    
    
     /**
     * Exibe todos os professores conforme o curso e série informados.
     * 
     * @param int $curso
     * @param int $serie
     * @return object[]
     */
    public function professoresCursoSerie($curso, $serie) {
        $this->db->distinct();
        $this->db->select("PRO.CD_PROFESSOR, PRO.NM_PROFESSOR");
        $this->db->from("BD_SICA.CL_TURMA_PROFESSORES TP");
        $this->db->join("BD_SICA.TURMA TU", "TU.CD_TURMA = TP.CD_TURMA");
        $this->db->join("BD_RH.VW_PROFESSOR_ATIVO PRO", "PRO.CD_PROFESSOR = TP.CD_PROFESSOR");
        $this->db->where("TU.PERIODO = (SELECT CL_PERIODO_ATUAL FROM BD_SICA.CONFIGURACAO)");
        $this->db->where("TU.CD_CURSO", $curso);
        $this->db->where("TU.CD_SERIE", $serie);
        $this->db->order_by("PRO.NM_PROFESSOR");

        $query = $this->db->get();
        return $query->result();
    }

}
