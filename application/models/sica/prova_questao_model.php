<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Prova_questao_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function listar($p) { 
        //$this->db->select('COLUNA');
        $query = $this->db->get('BD_SICA.AVAL_PROVA_QUESTOES');
        return $query;
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
        $r = $this->db->insert('BD_SICA.AVAL_PROVA_QUESTOES', $data);
    }
    
    function editar($p) { 
        $data = array(
            'CD_PERGUNTA' => $p['pergunta'] ,
            'CD_QUEST'    => $p['questionario'] ,
            'CD_RESPOSTA' => $p['resposta'],
            'CD_ALUNO'    => ''.$p['aluno'].'',
            'PERIODO'     => '2016/1',
            'BIMESTRE'    => $p['bimestre']
        );
        $this->db->where('CD_QUESTAO', $p['questao']);
        $this->db->where('CD_OPCAO', $p['opcao']);
        $r = $this->db->update('BD_SICA.AVAL_PROVA_QUESTOES', $data); 
    }
    
    
    
    function deletar($p) {
        
        // QUANDO A OS REGISTROS POSSUEM DEPENDENCIA
        // DEVE-SE INFORMA NO ARRAY DE TABELAS
        // PARA QUE SEJAM APAGADAS DO BANCO EM TODAS AS TABELAS        
        $tabela = array('BD_SICA.AVAL_PROVA_QUESTOES');
        // PASSA O CODIGO DO REGISTRO QUE SERÁ APAGADO
        $this->db->where('CD_QUESTAO', $p['questao']);
        $this->db->where('CD_OPCAO', $p['opcao']);
        $this->db->delete($tabela);
    }
    
    function limpa_flags($p) {
        
        $data = array(
            'FLG_ANULADA' => 'N',
          'FLG_CANCELADA' => 'N',
        );
        $this->db->where('CD_QUESTAO', $p['questao']);
        $this->db->where('CD_PROVA', $p['prova']);
        $this->db->update('BD_SICA.AVAL_PROVA_QUESTOES', $data);
    }
    
    function cancelar($p) {
        
        $data = array(
            'FLG_CANCELADA' => 'S',
        );
        $this->db->where('CD_QUESTAO', $p['questao']);
        $this->db->where('CD_PROVA', $p['prova']);
        $this->db->update('BD_SICA.AVAL_PROVA_QUESTOES', $data);
    }
    
    function anular($p) {
        $data = array(
            'FLG_ANULADA' => 'S',
        );
        $this->db->where('CD_PROVA', $p['prova']);
        $this->db->where('CD_QUESTAO', $p['questao']);
        $this->db->update('BD_SICA.AVAL_PROVA_QUESTOES', $data);
    }

}
