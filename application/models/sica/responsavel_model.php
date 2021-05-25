<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Responsavel_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table = "BD_SICA.RESPONSAVEL";
        $this->view = "BD_SICA.RESPONSAVEL";
    }    
    
    /**
     * Lista todos os responsaveis pelo curso, serie e turma dos seus filhos.     
     * 
     * @param array $params
     * @return object[]
     */
    public function listaPorTurma($params) {
        $this->db->distinct();
        $this->db->select("RE.ID_RESPONSAVEL, RE.CPF_RESPONSAVEL, RE.NM_RESPONSAVEL, AL.CD_ALUNO, AL.NM_ALUNO");
        $this->db->from("BD_SICA.RESPONSAVEL RE");
        $this->db->join("BD_SICA.ALU_RESPONSAVEL AR", "RE.ID_RESPONSAVEL = AR.ID_RESPONSAVEL");
        $this->db->join("BD_SICA.ALUNO AL", "AL.CD_ALUNO = AR.CD_ALUNO");
        $this->db->join("BD_SICA.MATRICULA MA", "MA.CD_ALUNO = AL.CD_ALUNO");
        $this->db->where("AL.CD_CURSO", $params['curso']);
        $this->db->where("AL.ORDEM_SERIE", $params['serie']);        
        $this->db->where("MA.PERIODO", $params['periodo']);
        $this->db->where("AL.STATUS = 1");
        
        if (!empty($params['turma'])) {
            $this->db->where("MA.CD_TURMA", $params['turma']);
        }

        //tipo T determina que exibe tanto responsaveis finaceiros quanto academicos
        if ($params['tipo'] != "T") {
            $this->db->where("AR.TIPO_RESPONSAVEL", $params['tipo']);
        }

        $this->db->order_by("RE.NM_RESPONSAVEL, AL.NM_ALUNO");

        $query = $this->db->get();
        return $query->result();
    }

    function listar_token($p) {
        /*
         * PEGA OS ALUNOS DO RESPONSAVEL
         * E O TOKEN DO ANDROID
         */
        $this->db->where('AR.CD_ALUNO', $p['aluno']);
        $this->db->where('AR.ACESSO_WEB', 'S');
        //$this->db->where('AR.RESPONSAVEL_LEGAL', 'S');
        $this->db->join('BD_SICA.ALU_RESPONSAVEL AR', 'AR.ID_RESPONSAVEL = R.ID_RESPONSAVEL');
        $this->db->join('BD_APLICACAO.APP_TOKEN T', 'R.CPF_RESPONSAVEL = T.CD_USUARIO');
        $query = $this->db->get('BD_SICA.RESPONSAVEL R')->result_array();
        return $query;
    }

    function listar_aluno($p) {
        $this->db->where('AR.CD_ALUNO', $p['aluno']);
        $this->db->join('BD_SICA.ALU_RESPONSAVEL AR', 'AR.ID_RESPONSAVEL = R.ID_RESPONSAVEL');
        $query = $this->db->get('BD_SICA.RESPONSAVEL R')->result_array();
        return $query;
    }

    function filtro($p) {
        $this->db->where('CD_SUSPENSAO', $p);
        $query = $this->db->get('BD_SICA.RESPONSAVEL')->row();
        return $query;
    }

    function adicionar($p) {

        $data = array(
            'PERIODO' => $p['periodo'],
            'CD_ALUNO' => $p['aluno'],
            'DT_INICIO' => date('d-M-y', strtotime(implode("-", array_reverse(explode("/", $p['inicio']))))),
            'DT_FIM' => date('d-M-y', strtotime(implode("-", array_reverse(explode("/", $p['fim']))))),
            'DC_MOTIVO' => $p['motivo'],
            'FLG_WEB' => $p['web'],
            'CD_USUARIO' => $this->session->userdata('SGP_CODIGO')
        );
        //print_r($data);

        $this->db->insert('BD_SICA.ALUNO_SUSPENSAO', $data);

        /*         * ************** ADICIONAR LOGS **************** */

        $sql = $this->db->last_query();
        $co = new Weblogs_lib();
        $co->sql = $sql;
        $co->url();
        /*         * ************** ADICIONAR LOGS **************** */
    }

    function editar($p) {
        $data = array(
            'PERIODO' => $p['periodo'],
            'CD_ALUNO' => $p['aluno'],
            'DT_INICIO' => $p['inicio'],
            'DT_FIM' => $p['fim'],
            'DC_MOTIVO' => $p['motivo'],
            'FLG_WEB' => $p['web'],
        );
        $this->db->where('CD_SUSPENSAO', $p['codigo']);
        $this->db->update('BD_SICA.ALUNO_SUSPENSAO', $data);

        /*         * ************** ADICIONAR LOGS **************** */
        $sql = $this->db->last_query();
        $co = new Weblogs_lib();
        $co->sql = $sql;
        $co->url();
        /*         * ************** ADICIONAR LOGS **************** */
    }

    function deletar($p) {
        $data = array(
            'FLG_ATIVO' => 'N',
            'FLG_WEB' => 'N',
        );
        $this->db->where('CD_SUSPENSAO', $p['codigo']);
        $this->db->update('BD_SICA.ALUNO_SUSPENSAO', $data);

        /*         * ************** ADICIONAR LOGS **************** */
        $sql = $this->db->last_query();
        $co = new Weblogs_lib();
        $co->sql = $sql;
        $co->url();
        /*         * ************** ADICIONAR LOGS **************** */
    }

}
