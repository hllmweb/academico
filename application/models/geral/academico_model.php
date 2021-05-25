<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Academico_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    function faltas($dado){
        $periodo = $this->session->userdata('SCL_SSS_USU_PERIODO');
        $cursor = '';
        /*
         * operacao
         * FT = FALTOSOS POR TURMA
         */
        $params = array(
                array('name'=>':P_OPERACAO', 'value'=>$dado['operacao']),
                array('name'=>':P_PERIODO', 'value'=>$dado['periodo']),
                array('name'=>':P_CURSOR', 'value'=>$cursor, 'type'=>OCI_B_CURSOR)
                );
        return $this->db->procedure('BD_PORTAL','AES_DIARIO_FALTAS',$params);		
	
    }

}
