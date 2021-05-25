<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Responsavel_termo_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function listar_turma($p) {
        $this->db->select('A.CD_ALUNO,
                           A.NM_ALUNO,
                           A.TURMA_ATUAL,
                           A.CD_CURSO,
                           A.ORDEM_SERIE,
                           C.NM_CURSO,
                           (SELECT COUNT(*) FROM BD_SICA.RESPONSAVEL_TERMO WHERE CD_ALUNO = A.CD_ALUNO) AS CONT
                           ');
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
        $query = $this->db->get('BD_SICA.VW_RESPONSAVEL_TERMO')->result_array();
        return $query;
    }

    function filtro($p){
        $this->db->where('CD_TERMO',$p);
        $query = $this->db->get('BD_SICA.VW_RESPONSAVEL_TERMO')->row();
        return $query;
    }

    function adicionar($p) {

        $data = array(
              'PERIODO' => $p['periodo'],
        'CD_TIPO_TERMO' => $p['tipo'],
             'CD_ALUNO' => $p['aluno'],
       'ID_RESPONSAVEL' => $p['responsavel'],
           'CD_USUARIO' => $this->session->userdata('SGP_CODIGO')
        );

        $this->db->insert('BD_SICA.RESPONSAVEL_TERMO', $data);        
       
        /**************** ADICIONAR LOGS *****************/
        
        $sql = $this->db->last_query();
        $co = new Weblogs_lib();
        $co->sql = $sql;
        $co->url();
        /**************** ADICIONAR LOGS *****************/

    }

    function editar($p) {
        $data = array(
            'PERIODO'     => $p['periodo'],
            'CD_ALUNO'    => $p['aluno'],
            'DT_INICIO'   => $p['inicio'],
            'DT_FIM'      => $p['fim'],
            'DC_MOTIVO'   => $p['motivo'],
            'FLG_WEB'     => $p['web'],
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
            'FLG_WEB'     => 'N',
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