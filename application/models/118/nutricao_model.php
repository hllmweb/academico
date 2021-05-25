<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Nutricao_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function almoco($dataInicial, $dataFinal){

        $dataInicial = implode("/",array_reverse(explode("-",$dataInicial)));
        $dataFinal = implode("/",array_reverse(explode("-",$dataFinal)));

        $cursor = '';
        $params = array(
                  array('name'=>':P_OPERACAO', 'value'=>'R'),
                  array('name'=>':P_DT_INICIO', 'value'=>$dataInicial),
                  array('name'=>':P_DT_FIM', 'value'=>$dataFinal),
                  array('name'=>':P_CURSOR', 'value'=>$cursor, 'type'=>OCI_B_CURSOR)
                  );

       return $this->db->procedure('BD_PORTAL','SP_GERENCIA_COLEGIO',$params);
    }

}

