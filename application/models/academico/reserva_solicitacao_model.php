<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reserva_solicitacao_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }


    function filtro($p) {
        $this->db->where('S.CD_RESERVA',$p['codigo']);
        $query = $this->db->get('BD_ACADEMICO.VW_RESERVA_SOLICITACAO S')->row();
        return $query;
    }

    
    function listar_filtro($p) {

        if($p['periodo'] != '')
            $this->db->where('PERIODO',$p['periodo']);
        
        if($p['data'] != '')
            $this->db->where('DT_PRATICA', date('d-M-y',strtotime(implode("-",array_reverse(explode("/",$p['data']))))));
        
        if($p['local'] != '')
            $this->db->where('TP_LOCAL',$p['local']);
        
        $this->db->order_by('CD_RESERVA', 'ASC');
        $query = $this->db->get('BD_ACADEMICO.VW_RESERVA_SOLICITACAO')->result_array();
        return $query;
    }
    
    
    function adicionar($p) {        

        $data = array(
           // 'CD_RESERVA' => $p['periodo'],
               'PERIODO' => $p['periodo'],
          'CD_PROFESSOR' => $p['professor'],
         'CD_DISCIPLINA' => $p['disciplina'],
              'CD_CURSO' => $p['curso'],
           'ORDEM_SERIE' => $p['serie'],
              'CD_TURMA' => $p['turma'],
            'NR_PRATICA' => $p['pratica'],
              'CD_LOCAL' => $p['local'],
            'DT_PRATICA' => date('d-M-y',strtotime(implode("-",array_reverse(explode("/",$p['dtInicio']))))),
      'DT_PRATICA_FINAL' => date('d-M-y',strtotime(implode("-",array_reverse(explode("/",$p['dtFim']))))),
             'HR_INICIO' => $p['inicio'],
              'HR_FINAL' => $p['fim'],
   'DS_CONTEUDO_PRATICA' => $p['conteudo'],
   'DS_OBJETIVO_PRATICA' => $p['objetivo'],
           'DS_MATERIAL' => $p['material'],
             'DS_METODO' => $p['metodo'],
          'DS_RESULTADO' => $p['resultado'],
         'DS_OBSERVACAO' => $p['observacao'],
             'FL_STATUS' => $p['status'],
            'CD_USUARIO' => $this->session->userdata('SGP_CODIGO')
        );
        $this->db->insert('BD_ACADEMICO.RESERVA_SOLICITACAO', $data);
        //echo $this->db->last_query();
        
        /**************** ADICIONAR LOGS *****************/
        $sql = $this->db->last_query();
        $co = new Weblogs_lib();
        $co->sql = $sql;
        $co->url();
        /**************** ADICIONAR LOGS *****************/
        
        $this->db->select("MAX(CD_RESERVA) AS RESERVA", FALSE);
        $row = $this->db->get('BD_ACADEMICO.RESERVA_SOLICITACAO')->row();
        return $row->RESERVA;
     
    }

    function editar($p) {
        $data = array(
               'PERIODO' => $p['periodo'],
          'CD_PROFESSOR' => $p['professor'],
         'CD_DISCIPLINA' => $p['disciplina'],
              'CD_CURSO' => $p['curso'],
           'ORDEM_SERIE' => $p['serie'],
              'CD_TURMA' => $p['turma'],
            'NR_PRATICA' => $p['pratica'],
              'CD_LOCAL' => $p['local'],
            'DT_PRATICA' => date('d-M-y',strtotime(implode("-",array_reverse(explode("/",$p['dtInicio']))))),
      'DT_PRATICA_FINAL' => date('d-M-y',strtotime(implode("-",array_reverse(explode("/",$p['dtFim']))))),
             'HR_INICIO' => $p['inicio'],
              'HR_FINAL' => $p['fim'],
   'DS_CONTEUDO_PRATICA' => $p['conteudo'],
   'DS_OBJETIVO_PRATICA' => $p['objetivo'],
           'DS_MATERIAL' => $p['material'],
             'DS_METODO' => $p['metodo'],
          'DS_RESULTADO' => $p['resultado'],
         'DS_OBSERVACAO' => $p['observacao'],
             'FL_STATUS' => $p['status'],
            'CD_USUARIO' => $this->session->userdata('SGP_CODIGO')
        );
        $this->db->where('CD_RESERVA', $p['codigo']);
        $this->db->update('BD_ACADEMICO.RESERVA_SOLICITACAO', $data); 
        
        /**************** ADICIONAR LOGS *****************/
        $sql = $this->db->last_query();
        $co = new Weblogs_lib();
        $co->sql = $sql;
        $co->url();
        /**************** ADICIONAR LOGS *****************/
    }
    
    
    function editar_status($p) {
        $data = array(
         'DS_OCORRENCIA' => $p['ocorrencia'],
             'FL_STATUS' => $p['status'],
        );
        $this->db->where('CD_RESERVA', $p['codigo']);
        $this->db->update('BD_ACADEMICO.RESERVA_SOLICITACAO', $data); 
        
        /**************** ADICIONAR LOGS *****************/
        $sql = $this->db->last_query();
        $co = new Weblogs_lib();
        $co->sql = $sql;
        $co->url();
        /**************** ADICIONAR LOGS *****************/
    }
    
    
    
    
    function deletar($p) {

        $data = array();
        $this->db->where('CD_RESERVA', $p['codigo']);
        $this->db->delete('BD_ACADEMICO.RESERVA_SOLICITACAO',$data); 
        
        /**************** ADICIONAR LOGS *****************/
        $sql = $this->db->last_query();
        $co = new Weblogs_lib();
        $co->sql = $sql;
        $co->url();
        /**************** ADICIONAR LOGS *****************/
    }
    
}
