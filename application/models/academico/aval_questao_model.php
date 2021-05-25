<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Aval_questao_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function listar() {
        $sql = "SELECT AQ.CD_QUESTAO,
           AQ.CD_CURSO,
           C.NM_CURSO,
           AQ.ORDEM_SERIE,
           S.NM_SERIE,
           AQ.CD_DISCIPLINA,
           D.NM_DISCIPLINA,
           TO_CHAR(AQ.DC_QUESTAO) AS QUESTAO,
           AQ.DC_QUESTAO_RODAPE,
           AQ.FLG_TIPO,
           AQ.IMG_QUESTAO,
           AQ.CD_PROFESSOR,
           PF.NM_PROFESSOR,       
           AQ.CD_USU_CADASTRO,
           AQ.NR_DIFICULDADE,
           SC.NM_USUARIO AS CADASTROU,
           AQ.DT_CADASTRO AS CADASTROU_EM,
           AQ.CD_USU_ALTERACAO,
           SC.NM_USUARIO AS ALTEROU,
           AQ.DT_ALTERACAO AS ALTEROU_EM       
      FROM BD_ACADEMICO.AVAL_QUESTAO AQ
      JOIN BD_SICA.CURSOS C ON C.CD_CURSO = AQ.CD_CURSO
      JOIN BD_SICA.SERIES S ON S.CD_CURSO = AQ.CD_CURSO AND S.ORDEM_SERIE = AQ.ORDEM_SERIE
      JOIN BD_SICA.CL_DISCIPLINA D ON D.CD_DISCIPLINA = AQ.CD_DISCIPLINA
      JOIN BD_SICA.USUARIOS SC ON SC.CD_USUARIO = AQ.CD_USU_CADASTRO
      LEFT JOIN BD_SICA.USUARIOS SA ON SA.CD_USUARIO = AQ.CD_USU_ALTERACAO
      LEFT JOIN BD_RH.VW_PROFESSOR PF ON PF.CD_PROFESSOR = AQ.CD_PROFESSOR
     WHERE AQ.CD_CURSO = 33
      AND AQ.ORDEM_SERIE = 6
      AND AQ.CD_DISCIPLINA = 1
      AND TRUNC(AQ.DT_CADASTRO) <= TO_DATE('30/07/2015','DD/MM/YYYY')
       ORDER BY AQ.CD_QUESTAO ASC";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
           return $query->result();
        } else {
           return false;
        }

    }
    
}
