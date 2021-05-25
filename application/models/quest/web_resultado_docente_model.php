<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Web_resultado_docente_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function web_resultado_pergunta($p){
        
        if($p['curso'] != '')
            $this->db->where('CD_CURSO',$p['curso']);
        
        if($p['serie'] != '')
            $this->db->where('CD_SERIE',$p['serie']);
        
        if($p['professor'] != '')
            $this->db->where('CD_PROFESSOR',$p['professor']);
        
        if($p['turma'] != '')
            $this->db->where('CD_TURMA',$p['turma']);
       
        if($p['disciplina'] != '')
            $this->db->where('CD_DISCIPLINA',$p['disciplina']);
        
        $this->db->where_not_in('CD_DISCIPLINA', 12);
        
        
        $query = $this->db->get('BD_QUEST.VW_RESULTADO_PROF_PERGUNTA')->result_array();
        return $query;
    }
    
    function listar_professores(){
        
        $this->db->where('ATIVO_PROF', 1);
        $this->db->where('CD_MANTENEDORA', 18);
        $query = $this->db->get('BD_RH.VW_PROFESSOR')->result_array();
        return $query;
    }
    
    function listar_docente(){
        
        $this->db->where('ATIVO', 1);
        $this->db->where('CD_MANTENEDORA', 18);
        $this->db->where_in('CD_FUNCAO', array(5536, 5770, 5609, 5912, 5534));
        $query = $this->db->get('BD_SICA.VW_FUNCIONARIO')->result_array();
        return $query;
    }
    
    
    
        
    function adicionar($p) {

        $data = array(
                       'PERIODO' => $p['periodo'],
                      'BIMESTRE' => $p['bimestre'],
                      'CD_QUEST' => $p['questionario'],
                'CD_FUNCIONARIO' => $p['funcionario'],
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