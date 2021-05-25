<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gabarito_model extends CI_Model {

    function __construct() {
        parent::__construct();
        
        $obj = & get_instance();
        
        $this->load->database();
        $obj->lang->load('dicionario', 'banco');
    }

    function listar() { 
        $r = $this->db->insert('BD_QUEST.WEB_RESULTADO', $data); 
    }
    
    function adicionar($p) { 
        $data = array(
            'CD_PERGUNTA' => $p['pergunta'] ,
            'CD_QUEST'    => $p['questionario'] ,
            'CD_RESPOSTA' => $p['resposta'],
            'CD_ALUNO'    => ''.$p['aluno'].'',
            'PERIODO'     => '2016/1',
            'BIMESTRE'    => $p['bimestre']
        );
        $r = $this->db->insert('BD_QUEST.WEB_RESULTADO', $data); 
    }
}