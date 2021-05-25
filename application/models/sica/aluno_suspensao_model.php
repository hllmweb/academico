<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Aluno_suspensao_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table = "BD_SICA.ALUNO_SUSPENSAO";
        $this->view = "BD_SICA.VW_ALUNO_SUSPENSAO";
    }
    
    function listar_turma($p) {
        $this->db->select("A.CD_ALUNO,
                           A.NM_ALUNO,
                           A.TURMA_ATUAL,
                           A.CD_CURSO,
                           A.ORDEM_SERIE,
                           C.NM_CURSO,
                           (SELECT COUNT(*) FROM BD_SICA.ALUNO_SUSPENSAO WHERE CD_ALUNO = A.CD_ALUNO AND FLG_ATIVO = 'S') AS CONT
                           ");
        $this->db->where('U.CD_USUARIO', $this->session->userdata('SGP_CODIGO'));
        $this->db->where('A.TIPO', 'C');
        $this->db->where('A.CD_CURSO', $p['curso']);
        $this->db->where('A.ORDEM_SERIE', $p['serie']);
        $this->db->where('A.STATUS', 1);
        $this->db->join("BD_SICA.MATRICULA M", "M.CD_ALUNO = A.CD_ALUNO AND M.CD_TURMA = A.TURMA_ATUAL AND M.PERIODO = '".$p['periodo']."'");
        $this->db->join('BD_SICA.T_CURSO_USER U', 'U.CD_CURSO = A.CD_CURSO');
        $this->db->join('BD_SICA.CURSOS C', 'A.CD_CURSO = C.CD_CURSO');
        $this->db->order_by('A.NM_ALUNO', 'ASC');
        $query = $this->db->get('BD_SICA.ALUNO A')->result_array();
        return $query;
    }
    
    
    
    function listar($p){
        $this->db->where('CD_ALUNO',$p['aluno']);
        $this->db->where('FLG_ATIVO','S');
        $query = $this->db->get('BD_SICA.VW_ALUNO_SUSPENSAO')->result_array();
        return $query;
    }
    
    
    function filtro($p){
        $this->db->where('CD_SUSPENSAO',$p['codigo']);
        $query = $this->db->get('BD_SICA.VW_ALUNO_SUSPENSAO')->row();
        return $query;
    }
    
        
    function adicionar($p) {

        $data = array(
            'PERIODO'     => $p['periodo'],
            'CD_ALUNO'    => $p['aluno'],
            'DT_INICIO'   => date('d-M-y',strtotime(implode("-",array_reverse(explode("/",$p['inicio']))))),
            'DT_FIM'      => date('d-M-y',strtotime(implode("-",array_reverse(explode("/",$p['fim']))))),
            'DC_MOTIVO'   => $p['motivo'],
            'FLG_WEB'     => $p['web'],
            'FLG_NOTIFICAR'     => $p['notificar'],
            'CD_USUARIO'  => $this->session->userdata('SGP_CODIGO')
        );
        
        $this->db->insert('BD_SICA.ALUNO_SUSPENSAO', $data);        
       
        /**************** ADICIONAR LOGS *****************/
        
        $sql = $this->db->last_query();
        $co = new Weblogs_lib();
        $co->sql = $sql;
        $co->url();
        /**************** ADICIONAR LOGS *****************/

    }

    function editar($p) {
        $data = array(
            'DT_INICIO'   => date('d-M-y',strtotime(implode("-",array_reverse(explode("/",$p['inicio']))))),
            'DT_FIM'      => date('d-M-y',strtotime(implode("-",array_reverse(explode("/",$p['fim']))))),
            'DC_MOTIVO'   => $p['motivo'],
            'CD_USUARIO'  => $this->session->userdata('SGP_CODIGO')
        );
        $this->db->where('CD_SUSPENSAO', $p['codigo']);
        $this->db->update('BD_SICA.ALUNO_SUSPENSAO', $data); 
        
        /**************** ADICIONAR LOGS *****************/
        $sql = $this->db->last_query();
        $co = new Weblogs_lib();
        $co->sql = $sql;
        $co->url();
        /**************** ADICIONAR LOGS *****************/
    }
    
    function deletar($p) {
        $data = array(
            'FLG_ATIVO'   => 'N',
        );
        $this->db->where('CD_SUSPENSAO', $p['codigo']);
        $this->db->update('BD_SICA.ALUNO_SUSPENSAO', $data); 
        
        /**************** ADICIONAR LOGS *****************/
        $sql = $this->db->last_query();
        $co = new Weblogs_lib();
        $co->sql = $sql;
        $co->url();
        /**************** ADICIONAR LOGS *****************/
    }

}