<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Aes_prova_inscritos_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function filtro_cartao($p){
        $this->db->select('PI.CD_PROVA,
                           PI.CD_PROVA_VERSAO,
                           PI.FEZ_PROVA,
                           PI.CD_SALA,
                           PI.NR_FILA,
                           PI.NR_POSICAO_FILA,
                           P.RESPOSTAS AS GABARITO,
                           P.QTDE_QUESTOES,
                           CL.RESPOSTAS,
                           CL.DT_LEITUTA,
                           CL.LOGIN_LEITURA');
        $this->db->where('PI.CD_PROVA',$p);
        $this->db->join('BD_SICA.AVAL_CARTOES_LIDOS CL','CL.CD_PROVA = PI.CD_PROVA_VERSAO AND PI.CD_ALUNO = CL.CD_ALUNO');
        $this->db->join('BD_SICA.AVAL_PROVA P','P.CD_PROVA = PI.CD_PROVA_VERSAO');
        $query = $this->db->get('BD_SICA.AVAL_PROVA_INSCRITOS PI')->result_array();
        return $query;
    }
    
    function listar_aluno($p){
        $this->db->select('A.CD_ALUNO, A.NM_ALUNO, P.TITULO, PI.CD_PROVA_VERSAO ');
        $this->db->where('PI.CD_PROVA',$p);
        $this->db->order_by('A.NM_ALUNO','ASC');
        $this->db->join('BD_SICA.ALUNO A','A.CD_ALUNO = PI.CD_ALUNO');
        $this->db->join('BD_SICA.AVAL_PROVA P','P.CD_PROVA= PI.CD_PROVA');
        $query = $this->db->get('BD_SICA.AVAL_PROVA_INSCRITOS PI')->result_array();
   
        return $query;
    }
    
    function listar($p){
        $query = $this->db->get('BD_SICA.AVAL_PROVA_INSCRITOS');
        return $query;
    }
    
    function adicionar($p) {
        $this->db->select('CD_PROVA');
        $this->db->where('NUM_PROVA', $p['prova']);
        $query = $this->db->get('BD_SICA.AVAL_PROVA_INSCRITOS')->row();
        return( $query->CD_PROVA );
        
        $data = array(
            'CD_PROVA' => $p['prova'] ,
            'CD_ALUNO' => $p['aluno'] ,
           'RESPOSTAS' => $p['resposta'],
       'LOGIN_LEITURA' => $p['usuario']
       );
       $r = $this->db->insert('BD_SICA.AVAL_PROVA_INSCRITOS', $data);
       
       /**************** ADICIONAR LOGS *****************/
        $sql = $this->db->last_query();
        $co = new Weblogs_lib();
        $co->sql = $sql;
        $co->url();
        /**************** ADICIONAR LOGS *****************/
    }
    
    function editar($p) { 
        $data = array(
            'RESPOSTAS' => $p['pergunta'] ,
        'LOGIN_LEITURA' => $p['usuario']
        );
        $this->db->where('CD_PROVA', $p['prova']);
        $this->db->where('CD_ALUNO', $p['aluno']);
        $r = $this->db->update('BD_SICA.AVAL_PROVA_INSCRITOS', $data); 
        
        /**************** ADICIONAR LOGS *****************/
        $sql = $this->db->last_query();
        $co = new Weblogs_lib();
        $co->sql = $sql;
        $co->url();
        /**************** ADICIONAR LOGS *****************/
    }
    
    function listar_disciplina_prova($p){

        $this->db->select('PD.CD_PROVA,
                           PD.CD_DISCIPLINA,
                           D.NM_DISCIPLINA,
                           PD.POSICAO_INICIAL,
                           PD.POSICAO_FINAL,
                           PD.PESO,
                           PD.TIPO_QUESTAO,
                           PD.CD_PROFESSOR_CORRECAO,
                           PD.VL_QUESTAO,
                           AD.TOTAL_ACERTOS,
                           AD.NR_ACERTO,
                           AD.PC_ACERTO,
                           AD.NR_ERRO,
                           AD.PC_ERRO,
                           AD.NR_NOTA');        
        $this->db->join('BD_SICA.CL_DISCIPLINA D','PD.CD_DISCIPLINA = D.CD_DISCIPLINA');
        $this->db->join('BD_SICA.AVAL_PROVA_ALUNO_DISC AD', 'PD.CD_PROVA = AD.CD_PROVA AND PD.CD_DISCIPLINA = AD.CD_DISCIPLINA AND AD.CD_ALUNO = '.$p['aluno'].'','left');
        $this->db->where('PD.CD_PROVA',$p['prova']);
        $this->db->order_by('POSICAO_INICIAL','ASC');
        $query = $this->db->get('BD_SICA.AVAL_PROVA_DISC PD')->result_array();
        return $query;
    }
    
    //Aba Ranking da tela de acompanhamento da prova online
    function ranking($p){
        $this->db->where('CD_PROVA',$p['prova']);
        $query = $this->db->get('BD_SICA.VW_AVAL_PROVA_ALUNO_RESULTADO')->result_array();
        //echo $this->db->last_query($query);
        return $query;
    }
    
    //Aba Acompanhamento da tela de acompanhamento da prova online By: Mônica
    function acompanhamento($p){
        $this->db->where('CD_PROVA',$p['prova']);
        $this->db->where('CD_ALUNO',$p['aluno']);
        $this->db->where('CD_DISCIPLINA',$p['disciplina']);
        $query = $this->db->get('BD_SICA.VW_AVAL_PROVA_ALUNO_RESULTADO')->result_array();
        //echo $this->db->last_query($query);
        return $query;
    }
    
    //Aba Tempo por Questao da tela de acompanhamento da prova online By: Mônica
    function listar_questoesRespondidasPorTempo($p){

        $this->db->select('PAQ.CD_ALUNO,
                            A.NM_ALUNO,
                            PAQ.CD_PROVA,
                            PAQ.CD_QUESTAO,
                            AQ.CD_DISCIPLINA,
                            AQ.DC_QUESTAO AS QUESTAO,
                            POSICAO, 
                            NR_TEMPO_RESPOSTA');       
        $this->db->join('BD_SICA.ALUNO A','PAQ.CD_ALUNO = A.CD_ALUNO');
        $this->db->join('BD_ACADEMICO.AVAL_QUESTAO AQ','PAQ.CD_QUESTAO = AQ.CD_QUESTAO');
        $this->db->where('(SELECT DISTINCT API.CD_PROVA FROM BD_SICA.AVAL_PROVA_INSCRITOS API WHERE API.CD_PROVA_VERSAO = PAQ.CD_PROVA)='.$p['prova']);
        $this->db->where('AQ.CD_DISCIPLINA',$p['disciplina']);
        $this->db->order_by('NR_TEMPO_RESPOSTA','DESC');
        $query = $this->db->get('BD_SICA.AVAL_PROVA_ALUNO_QUESTAO PAQ')->result_array();

        return $query;  
    }      
    
    //Verifica quantas avaliações já foram finalizadas, utilizada para atualizar a tela de acompanhamento By: Mônica
    function verificarRespondidas($p) {

        $this->db->select("COUNT (PAQ.CD_PROVA) AS QUANTIDADE");
        $this->db->join('BD_SICA.AVAL_PROVA_INSCRITOS API', 'API.CD_PROVA_VERSAO = PAQ.CD_PROVA');
        $this->db->where('API.CD_PROVA', $p);
        $query = $this->db->get('BD_SICA.AVAL_PROVA_ALUNO_QUESTAO PAQ')->result_array();
        //echo $this->db->last_query($query);

        return $query;
    }

    //Lista as disciplinas da prova, utilizada nas abas de acompanhamento da prova online By: Mônica
    function disciplinasPorProva($p){

        $this->db->select('PD.CD_PROVA,
                           PD.CD_DISCIPLINA,
                           D.NM_DISCIPLINA,
                           VL_QUESTAO,
                           POSICAO_INICIAL,
                           POSICAO_FINAL');        
        $this->db->join('BD_SICA.CL_DISCIPLINA D','PD.CD_DISCIPLINA = D.CD_DISCIPLINA');
        $this->db->where('PD.CD_PROVA',$p);
        $this->db->order_by('POSICAO_INICIAL','ASC');
        $query = $this->db->get('BD_SICA.AVAL_PROVA_DISC PD')->result_array();
        return $query;
    }
    
    /*function listar_questoesRespondidas($p){

        $this->db->select('PAQ.CD_ALUNO,
                           PAQ.CD_PROVA,
                           PAQ.CD_QUESTAO,
                           PAQ.RESPOSTA,
                           PAQ.CORRETA,
                           AQ.CD_DISCIPLINA,
                           POSICAO');       
        $this->db->join('BD_ACADEMICO.AVAL_QUESTAO AQ','PAQ.CD_QUESTAO = AQ.CD_QUESTAO');
        $this->db->where('PAQ.CD_PROVA',$p['prova']);
        $this->db->where('PAQ.CD_ALUNO',$p['aluno']);
        $this->db->where('AQ.CD_DISCIPLINA',$p['disciplina']);
        $this->db->order_by('POSICAO','ASC');
        $query = $this->db->get('BD_SICA.AVAL_PROVA_ALUNO_QUESTAO PAQ')->result_array();
        
        //echo $this->db->last_query($query);
        return $query;
    }    */
    
}
