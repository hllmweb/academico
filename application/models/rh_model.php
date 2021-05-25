<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rh_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function funcionario($p) {
       $cursor = '';
       $params = array(
           array('name' => ':P_OPERACAO',   'value' => $p['operacao']),
           array('name' => ':P_CD_USUARIO', 'value' => $this->session->userdata('SGP_CODIGO') ),
           array('name' => ':P_MES',        'value' => $p['mes']),
           array('name' => ':P_CURSOR',     'value' => $cursor, 'type' => OCI_B_CURSOR)
       );
       return $this->db->procedure('BD_PORTAL','RH_FUNCIONARIOS',$params);
    }
}



