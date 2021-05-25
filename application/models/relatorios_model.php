<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Relatorios_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function relTema($p) {

        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO', 'value' => $p['operacao']),
            array('name' => ':P_CD_CURSO', 'value' => $p['curso']),
            array('name' => ':P_ORDEM_SERIE', 'value' => $p['serie']),
            array('name' => ':P_CD_DISCIPLINA', 'value' => $p['disciplina']),
            array('name' => ':P_CD_PROVA', 'value' => $p['prova']),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );

        $sql = $this->db->procedure('BD_ACADEMICO','AVAL_DETALHES',$params);
        return($sql);
    }
}



