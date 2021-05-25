<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Aluno_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->model("pajela/bimestre_model", "bimestre");
        $this->load->database();
    }

    function listar_serie($p) {
        $this->db->select('A.CD_ALUNO,
                           A.NM_ALUNO,
                           A.TURMA_ATUAL,
                           A.CD_CURSO,
                           A.ORDEM_SERIE,
                           A.STATUS,
                           A.TIPO,
                           C.NM_CURSO
                           ');
        $this->db->where('U.CD_USUARIO', $this->session->userdata('SGP_CODIGO'));
        $this->db->where('A.TIPO', 'C');
        $this->db->where('A.CD_CURSO', $p['curso']);
        $this->db->where('A.ORDEM_SERIE', $p['serie']);
        $this->db->where('A.STATUS', 1);
        $this->db->join("BD_SICA.MATRICULA M", "M.CD_ALUNO = A.CD_ALUNO AND M.CD_TURMA = A.TURMA_ATUAL AND M.PERIODO = (SELECT CL_PERIODO_ATUAL FROM BD_SICA.CONFIGURACAO)");
        $this->db->join('BD_SICA.T_CURSO_USER U', 'U.CD_CURSO = A.CD_CURSO');
        $this->db->join('BD_SICA.CURSOS C', 'A.CD_CURSO = C.CD_CURSO');
        $this->db->order_by('A.NM_ALUNO', 'ASC');
        $query = $this->db->get('BD_SICA.ALUNO A')->result_array();

        return $query;
    }

    function listar_faltas($p) {
        $this->db->order_by('AF.NM_ALUNO, NM_DISCIPLINA', 'ASC');
        $this->db->where('U.CD_USUARIO', $this->session->userdata('SGP_CODIGO'));
        $this->db->where('AF.STATUS', 1);
        $this->db->where('AF.TIPO', 'C');
        $this->db->where('AF.CD_TURMA', $p['turma']);
        $this->db->where('AF.PERIODO', '2016/1');
        $this->db->join('BD_SICA.T_CURSO_USER U', 'U.CD_CURSO = AF.CD_CURSO');
        $query = $this->db->get('BD_SICA.VW_ALUNO_FALTAS AF')->result_array();
        return $query;
    }

    /**
     * Consulta os dados do aluno conforme a matricula informada.
     * 
     * @param int $matricula
     * @return array
     */
    public function consultar($matricula) {
        $this->db->from("BD_SICA.ALUNO");
        $this->db->where("CD_ALUNO", $matricula);

        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Retorna as provas realizadas pelo aluno do bimestre corrente.
     * As provas são P1 e P2 de cada disciplina.
     * 
     * @param int $matricula     
     * @param int $bimestre
     * @return array
     */
    public function listaGabaritosProvas($matricula, $bimestre) {
        $this->db->distinct();
        $this->db->select("QTDE_QUESTOES, NUM_PROVA, BIMESTRE, "
                . "NM_MINI, DISCIPLINAS, GABARITO, RESPOSTAS"
        );
        $this->db->from("BD_ACADEMICO.VW_ALUNO_PROVAS_TODOS");
        $this->db->where("CD_ALUNO", $matricula);
        $this->db->where("BIMESTRE", $bimestre);
        $this->db->where_in("NM_MINI", array("P1", "P2"));
        $this->db->order_by("DISCIPLINAS, NM_MINI");

        $query = $this->db->get();
        return $query->result_array();
    }    

    /**
     * Lista todos os gabaritos de provas online de um determinado aluno no
     * bimestre corrente.
     * 
     * @param int $aluno
     * @param int $bimestre
     * @return array 
     */
    public function listaGabaritosProvasOnline($aluno, $bimestre) {
        $this->db->select("AP.CD_PROVA,
                AP.NUM_PROVA,
                AP.TITULO,
                AP.BIMESTRE,
                AP.CHAMADA,
                AP.CD_TIPO_NOTA,
                TP.DC_TIPO_NOTA,
                TP.NM_MINI,    
                (BD_SICA.F_AVAL_PROVA_DISCIPLINAS(AP.CD_PROVA)) AS DISCIPLINAS,
                APAQ.POSICAO,
                APAQ.CORRETA,
                APAQ.RESPOSTA,
                APAQ.NR_TEMPO_RESPOSTA", false
        );
        $this->db->from("BD_SICA.AVAL_PROVA AP");
        $this->db->join("BD_SICA.CL_TIPO_NOTA TP", "TP.CD_TIPO_NOTA = AP.CD_TIPO_NOTA");
        $this->db->join("BD_SICA.AVAL_PROVA_INSCRITOS API", "AP.CD_PROVA = API.CD_PROVA_VERSAO");
        $this->db->join("BD_SICA.AVAL_PROVA_ALUNO_QUESTAO APAQ", "APAQ.CD_PROVA = API.CD_PROVA_VERSAO "
                . "AND APAQ.CD_ALUNO = API.CD_ALUNO"
        );
        $this->db->where("AP.PERIODO = (SELECT CL_PERIODO_ATUAL FROM BD_SICA.CONFIGURACAO)");
        $this->db->where_in("TP.NM_MINI", array("P1", "P2"));
        $this->db->where_in("AP.CHAMADA", array(1, 2));
        $this->db->where("AP.FLG_WEB", 1);
        $this->db->where("API.FEZ_PROVA", 1);
        $this->db->where("API.CD_ALUNO", $aluno);
        $this->db->where("BIMESTRE", $bimestre);
        $this->db->order_by("AP.CD_PROVA, AP.TITULO, APAQ.POSICAO");

        $query = $this->db->get();
        return $query->result_array();
    }

    public function listaDevedores() {

        $this->db->select("A.CD_ALUNO,
                           A.NM_ALUNO,
                           A.RES_CPF,
                           A.NM_RESPONSAVEL,
                           A.RES_TEL_CEL,
                           A.VL_SALDO,
                           U.SALDO_ALMOCO");
        $this->db->where("A.VL_SALDO <= 10");
        $this->db->where("A.TIPO", 'C');
        $this->db->where("A.STATUS", 1);
        $this->db->where("M.TIPO", 'N');
        $this->db->where("M.PERIODO = (SELECT PERIODO_ATUAL FROM BD_SICA.CONFIGURACAO)");
        $this->db->where("A.CD_CURSO <> 1");
        $this->db->where("LENGTH(A.RES_TEL_CEL) = 11");
        $this->db->join("BD_CONTROLE.USUARIOS U", "A.CD_ALUNO = U.CD_ALUNO");
        $this->db->join("BD_SICA.MATRICULA M", "A.CD_ALUNO = U.CD_ALUNO");
        $this->db->order_by("A.NM_ALUNO", "ASC");
        $result = $this->db->get("BD_SICA.ALUNO A")->result_object();
        return $result;
    }

}
