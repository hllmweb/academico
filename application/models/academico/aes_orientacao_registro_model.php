<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Aes_orientacao_registro_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table = "BD_ACADEMICO.AES_ORIENTACAO_REGISTRO";
        $this->view = "BD_ACADEMICO.VW_ORIENTACAO_REGISTRO";
    }
    
    function listar_turma($p) {
        $this->db->select("A.CD_ALUNO,
                           A.NM_ALUNO,
                           M.CD_TURMA,
                           A.CD_CURSO,
                           A.ORDEM_SERIE,
                           C.NM_CURSO,
                           (SELECT COUNT(*) FROM BD_ACADEMICO.AES_ORIENTACAO_REGISTRO WHERE 
                           FLG_ATIVO = 'S' 
                           AND CD_ALUNO = A.CD_ALUNO AND PERIODO = '".$p['periodo']."') AS CONT
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
    
    function filtro($param) {

        $this->db->where('CD_REGISTRO', $param['codigo']);
        $this->db->order_by('ORT.DT_REGISTRO', 'DESC');
        $query = $this->db->get('BD_ACADEMICO.VW_ORIENTACAO_REGISTRO ORT')->row();
        return $query;
    }
    
    
    function listar($param) {

        $this->db->where('CD_ALUNO', $param['aluno']);
        $this->db->where('FLG_ATIVO', 'S');
        $this->db->where('PERIODO', $this->session->userdata('SGP_PERIODO'));
//        $this->db->where('OPCAO_REGISTRO', 1);
        $this->db->order_by('ORT.DT_REGISTRO', 'DESC');
        $query = $this->db->get('BD_ACADEMICO.VW_ORIENTACAO_REGISTRO ORT')->result_array();
        return $query;
    }

    function adicionar($p) {

        $data = array(
            'CD_ALUNO' => $p['aluno'] ,
    'CD_TIPO_REGISTRO' => $p['tipo'] ,
          'CD_USUARIO' => $p['usuario'],
         'DS_REGISTRO' => $p['descricao'],
      'OPCAO_REGISTRO' => 1,
              'STATUS' => 0,
         'DT_REGISTRO' => date('d-M-y',strtotime(implode("-",array_reverse(explode("/",$p['data']))))),
       'FLG_SMS_AVISO' => $p['sms'],
            'FLG_NOTIFICAR' => $p['notificar'],
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
    'CD_TIPO_REGISTRO' => $p['tipo'] ,
          'CD_USUARIO' => $p['usuario'],
         'DS_REGISTRO' => $p['descricao'],
         'DT_REGISTRO' => date('d-M-y',strtotime(implode("-",array_reverse(explode("/",$p['data']))))),
             'PERIODO' => $p['periodo'],
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

}