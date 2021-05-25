<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Aes_cl_alu_nota_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        
    }
        
    function adicionar($p) {
        $data = array(
            'CD_ALU_DISC' => $p['aluno'],
            'NUM_NOTA'    => $p['num_nota'],
            'NOTA'        => $p['nota']
        );
        $this->db->insert('BD_SICA.CL_ALU_NOTA', $data);        
       
        /**************** ADICIONAR LOGS *****************/
        $sql = $this->db->last_query();
        $co = new Weblogs_lib();
        $co->sql = $sql;
        $co->url();
        /**************** ADICIONAR LOGS *****************/

    }

    function editar($p) {
        $data = array(
            'NOTA' => $p['nota']
        );
        $this->db->where('CD_ALU_DISC', $p['aluno']);
        $this->db->where('NUM_NOTA', $p['num_nota']);
        $this->db->update('BD_SICA.CL_ALU_NOTA', $data); 
        
        /**************** ADICIONAR LOGS *****************/
        $sql = $this->db->last_query();
        $co = new Weblogs_lib();
        $co->sql = $sql;
        $co->url();
        /**************** ADICIONAR LOGS *****************/
    }

}