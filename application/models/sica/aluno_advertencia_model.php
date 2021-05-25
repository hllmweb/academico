<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Aluno_advertencia_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table = "BD_SICA.ALUNO_ADVERTENCIA";
        $this->view = "BD_SICA.VW_ALUNO_ADVERTENCIA";
    }
    
    function listar_turma($p) {
        $this->db->select("A.CD_ALUNO,
                           A.NM_ALUNO,
                           M.CD_TURMA,
                           A.TURMA_ATUAL,
                           A.CD_CURSO,
                           A.ORDEM_SERIE,
                           A.TIPO,
                           C.NM_CURSO,
                           (SELECT COUNT(*) 
                              FROM BD_SICA.ALUNO_ADVERTENCIA 
                             WHERE CD_ALUNO = A.CD_ALUNO 
                               AND FLG_ATIVO = 'S'
                               AND PERIODO = '".$p['periodo']."'
                               ) AS CONT
                           ");
        $this->db->where('U.CD_USUARIO', $this->session->userdata('SGP_CODIGO'));
        $this->db->where('A.TIPO', 'C');
        $this->db->where_in('A.STATUS', array('1'));
        $this->db->where('M.TIPO', 'N');
        $this->db->join("BD_SICA.MATRICULA M", "M.CD_ALUNO = A.CD_ALUNO AND M.CD_TURMA = '".$p['turma']."' AND M.PERIODO = '".$p['periodo']."'");
        $this->db->join('BD_SICA.T_CURSO_USER U', 'U.CD_CURSO = A.CD_CURSO');
        $this->db->join('BD_SICA.CURSOS C', 'A.CD_CURSO = C.CD_CURSO');
        $this->db->order_by('A.NM_ALUNO', 'ASC');
        $query = $this->db->get('BD_SICA.ALUNO A')->result_array();
        return $query;
    }
    
    
    
    function listar($p){
        $this->db->where('CD_ALUNO',$p['aluno']);
        $this->db->where('FLG_ATIVO','S');
        $query = $this->db->get('BD_SICA.VW_ALUNO_ADVERTENCIA')->result_array();
        return $query;
    }
    
    
    function filtro($p){
        $this->db->where('CD_ADVERTENCIA',$p['codigo']);
        $query = $this->db->get('BD_SICA.VW_ALUNO_ADVERTENCIA')->row();
        return $query;
    }
    
        
    function adicionar($p) {

        $data = array(
              'PERIODO' => $p['periodo'],
             'CD_ALUNO' => $p['aluno'],
             'FLG_TIPO' => $p['tipo'],
             'FLG_NOTIFICAR' => $p['notificar'],
            'DC_MOTIVO' => $p['motivo'],
       'ID_RESPONSAVEL' => (($p['responsavel'] == '')? null: $p['responsavel']),
       'DT_ADVERTENCIA' => date('d-M-y',strtotime(implode("-",array_reverse(explode("/",$p['data']))))),
           'CD_USUARIO' => $this->session->userdata('SGP_CODIGO')
        );        
        $this->db->insert('BD_SICA.ALUNO_ADVERTENCIA', $data);

        /**************** ADICIONAR LOGS *****************/
        $sql = $this->db->last_query();
        $co = new Weblogs_lib();
        $co->sql = $sql;
        $co->url();
        /**************** ADICIONAR LOGS *****************/

    }

    function editar($p) {
        $data = array(
      'DT_ADVERTENCIA' => date('d-M-y',strtotime(implode("-",array_reverse(explode("/",$p['data']))))),
            'FLG_TIPO' => $p['tipo'],
           'DC_MOTIVO' => $p['motivo']
        );
        $this->db->where('CD_ADVERTENCIA', $p['codigo']);
        $this->db->update('BD_SICA.ALUNO_ADVERTENCIA', $data); 
        
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
        $this->db->where('CD_ADVERTENCIA', $p['codigo']);
        $this->db->update('BD_SICA.ALUNO_ADVERTENCIA', $data); 
        
        /**************** ADICIONAR LOGS *****************/
        $sql = $this->db->last_query();
        $co = new Weblogs_lib();
        $co->sql = $sql;
        $co->url();
        /**************** ADICIONAR LOGS *****************/
    }

}