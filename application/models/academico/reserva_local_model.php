<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reserva_local_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function listar_tipo($tipo) {
        $this->db->where('TP_LOCAL', $tipo);
        $this->db->order_by('NM_LOCAL', 'ASC');
        $query = $this->db->get('BD_ACADEMICO.RESERVA_LOCAL')->result_array();
        return $query;
    }
    
    function filtro($p){
        $this->db->where('CD_LOCAL',$p);
        $query = $this->db->get('BD_SICA.RESERVA_LOCAL')->row();
        return $query;
    }
    
    function adicionar($p) {

        $data = array(
              'PERIODO' => $p['periodo'],
             'CD_ALUNO' => $p['aluno'],
             'FLG_TIPO' => $p['tipo'],
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
             'PERIODO' => $p['periodo'],
            'CD_ALUNO' => $p['aluno'],
      'DT_ADVERTENCIA' => $p['inicio'],
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
            'FLG_WEB'     => 'N',
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
