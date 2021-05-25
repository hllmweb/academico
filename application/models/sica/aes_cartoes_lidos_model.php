<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Aes_cartoes_lidos_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function processar_prova($p){
        $cursor = "";
        $params = array(
            array('name' => ':P_CD_PROVA', 'value' => $p['prova']),
            array('name' => ':P_QTDE_PROCESSADOS', 'value' => 0, 'type' => OCI_B_ROWID)
        );
        return $this->db->procedure('BD_SICA','SP_PROCESSA_AVAL_PROVA', $params);
    }


    function prova_detalhe_aluno($p){
        $this->db->where('CD_PROVA_VERSAO',$p['prova']);
        $this->db->where('CD_ALUNO',$p['aluno']);
        $query = $this->db->get('BD_SICA.VW_PROVA_DETALHE')->result_array();
        return $query;
    }

    function prova_detalhe_simulado($p){
        $this->db->where('CD_PROVA',$p);
        $this->db->order_by('NM_ALUNO','asc');
        $query = $this->db->get('BD_SICA.VW_AVAL_PROVA_ALUNO_DISC')->result_array();
        return $query;
    }

    function prova_detalhe($p){
        $this->db->where('CD_PROVA',$p);
        $this->db->order_by('NM_ALUNO','asc');
        $query = $this->db->get('BD_SICA.VW_AVAL_PROVA_ALUNO_DISC')->result_array();
        return $query;
    }

    public function prova_detalhe_fez_prova($p){
        $this->db->select('AL.*, P.*');
        $this->db->where('P.CD_PROVA', $p);
        $this->db->where('P.FEZ_PROVA', 0);
        $this->db->join('BD_SICA.ALUNO AL','AL.CD_ALUNO = P.CD_ALUNO');
        $query = $this->db->get('BD_SICA.AVAL_PROVA_INSCRITOS P')->result_array();
        return $query;
    }

    function filtro($p){
        $query = $this->db->get('BD_SICA.AVAL_CARTOES_LIDOS');
        return $query;
    }

    function listar($p){
        $query = $this->db->get('BD_SICA.AVAL_CARTOES_LIDOS');
        return $query;
    }

    function adicionar($p) {
        $this->db->select('CD_PROVA, FLG_PEND_PROCESSAMENTO');
        $this->db->where('NUM_PROVA', $p['prova']);
        $query = $this->db->get('BD_SICA.AVAL_PROVA')->row();


        $dados = array(
             'CD_PROVA' => $query->CD_PROVA,
             'CD_ALUNO' => $p['aluno'],
        );
        $this->db->delete('BD_SICA.AVAL_CARTOES_LIDOS', $dados);



        $data = array(
             'CD_PROVA' => $query->CD_PROVA,
             'CD_ALUNO' => $p['aluno'] ,
            'RESPOSTAS' => $p['respostas'],
        'LOGIN_LEITURA' => $p['usuario']
        );
        $r = $this->db->insert('BD_SICA.AVAL_CARTOES_LIDOS', $data);

        /**************** ADICIONAR LOGS *****************/
        $sql = $this->db->last_query();
        $co = new Weblogs_lib();
        $co->sql = $sql;
        $co->url();
        /**************** ADICIONAR LOGS *****************/
    }

    function editar($p) {
        $data = array(
            'RESPOSTAS' => $p['respostas'] ,
        'LOGIN_LEITURA' => $p['usuario']
        );
        $this->db->where('CD_PROVA', $p['prova']);
        $this->db->where('CD_ALUNO', $p['aluno']);
        $r = $this->db->update('BD_SICA.AVAL_CARTOES_LIDOS', $data);

        /**************** ADICIONAR LOGS *****************/
        $sql = $this->db->last_query();
        $co = new Weblogs_lib();
        $co->sql = $sql;
        $co->url();
        /**************** ADICIONAR LOGS *****************/
    }


    function getRespostaProvaOnline($CD_PROVA_VERSAO,$CD_ALUNO){

        
        
        $sql = "SELECT AQ.*, D.CD_DISCIPLINA, D.CD_TIPO_PROVA, PR.FL_FORMATO
         FROM BD_SICA.AVAL_PROVA_ALUNO_QUESTAO aq
          JOIN BD_SICA.VW_AVAL_PROVA_ALUNO_DISC D ON D.cd_prova_versao = aq.cd_prova and D.cd_aluno = {$CD_ALUNO}
          LEFT JOIN BD_SICA.AVAL_PROVA PR ON PR.CD_PROVA=AQ.CD_PROVA
          where D.CD_PROVA_VERSAO = {$CD_PROVA_VERSAO} and aq.cd_aluno = {$CD_ALUNO}
          order by aq.POSICAO";

        return $this->db->query($sql)->result_array();
    }
}
