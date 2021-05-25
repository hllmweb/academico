<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Orientacao_Atendimento_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table = "BD_ACADEMICO.AES_ORIENTACAO_ATENDIMENTO";
        $this->view = "BD_ACADEMICO.VW_ORIENTACAO_ATENDIMENTO";
    }

    function listar_turma($p) {
        $this->db->select("A.CD_ALUNO,
                           A.NM_ALUNO,
                           RE.ID_RESPONSAVEL,
                           RE.NM_RESPONSAVEL,
                           M.CD_TURMA,
                           A.TURMA_ATUAL,
                           A.CD_CURSO,
                           A.ORDEM_SERIE,
                           A.TIPO,
                           C.NM_CURSO,
                           (SELECT COUNT(*) 
                              FROM BD_ACADEMICO.AES_ORIENTACAO_ATENDIMENTO 
                             WHERE CD_ALUNO = A.CD_ALUNO 
                               AND ID_RESPONSAVEL = RE.ID_RESPONSAVEL
                               AND PERIODO = '" . $p['periodo'] . "'
                               ) AS CONT
                           ");
        $this->db->where('U.CD_USUARIO', $this->session->userdata('SGP_CODIGO'));
        $this->db->where('A.TIPO', 'C');
        $this->db->where_in('A.STATUS', array('1'));
        $this->db->where('M.TIPO', 'N');
        $this->db->join("BD_SICA.MATRICULA M", "M.CD_ALUNO = A.CD_ALUNO AND M.CD_TURMA = '" . $p['turma'] . "' AND M.PERIODO = '" . $p['periodo'] . "'");
        $this->db->join('BD_SICA.T_CURSO_USER U', 'U.CD_CURSO = A.CD_CURSO');
        $this->db->join("BD_SICA.ALU_RESPONSAVEL AR", "A.CD_ALUNO = AR.CD_ALUNO");
        $this->db->join("BD_SICA.RESPONSAVEL RE", "RE.ID_RESPONSAVEL = AR.ID_RESPONSAVEL");
        $this->db->join('BD_SICA.CURSOS C', 'A.CD_CURSO = C.CD_CURSO');
        $this->db->order_by('RE.NM_RESPONSAVEL, A.NM_ALUNO');
        $query = $this->db->get('BD_SICA.ALUNO A')->result_array();
        return $query;
    }

}
