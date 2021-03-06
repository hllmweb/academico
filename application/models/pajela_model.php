<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pajela_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function cl_gera_diario_classe($p) {

        $cursor = '';
        $params = array(
            array('name' => ':p_PERIODO', 'value' => $p['periodo']),
            array('name' => ':p_CD_CURSO', 'value' => $p['curso']),
            array('name' => ':p_ORDEM_SERIE', 'value' => $p['serie']),
            array('name' => ':p_CD_TURMA', 'value' => $p['turma']),
            array('name' => ':p_SUBTURMA', 'value' => $p['subturma']),
            array('name' => ':p_CD_DISCIPLINA', 'value' => $p['disciplina']),
            array('name' => ':p_CD_PROFESSOR', 'value' => $p['professor']),
            array('name' => ':RC1', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_PAJELA', 'CL_GERA_DIARIO_CLASSE', $params);
    }

    function aes_diario_online($p) {

        $cursor = '';
        $params = array(
            array('name' => ':OPERACAO', 'value' => $p['operacao']),
            array('name' => ':PERIODO', 'value' => $p['periodo']),
            array('name' => ':CD_PROFESSOR', 'value' => $p['professor']),
            array('name' => ':DIA', 'value' => $p['dia']),
            array('name' => ':CD_CL_AULA', 'value' => $p['aula']),
            array('name' => ':CD_DISCIPLINA', 'value' => $p['disciplina']),
            array('name' => ':CD_CURSO', 'value' => $p['curso']),
            array('name' => ':CD_TURMA', 'value' => $p['turma']),
            array('name' => ':SUBTURMA', 'value' => $p['subturma']),
            array('name' => ':CD_ALUNO', 'value' => $p['aluno']),
            array('name' => ':PRESENCA', 'value' => $p['frequencia']),
            array('name' => ':CD_PLANO', 'value' => $p['cd_plano']),
            array('name' => ':CONTEUDO', 'value' => $p['conteudo']),
            array('name' => ':TAREFA', 'value' => $p['tarefa']),
            array('name' => ':DATA', 'value' => $p['data']),
            array('name' => ':RC1', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_PORTAL', 'AES_DIARIO_ONLINE', $params);
    }
    
    function aes_diario_notas($p) {

        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO',       'value' => $p['operacao']),
            array('name' => ':P_CD_DISCIPLINA',  'value' => $p['disciplina']),
            array('name' => ':P_PERIODO',        'value' => $p['periodo']),
            array('name' => ':P_CD_PROFESSOR',   'value' => $p['professor']),
            array('name' => ':P_CD_TURMA',       'value' => $p['turma']),
            array('name' => ':P_CD_CURSO',       'value' => $p['curso']),
            array('name' => ':P_NUM_NOTA',       'value' => $p['num_nota']),
            array('name' => ':P_CD_ESTRUTURA',   'value' => $p['estrutura']),
            array('name' => ':P_BIMESTRE',       'value' => $p['bimestre']),
            array('name' => ':P_CURSOR',         'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_PORTAL', 'AES_DIARIO_NOTAS', $params);
    }
    
    
    function aval_professor_provas($p) {

        $cursor = '';
        $params = array(
            array('name' => ':P_CD_PROFESSOR', 'value' => $p['professor']),
            array('name' => ':P_CD_TURMA',     'value' => $p['turma']),
            array('name' => ':P_CURSOR',       'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_ACADEMICO','AVAL_PROFESSOR_PROVAS', $params);
    }
    
    function aval_prova_aluno_nota($p) {

        $cursor = '';
        $params = array(
            array('name' => ':P_CD_ALUNO', 'value' => $p['aluno']),
            array('name' => ':P_NOTA',     'value' => $p['nota']),
            array('name' => ':P_CD_PROVA', 'value' => $p['prova']),
            array('name' => ':v_RETORNO', 'value' => '', 'type' => OCI_B_ROWID),
            array('name' => ':P_CURSOR',   'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_ACADEMICO','AVAL_PROVA_ALUNO_NOTA', $params);
    }
    
    function aval_processa_nota($p) {

        $cursor = '';
        $params = array(
            array('name' => ':P_CD_PROVA',        'value' => $p['prova']),
            array('name' => ':P_CD_DISCIPLINA',   'value' => $p['disciplina']),
            array('name' => ':v_RETORNO',         'value' => '', 'type' => OCI_B_ROWID),
            array('name' => ':P_CURSOR',          'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_ACADEMICO','AVAL_PROCESSA_NOTAS', $params);
    }
    
    function aes_diario_lancar_nota($p) {

        $cursor = '';
        $params = array(
            array('name' => ':P_CD_ALU_DISC',     'value' => $p['aluno']),
            array('name' => ':P_NUM_NOTA',        'value' => $p['numNota']),
            array('name' => ':P_NOTA',            'value' => $p['nota']),
            array('name' => ':v_RETORNO',         'value' => '', 'type' => OCI_B_ROWID),
            array('name' => ':P_CURSOR',          'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_PORTAL','AES_DIARIO_LANCAR_NOTA', $params);
    }
    
    function aes_questionario_infantil($parametro) {
        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO', 'value' => $parametro['operacao']),
            array('name' => ':P_CD_ALUNO', 'value' => $parametro['aluno']),
            array('name' => ':P_CD_PERGUNTA', 'value' => $parametro['pergunta']),
            array('name' => ':P_CD_QUEST', 'value' => $parametro['questionario']),
            array('name' => ':P_CD_RESPOSTA', 'value' => $parametro['resposta']),
            array('name' => ':P_PERIODO', 'value' => $parametro['periodo']),
            array('name' => ':P_BIMESTRE', 'value' => 1),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_PORTAL', 'AES_QUESTIONARIO_INFANTIL', $params);
    }
    
    function aes_diario_infantil($p) { 
        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO',     'value' => $p['operacao']),
            array('name' => ':P_CD_PROFESSOR', 'value' => $p['cd_professor']),
            array('name' => ':P_PERIODO',      'value' => $p['periodo']),
            array('name' => ':P_CD_TURMA',     'value' => $p['cd_turma']),
            array('name' => ':P_CD_ALUNO',     'value' => $p['cd_aluno']),
            array('name' => ':P_DATA',         'value' => $p['dia']),
            array('name' => ':P_CURSOR',       'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        
        return $this->db->procedure('BD_PORTAL', 'AES_DIARIO_INFANTIL', $params);
    }
    
    function questionario_resultado($p) { 
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
