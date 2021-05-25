<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Aes_tipo_registro_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function listar() {
        $this->db->order_by('CD_TIPO_REGISTRO', 'ASC');
        $query = $this->db->get('BD_ACADEMICO.AES_REGISTRO_TIPO')->result_array();
        return $query;
    }
    

}
