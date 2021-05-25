<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Prova_questoes extends CI_Controller {

     function __construct() {
        parent::__construct();

        $this->load->model('prova_model', 'banco', TRUE);
        $this->load->model('cadastro_model', 'cadastro', TRUE);
        $this->load->model('geral/secretaria_model', 'secretaria', TRUE);
        $this->load->model('geral/colegio_model', 'colegio', TRUE);

        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'session', 'prova_lib'));

    }

      function mdlTemaQuestoes() {

        // MONTA O MODAL DE QUESTÕES
        $params = array('operacao' => 'FQPT',
                           'curso' => $this->input->get('curso'),
                           'serie' => $this->input->get('serie'),
                      'disciplina' => $this->input->get('disciplina'),
                            'tema' => $this->input->get('tema'),
                            'prova' => $this->input->get('prova'),
                       );

        $questoes = $this->cadastro->questao($params);

        $lista = array();
        foreach($questoes as $q){
            $lista[] = array(
                 'codigo' => $q['CD_QUESTAO'],
                'questao' => $q['DC_QUESTAO'],
               'detalhes' => $q,
                   'tipo' => $q['FLG_TIPO'],
                  'usada' => $q['QTD_X_USADAS'],
                  'nivel' => $q['DIFICULDADE'],
                'usuario' => $q['CADASTROU'],
                    'dia' => $q['CADASTROU_EM'],
                  'prova' => $this->input->get('prova'),
                  'opcao' => $this->cadastro->questao_resposta(array('operacao' => 'FK', 'questao' => $q['CD_QUESTAO'])),
               'conteudo' => $this->cadastro->questao_conteudo(array('operacao' => 'FK', 'questao' => $q['CD_QUESTAO'])),
            );
        }
        $data = array(
              'listar' => $lista,
            'conteudo' => $this->cadastro->conteudo(array('operacao' => 'F', 'tema' => $this->input->get('tema'))),
        );
        $this->load->view('108/provas/mdlTemaQuestoes', $data);
    }

    function frmManterProvaQuestao() {
        // RECEBE OS DADOS DO FORMULARIO
        $params = array(
                    'operacao' => $this->input->post('operacao'),
                       'prova' => $this->input->post('avalProva'),
                     'questao' => $this->input->post('avalQuestao'),
                     'posicao' => $this->input->post('avalPosicao'),
                       'valor' => $this->input->post('avalValor'),
                     'anulada' => $this->input->post('avalAnulada'),
                 );
        //print_r($params);;
        $l = $this->banco->prova_questao($params);
        echo '<label class="label label-success">Dados Registrados</label>';
      }


      function frmManterProvaQuestao_new() {
        // RECEBE OS DADOS DO FORMULARIO
        $params = array(
                    'operacao' => $this->input->post('operacao'),
                       'prova' => $this->input->post('avalProva'),
                     'questao' => $this->input->post('avalQuestao'),
                     'posicao' => $this->input->post('avalPosicao'),
                       'valor' => $this->input->post('avalValor'),
                     'anulada' => $this->input->post('avalAnulada'),
                 );
        //print_r($params);;
        $l = $this->banco->prova_questao($params);
        echo '<label class="label label-success">Dados Registrados</label>';
        
      }

      function upNotaDiscursiva(){
        $nota_discursiva =  $this->input->post("nota_discursiva");
        $cd_aluno        =  $this->input->post("cd_aluno");
        $cd_prova_versao =  $this->input->post("cd_prova_versao");
        $cd_disciplina   =  $this->input->post("cd_disciplina");


        $query = $this->db->query("UPDATE BD_SICA.AVAL_PROVA_ALUNO_DISC set nr_nota_discursiva = $nota_discursiva WHERE CD_ALUNO = $cd_aluno and cd_prova = $cd_prova_versao and cd_disciplina = $cd_disciplina");

        if($query){
          echo "ok";
        }

      }


      function refreshNotaDiscursiva(){
         $cd_aluno        =  $this->input->post("cd_aluno");
         $cd_prova_versao =  $this->input->post("cd_prova_versao");
         $cd_disciplina   =  $this->input->post("cd_disciplina");


         $query = $this->db->query("SELECT * FROM BD_SICA.AVAL_PROVA_ALUNO_DISC WHERE cd_aluno = $cd_aluno and cd_prova = $cd_prova_versao and cd_disciplina = $cd_disciplina");
         //return $query->result();
         /*if($query){
            echo "ok";
         }*/

         $result = $query->result_array();
         echo str_replace(",",".",$result[0]['NR_NOTA_DISCURSIVA']);
          //echo $query;
      }



      function detalheProva($idProva = null,$disciplina = null){

        $this->session->set_userdata('SGP_PROVA_ATUAL', $idProva);
        $this->session->set_userdata('SGP_DISCIPLINA_ATUAL', $disciplina);

        $prova = $this->banco->banco_prova(array('operacao' => 'VFC', 'prova' => $idProva));
        
        $questoes = $this->banco->prova_questao(array('operacao' => 'FD', 'prova' => $prova[0]['CD_PROVA'], 'disciplina' => $this->session->userdata('SGP_DISCIPLINA_ATUAL')));

        $lista = array();
        foreach ($questoes as $q) {
            $lista[] = array(
                'codigo' => $q['CD_QUESTAO'],
                'questao' => $q['DC_QUESTAO'],
                'tipo' => $q['FLG_TIPO'],
                'disciplina' => $this->session->userdata('SGP_DISCIPLINA_ATUAL'),
                'posicao' => $q['POSICAO'],
                'nivel' => $q['DIFICULDADE'],
                'usuario' => $q['CADASTROU'],
                'dia' => $q['CADASTROU_EM'],
                'prova' => $prova[0]['CD_PROVA'],
                'opcao' => $this->cadastro->questao_resposta(array('operacao' => 'FK', 'questao' => $q['CD_QUESTAO'])),
                'conteudo' => $this->cadastro->questao_conteudo(array('operacao' => 'FK', 'questao' => $q['CD_QUESTAO'])),
                'nomeDisciplina' => $q['NM_DISCIPLINA']
            );
        }

        $data = array(
            'prova' => $prova,
            'titulo' => 'CONFIGURAÇÃO DE PROVA :: QUESTÕES DA PROVA <strong style="font-size:16px">Nº ' . $this->session->userdata('SGP_PROVA_ATUAL') . '</strong>',
            'tema' => $this->cadastro->tema(array('operacao' => 'FN', 'curso' => $prova[0]['CD_CURSO'], 'serie' => $prova[0]['ORDEM_SERIE'], 'disciplina' => $this->session->userdata('SGP_DISCIPLINA_ATUAL'))),
            'listar' => $lista,
            'disciplina' => $this->session->userdata('SGP_DISCIPLINA_ATUAL'),
        );



       $this->load->view('108/provas/mdlDetalhesProva',$data);
    }

}
