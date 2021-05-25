<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class professor_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table = 'BD_RH.PNT_PROFESSOR';
        $this->view  = 'BD_RH.VW_PROFESSOR';
    }

    
    function listar($p){
        $this->db->where('DT_DEMISSAO');
        $this->db->where_not_in('CD_PROFESSOR', '12');
        $query = $this->db->get('BD_RH.VW_PROFESSOR')->result_array();
        return $query;
    }

   function aluno_professor($p){
        $sql = "SELECT DISTINCT 
                       CTP.PERIODO,
                       CTP.CD_TURMA,
                       CTP.CD_DISCIPLINA,
                       D.NM_DISCIPLINA,
                       CTP.CD_PROFESSOR,
                       P.NM_PROFESSOR,
                       WP.CD_QUEST
                  FROM BD_SICA.CL_TURMA_PROFESSORES CTP
                  JOIN BD_SICA.CL_DISCIPLINA D ON CTP.CD_DISCIPLINA = D.CD_DISCIPLINA
                  JOIN BD_RH.VW_PROFESSOR P ON CTP.CD_PROFESSOR = P.CD_PROFESSOR
                    JOIN BD_RH.PNT_VW_COL_HORARIO_ATUAL VHA
                    ON vha.cd_disciplina = D.CD_DISCIPLINA
                    AND vha.periodo = CTP.periodo
                    AND vha.cd_turma = CTP.CD_TURMA
                    AND vha.cd_professor = CTP.CD_PROFESSOR
                  LEFT JOIN BD_QUEST.WEB_RESULTADO_PROFESSOR WP ON CTP.CD_PROFESSOR = WP.CD_PROFESSOR 
                                                               AND WP.CD_QUEST IN(".$p['questionario'].")
                                                               AND CTP.PERIODO = WP.PERIODO
                                                               AND WP.CD_ALUNO = '".$p['aluno']."'
                                                               AND WP.BIMESTRE = ".$p['bimestre']."
                 WHERE CTP.PERIODO = '".$p['periodo']."'
                   AND CTP.CD_PROFESSOR <> 32
                   AND D.COMPOSTO = 0
                   AND   D.NM_DISCIPLINA NOT LIKE 'REF%'
                   AND   D.NM_DISCIPLINA NOT LIKE 'AVA%'
                   AND   D.NM_DISCIPLINA NOT LIKE 'ATIVI%'
                -- AND CTP.CD_DISCIPLINA NOT IN( 1 )
                   AND EXISTS (SELECT 1
                                 FROM BD_SICA.MATRICULA 
                                WHERE CD_ALUNO = '".$p['aluno']."'
                                  AND PERIODO = CTP.PERIODO
                                  AND CD_TURMA = CTP.CD_TURMA
                                  AND TIPO IN ('N','X')
                                    )
              ORDER BY D.NM_DISCIPLINA ASC";
       $query = $this->db->query($sql);
       if ($query->num_rows() > 0) {
           return $query->result();
        } else {
           return false;
        }
    }
    
    function professor_filtro($p){
       $sql = "SELECT DISTINCT 
                       CTP.PERIODO,
                       CTP.CD_TURMA,
                       CTP.CD_DISCIPLINA,
                       D.NM_DISCIPLINA,
                       CTP.CD_PROFESSOR,
                       P.NM_PROFESSOR
                  FROM BD_SICA.CL_TURMA_PROFESSORES CTP
                  JOIN BD_SICA.CL_DISCIPLINA D ON CTP.CD_DISCIPLINA = D.CD_DISCIPLINA
                  JOIN BD_RH.VW_PROFESSOR P ON CTP.CD_PROFESSOR = P.CD_PROFESSOR
                 WHERE CTP.PERIODO = '".$p['periodo']."'
                   AND CTP.CD_DISCIPLINA = ".$p['disciplina']."
                   AND CTP.CD_PROFESSOR = ".$p['professor']."
                   AND EXISTS (SELECT 1
                                 FROM BD_SICA.MATRICULA 
                                WHERE CD_ALUNO = '".$p['aluno']."'
                                  AND PERIODO = CTP.PERIODO
                                  AND CD_TURMA = CTP.CD_TURMA
                                  AND TIPO IN ('N','X')
                                    )
              ORDER BY D.NM_DISCIPLINA ASC";
        
       $query = $this->db->query($sql);
       if ($query->num_rows() == 1) {
           return $query->row();
        } else {
           return false;
        }
    }

}