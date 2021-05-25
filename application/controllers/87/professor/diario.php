<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Diario extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('87/professor/diario_model', 'diario', TRUE);
        $this->load->model('87/coordenacao/coordenador_model', 'coordenador', TRUE);

        $this->load->library("session");
        $this->load->helper("form");
    }

    /**
     * Direciona para a tela de lançar conteúdo da prova, onde o professor
     * seleciona a turma e disciplina que irá lançar o conteudo.
     */
    function conteudo_prova() {
        $aux = $this->coordenador->aes_professor(array(
            'operacao' => 'TR',
            'cd_professor' => $this->session->userdata('SGP_PROFESSOR')
        ));

        $turmas = array();
        foreach ($aux as $turma) {
            if (strstr("+", $turma['CD_TURMA']) === FALSE) {
                $turma['notas'] = $this->diario->sp_notas(array(
                    'operacao' => 'LN',
                    'periodo' => $this->session->userdata('SGP_PERIODO'),
                    'cd_turma' => $turma['CD_TURMA']
                ));
            }

            $turmas[] = $turma;
        }

        $data = array(
            "TituloSistema" => "PORTAL ACADÊMICO",
            "titulo" => "DIÁRIO DE CLASSE",
            "SubTitulo" => "LANÇAR CONTEÚDO DE PROVA",
            "side_bar" => false,
            "turmas" => $turmas,
        );

        $this->load->view("87/professor/diario/conteudo_prova", $data);
    }

    /**
     * Direciona para tela onde o professor informa quais os conteúdos de uma determinada
     * nota.
     */
    function lancar_conteudo_prova() {
        //obter o tipo de nota e bimestre
        $aux = explode("-", $this->input->post("tipo-nota"));
        $tipoNota = $aux[0];
        $bimestre = $aux[1];

        $lancamentos = $this->diario->aes_prova_agendamento(array(
            "operacao" => "L",
        ));

        /*
         * checar se para o bimestre, periodo, disciplina e tipo de nota já
         * foi lançado algum conteudo de prova.
         */
        $prova = null;
        foreach ($lancamentos as $row) {
            if ($row['PERIODO'] == $this->session->userdata("SGP_PERIODO") &&
                    $row["BIMESTRE"] == $bimestre && $row['CD_TIPO_NOTA'] == $tipoNota &&
                    $row["CD_DISCIPLINA"] == $this->input->post("codigo-disciplina") &&
                    $row["CD_TURMA"] == $this->input->post("turma")) {

                $prova = $row;
                $prova['DT_PROVA'] = date("d/m/Y", strtotime($prova['DT_PROVA']));
                $prova['data-conteudo'] = date("d/m/Y", strtotime($prova["DT_INICIO"])) . " - " . date("d/m/Y", strtotime($prova["DT_FIM"]));
                break;
            }
        }

        //obter descrição do tipo nota
        $result = $this->diario->sp_notas(array(
            "cd_turma" => $this->input->post("turma"),
            "operacao" => "LN"
        ));

        $nota = null;
        foreach ($result as $row) {
            if ($row['CD_TIPO_NOTA'] == $tipoNota) {
                $nota = $row;
                break;
            }
        }

        //obter os conteudos do professor caso seja uma edição
        $conteudos = array();
        if (!empty($prova['DT_INICIO']) && !empty($prova['DT_FIM'])) {
            $params = array(
                "dataInicio" => $prova['DT_INICIO'],
                "dataFim" => $prova['DT_FIM'],
                "turma" => $prova['CD_TURMA'],
                "disciplina" => $prova['CD_DISCIPLINA'],
                "periodo" => $prova['PERIODO'],
                "bimestre" => $prova['BIMESTRE'],
            );

            $conteudos = $this->listar_conteudo_prova($params);
        }

        $data = array(
            "TituloSistema" => "PORTAL ACADÊMICO",
            "titulo" => "DIÁRIO DE CLASSE",
            "SubTitulo" => "LANÇAR CONTEÚDO DE PROVA",
            "side_bar" => false,
            "turma" => $this->input->post("turma"),
            "codigoDisciplina" => $this->input->post("codigo-disciplina"),
            "descricaoDisciplina" => $this->input->post("descricao-disciplina"),
            "prova" => $prova,
            "nota" => $nota,
            "conteudos" => $conteudos,
        );

        $this->load->view("87/professor/diario/lancar_conteudo_prova", $data);
    }

    /**
     * Método que irá salvar os dados do conteudo da prova
     */
    function confirmar_conteudo_prova() {
        $aux = explode("-", $this->input->post("data-conteudo"));
        $dataInicio = $aux[0];
        $dataFim = $aux[1];

        $params = array(
            "operacao" => "I",
            "periodo" => $this->session->userdata("SGP_PERIODO"),
            "bimestre" => $this->input->post("bimestre"),
            "tipo_nota" => $this->input->post("tipo-nota"),
            "disciplina" => $this->input->post("codigo-disciplina"),
            "data_prova" => $this->input->post("data-prova"),
            "turma" => $this->input->post("turma"),
            "data_inicio" => $dataInicio,
            "data_fim" => $dataFim,
            "flag" => $this->input->post("flag") == null ? "N" : $this->input->post("flag"),
        );

        //caso já tenha sido lançado o conteudo será apenas atualizado os dados
        $codigoProva = $this->input->post("prova");
        if (!empty($codigoProva)) {
            $params['operacao'] = "E";
            $params['codigo_prova'] = $codigoProva;
        }

        try {
            $this->diario->aes_prova_agendamento($params);
        } catch (Exception $ex) {
            $this->session->set_flashdata("error", "Ocorreu um erro ao lançar conteúdo de prova.");
        }

        $this->session->set_flashdata("success", "Conteúdo lançado com sucesso.");
        redirect("87/professor/diario/conteudo_prova");
    }

    /**
     * Popula a grid de conteudos da tela de lançamento de conteúdo de prova
     */
    function grid_conteudo_prova() {
        $params = array(
            "dataInicio" => $this->input->post("inicio"),
            "dataFim" => $this->input->post("fim"),
            "turma" => $this->input->post("turma"),
            "disciplina" => $this->input->post("disciplina"),
            "periodo" => $this->session->userdata("SGP_PERIODO"),
            "bimestre" => $this->input->post("bimestre"),
        );

        $data = array(
            'conteudos' => $this->listar_conteudo_prova($params),
        );

        $this->load->view("87/professor/diario/grid_conteudo_prova", $data);
    }

    /**
     * Função que retorna o conteudo do bimestre e periodo filtrado pelo
     * parametro [$params]
     * 
     * @param array $dados Um vetor com vários parametros na seguinte forma:
     * 
     * array(
     *      dataInicio => value
     *      dataFim => value
     *      bimestre => value
     *      periodo => value
     *      turma => value
     *      disciplina => value
     * );     
     */
    private function listar_conteudo_prova($dados) {
        $dataInicio = strtotime($dados['dataInicio']);
        $dataFim = strtotime($dados['dataFim']);

        $params = array(
            "operacao" => "LCB",
            "cd_turma" => $dados['turma'],
            "cd_disciplina" => $dados['disciplina'],
            "periodo" => $dados['periodo'],
            "bimestre" => $dados['bimestre'],
        );

        $result = $this->diario->aes_conteudo_ministrado($params);

        $conteudos = array();
        foreach ($result as $row) {
            $data = strtotime($row['DT_AULA']);

            if ($data >= $dataInicio && $data <= $dataFim) {
                $conteudos[] = $row;
            }
        }

        $tamanho = count($conteudos);
        for ($i = 0; $i < $tamanho; $i++) {
            $assuntos = $this->diario->sp_diario(array(
                'cl_aula' => $conteudos[$i]['CD_CL_AULA'],
                'operacao' => 'LAL'
            ));

            $conteudos[$i]['AULA_ASSUNTO_LIVRO'] = $assuntos;
        }

        return $conteudos;
    }

}
