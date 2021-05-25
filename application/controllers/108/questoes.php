<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Questoes extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("academico/questao_model", "questao", true);
        $this->load->model('cadastro_model', 'cadastro', TRUE);
        $this->load->model("academico/questao_opcao_model", "opcao", true);
        $this->load->model("academico/questao_conteudo_model", "conteudo", true);
        $this->load->model("academico/tema_model", "tema", true);
        $this->load->model("academico/tema_conteudo_model", "tema_conteudo", true);
        $this->load->model("sica/cursos_model", "curso", true);
        $this->load->model("sica/serie_model", "serie", true);
        $this->load->model("sica/disciplina_model", "disciplina", true);

        $this->load->helper(array('url', 'form', 'text'));
        $this->load->library(array('session', 'user_agent', 'prova_lib'));

        /**
         * linhas para destruir valor do filtro caso tenha saído do módulo de
         * questões.
         */
        $ref = $this->agent->referrer();
        if (empty($ref) || !strpos($ref, "questoes")) {
            $this->session->set_userdata("SGP_FILTRO", null);
        }
    }

    /**
     * Exibe a tela com filtros para pesquisa
     */
    function index() {
        //codigos selecionados no ultimo filtro
        $codigo       = null;
        $curso        = null;
        $serie        = null;
        $disciplina   = null;
        $pagina       = null;

        //listas para popular as combos
        $series       = null;
        $disciplinas  = null;

        //preencher dados de acordo filtro na sessão
        $filtro = $this->session->userdata("SGP_FILTRO");
        if ($filtro !== null && isset($filtro['params']['CD_QUESTAO'])) {
            $codigo = $filtro['params']['CD_QUESTAO'];
            $pagina = $filtro['pagina'];
        } else if ($filtro !== null && isset($filtro['params']['CD_DISCIPLINA'])) {
            $curso = $filtro['params']['CD_CURSO'];
            $serie = $filtro['params']['ORDEM_SERIE'];
            $disciplina = $filtro['params']['CD_DISCIPLINA'];
            $pagina = $filtro['pagina'];

            $series = $this->serie->filtrar(array(
                array('campo' => 'CD_CURSO', 'valor' => $curso)
            ));

            $disciplinas = $this->disciplina->filtrar(array(
                array('campo' => 'CD_CURSO', 'valor' => $curso),
                array('campo' => 'CD_SERIE', 'valor' => $serie),
                array('campo' => 'TIPO', 'valor' => "N"),
                array('campo' => 'PERIODO', 'valor' => $this->session->userdata('SGP_PERIODO')),
            ));
        }

        $data = array(
            'cursos' => $this->curso->listarRegular(),
            'series' => $series,
            'disciplinas' => $disciplinas,
            'codigo' => $codigo,
            'curso' => $curso,
            'serie' => $serie,
            'disciplina' => $disciplina,
            'pagina' => $pagina,
            'titulo' => 'BANCO DE QUESTÕES',
            'SubTitulo' => 'PESQUISAR',
            'filtro' => $filtro !== null,
        );

        //checar se existe alguma mensagem de sucesso ou erro
        if ($this->session->flashdata('success') !== false) {
            $data['tipo'] = 'success';
            $data['mensagem'] = $this->session->flashdata('success');
        } else if ($this->session->flashdata('error') !== false) {
            $data['tipo'] = 'error';
            $data['mensagem'] = $this->session->flashdata('error');
        }

        $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/questoes/index', $data);
    }

    /**
     * Gera os dados para popular a grid de acordo com os filtros de pesquisa
     **/
    function grdQuestoes() {
        $codigo = $this->input->post("codigo");
        $disciplina = $this->input->post("disciplina");
        if (!empty($codigo)) {
            $params = array(
                array('campo' => 'CD_QUESTAO', 'valor' => $this->input->post('codigo'))
            );
        } else if (!empty($disciplina)) {
            $params = array(
                array('campo' => 'CD_CURSO', 'valor' => $this->input->post('curso')),
                array('campo' => 'ORDEM_SERIE', 'valor' => $this->input->post('serie')),
                array('campo' => 'CD_DISCIPLINA', 'valor' => $this->input->post('disciplina')),
            );
        }

        $questoes = null;
        if (!empty($params)) {
            $questoes = $this->questao->filtrar($params);
        }

        $data = array(
            'titulo' => 'QUESTÃO(ÕES) ENCONTRADA(S)',
            'questoes' => $questoes
        );

        $sub =  function($cd_questao = null){
            
             return $this->cadastro->questao_conteudo(array('operacao' => 'FK', 'questao' => $cd_questao));
        };

        $data['subtema'] = $sub;

        $this->load->view($this->session->userdata('SGP_SISTEMA') . '/questoes/grdQuestoes', $data);
    }

    /**
     * Exibe o formulário de cadastro e edição
     * 
     * @param string $p Composto de um caractere indicando a operação que pode 
     * ser I (inserir)e E (editar). Quando for a edição o código da questão vem 
     * separado por um hifen.
     * 
     */
    function frmQuestao($p) {
        $it = explode('-', $p);
        if ($it[0] == 'E') {
            //carregar dados para edição de uma questão
            $data = array(
                'titulo' => 'BANCO DE QUESTÕES',
                'SubTitulo' => 'EDITAR QUESTÃO',
                'cursos' => $this->curso->listarCursosOrdem(),
                'questao' => $this->questao->pesquisar_id(array('campo' => 'CD_QUESTAO', 'valor' => $it[1])),
                'conteudo' => $this->conteudo->obterConteudo($it[1]),
                'alternativas' => $this->opcao->listarAlternativas($it[1]),
                'operacao' => "E",
            );
        } else {
            //verificar se existe dados na sessão
            if ($this->session->flashdata("questao") !== false) {
                $questao = $this->session->flashdata("questao");
            }

            //carregar dados para inserção de nova questão
            $data = array(
                'titulo' => 'BANCO DE QUESTÕES',
                'SubTitulo' => 'CADASTRAR QUESTÃO',
                'cursos' => $this->curso->listarCursosOrdem(),
                'operacao' => "I",
                'questao' => (object) $questao
            );
        }

        //checar se existe alguma mensagem de sucesso
        if ($this->session->flashdata('success') !== false) {
            $data['tipo'] = 'success';
            $data['mensagem'] = $this->session->flashdata('success');
        }

        $this->load->view($this->session->userdata('SGP_SISTEMA') . '/questoes/frmQuestao', $data);
    }

    /**
     * Exibe para previsualizar a questão que está sendo cadastrada
     */
    function modalPrevisualizar() {
        //obter dados da questao
        $questao = array(
            'CD_QUESTAO' => $this->input->post('FTCodQuestao'),
            'CD_CURSO' => $this->input->post("FTCurso"),
            'ORDEM_SERIE' => $this->input->post("FTSerie"),
            'CD_DISCIPLINA' => $this->input->post("FTDisciplina"),
            'CD_PROFESSOR' => $this->input->post("FTProfessor"),
            'CD_USU_CADASTRO' => $this->session->userdata("SGP_CODIGO"),
            'FLG_TIPO' => $this->input->post("FTTipoQuestao"),
            'NR_DIFICULDADE' => $this->input->post("FTNivel"),
            'DC_QUESTAO' => $this->input->post("avalQuestao")
        );

        //obter dados das alternativas caso seja objetiva        
        $opcoes = array();
        if ($questao['FLG_TIPO'] == 'O') {
            for ($i = 1; $i < 6; $i++) {
                $aux = array(
                    'CD_OPCAO' => $i,
                    'DC_OPCAO' => $this->input->post("avalQuestaoOpcao" . $i),
                    'FLG_CORRETA' => $this->input->post("avalCorreta") == $i ? 1 : 0,
                    'CD_USU_CADASTRO' => $this->session->userdata("SGP_CODIGO"),
                );
                $opcoes[] = (object) $aux;
            }
        }

        $descricao = $this->questao->formatar((object) $questao, $opcoes);

        $data = array(
            "titulo" => "Pré-Visualização da Questão",
            "descricao" => $descricao,
            "conteudo" => null,
            "operacao" => $this->input->post("operacao"),
            "questao" => (object) $questao
        );

        $this->load->view("108/questoes/mdlQuestaoView", $data);
    }

    /**
     * 
     * @param string $id Parametro indicando a operação que chamou o modal de 
     * detalhes e o código da questão separado por hífen
     */
    function mdlQuestaoView($id) {
        $aux = explode("-", $id);

        $operacao = $aux[0];
        $codigo = $aux[1];

        $questao = $this->questao->pesquisar_id(array(
            'campo' => 'CD_QUESTAO',
            'valor' => $codigo
        ));

        $alternativas = $this->opcao->listarAlternativas($codigo);
        $descricao = $this->questao->formatar($questao, $alternativas, true);

        $dificuldade = $questao->NR_DIFICULDADE == 3 ? 'DIFÍCIL' : $questao->NR_DIFICULDADE == 2 ? 'MÉDIA' : 'FÁCIL';
        $titulo = $questao->NM_CURSO . ' - ' . $questao->ORDEM_SERIE . 'º ANO - ' . $questao->NM_DISCIPLINA . ' - ' . $dificuldade;

        $data = array(
            "titulo" => $titulo,
            "descricao" => $descricao,
            "conteudo" => $this->conteudo->obterConteudo($codigo),
            "questao" => $questao,
            "operacao" => $operacao
        );

        $this->load->view('108/questoes/mdlQuestaoView', $data);
    }

    /**
     * Função que realiza a exclusão da questão informada
     * 
     * @param int $id
     */
    function frmQuestaoDeletar($id) {
        if ($this->questao->isUtilizada($id)) {
            $this->session->set_flashdata('error', 'A questão não pode ser excluída enquanto for utilizada em uma prova.');
        } else if ($this->questao->excluirDados($id)) {
            $this->session->set_flashdata('success', 'Questão excluída com sucesso.');
        } else {
            $this->session->set_flashdata('error', 'Ocorreu um erro ao excluir a questão.');
        }

        redirect("108/questoes/index");
    }

    /**
     * Função para salvar o formulário de cadastro ou edição da questãos
     */
    function frmQuestaoSalvar() {
//obter dados da questao
        $questao = array(
            'CD_CURSO' => $this->input->post("FTCurso"),
            'ORDEM_SERIE' => $this->input->post("FTSerie"),
            'CD_DISCIPLINA' => $this->input->post("FTDisciplina"),
            'CD_PROFESSOR' => $this->input->post("FTProfessor"),
            'CD_USU_CADASTRO' => $this->session->userdata("SGP_CODIGO"),
            'FLG_TIPO' => $this->input->post("FTTipoQuestao"),
            'NR_DIFICULDADE' => $this->input->post("FTNivel"),
            'DC_QUESTAO' => $this->input->post("avalQuestao")
        );

//obter dados das alternativas
        $opcoes = array();
        if ($questao['FLG_TIPO'] == 'O') {
            for ($i = 1; $i < 5; $i++) {
                $opcoes[] = array(
                    'CD_OPCAO' => $i,
                    'DC_OPCAO' => $this->input->post("avalQuestaoOpcao" . $i),
                    'FLG_CORRETA' => $this->input->post("avalCorreta") == $i ? 1 : 0,
                    'CD_USU_CADASTRO' => $this->session->userdata("SGP_CODIGO"),
                );
            }
        }

//obter dados do conteudo
        $conteudo = array(
            'CD_CONTEUDO' => $this->input->post("FTConteudo"),
        );

        $operacao = $this->input->post('operacao');
        switch ($operacao) {
            case 'I':
                if (!$this->questao->inserirDados($questao, $opcoes, $conteudo)) {
                    $mensagem = "Ocorreu um erro ao salvar a questão.";
                    $tipo = "error";

                    //preparar dados como stdClass
                    $aux = array();
                    foreach ($opcoes as $row) {
                        $aux[] = (object) $row;
                    }

                    //popular dados para preencher formulário corretamente
                    $conteudo['CD_TEMA'] = $this->input->post("FTTema");

                    //devolver os dados para continuar cadastro
                    $data = array(
                        'titulo' => 'BANCO DE QUESTÕES',
                        'SubTitulo' => 'CADASTRAR QUESTÃO',
                        'TituloSistema' => 'GESTOR DE PROVAS',
                        'operacao' => 'I',
                        'cursos' => $this->curso->listarCursosOrdem(),
                        'questao' => (object) $questao,
                        'conteudo' => (object) $conteudo,
                        'alternativas' => $aux,
                        'tipo' => $tipo,
                        'mensagem' => $mensagem
                    );

                    $this->load->view('108/questoes/frmQuestao', $data);
                    exit();
                }

                if ($this->input->post("modoSalvar") == "P") {
                    $dados = array(
                        "CD_CURSO" => $questao['CD_CURSO'],
                        "ORDEM_SERIE" => $questao['ORDEM_SERIE'],
                        "CD_DISCIPLINA" => $questao['CD_DISCIPLINA'],
                        "CD_PROFESSOR" => $questao['CD_PROFESSOR']
                    );

                    $this->session->set_flashdata("questao", $dados);
                }

                $codigo = $this->questao->max("CD_QUESTAO");

                $this->session->set_flashdata('success', 'Questão código ' . $codigo . ' salva com sucesso.');
                redirect('108/questoes/frmQuestao/I');
                break;
            case 'E':

                //********** ATUALIZA A QUESTÃO
                $questao['operacao'] = "E";
                $questao['CD_QUESTAO'] = $this->input->post('FTCodQuestao');
                $this->questao->procedure_manter_questao($questao);

                // DELETA OS CONTEUDOS MARCADOS
                $key = array(
                    array('campo' => 'CD_QUESTAO', 'valor' => $this->input->post('FTCodQuestao')),
                );
                $this->conteudo->deletar($key);

                // INSERE O CONTEUDO DA QUESTÃO
                $param = array(
                    'CD_QUESTAO' => $this->input->post('FTCodQuestao'),
                    'CD_CONTEUDO' => $this->input->post('FTConteudo'),
                );
                $this->conteudo->inserir($param);

                // DELETA AS OPÇÕES CADASTRADAS
                $key = array(
                    array('campo' => 'CD_QUESTAO', 'valor' => $this->input->post('FTCodQuestao')),
                );
                $this->opcao->deletar($key);

                // ADICIONA AS OPÇÕES
                if ($questao['FLG_TIPO'] == 'O') {
                    foreach ($opcoes as $op) {
                        $op['operacao'] = "I";
                        $op['CD_QUESTAO'] = $this->input->post('FTCodQuestao');
                        $this->opcao->procedure_manter_questao_opcao($op);

                        //gabaritar a questão
                        $keys = array(
                            array("campo" => "CD_QUESTAO", "valor" => $op['CD_QUESTAO']),
                            array("campo" => "CD_OPCAO", "valor" => $op['CD_OPCAO'])
                        );

                        $set = array(
                            array("campo" => "FLG_CORRETA", "valor" => $op['FLG_CORRETA']),
                        );

                        $this->opcao->editar($keys, $set);
                    }
                }

                $this->session->set_flashdata('success', 'Questão salva com sucesso.');
                redirect('108/questoes/frmQuestao/E-' . $this->input->post('FTCodQuestao'));
                break;
        }
    }

    /**
     * Funcao que retorna no formato json se uma questao está gabaritada ou não.
     * 
     * Retorna:
     * 
     * success => true se estiver gabaritada;
     * success => false se não estiver gabaritada;
     * success => '-' questão discursiva.
     */
    public function statusGabarito() {
        $codigo = $this->input->post("questao");
        $questao = $this->questao->pesquisar_id(array(
            'campo' => 'CD_QUESTAO',
            'valor' => $codigo
        ));

        $result = array(
            "success" => true,
            "codigo" => $codigo
        );

        if ($questao->FLG_TIPO == 'O') {
            $result['success'] = $this->questao->isGabaritada($codigo);
        } else {
            $result['success'] = '-';
        }

        echo json_encode($result);
    }

    /**
     * Função que irá remover toda formatação do editor. Exceto tags de imagem.
     * 
     * @return string
     */
    public function limparTags() {
        $descricao = $this->input->post("descricao");

        //substituir tags de titulo por quebra de linha
        for ($i = 1; $i <= 6; $i++) {
            $descricao = str_ireplace("<h" . $i . ">", "", $descricao);
            $descricao = str_ireplace("</h" . $i . ">", "<br>", $descricao);
        }

        //substituir paragrafo <p> por <br>
        $descricao = str_ireplace("<p>", "", $descricao);
        $descricao = str_ireplace("</p>", "<br>", $descricao);
        $descricao = str_ireplace(chr(194) . chr(160), "", $descricao);

        //substituir travessão longo por um normal                        
        $descricao = str_ireplace(chr(194) . chr(190), '–', $descricao);

        $textoLimpo = strip_tags($descricao, "<img><br/><br><ul><li><ol><sub><sup>");

        echo $textoLimpo;
    }

    /**
     * Função que insere em sessão os dados do último filtro de pesquisa 
     * realizado e a última página da grid
     * 
     */
    public function salvarFiltro() {
        $codigo = $this->input->post("codigo");
        $disciplina = $this->input->post("disciplina");

        if (!empty($codigo)) {
            $filtro = array(
                'CD_QUESTAO' => $this->input->post("codigo")
            );
        } else if (!empty($disciplina)) {
            $filtro = array(
                'CD_CURSO' => $this->input->post("curso"),
                'ORDEM_SERIE' => $this->input->post("serie"),
                'CD_DISCIPLINA' => $this->input->post("disciplina")
            );
        }

        if (!empty($filtro)) {
            $this->session->set_userdata("SGP_FILTRO", array(
                "params" => $filtro,
                "pagina" => $this->input->post("pagina")
            ));
        } else {
            $this->session->set_userdata("SGP_FILTRO", null);
        }
    }

}
