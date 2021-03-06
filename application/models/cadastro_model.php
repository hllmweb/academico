<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cadastro_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function tema($p) {

        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO',        'value' => $p['operacao']),
            array('name' => ':P_CD_TEMA',         'value' => $p['codigo']),
            array('name' => ':P_CD_CURSO',        'value' => $p['curso']),
            array('name' => ':P_ORDEM_SERIE',     'value' => $p['serie']),
            array('name' => ':P_CD_DISCIPLINA',   'value' => $p['disciplina']),
            array('name' => ':P_DC_TEMA',         'value' => $p['descricao']),
            array('name' => ':P_FLG_ATIVO',       'value' => $p['ativo']),
            array('name' => ':P_CD_USU_CADASTRO', 'value' => $this->session->userdata('CES_CODIGO') ),
            array('name' => ':P_CURSOR',          'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_ACADEMICO','AVAL_MANTER_TEMA', $params);
        
    }
    
    function conteudo($p) {

        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO', 'value' => $p['operacao']),
            array('name' => ':P_CD_TEMA', 'value' => $p['tema']),
            array('name' => ':P_CD_CONTEUDO', 'value' => $p['codigo']),
            array('name' => ':P_DC_CONTEUDO', 'value' => $p['descricao']),
            array('name' => ':P_CD_USUARIO', 'value' => $this->session->userdata('CES_CODIGO')),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_ACADEMICO','AVAL_MANTER_CONTEUDO',$params);        
    }
    
    function questao($p) {

        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO',          'value' => $p['operacao']),
            array('name' => ':P_CD_QUESTAO',        'value' => $p['codigo']),
            array('name' => ':P_CD_CURSO',          'value' => $p['curso']),
            array('name' => ':P_ORDEM_SERIE',       'value' => $p['serie']),
            array('name' => ':P_FLG_TIPO',          'value' => $p['tipo']),
            array('name' => ':P_DC_QUESTAO',        'value' => $p['descricao']),
            array('name' => ':P_DC_QUESTAO_RODAPE', 'value' => $p['rodape']),            
            array('name' => ':P_CD_DISCIPLINA',     'value' => $p['disciplina']),
            array('name' => ':P_CD_PROFESSOR',      'value' => $p['professor']),
            array('name' => ':P_CD_USUARIO',        'value' => $p['usuario']),
            array('name' => ':P_NR_DIFICULDADE',    'value' => $p['dificuldade']),
            array('name' => ':P_CD_TEMA',           'value' => $p['tema']),
            array('name' => ':v_RETORNO',           'value' => 0,               'type' => OCI_B_ROWID),
            array('name' => ':P_CURSOR',            'value' => $cursor,         'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_ACADEMICO','AVAL_MANTER_QUESTAO', $params);
    }
    
    function questao_resposta($p) {

        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO',          'value' => $p['operacao']),
            array('name' => ':P_CD_QUESTAO',        'value' => $p['questao']),
            array('name' => ':P_CD_PROVA',          'value' => $p['prova']),
            array('name' => ':P_CD_OPCAO',          'value' => $p['opcao']),
            array('name' => ':P_DC_OPCAO',          'value' => $p['descricao']),
            array('name' => ':P_CD_USU_CADASTRO',   'value' => $p['usuario']),
            array('name' => ':P_CURSOR',            'value' => $cursor,         'type' => OCI_B_CURSOR)
        );
        
        return $this->db->procedure('BD_ACADEMICO','AVAL_MANTER_QUESTAO_OPCAO', $params);
    }
    
    function questao_conteudo($p) {

        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO',          'value' => $p['operacao']),
            array('name' => ':P_CD_QUESTAO',        'value' => $p['questao']),
            array('name' => ':P_CD_CONTEUDO',       'value' => $p['conteudo']),
            array('name' => ':P_CURSOR',            'value' => $cursor,         'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_ACADEMICO','AVAL_MANTER_QUESTAO_CONTEUDO', $params);
    }
    
    
    function relatorio($p) {

        $cursor = '';
        $params = array(
            array('name' => ':P_CD_TURMA',          'value' => $p['turma']),
            array('name' => ':P_CURSOR',            'value' => $cursor,         'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_ACADEMICO','AVAL_RELATORIO', $params);
    }
    
    function relMediaFinal($p) {

        $cursor = '';
        $params = array(
            array('name' => ':P_CD_TURMA',          'value' => $p['turma']),
            array('name' => ':P_CURSOR',            'value' => $cursor,         'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_ACADEMICO','AVAL_RELATORIO_MEDIA_FINAL', $params);
    }

    function prova_questoes_us($cd_questao){

                $this->db->where('CD_QUESTAO',$cd_questao);
                $this->db->select('CD_PROVA');
        return $this->db->get('BD_SICA.AVAL_PROVA_QUESTOES')->result();
    }

    function prova_questoes_detalhe($cd_prova){

      
               $this->db->where('CD_PROVA',$cd_prova);
               $this->db->select('TITULO,NUM_PROVA');
        return $this->db->get('BD_SICA.AVAL_PROVA')->result();
    }

}



