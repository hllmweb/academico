<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Acesso_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function sistemas($p) {

        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO', 'value' => $p['operacao']),
            array('name' => ':P_SISTEMA', 'value' => $p['codigo']),
            array('name' => ':P_DC_SISTEMA', 'value' => $p['nome']),
            array('name' => ':P_VERSAO', 'value' => $p['versao']),
            array('name' => ':P_TITULO', 'value' => $p['titulo']),
            array('name' => ':P_CD_GRUPO', 'value' => $p['grupo']),
            array('name' => ':P_ICONE_INDEX', 'value' => $p['icone']),
            array('name' => ':P_ATIVO', 'value' => $p['ativo']),
            array('name' => ':P_OBS', 'value' => $p['observacao']),
            array('name' => ':P_CD_PROGRAMA_ACESSO', 'value' => $p['acesso']),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_PORTAL', 'CDA_SISTEMAS', $params);
    }

    function grupo($dado) {

        $cursor = '';
        
        $params = array(
            array('name' => ':P_OPERACAO',  'value' => $dado['operacao']),
            array('name' => ':P_CD_GRUPO',  'value' => $dado['codigo']),
            array('name' => ':P_CD_USUARIO',  'value' => $dado['usuario']),
            array('name' => ':P_DC_GRUPO',  'value' => $dado['nome']),
            array('name' => ':P_FLG_ATIVO', 'value' => $dado['ativo']),
            
            array('name' => ':P_CD_PROGRAMA', 'value' => $dado['programa']),
            array('name' => ':P_INCLUIR', 'value' => $dado['incluir']),
            array('name' => ':P_ALTERAR', 'value' => $dado['alterar']),
            array('name' => ':P_EXCLUIR', 'value' => $dado['excluir']),
            array('name' => ':P_IMPRIMIR', 'value' => $dado['imprimir']),
            array('name' => ':P_ESPECIAL1', 'value' => $dado['especial1']),
            array('name' => ':P_ESPECIAL2', 'value' => $dado['especial2']),
            array('name' => ':P_MENU_ITEM', 'value' => '0'),
            
            array('name' => ':P_CURSOR',    'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_PORTAL', 'CDA_GRUPO', $params);
    }

    function programa($dado) {

        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO',    'value' => $dado['operacao']),
            array('name' => ':P_CD_PROGRAMA', 'value' => $dado['codigo']),
            array('name' => ':P_NM_PROGRAMA', 'value' => $dado['nome']),
            array('name' => ':P_SISTEMA',     'value' => $dado['sistema']),
            array('name' => ':P_FORMULARIO',  'value' => $dado['formulario']),
            array('name' => ':P_OBSERVACAO',  'value' => $dado['observacao']),
            array('name' => ':P_CLASSE',      'value' => $dado['classe']),
            array('name' => ':P_CURSOR',      'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        
        return $this->db->procedure('BD_PORTAL', 'CDA_PROGRAMAS', $params);
    }

    function usuario($params) {

        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO',  'value' => $params['operacao']),
            array('name' => ':P_CD_USUARIO','value' => $params['codigo']),
            array('name' => ':P_NM_USUARIO',  'value' => $params['nome']),
            array('name' => ':P_CD_GRUPO',  'value' => $params['grupo']),
            array('name' => ':P_CD_PROGRAMA',  'value' => $params['programa']),
            array('name' => ':P_CURSOR',    'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_PORTAL', 'CDA_USUARIOS',$params);
    }
    
}
