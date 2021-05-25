<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Prova_Espaco_Posicao extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('prova_model', 'banco', TRUE);
        $this->load->model('sica/aval_prova_questoes_model', "provaQuestao", true);
    }

    /**
     * Exibe modal para selecionar versão da prova que irá alterar a posição
     * das questões.
     * 
     * @param string $prova
     */
    public function modalProva($prova) {
        //obter versões e original
        $versoes = $this->banco->banco_prova(array(
            'operacao' => 'FPV',
            'prova' => $prova,
        ));

        $data = array(
            'versoes' => $versoes,
        );

        $this->load->view($this->session->userdata('SGP_SISTEMA') . '/provas/espaco_posicao/modalProva', $data);
    }

    /**
     * Método que irá salvar as novas posições das questões.
     * 
     * @param string $prova
     * @param string $posicaoAntiga
     * @param string $posicaoNova
     * @return json
     */
    public function formManter() {
        //obter dados do formulário
        $prova = $this->input->post("prova");
        $aux1 = $this->input->post("posicaoAntiga");
        $aux2 = $this->input->post("posicaoNova");
        $questaoEspaco = $this->input->post("questao");
        $espacoQtde = $this->input->post("espaco");
        $tipo_prova = $this->input->post("tipo_prova");
        $prova_versao = $this->input->post("prova_versao");


        //iniciar vetores
        $questaoA = array();
        $questaoB = array();
        $espaco = array();

        //preparar valores das questões que vão trocar de posição
        if (!empty($aux1) && !empty($aux2)) {
            $aux1 = explode("-", $this->input->post("posicaoAntiga"));
            $aux2 = explode("-", $this->input->post("posicaoNova"));

            $questaoA = array(
                "CD_QUESTAO" => $aux1[0],
                "POSICAO" => $aux1[1]
            );

            $questaoB = array(
                "CD_QUESTAO" => $aux2[0],
                "POSICAO" => $aux2[1]
            );
        }

        //preparar valores da questão que vai adicionar espaço
        if (!empty($questaoEspaco) && $espacoQtde !== "") {
            $aux = explode("-", $questaoEspaco);
            $espaco = array(
                'CD_QUESTAO' => $aux[0],
                'QTD_ESPACO' => $espacoQtde
            );
        }


        if($tipo_prova == "D"){
            $separa_prova = explode(",",$prova);

        // echo json_encode(count($separa_prova));
        // exit;
            for($i=0; $i<=count($separa_prova)-1; $i++){
                $params[$i] = array(
                    'CD_PROVA' => $separa_prova[$i],
                    'QUESTAOA' => $questaoA,
                    'QUESTAOB' => $questaoB,
                    'ESPACO' => $espaco
                );
                
                $salvar_prova = $this->provaQuestao->salvar($params[$i]);
            }
        }elseif($tipo_prova == "O"){
            $params = array(
                'CD_PROVA' => $prova_versao,
                'QUESTAOA' => $questaoA,
                'QUESTAOB' => $questaoB,
                'ESPACO'   => $espaco
            );

            $salvar_prova = $this->provaQuestao->salvar($params);
        }


        $result = array(
            "success" => false,
            "mensagem" => '<label class="label label-danger">Ocorreu um erro.</label>',
            "questaoEspaco" => $questaoEspaco,
            "qtdEspaco" => $espacoQtde,
            "posicaoAntiga" => $this->input->post("posicaoAntiga"),
            "posicaoNova" => $this->input->post("posicaoNova"),
            "tipo_prova" => $this->input->post("tipo_prova")
        );



        if ($salvar_prova) {
            $result['success'] = true;
            $result['mensagem'] = '<label class="label label-success">Dados Registrados</label>';
        }

        echo json_encode($result);
    }

    /**
     * Obtem todas as questões e suas respectivas posições na prova informada.
     * 
     * @param string $prova
     * @return string
     */
    public function questoes() {
        $prova = $this->input->post('prova');

        //obter questões e posicao da prova caso não seja vazia
        $questoes = array();
        if (!empty($prova)) {
            $questoes = $this->provaQuestao->filtrar(array(
                array('campo' => 'CD_PROVA', 'valor' => $prova),
            ));
        }

        //montar combo
        $combo = "<option value=''>QUESTÃO</option>";
        foreach ($questoes as $row) {
            $combo .= "<option value='" . $row->CD_QUESTAO . '-' . $row->POSICAO . "'>" . $row->POSICAO . "</option>";
        }

        echo $combo;
    }

}
