<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Academico_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function consultas($p) {

        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO',     'value' => $p['operacao']),
            array('name' => ':P_CD_USUARIO',   'value' => $this->session->userdata('SGP_CODIGO') ),
            array('name' => ':P_CD_PROFESSOR', 'value' => $p['professor']),
            array('name' => ':P_CD_TURMA',     'value' => $p['turma']),
            array('name' => ':P_CURSOR',       'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_ACADEMICO','AES_CONSULTAS_COORDENACAO', $params);
        
    }
    
    
    function reserva($p) {

        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO',     'value' => $p['operacao']),
            array('name' => ':P_CD_USUARIO',   'value' => $this->session->userdata('SGP_CODIGO') ),
            array('name' => ':P_CD_PROFESSOR', 'value' => $p['professor']),
            array('name' => ':P_CD_TURMA',     'value' => $p['turma']),
            array('name' => ':P_CURSOR',       'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_ACADEMICO','AES_CONSULTAS_COORDENACAO', $params);
        
    }
    
    
    function monitor($p) {

        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO',     'value' => $p['operacao']),
            array('name' => ':P_CD_USUARIO',   'value' => $this->session->userdata('SGP_CODIGO') ),
            array('name' => ':P_CD_PROFESSOR', 'value' => $p['professor']),
            array('name' => ':P_CD_CURSO',     'value' => $p['curso']),
            array('name' => ':P_ORDEM_SERIE',  'value' => $p['serie']),
            array('name' => ':P_CD_TURMA',     'value' => $p['turma']),
            array('name' => ':P_DT_AULA',      'value' => date('Y-m-d', strtotime(implode("-", array_reverse(explode("/", $p['data'])))))),
            array('name' => ':P_CURSOR',       'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_ACADEMICO','AES_COORDENACAO_MONITOR', $params);
        
    }
}



