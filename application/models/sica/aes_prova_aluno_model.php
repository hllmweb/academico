<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Aes_prova_aluno_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function listar_provas($p) { 
        $this->db->select('CD_PROVA');
        $this->db->where('CD_PROVA', $p);
        $this->db->or_where('CD_PROVA_PAI', $p);
        $query = $this->db->get('BD_SICA.AVAL_PROVA')->result_array();
        return $query;
    }
    
    
    function resposta($p) {
        $data = array(
            'RESPOSTAS' => $p['gabarito'],
        );
        $this->db->where('CD_PROVA', $p['prova']);
        $this->db->update('BD_SICA.AVAL_PROVA', $data);

        /**************** ADICIONAR LOGS *****************/
        $sql = $this->db->last_query();
        $co = new Weblogs_lib();
        $co->sql = $sql;
        $co->url();
        /**************** ADICIONAR LOGS *****************/
    }
    
}
