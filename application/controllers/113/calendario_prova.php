<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Calendario_Prova extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model("sica/aval_prova_calendario_model", "calendario", true);
        $this->load->model('sica/aval_tipo_prova_model', 'tipo_prova', true);
        $this->load->model('sica/cursos_model', 'curso', true);
        $this->load->model('sica/estrutura_notas_model', 'estrutura_notas', true);
        $this->load->model('sica/serie_model', 'serie', true);
        $this->load->model('sica/turma_disciplina_model', 'turma_disciplina', true);
        $this->load->model('sica/turma_model', 'turma', true);

        $this->load->helper(array('url'));
        $this->load->library(array('session', 'tracert'));

    }

    function index() {
        //$log = new Tracert();
        //$log->validar_url();

        $data = array(
            'curso' => $this->curso->listar(),
            'titulo' => 'GERENCIADOR DE AVALIAÇÕES',
            'SubTitulo' => 'CALENDÁRIO DE PROVAS'
        );

        $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/calendario_prova/index', $data);
    }

    /**
     * Exibe os dados da pesquisa
     */
    public function registros() {
        $inicio = new DateTime($this->input->post("inicio"));
        $fim = new DateTime($this->input->post("fim"));

        $params = array(
            //array("campo" => "DT_PROVA >=", "valor" => $inicio->format("d-M-y")),
            //array("campo" => "DT_PROVA <=", "valor" => $fim->format("d-M-y"))
            array("campo" => "TO_NUMBER(TO_CHAR(DT_PROVA, 'RRRRMMDD')) >=", "valor" => $inicio->format("Ymd")),
            array("campo" => "TO_NUMBER(TO_CHAR(DT_PROVA, 'RRRRMMDD')) <=", "valor" => $fim->format("Ymd"))
        );

        $bimestre = $this->input->post("bimestre");
        $curso = $this->input->post("curso");
        $serie = $this->input->post("serie");
        if (!empty($bimestre)) {
            $params[] = array("campo" => "BIMESTRE", "valor" => $bimestre);
        }

        if (!empty($curso)) {
            $params[] = array("campo" => "CD_CURSO", "valor" => $curso);
        }

        if (!empty($serie)) {
            $params[] = array("campo" => "ORDEM_SERIE", "valor" => $serie);
        }

        $registros = $this->calendario->filtrar($params);

        $response = array();
        foreach ($registros as $row) {
            $disciplina = "";
            if ($row->CD_TIPO_PROVA == 1) {
                $disciplina = $row->OBSERVACAO;
            } else {
                $disciplina = $row->NM_DISCIPLINA;
            }
    
            $aux = array(
                'title' => $row->BIMESTRE . "º BIM - " . $row->CD_TURMA . " - " . $disciplina . " (" . $row->NM_MINI . ")",
                'modal' => site_url($this->session->userdata('SGP_SISTEMA') . "/calendario_prova/modalRegistro/V-" . $row->CD_CALENDARIO),
                'dtprova' => $row->DT_PROVA,
                'start' => date("Y-m-d", strtotime($row->DT_PROVA)),
            );

            $response[] = $aux;
        }

        echo json_encode($response);
    }

    /**
     * Exibe o modal para cadastro, edição, exclusão e detalhes do registro. 
     * 
     * @param string $param
     */
    public function modalRegistro($param) {
        $aux = explode("-", $param);
        $operacao = $aux[0];
        $codigo = $aux[1];
        $cursos = $this->curso->listar();
        $tipoProvas = $this->tipo_prova->listar();

        $registro = null;
        if ($operacao !== "I") {
            $registro = $this->calendario->pesquisar_id(array(
                "campo" => "CD_CALENDARIO",
                "valor" => $codigo
            ));

          
            $visualizaNota = $this->db->query("SELECT FLG_EXIBE_RESULTADO FROM
                             BD_SICA.AVAL_PROVA_CALENDARIO WHERE 
                             CD_CALENDARIO = ".$registro->CD_CALENDARIO);
              

            $series = $this->serie->filtrar(array(
                array("campo" => "CD_CURSO", "valor" => $registro->CD_CURSO)
            ));

            $turmas = $this->turma->filtrar(array(
                array("campo" => "CD_CURSO", "valor" => $registro->CD_CURSO),
                array("campo" => "CD_SERIE", "valor" => $registro->ORDEM_SERIE),
                array("campo" => "TIPO IN ('N', 'D', 'X')"),
                array("campo" => "PERIODO", "valor" => $registro->PERIODO)
            ));

            $disciplinas = $this->turma_disciplina->filtrar(array(
                array("campo" => "PERIODO", "valor" => $registro->PERIODO),
                array("campo" => "CD_TURMA", "valor" => $registro->CD_TURMA),
            ));

            $turmaDetalhe = $this->turma->filtro_id(array(
                array('campo' => "PERIODO", 'valor' => $registro->PERIODO),
                array('campo' => "CD_TURMA", 'valor' => $registro->CD_TURMA)
            ));
            $estruturaNotas = $this->estrutura_notas->filtrar(array(
                array("campo" => "CD_ESTRUTURA", "valor" => $turmaDetalhe->CD_ESTRUTURA),
                array("campo" => "BIMESTRE", "valor" => $registro->BIMESTRE),
            ));

        }

        $data = array(
            "cursos" => $cursos,
            "series" => $series,
            "turmas" => $turmas,
            "disciplinas" => $disciplinas,
            "estruturaNotas" => $estruturaNotas,
            "tipoProvas" => $tipoProvas,
            "registro" => $registro,
            "operacao" => $operacao,
            "visualizaNota" => $visualizaNota
        );

        switch ($operacao) {
            case "I" :
                $data['titulo'] = "CADASTRAR CALENDÁRIO DE PROVA";
                break;
            case "E" :
                $data['titulo'] = "EDITAR CALENDÁRIO DE PROVA";
                break;
            case "D" :
                $data['titulo'] = "EXCLUIR CALENDÁRIO DE PROVA";
                break;
            case "V" :
                $data['titulo'] = "VISUALIZAR CALENDÁRIO DE PROVA";
                break;
        }

        $this->load->view($this->session->userdata('SGP_SISTEMA') . "/calendario_prova/modalRegistro", $data);
    }

    /**
     * Função que conclui as operações de cadastro, edição e exclusão
     */
    public function formManter() {
        $operacao = $this->input->post("operacao");

        //mensagem de retorno
        $result = array(
            "success" => false,
            "mensagem" => "<label class='text-danger'>Ocorreu um erro ao realizar a operação.</label>"
        );

        //converter data para formato oracle e obter numero e tipo nota
        $dataProva = "";
        $tipoNota = "";
        $numNota = "";
        if ($operacao == "I" || $operacao == "E") {
            $aux = DateTime::createFromFormat("d/m/Y", $this->input->post("dataProva"));
            $dataProva = $aux->format("d-M-y");

            $aux = explode("-", $this->input->post("nota"));
            $numNota = $aux[0];
            $tipoNota = $aux[1];
        }

        //prepara vetor de parametros e chaves de inserção ou edição
        $keys = array(
            array("campo" => "CD_CALENDARIO", "valor" => $this->input->post("codigo")),
        );

        $params = array(
            "PERIODO" => $this->session->userdata("SGP_PERIODO"),
            "CD_CURSO" => $this->input->post("curso"),
            "ORDEM_SERIE" => $this->input->post("serie"),
            "CD_TURMA" => $this->input->post("turma"),
            "BIMESTRE" => $this->input->post("bimestre"),
            "CD_TIPO_NOTA" => $tipoNota,
            "NUM_NOTA" => $numNota,
            "CD_DISCIPLINA" => $this->input->post("disciplina"),
            "OBSERVACAO" => $this->input->post("disciplinaTexto"),
            "DT_PROVA" => $dataProva,
            "CD_TIPO_PROVA" => $this->input->post("tipoProva"),
            "NR_CHAMADA" => $this->input->post("chamada"),
            "CD_USUARIO" => $this->session->userdata("SGP_CODIGO"),
            "FLG_EXIBE_RESULTADO" => $this->input->post('exibirNota')
        );

        //validar se o registro é único
        $novo = $operacao == "E" ? false : true;
        $validar = $params;
        $validar['CD_CALENDARIO'] = $this->input->post("codigo");
        if (($operacao == "I" || $operacao == "E") && !$this->calendario->isUnicaProva($validar, $novo)) {
            $result['success'] = false;

            $aux = $this->tipo_prova->pesquisar_id(array(
                "campo" => "CD_TIPO_PROVA", "valor" => $params['CD_TIPO_PROVA']
            ));

            if ($aux->FLG_SIMULADO == "S") {
                $result['mensagem'] = '<h3 class="text-danger">Para a turma e data informada já foi agendado um simulado.</h3>';
            } else {
                $result['mensagem'] = '<h3 class="text-danger">Já existe uma prova agendada da disciplina informada para esta data.</h3>';
            }

            $operacao = null;
        }

        //executar operaçao
        switch ($operacao) {
            case "I":
                if ($this->calendario->inserir($params)) {
                 
                    $result['success'] = true;
                    $result['mensagem'] = '<h3 class="text-success">Prova cadastrada com sucesso no calendário.</h3><script>window.location.reload();</script>';
                }
                break;
            case "E":
                $params = array(
                    array("campo" => "PERIODO", "valor" => $this->session->userdata("SGP_PERIODO")),
                    array("campo" => "CD_CURSO", "valor" => $this->input->post("curso")),
                    array("campo" => "ORDEM_SERIE", "valor" => $this->input->post("serie")),
                    array("campo" => "CD_TURMA", "valor" => $this->input->post("turma")),
                    array("campo" => "BIMESTRE", "valor" => $this->input->post("bimestre")),
                    array("campo" => "CD_TIPO_NOTA", "valor" => $tipoNota),
                    array("campo" => "NUM_NOTA", "valor" => $numNota),
                    array("campo" => "CD_DISCIPLINA", "valor" => $this->input->post("disciplina")),
                    array("campo" => "OBSERVACAO", "valor" => $this->input->post("disciplinaTexto")),
                    array("campo" => "CD_TIPO_PROVA", "valor" => $this->input->post("tipoProva")),
                    array("campo" => "NR_CHAMADA", "valor" => $this->input->post("chamada")),
                    array("campo" => "DT_PROVA", "valor" => $dataProva),
                    array("campo" =>  "FLG_EXIBE_RESULTADO", "valor" => $this->input->post('exibirNota'))
                );

                if ($this->calendario->editar($keys, $params)) {
                    $result['success'] = true;
                    $result['mensagem'] = '<h3 class="text-warning">Dados da Prova editados com sucesso.</h3><script>window.location.reload();</script>';
                }
                break;
            case "D":
                if ($this->calendario->deletar($keys)) {
                    $result['success'] = true;
                    $result['mensagem'] = 'Prova excluída com sucesso do calendário.';
                }
                break;
        }

        echo json_encode($result);
    }

    /**
     * Função para verificar se o tipo de prova selecionado é simulado.
     */
    function isSimulado() {
        $codigo = $this->input->post("codigo");
        $tipoProva = $this->tipo_prova->pesquisar_id(array(
            "campo" => "CD_TIPO_PROVA", "valor" => $codigo
        ));

        $response = array(
            "success" => $tipoProva->FLG_SIMULADO == "S" ? true : false
        );

        echo json_encode($response);
    }

}
