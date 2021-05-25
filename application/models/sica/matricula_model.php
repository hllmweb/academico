<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Matricula_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table = "BD_SICA.MATRICULA";
        $this->view = "BD_SICA.MATRICULA";
    }

    /**
     * Lista todos os alunos matriculados nos cursos, series e turmas informados
     * 
     * @param array $cursos
     * @param array $series
     * @param array $turmas
     * @return array
     */
    public function listaAlunos($cursos, $series, $turmas) {
        $this->db->distinct();
        $this->db->select("AL.CD_ALUNO, RE.CPF_RESPONSAVEL");
        $this->db->from("BD_SICA.MATRICULA MA");
        $this->db->join("BD_SICA.TURMA TU", "MA.CD_TURMA = TU.CD_TURMA AND TU.PERIODO = MA.PERIODO");
        $this->db->join("BD_SICA.ALUNO AL", "AL.CD_ALUNO = MA.CD_ALUNO");
        $this->db->join("BD_SICA.ALU_RESPONSAVEL AR", "AL.CD_ALUNO = AR.CD_ALUNO AND AR.TIPO_RESPONSAVEL = 'F'");
        $this->db->join("BD_SICA.RESPONSAVEL RE", "RE.ID_RESPONSAVEL = AR.ID_RESPONSAVEL");

        //para selecionar apenas um responsável financeiro, alguns alunos possuem dois
        $this->db->where("RE.ID_RESPONSAVEL = (SELECT ID_RESPONSAVEL FROM BD_SICA.ALU_RESPONSAVEL 
                                                WHERE CD_ALUNO = AL.CD_ALUNO                                     
                                                    AND TIPO_RESPONSAVEL = 'F'
                                                    AND ROWNUM = 1)");
        $this->db->where("AL.STATUS", true);
        $this->db->where("TU.TIPO", "N");
        $this->db->where("MA.PERIODO = (SELECT CL_PERIODO_ATUAL FROM BD_SICA.CONFIGURACAO)");

        $this->db->where_in("AL.CD_CURSO", $cursos);

        if (!empty($series)) {
            $this->db->where_in("AL.ORDEM_SERIE", $series);
        }

        if (!empty($turmas)) {
            $this->db->where_in("TU.CD_TURMA", $turmas);
        }

        $query = $this->db->get();
        return $query->result();
    }

}
