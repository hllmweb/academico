<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Comunicado_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function comunicado($parametro) {
        $cursor = '';
        $return = 0;
        $params = array(
            array('name' => ':P_OPERACAO', 'value' => $parametro['operacao']),
            array('name' => ':P_ID_COMUNICADO', 'value' => $parametro['codigo']),
            array('name' => ':P_CD_ALUNO', 'value' => $parametro['aluno']),
            array('name' => ':P_FL_ASS_RESPONSAVEL', 'value' => $parametro['aResp']),
            array('name' => ':P_FL_ASS_COORDENADOR', 'value' => $parametro['aCoor']),
            array('name' => ':P_FL_ASS_ALUNO', 'value' => $parametro['aAlun']),
            array('name' => ':P_CD_DISCIPLINA', 'value' => $parametro['disciplina']),
            array('name' => ':P_CD_PROFESSOR', 'value' => $parametro['professor']),
            
            array('name' => ':P_ID_RESPONSAVEL', 'value' => $parametro['responsavel']),
            array('name' => ':P_TEL_RESPONSAVEL', 'value' => $parametro['celular']),
            array('name' => ':P_DS_SMS', 'value' => $parametro['textosms']),
            
            array('name' => ':P_ID', 'value' => $parametro['id']),
            array('name' => ':P_CD_ITEM', 'value' => $parametro['item']),
            array('name' => ':P_DS_ITEM', 'value' => $parametro['descricao']),
            
            array('name' => ':P_NM_NOME', 'value' => $parametro['nome']),
            array('name' => ':v_RETORNO', 'value' => $return, 'type' => RTN),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
       //print_r($params);
        return $this->db->procedure('BD_PORTAL','AES_COMUNICACAO', $params);
        /*
         * Array ( 
         *   [0] => Array ( [name] => :P_OPERACAO [value] => ADD_COMUNICADO ) 
         *   [1] => Array ( [name] => :P_ID_COMUNICADO [value] => 0 ) 
         *   [2] => Array ( [name] => :P_CD_ALUNO [value] => 14004160 ) 
         *   [3] => Array ( [name] => :P_FL_ASS_RESPONSAVEL [value] => 1 ) 
         *   [4] => Array ( [name] => :P_FL_ASS_COORDENADOR [value] => 5274 ) 
         *   [5] => Array ( [name] => :P_FL_ASS_ALUNO [value] => 1 ) 
         *   [6] => Array ( [name] => :P_CD_DISCIPLINA [value] => ) 
         *   [7] => Array ( [name] => :P_CD_PROFESSOR [value] => ) 
         *   [8] => Array ( [name] => :P_ID_RESPONSAVEL [value] => 2223 ) 
         *   [9] => Array ( [name] => :P_TEL_RESPONSAVEL [value] => 92981669031 ) 
         *   [10] => Array ( [name] => :P_DS_SMS [value] => ertyreyert ) 
         *   [11] => Array ( [name] => :P_ID [value] => ) 
         *   [12] => Array ( [name] => :P_CD_ITEM [value] => ) 
         *   [13] => Array ( [name] => :P_DS_ITEM [value] => ) 
         *   [14] => Array ( [name] => :P_NM_NOME [value] => ) 
         *   [15] => Array ( [name] => :v_RETORNO [value] => 0 [type] => RTN ) 
         *   [16] => Array ( [name] => :P_CURSOR [value] => [type] => 116 ) ) 
         */
    }
    function listar() {

        $query = $this->db->query("SELECT * FROM BD_SICA.COMUNICADO");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function item($tipo) {

        $query = $this->db->query("SELECT * FROM BD_SICA.COMUNICADO_ITEM WHERE ID_COMUNICADO = ".$tipo."");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

}
/*
  Array ( 
 
    [operacao] => ADD_COMUNICADO 
    [codigo] => 2 
    [aluno] => 14003236 
    [aResp] => 1 
    [aCoor] => 5274 
    [aAlun] => 1 
    [disciplina] => 88 
    [professor] => 555406 
    [responsavel] => 
    [celular] => 
    [textosms] => 
    ) 

CÓDIGO: 6502
ORACLE: ORA-06502: PL/SQL: numeric or value error: character string buffer too small ORA-06512: at line 1
OFFSET: 0
SQL: begin BD_PORTAL.AES_COMUNICACAO(:P_OPERACAO,:P_ID_COMUNICADO,:P_CD_ALUNO,:P_FL_ASS_RESPONSAVEL,:P_FL_ASS_COORDENADOR,:P_FL_ASS_ALUNO,:P_CD_DISCIPLINA,:P_CD_PROFESSOR,:P_ID_RESPONSAVEL,:P_TEL_RESPONSAVEL,:P_DS_SMS,:P_ID,:P_CD_ITEM,:P_DS_ITEM,:P_NM_NOME,:v_RETORNO,:P_CURSOR); end;

Não foi possivel criar o Comunicado'