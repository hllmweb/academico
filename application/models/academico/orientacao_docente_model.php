<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Orientacao_docente_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function listar_turma($p) {
        $this->db->select("A.*,
                           (SELECT COUNT(*) 
                              FROM BD_ACADEMICO.AES_ORIENTACAO_DOCENTE 
                             WHERE CD_PROFESSOR = A.CD_PROFESSOR 
                               AND CD_DISCIPLINA = A.CD_DISCIPLINA 
                               AND FLG_ATIVO = 'S'
                               AND PERIODO = '".$this->session->userdata('SGP_PERIODO')."') AS CONT
                           ");
        $this->db->order_by('A.NM_PROFESSOR', 'ASC');
        $this->db->where('A.CD_TURMA', $p['turma']);
        $query = $this->db->get('BD_SICA.VW_PROFESSOR_TURMA A')->result_array();
        return $query;
    }
    
    
    function filtro($param) {

        $this->db->where('CD_ORIENTACAO', $param['codigo']);
        $query = $this->db->get('BD_ACADEMICO.VW_ORIENTACAO_DOCENTE')->row();
        return $query;
    }
    
    
    function listar($param) {

        $this->db->where('CD_TURMA', $param['turma']);
        $this->db->where('CD_DISCIPLINA', $param['disciplina']);
        $this->db->where('FLG_ATIVO', 'S');
        $this->db->where('CD_PROFESSOR', $param['professor']);
        $this->db->order_by('CD_ORIENTACAO', 'ASC');
        $query = $this->db->get('BD_ACADEMICO.AES_ORIENTACAO_DOCENTE')->result_array();
        return $query;
    }

    function adicionar($p) {
        $data = array(
            'PERIODO' => $p['periodo'] ,
           'CD_TURMA' => $p['turma'] ,
       'CD_PROFESSOR' => $p['professor'],
      'CD_DISCIPLINA' => $p['disciplina'],
          'DC_MOTIVO' => $p['motivo'],
          'DC_RESUMO' => $p['resumo'],
             'DC_OBS' => $p['obs'],
      'DT_ORIENTACAO' => date('d-M-y',strtotime(implode("-",array_reverse(explode("/",$p['data']))))),
         'CD_USUARIO' => $this->session->userdata('SGP_CODIGO'),
            'DC_HORA' => $p['hora'],
        );
        $this->db->insert('BD_ACADEMICO.AES_ORIENTACAO_DOCENTE', $data);
        
        /**************** ADICIONAR LOGS *****************/
        $sql = $this->db->last_query();
        $co = new Weblogs_lib();
        $co->sql = $sql;
        $co->url();
        /**************** ADICIONAR LOGS *****************/
    }

    function editar($p) {

       $data = array(
           'CD_TURMA' => $p['turma'] ,
       'CD_PROFESSOR' => $p['professor'],
      'CD_DISCIPLINA' => $p['disciplina'],
          'DC_MOTIVO' => $p['motivo'],
          'DC_RESUMO' => $p['resumo'],
             'DC_OBS' => $p['obs'],
      'DT_ORIENTACAO' => date('d-M-y',strtotime(implode("-",array_reverse(explode("/",$p['data']))))),
            'DC_HORA' => $p['hora'],
        );
        $this->db->where('CD_ORIENTACAO', $p['codigo']);
        $this->db->update('BD_ACADEMICO.AES_ORIENTACAO_DOCENTE', $data);
        
        
        /**************** ADICIONAR LOGS *****************/
        $sql = $this->db->last_query();
        $co = new Weblogs_lib();
        $co->sql = $sql;
        $co->url();
        /**************** ADICIONAR LOGS *****************/

    }

    function deletar($p) {

         $data = array(
            'FLG_ATIVO' => 'N'
        );
        $this->db->where('CD_ORIENTACAO', $p['codigo']);
        $this->db->update('BD_ACADEMICO.AES_ORIENTACAO_DOCENTE', $data);
        
        /**************** ADICIONAR LOGS *****************/
        $sql = $this->db->last_query();
        $co = new Weblogs_lib();
        $co->sql = $sql;
        $co->url();
        /**************** ADICIONAR LOGS *****************/
    }

}