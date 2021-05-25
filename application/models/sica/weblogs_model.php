<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Weblogs_model extends CI_Model {
    

// CAMPOS DA TABELA
// -------------------
// ID          | ( PK )
// CD_USUARIO  | 
// PROGRAMA    |
// DATA        |
// IP          |
// DISPOSITIVO |
// DC_SQL      |

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function listar() {
        $query = $this->db->get('BD_SICA.WEBLOGS')->result_array();
        return $query;
    }

    function adicionar($p) {
        $data = array(
            'CD_USUARIO'  => $p['usuario'],
            'PROGRAMA'    => $p['programa'],
            'IP'          => $p['ip'],
            'DISPOSITIVO' => $p['dispositivo'],
            'DC_SQL'      => str_replace("'",'',str_replace('"','',$p['sql']))
       );
       $this->db->insert('BD_SICA.WEBLOGS', $data);
    }

}
