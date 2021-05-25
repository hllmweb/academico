<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Web_questionario_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function listar(){
        
        $query = $this->db->get('BD_QUEST.WEB_QUESTIONARIO')->result_array();
        return $query;
    }
    
        
    function adicionar($p) {

        $data = array(
                       'PERIODO' => $p['periodo'],
                      'BIMESTRE' => $p['bimestre'],
                      'CD_QUEST' => $p['questionario'],
                      'CD_ALUNO' => $p['aluno'],
                  'CD_PROFESSOR' => $p['professor'],
                 'CD_DISCIPLINA' => $p['disciplina'],
                   'CD_PERGUNTA' => $p['pergunta'],
            'CD_RESPOSTA_PADRAO' => $p['resposta'],
           'CD_USUARIO_REGISTRO' => $p['usuario'],
        );
        //print_r($data);
        $this->db->insert('BD_QUEST.WEB_RESULTADO_PROFESSOR', $data);        
       
        /**************** ADICIONAR LOGS *****************/
        $sql = $this->db->last_query();
        $co = new Weblogs_lib();
        $co->sql = $sql;
        $co->url();
        /**************** ADICIONAR LOGS *****************/

    }

    function editar($p) {
        $data = array(
            'CD_RESPOSTA_PADRAO' => $p['resposta'],
        );
        $this->db->where('PERIODO', $p['periodo']);
        $this->db->where('BIMESTRE', $p['bimestre']);
        $this->db->where('CD_QUEST', $p['questionario']);
        $this->db->where('CD_ALUNO', $p['aluno']);
        $this->db->where('CD_PROFESSOR', $p['aluno']);
        $this->db->where('CD_DISCIPLINA', $p['aluno']);
        $this->db->where('CD_PERGUNTA', $p['aluno']);

        $this->db->update('BD_QUEST.WEB_RESULTADO_PROFESSOR', $data); 
        
        /**************** ADICIONAR LOGS *****************/
        $sql = $this->db->last_query();
        $co = new Weblogs_lib();
        $co->sql = $sql;
        $co->url();
        /**************** ADICIONAR LOGS *****************/
    }

}