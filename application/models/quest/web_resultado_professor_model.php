<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Web_resultado_professor_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function web_resultado_pergunta($p){
        
        if($p['quest'] != '')
            $this->db->where('CD_QUEST',$p['quest']);
        
        if($p['curso'] != '')
            $this->db->where('CD_CURSO',$p['curso']);
        
        if($p['serie'] != '')
            $this->db->where('CD_SERIE',$p['serie']);
        
        if($p['professor'] != '')
            $this->db->where('CD_PROFESSOR',$p['professor']);
        
        if($p['periodo'] != '')
            $this->db->where('PERIODO',$p['periodo']);
        
        if($p['turma'] != '')
            $this->db->where('CD_TURMA',$p['turma']);
       
        if($p['disciplina'] != '')
            $this->db->where('CD_DISCIPLINA',$p['disciplina']);
        
        if($p['bimestre'] != '')
            $this->db->where('BIMESTRE',$p['bimestre']);
        
        $this->db->where_not_in('CD_DISCIPLINA', 12);
        
        $this->db->order_by("NM_PROFESSOR, NM_DISCIPLINA, CD_PERGUNTA");
        
        $query = $this->db->get('BD_QUEST.VW_RESULTADO_PROF_PERGUNTA')->result_array();
        
        
        //echo $this->db->last_query();
        
        return $query;
    }
    
    function web_resultado_divisao($p){
        
        if($p['periodo'] != '')
            $this->db->where('PERIODO',$p['periodo']);

        if($p['quest'] != '')
            $this->db->where('CD_QUEST',$p['quest']);

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
        
        if($p['bimestre'] != '')
            $this->db->where('BIMESTRE',$p['bimestre']);

        $this->db->where_not_in('CD_DISCIPLINA', 12);

        $query = $this->db->get('BD_QUEST.VW_RESULTADO_PROF_DIVISAO')->result_array();

        return $query;
    }
    
    function web_resultado_pergunta_auto($p){

        if($p['quest'] != '')
            $this->db->where('CD_QUEST',$p['quest']);

        if($p['periodo'] != '')
            $this->db->where('PERIODO',$p['periodo']);

        if($p['professor'] != '')
            $this->db->where('CD_PROFESSOR',$p['professor']);

        $query = $this->db->get('BD_QUEST.VW_RESULTADO_AUTO_PROF')->result_array();

        return $query;
    }
    
    function web_resultado_divisao_auto($p){
        
        if($p['quest'] != '')
            $this->db->where('CD_QUEST',$p['quest']);
        
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
        
        $query = $this->db->get('BD_QUEST.VW_RESULTADO_PROF_DIVISAO')->result_array();
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
                       'FL_TIPO' => $p['tipo'],
        );
        $this->db->insert('BD_QUEST.WEB_RESULTADO_PROFESSOR', $data);        
        //echo $this->db->last_query();
        /**************** ADICIONAR LOGS *****************/
        //$sql = $this->db->last_query();
        //$co = new Weblogs_lib();
        //$co->sql = $sql;
        //$co->url();
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
        //$sql = $this->db->last_query();
        //$co = new Weblogs_lib();
        //$co->sql = $sql;
        //$co->url();
        /**************** ADICIONAR LOGS *****************/
    }

}