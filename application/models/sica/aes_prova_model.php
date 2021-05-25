<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Aes_prova_model extends MY_Model { //CI_Model

    function __construct() {
        parent::__construct();
        $this->load->database();        
    }

    function listar_provas($p) {
        $this->db->select('CD_PROVA');
        $this->db->where('CD_PROVA', $p);
        $this->db->or_where('CD_PROVA_PAI', $p);
        $query = $this->db->get('BD_SICA.AVAL_PROVA')->result_array();
        return $query;
    }

    function listar_prova_dia($p) {

        $this->db->select('P.*, T.DC_TIPO_PROVA, (BD_SICA.F_AVAL_PROVA_DISCIPLINAS(P.CD_PROVA)) AS DISCIPLINAS');
        $this->db->where('P.PERIODO', $p['periodo']);
        $this->db->where('P.DT_PROVA', date('d-M-Y'));
        $this->db->where('P.CD_PROVA_PAI');
        $this->db->order_by('P.CD_PROVA', 'DESC');
        $this->db->join('BD_SICA.AVAL_TIPO_PROVA T', 'P.CD_TIPO_PROVA = T.CD_TIPO_PROVA');
        $query = $this->db->get('BD_SICA.AVAL_PROVA P')->result_array();

        return $query;
    }

    function resposta($p) {
        $data = array(
            'RESPOSTAS' => $p['gabarito'],
        );
        $this->db->where('CD_PROVA', $p['prova']);
        $this->db->update('BD_SICA.AVAL_PROVA', $data);

        /*         * ************** ADICIONAR LOGS **************** */
        $sql = $this->db->last_query();
        $co = new Weblogs_lib();
        $co->sql = $sql;
        $co->url();
        /*         * ************** ADICIONAR LOGS **************** */
    }

    function online_resultado($p) {
        $this->db->select('A.CD_ALUNO,
                           A.NM_ALUNO,
                           P.QTDE_QUESTOES,
                           AI.*,
                           AQ.*');
        $this->db->where('AI.CD_PROVA', $p);
        $this->db->order_by('A.NM_ALUNO, POSICAO', 'ASC');
        $this->db->join('BD_SICA.ALUNO A', 'A.CD_ALUNO = AI.CD_ALUNO');
        $this->db->join('BD_SICA.AVAL_PROVA P', 'AI.CD_PROVA = P.CD_PROVA');
        $this->db->join('BD_SICA.AVAL_PROVA_ALUNO_QUESTAO AQ', 'AQ.CD_ALUNO = AI.CD_ALUNO AND AQ.CD_PROVA = AI.CD_PROVA_VERSAO', 'left');
        $query = $this->db->get('BD_SICA.AVAL_PROVA_INSCRITOS AI')->result_array();
        return $query;
    }

    //Lista as Datas das Provas que serão realizadas para determinada turma, utilizada pelo filtro DATA DE REALIZAÇÃO(combo) na tela de acompanhamento da prova online By: Mônica
    function provasPorCurso($p) {

        $this->db->distinct();
        $this->db->select("P.DT_PROVA");
        $this->db->where('P.CD_CURSO', $p['curso']);
        $this->db->where('P.ORDEM_SERIE', $p['serie']);
        $this->db->order_by('P.DT_PROVA', 'DESC');
        $query = $this->db->get('BD_SICA.AVAL_PROVA P')->result_array();

        return $query;
    }

    //Lista as Provas que serão realizadas em determinada data e para determinada turma, utilizada pelo filtro NºPROVA(combo) na tela de acompanhamento da prova online By: Mônica
    function provaPorData($p) {

        $this->db->select('*');
        $this->db->where("TRUNC(P.DT_PROVA) = TO_DATE('" . $p['data'] . "', 'dd/mm/yyyy')");
        $this->db->where('P.CD_CURSO', $p['curso']);
        $this->db->where('P.ORDEM_SERIE', $p['serie']);
        $this->db->order_by('P.NUM_PROVA', 'DESC');
        $query = $this->db->get('BD_SICA.AVAL_PROVA P')->result_array();

        return $query;
    }   

}
