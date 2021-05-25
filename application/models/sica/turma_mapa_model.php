<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Turma_mapa_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
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
                           TM.NR_FILA,
                           TM.NR_POSICAO
                           ");
        $this->db->where('U.CD_USUARIO', $this->session->userdata('SGP_CODIGO'));
        $this->db->where('A.TIPO', 'C');
        $this->db->where_in('A.STATUS', array('1'));
        $this->db->where('M.TIPO', 'N');
        $this->db->join("BD_SICA.MATRICULA M", "M.CD_ALUNO = A.CD_ALUNO AND M.CD_TURMA = '".$p['turma']."' AND M.PERIODO = '".$p['periodo']."'");
        $this->db->join("BD_SICA.TURMA_MAPA TM", "TM.CD_ALUNO = A.CD_ALUNO AND TM.CD_TURMA = M.CD_TURMA AND TM.PERIODO = M.PERIODO",'LEFT');
        $this->db->join('BD_SICA.T_CURSO_USER U', 'U.CD_CURSO = A.CD_CURSO');
        $this->db->join('BD_SICA.CURSOS C', 'A.CD_CURSO = C.CD_CURSO');
        $this->db->order_by('A.NM_ALUNO', 'ASC');
        $query = $this->db->get('BD_SICA.ALUNO A')->result_array();
        return $query;
    }    
        
    function adicionar($p) {

        $data = array(
              'PERIODO' => $p['periodo'],
             'CD_ALUNO' => $p['aluno'],
             'CD_TURMA' => $p['turma'],
              'NR_FILA' => $p['fila'],
           'NR_POSICAO' => $p['posicao'],
           'CD_USUARIO' => $this->session->userdata('SGP_CODIGO')
        );        
        $this->db->insert('BD_SICA.TURMA_MAPA', $data);

        /**************** ADICIONAR LOGS *****************/
        $sql = $this->db->last_query();
        $co = new Weblogs_lib();
        $co->sql = $sql;
        $co->url();
        /**************** ADICIONAR LOGS *****************/

    }

    function editar($p) {
        $data = array(
              'NR_FILA' => $p['fila'],
           'NR_POSICAO' => $p['posicao'],
        );   
        $this->db->where('PERIODO', $p['periodo']);
        $this->db->where('CD_ALUNO', $p['aluno']);
        $this->db->where('CD_TURMA', $p['turms']);
        $this->db->update('BD_SICA.TURMA_MAPA', $data); 
        
        /**************** ADICIONAR LOGS *****************/
        $sql = $this->db->last_query();
        $co = new Weblogs_lib();
        $co->sql = $sql;
        $co->url();
        /**************** ADICIONAR LOGS *****************/
    }
    
    function deletar($p) {
        $this->db->where('PERIODO', $p['periodo']);
        $this->db->where('CD_ALUNO', $p['aluno']);
        $this->db->where('CD_TURMA', $p['turma']);
        $this->db->delete('BD_SICA.TURMA_MAPA', $data); 
        
        /**************** ADICIONAR LOGS *****************/
        $sql = $this->db->last_query();
        $co = new Weblogs_lib();
        $co->sql = $sql;
        $co->url();
        /**************** ADICIONAR LOGS *****************/
    }

}