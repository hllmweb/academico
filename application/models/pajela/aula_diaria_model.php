<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Aula_diaria_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function relatorio($p){
        
        // CASO O PARAMETRO CURSO ESTEJA SETADO
        if($p['periodo'] != '')
            $this->db->where('PERIODO',$p['periodo']);

        // CASO O PARAMETRO DISCIPLINA ESTEJA SETADO
        if($p['tipo'] != '')
            $this->db->where('TIPO',$p['tipo']);

        // CASO O PARAMETRO PROFESSOR ESTEJA SETADO
        if($p['professor'] != '')
            $this->db->where('CD_PROFESSOR',$p['professor']);

        // CAMPO PERIODO
        $inicio = date('d-M-y',strtotime(implode("-",array_reverse(explode("/",$p['inicio'])))));
        $fim = date('d-M-y',strtotime(implode("-",array_reverse(explode("/",$p['fim'])))));
        
        // CAMPO PERIODO INCIO
        $this->db->where('TRUNC(DT_AULA) >=', $inicio);
        // CAMPO PERIODO FIM
        $this->db->where('TRUNC(DT_AULA) <=', $fim);
        
        
        $this->db->order_by('DT_AULA, TEMPO_AULA', 'ASC');
        $query = $this->db->get('BD_PAJELA.VW_CL_AULA_DIARIA')->result_array();

        return $query;
    }

}