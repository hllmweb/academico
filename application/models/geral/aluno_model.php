<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Aluno_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    function aluno($dado){
        $cursor = '';

        $params = array(
                array('name'=>':P_OPERACAO', 'value'=>$dado['operacao']),
                array('name'=>':P_CD_ALUNO', 'value'=>$dado['codigo']),
                array('name'=>':P_NM_ALUNO', 'value'=>$dado['nome']),
                array('name'=>':P_CURSOR', 'value'=>$cursor, 'type'=>OCI_B_CURSOR)
                );
        return $this->db->procedure('BD_PORTAL','AES_ALUNO',$params);		
	
    }
    

}