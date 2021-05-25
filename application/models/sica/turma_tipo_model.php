<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class turma_tipo_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function listar($p) {
        $this->db->order_by('DC_TIPO', 'ASC');
        $query = $this->db->get('BD_SICA.TURMA_TIPO')->result_array();
        
        return $query;
    }

}
