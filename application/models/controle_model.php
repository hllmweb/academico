<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Controle_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function weblog($p) {
        $cursor = '';
        $params = array(
                  array('name' => ':P_OPERACAO',   'value' => $p['operacao']   ),
                  array('name' => ':P_CD_USUARIO', 'value' => $this->session->userdata('SGP_CODIGO') ),
                  array('name' => ':P_PROGRAMA',   'value' => $p['programa']   ),
                  array('name' => ':P_IP',         'value' => $p['ip']         ),
                  array('name' => ':P_DISPOSITIVO','value' => $p['device']     ),
                  array('name' => ':P_SISTEMA',    'value' => $p['sistema']    ),
                  array('name' => ':P_CURSOR',     'value' => $p,         'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_PORTAL','AES_WEBLOG',$params);
    }
    
    
    function acesso_catraca($dados) {
        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO', 'value' => $dados['operacao']),
            array('name' => ':P_DT_BASE', 'value' => $dados['data']),
            array('name' => ':P_TIPO_USUARIO', 'value' => $dados['tipo']),
            array('name' => ':P_FLG_PASSAGEM', 'value' => $dados['passe']),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_CONTROLE','GET_PASSAGENS',$params);
    }
}

