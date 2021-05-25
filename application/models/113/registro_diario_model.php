<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Registro_diario_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function listar_turma($p) {
        $this->db->select("A.CD_ALUNO,
                           A.NM_ALUNO,
                           M.CD_TURMA,
                           A.CD_CURSO,
                           A.ORDEM_SERIE,
                           M.PERIODO,
                           C.NM_CURSO,
                           (SELECT COUNT(*) FROM BD_ACADEMICO.AES_ORIENTACAO_REGISTRO WHERE FLG_ATIVO = 'S' AND CD_ALUNO = A.CD_ALUNO AND OPCAO_REGISTRO = 0 AND PERIODO = '".$p['periodo']."') AS CONT
                           ");
        
        $this->db->where('A.TIPO', 'C');
        $this->db->where_in('M.TIPO', array('N','X'));
        $this->db->where_in('A.STATUS', array('1'));
        
        $this->db->join("BD_SICA.MATRICULA M", "M.CD_ALUNO = A.CD_ALUNO AND M.CD_TURMA = '".$p['turma']."' AND M.PERIODO = '".$p['periodo']."'");
        $this->db->join('BD_SICA.CURSOS C', 'A.CD_CURSO = C.CD_CURSO');
        $this->db->order_by('A.NM_ALUNO', 'ASC');
        $query = $this->db->get('BD_SICA.ALUNO A')->result_array();
        return $query;
    }
    
    function listar_pendencias() {
        $this->db->select("A.CD_ALUNO,
                           A.NM_ALUNO,
                           M.CD_TURMA,
                           A.CD_CURSO,
                           A.ORDEM_SERIE,
                           M.PERIODO,
                           C.NM_CURSO,
                           (SELECT COUNT(*) FROM BD_ACADEMICO.AES_ORIENTACAO_REGISTRO WHERE FLG_ATIVO = 'S' AND CD_ALUNO = A.CD_ALUNO AND OPCAO_REGISTRO = 0 AND STATUS = 1) AS CONT
                           ");
        
        $this->db->where('U.CD_USUARIO', $this->session->userdata('SGP_CODIGO'));
        $this->db->where('M.PERIODO', $this->session->userdata('SGP_PERIODO'));
        $this->db->where('ORT.STATUS', 1);
        $this->db->where('ORT.OPCAO_REGISTRO', 0);
        $this->db->where_in('A.STATUS', array('1'));
       
        $this->db->join("BD_SICA.ALUNO A", "ORT.CD_ALUNO = A.CD_ALUNO");
        $this->db->join("BD_SICA.MATRICULA M", "M.CD_ALUNO = ORT.CD_ALUNO AND M.TIPO = 'N'");
        $this->db->join("BD_SICA.CURSOS C", "A.CD_CURSO = C.CD_CURSO");
        $this->db->join("BD_SICA.T_CURSO_USER U", "U.CD_CURSO = C.CD_CURSO");
        $this->db->group_by("A.CD_ALUNO, A.NM_ALUNO, M.CD_TURMA, A.CD_CURSO, A.ORDEM_SERIE, M.PERIODO, C.NM_CURSO");
        $this->db->order_by('A.NM_ALUNO', 'ASC');
        
        $query = $this->db->get('BD_ACADEMICO.AES_ORIENTACAO_REGISTRO ORT')->result_array();
        //echo $this->db->last_query();
        return $query;
       
    }
    
    function filtro($param) {

        $this->db->where('CD_REGISTRO', $param['codigo']);
        $this->db->order_by('ORT.DT_REGISTRO', 'DESC');
        $query = $this->db->get('BD_ACADEMICO.VW_ORIENTACAO_REGISTRO ORT')->row();
        return $query;
    }
    
    function listar($param) {

        //$this->db->select('ORT.*, A.NM_ALUNO, U.NM_USUARIO');
        $this->db->select('ORT.*, A.NM_ALUNO, U.NM_USUARIO, ORDEM_SERIE');
        $this->db->where('ORT.CD_ALUNO', $param['aluno']);
        $this->db->where('ORT.PERIODO', $param['periodo']);
        //$this->db->where('ORT.OPCAO_REGISTRO', 0);
        
        //Resgates de Registros ATIVOS
        $this->db->where('ORT.FLG_ATIVO', 'S');
        
        //if($param['filtro']== 1){
         //   $this->db->where('ORT.STATUS', 1);
       // }
        
        $this->db->join('BD_SICA.ALUNO A', 'ORT.CD_ALUNO = A.CD_ALUNO');
        $this->db->join('BD_SICA.USUARIOS U', 'ORT.CD_USUARIO = U.CD_USUARIO');
        $this->db->order_by('ORT.DT_REGISTRO', 'DESC');
        $query = $this->db->get('BD_ACADEMICO.AES_ORIENTACAO_REGISTRO ORT')->result_array();
        return $query;
    }

    function adicionar($p) {

        $data = array(
            'CD_ALUNO' => $p['aluno'] ,
          'CD_USUARIO' => $p['usuario'],
         'DS_REGISTRO' => $p['descricao'],
      'OPCAO_REGISTRO' => 0,
              'STATUS' => 0,
    'CD_TIPO_REGISTRO' => $p['tipo'],
         'DT_REGISTRO' => date('d-M-Y',strtotime(implode("-",explode("/",$p['data'])))),
       'FLG_SMS_AVISO' => $p['sms'],
             'PERIODO' => $p['periodo'],
        );
        
        $this->db->insert('BD_ACADEMICO.AES_ORIENTACAO_REGISTRO', $data);        
        /**************** ADICIONAR LOGS *****************/
        $sql = $this->db->last_query();
        $co = new Weblogs_lib();
        $co->sql = $sql;
        $co->url();
        /**************** ADICIONAR LOGS *****************/
    }

    function editar($p) {

        $data = array(
         'DS_REGISTRO' => $p['descricao'],
         'DT_REGISTRO' => date('d-M-y',strtotime(implode("-",explode("/",$p['data']))))
        );

        $this->db->where('CD_REGISTRO', $p['codigo']);
        $this->db->update('BD_ACADEMICO.AES_ORIENTACAO_REGISTRO', $data);
        
        
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
        $this->db->where('CD_REGISTRO', $p['codigo']);
        $this->db->update('BD_ACADEMICO.AES_ORIENTACAO_REGISTRO', $data);
        
        /**************** ADICIONAR LOGS *****************/
        $sql = $this->db->last_query();
        $co = new Weblogs_lib();
        $co->sql = $sql;
        $co->url();
        /**************** ADICIONAR LOGS *****************/
    }

    function liberar($p) {

         $data = array(
            'STATUS' => (($p['status'] == 0) ? 1 : 0)
        );
        $this->db->where('CD_REGISTRO', $p['codigo']);
        $this->db->update('BD_ACADEMICO.AES_ORIENTACAO_REGISTRO', $data);
        
        /**************** ADICIONAR LOGS *****************/
        $sql = $this->db->last_query();
        $co = new Weblogs_lib();
        $co->sql = $sql;
        $co->url();
        /**************** ADICIONAR LOGS *****************/
    }
}