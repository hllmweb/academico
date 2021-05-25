<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Calendario_Evento extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('sica/cursos_model', 'curso', true);
        $this->load->model("sica/evento_model", "calendario", true);
        $this->load->model("sica/evento_aluno_model", "eventoAluno", true);
        $this->load->model("sica/produtos_model", "produto", true);
        $this->load->model("sica/responsavel_model", "responsavel", true);

        $this->load->helper(array('url'));
        $this->load->library(array('session', 'tracert', 'gcm_lib'));
    }

    function index() {
        //$log = new Tracert();
        //$log->validar_url();

        $data = array(
            'curso' => $this->curso->listar(),
            'titulo' => 'ACADÊMICO',
            'SubTitulo' => 'CALENDÁRIO DE EVENTOS'
        );

        $this->load->view($this->session->userdata('SGP_SISTEMA') . '/calendario_evento/index', $data);
    }

    /**
     * Exibe os dados da pesquisa
     */
    public function registros() {
        $inicio = $this->input->post("inicio");
        $fim = $this->input->post("fim");

        $params = array(
            array("campo" => "TRUNC(DT_INICIO) BETWEEN TO_DATE('" . $inicio . "', 'YYYY-MM-DD') AND TO_DATE('" . $fim . "', 'YYYY-MM-DD')", "valor" => null),
            array("campo" => "FL_ATIVO", "valor" => true)
        );

        $registros = $this->calendario->filtrar($params);

        $response = array();
        foreach ($registros as $row) {
            $inicio = new DateTime($row->DT_INICIO);
            $horaInicio = explode(":", $row->HR_INICIO);
            $inicio->add(new DateInterval("PT" . $horaInicio[0] . "H" . $horaInicio[1] . "M"));

            $aux = array(
                'title' => $row->NM_EVENTO,
                'modal' => site_url($this->session->userdata('SGP_SISTEMA') . "/calendario_evento/modalViewRegistro/" . $row->CD_EVENTO),
                'color' => $row->DS_COR,
                'start' => $inicio->format('c'),
            );            

            if ($row->DT_FIM !== null) {
                $fim = new DateTime($row->DT_FIM);

                if ($row->HR_FIM !== null) {
                    $horaFim = explode(":", $row->HR_FIM);
                    $fim->add(new DateInterval("PT" . $horaFim[0] . "H" . $horaFim[1] . "M"));
                }

                $aux['end'] = $fim->format('c');
            }

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

        if (strpos($param, "-") === false) {
            $operacao = "I";
        }

        $cursos = $this->curso->listar();
        $produtos = $this->produto->filtrar(array(
            array('campo' => 'CD_CLASSE', "valor" => 3)
        ));

        $registro = null;
        if ($operacao !== "I") {
            $registro = $this->calendario->pesquisar_id(array(
                "campo" => "CD_EVENTO",
                "valor" => $codigo
            ));
        }

        $data = array(
            "cursos" => $cursos,
            "registro" => $registro,
            "produtos" => $produtos,
            "operacao" => $operacao
        );

        switch ($operacao) {
            case "I" :
                $data['titulo'] = "CADASTRAR CALENDÁRIO DE EVENTOS";
                break;
            case "E" :
                $data['titulo'] = "EDITAR CALENDÁRIO DE EVENTOS";
                break;
            case "D" :
                $data['titulo'] = "EXCLUIR CALENDÁRIO DE EVENTOS";
                break;
        }

        $this->load->view($this->session->userdata('SGP_SISTEMA') . "/calendario_evento/modalRegistro", $data);
    }

    /**
     * Modal que exibe os detalhes do evento e alunos que participarão dele.
     * 
     * @param int $codigo
     */
    public function modalViewRegistro($codigo) {
        $evento = $this->calendario->pesquisar_id(array(
            "campo" => "CD_EVENTO",
            "valor" => $codigo
        ));


        $alunos = $this->eventoAluno->filtrar(array(
            array("campo" => "CD_EVENTO", "valor" => $codigo),
        ));

        $produtos = $this->produto->filtrar(array(
            array('campo' => "CD_PRODUTO", "valor" => $evento->CD_PRODUTO),
        ));

        $data = array(
            "registro" => $evento,
            "alunos" => $alunos,
            "produtos" => $produtos,
            "titulo" => "VISUALIZAR EVENTO"
        );

        $this->load->view($this->session->userdata('SGP_SISTEMA') . "/calendario_evento/modalViewRegistro", $data);
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

        //converter data para formato oracle e obter alunos do evento
        $dataInicio = "";
        $dataFim = "";
        $dataVencimento = "";
        $alunos = array();
        if ($operacao == "I" || $operacao == "E") {
            $dataEvento = $this->input->post("dataEvento");
            $vencimento = $this->input->post("dataVencimento");

            $aux = explode("-", $dataEvento);
            $inicio = trim($aux[0]);
            $fim = trim($aux[1]);

            $aux = DateTime::createFromFormat("d/m/Y", $inicio);
            $dataInicio = empty($inicio) ? null : $aux->format("d-M-y");

            $aux = DateTime::createFromFormat("d/m/Y", $fim);
            $dataFim = empty($fim) ? null : $aux->format("d-M-y");

            $aux = DateTime::createFromFormat("d/m/Y", $vencimento);
            $dataVencimento = empty($vencimento) ? null : $aux->format("d-M-y");

            $alunos['CURSOS'] = $this->input->post("cursos");
            $alunos['SERIES'] = $this->input->post("series");
            $alunos['TURMAS'] = $this->input->post("turmas");
        }

        //preparar vetor com chaves
        $keys = array(
            array("campo" => "CD_EVENTO", "valor" => $this->input->post("codigo")),
        );

        //preparar vetor com dados que serão salvos        
        $notificar = $this->input->post("notificar");
        $params = array(
            "NM_EVENTO" => html_entity_decode($this->input->post("nome"), ENT_QUOTES, 'UTF-8'),
            "DS_EVENTO" => html_entity_decode(strip_tags($this->input->post("descricao"), "<strong><br><br/>"), ENT_QUOTES, 'UTF-8'),
            "DT_INICIO" => $dataInicio,
            "DT_FIM" => $dataFim,
            "DT_VENCIMENTO" => $dataVencimento,
            "HR_INICIO" => $this->input->post("horaInicio"),
            "HR_FIM" => $this->input->post("horaFim"),
            "CD_PRODUTO" => $this->input->post("produto"),
            "DS_COR" => $this->input->post("cor"),
            "FL_NOTIFICAR" => empty($notificar) ? "N" : $notificar,
        );

        if ($operacao == "I") {
            $params['CD_USUARIO'] = $this->session->userdata("SGP_CODIGO");
            $params['FL_ATIVO'] = true;
            $params['DS_IMAGEM'] = $this->do_upload();
        } else if ($operacao == "E") {
            $params['CD_EVENTO'] = $this->input->post("codigo");
            $params['operacao'] = "E";

            //salvar o caminho da nova imagem
            $caminho = $this->do_upload();
            if (!empty($caminho)) {
                $params["DS_IMAGEM"] = $caminho;
            } else {
                //salvar o caminho antigo caso venha em branco
                $dados = $this->calendario->filtro_id($keys);
                $params['DS_IMAGEM'] = $dados->DS_IMAGEM;
            }
        }

        //executar operaçao
        switch ($operacao) {
            case "I":
                if ($this->calendario->adicionar($params, $alunos)) {
                    $result['success'] = true;
                    $result['mensagem'] = '<h3 class="text-success">Evento cadastrado com sucesso no calendário.</h3><script>window.location.reload();</script>';
                }
                break;
            case "E":
                $this->calendario->procedure_manter_evento($params);
                $result['success'] = true;
                $result['mensagem'] = '<h3 class="text-warning">Dados do evento editados com sucesso.</h3><script>window.location.reload();</script>';
                break;
            case "D":
                if ($this->calendario->excluir($keys)) {
                    $result['success'] = true;
                    $result['mensagem'] = 'Evento excluído com sucesso do calendário.';
                }
                break;
        }

        //realizar a notificação
        if ($params['FL_NOTIFICAR'] == "S" && $result['success'] == true) {
            $codigo = $this->calendario->max("CD_EVENTO");
            $this->notificar($codigo);
        }
        echo json_encode($result);
    }

    /**
     * Realiza o upload do arquivo.
     * 
     * @return string caminho da imagem
     */
    private function do_upload() {
        $path = "/upload/imagem_evento/";

        $config['upload_path'] = $_SERVER['DOCUMENT_ROOT'] . "/academico" . $path;
        $config['allowed_types'] = 'jpg|png';
        $config['encrypt_name'] = TRUE;
        $config['overwrite'] = FALSE;
        $config['allow_resize'] = TRUE;

        $this->load->library('upload', $config);

        $caminho = "";

        if ($this->upload->do_upload("imagem")) {
            $data = $this->upload->data();

            $caminho = base_url($path . $data['file_name']);
        }

        return $caminho;
    }

    /**
     * Método que verifica qual a forma de notificação será utilizada para o evento
     * 
     * @param int $codigo
     */
    private function notificar($codigo) {
        $evento = $this->calendario->filtro_id(array(
            array("campo" => "CD_EVENTO", "valor" => $codigo)
        ));

        if ($evento !== null) {
            if ($evento->CD_PRODUTO == null) {
                $this->evento_naocobrado($evento->CD_EVENTO);
            } else {
                $this->evento_cobrado($evento->CD_EVENTO);
            }
        }
    }

    /**
     * Dispara notificação para o dispositivos dos responsáveis sobre o evento,
     * o pagamento e autorização para a participação do aluno.
     * 
     * @param int $codigo Código do evento
     */
    private function evento_cobrado($codigo) {

        $alunos = $this->eventoAluno->filtrar(array(array('campo' => 'CD_EVENTO', 'valor' => $codigo)));

        $resp = array();
        foreach ($alunos as $l) {
            $responsavel = $this->responsavel->listar_token(array('aluno' => $l->CD_ALUNO));
            foreach ($responsavel as $rp) {
                $resp[] = array(
                    'codigo' => $l->CD_EVENTO,
                    'titulo' => $l->NM_EVENTO,
                    'imagem' => $l->DS_IMAGEM,
                    'evento' => $l->DS_EVENTO->load(),
                    'matricula' => $l->CD_ALUNO,
                    'aluno' => $l->NM_ALUNO,
                    'token' => $rp['TOKEN_GCM'],
                    'inicio' => $l->DT_INICIO,
                    'fim' => $l->DT_FIM,
                    'horario' => $l->HR_INICIO . ' até ' . $l->HR_FIM,
                    'valor' => $l->PRECO,
                );
            }
        }

        $gcm = new Gcm_lib();
        foreach ($resp as $row) {

            $gcm->reg_id = array($row['token']);
            $gcm->titulo = $row['titulo'];
            $gcm->mensagem = $row['evento'];
            $gcm->dados = array(
                //'codigo' => date('dmYhms'),
                'codigo' => $codigo,
                'descricao' => $row['evento'],
                'foto' => 'https://www.seculomanaus.com.br/portal/restrito/foto?codigo=' . $row['matricula'] . '',
                'data' => $row['inicio'],
                'horario' => $row['horario'],
                'app' => 3,
                // PARAMETROS PARA EVENTOS
                'nm_tipo' => 'EVENTO COM TAXA',
                'cd_evento' => $codigo,
                'cd_aluno' => $row['matricula'],
                'nm_aluno' => $row['aluno'],
                'dt_evento' => $row['inicio'],
                'ds_horario' => $row['horario'],
                'vl_evento' => $row['valor'],
                'fl_pago' => 'N',
                'fl_lido' => 'N',
                'fl_confirmacao' => 'N',
            );

            $gcm->evento_cobrado();
        }
    }

    /**
     * Dispara notificação para os dispositivos dos responsáveis quanto ao 
     * evento e autorização para a participação do aluno.
     * 
     * @param int $codigo Código do evento
     */
    private function evento_naocobrado($codigo) {

        $alunos = $this->eventoAluno->filtrar(array(array('campo' => 'CD_EVENTO', 'valor' => $codigo)));
        $resp = array();
        foreach ($alunos as $l) {
            $responsavel = $this->responsavel->listar_token(array('aluno' => $l->CD_ALUNO));
            foreach ($responsavel as $rp) {
                $resp[] = array(
                    'codigo' => $l->CD_EVENTO,
                    'titulo' => $l->NM_EVENTO,
                    'imagem' => $l->DS_IMAGEM,
                    'evento' => $l->DS_EVENTO->load(),
                    'matricula' => $l->CD_ALUNO,
                    'aluno' => $l->NM_ALUNO,
                    'token' => $rp['TOKEN_GCM'],
                    'inicio' => $l->DT_INICIO,
                    'fim' => $l->DT_FIM,
                    'horario' => $l->HR_INICIO . ' até ' . $l->HR_FIM,
                );
            }
        }

        $gcm = new Gcm_lib();
        foreach ($resp as $row) {

            $gcm->reg_id = array($row['token']);
            $gcm->titulo = $row['titulo'];
            $gcm->mensagem = $row['evento'];
            $gcm->dados = array(
                //'cd_alerta' => date('dmYhms'),
                'cd_alerta' => $codigo,
                'nm_alerta' => $row['titulo'],
                'ds_alerta' => $row['evento'],
                'ds_foto' => 'https://www.seculomanaus.com.br/portal/restrito/foto?codigo=' . $row['matricula'] . '',
                'ds_foto_mini' => 'https://www.seculomanaus.com.br/portal/restrito/foto?codigo=' . $row['matricula'] . '',
                'dt_cadastro' => date('d/m/Y h:m:s'),
                //PARAMETROS PARA EVENTOS
                'nm_tipo' => 'EVENTO SEM TAXA',
                'cd_evento' => $codigo,
                'cd_aluno' => $row['matricula'],
                'nm_aluno' => $row['aluno'],
                'dt_evento' => $row['inicio'],
                'ds_horario' => $row['horario'],
                'vl_evento' => 'NULL',
                'fl_pago' => 'NULL',
                'fl_lido' => 'N',
                'fl_confirmacao' => 'N',
            );

            $gcm->evento_naocobrado();
        }
    }

}
