<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Comunicado extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("aplicacao/app_token_model", "token", true);
        $this->load->model("sica/cursos_model", "curso", true);
        $this->load->model("academico/comunicado_model", "comunicado", true);

        $this->load->helper(array("url"));
        $this->load->library(array("session", "gcm_lib", "tracert"));
    }

    /**
     * Exibe tela para pesquisa de registros
     */
    public function index() {
        $log = new Tracert();
        $log->usuario = $this->session->userdata('USU_CODIGO');
        $log->validar_url();
        
        $cursos = $this->curso->listar();

        $data = array(
            'titulo' => 'COMUNICADOS',
            'SubTitulo' => 'PESQUISAR',
            'cursos' => $cursos
        );

        $this->load->view($this->session->userdata('SGP_SISTEMA') . "/comunicado/index", $data);
    }

    /**
     * Exibe os dados da pesquisa referentes ao usuário logado
     */
    public function gridRegistro() {
        $envio = $this->input->post("data");

        if (empty($envio)) {
            $params = array();
        } else {
            $params = array(
                array("campo" => "TRUNC(DT_ENVIO) = TO_DATE('" . $envio . "', 'DD/MM/YYYY')", 'valor' => ''),
            );
        }

        $data = array(
            "registros" => $this->comunicado->filtrar($params)
        );

        $this->load->view($this->session->userdata('SGP_SISTEMA') . "/comunicado/gridRegistro", $data);
    }

    /**
     * Exibe o modal para cadastro, edição, exclusão e detalhes do registro de
     * solicitação.
     * 
     * @param string $id String com letra da operação e código do registro
     * Ex.: V-10
     */
    public function modalRegistro($id) {
        $aux = explode("-", $id);

        $operacao = $aux[0];
        $codigo = $aux[1];

        $data = array(
            'cursos' => $this->curso->listar(),
            'operacao' => $operacao
        );

        switch ($operacao) {
            case "I" :
                $data['titulo'] = "Novo Comunicado";
                break;
            case "V" :
                $data['titulo'] = "Detalhes Comunicado";
                $data['registro'] = $this->comunicado->filtro_id(array(
                    array('campo' => 'CD_COMUNICADO', 'valor' => $codigo)
                ));
                break;
        }

        $this->load->view($this->session->userdata('SGP_SISTEMA') . "/comunicado/modalRegistro", $data);
    }

    /**
     * Função que conclui as operações de cadastro, edição e exclusão
     */
    public function formManter() {
        switch ($this->input->post("operacao")) {
            case "I":
                $destinatarios = $this->input->post("destinatario");

                $params = array(
                    'DS_TITULO' => $this->input->post('titulo'),
                    'DS_MENSAGEM' => $this->input->post('mensagem'),
                    'CD_USUARIO' => $this->session->userdata('SGP_CODIGO')
                );

                foreach ($destinatarios as $row) {
                    $params['CD_DESTINATARIO'] = $row;
                    $this->comunicado->inserir($params);
                    $codigo = $this->comunicado->max("CD_COMUNICADO");
                    $this->notificar($codigo);
                }

                $retorno = "<h3 class='text-success'>Comunicado enviado com sucesso.</h3><script>window.location.reload();</script>";
                break;
            case "R" ://reenvio de notificação                
                $this->notificar($this->input->post("codigo"));

                $retorno = "<h3 class='text-success'>Comunicado enviado com sucesso.</h3><script>window.location.reload();</script>";
                break;
        }

        echo $retorno;
    }

    /**
     * Função que irá notificar o destinatário da mensagem.     
     * 
     * @param int $codigo
     */
    private function notificar($codigo) {
        $gcm = new Gcm_lib();

        //obter o comunicado
        $comunicado = $this->comunicado->filtro_id(array(
            array('campo' => 'CD_COMUNICADO', 'valor' => $codigo),
        ));

        //obter todos os tokens do destinatario
        $tokens = $this->token->listarTokens($comunicado->CD_DESTINATARIO);

        //prepara para enviar somente para quem possui o aplicativo
        if (!empty($tokens)) {            
            $gcm->reg_id = $tokens;
            $gcm->titulo = $comunicado->DS_TITULO;
            $gcm->mensagem = $comunicado->DS_MENSAGEM;
            $gcm->dados = array(
                'cd_comunicado' => $comunicado->CD_COMUNICADO,
                'cd_destinatario' => $comunicado->CD_DESTINATARIO,
                'ds_titulo' => $comunicado->DS_TITULO,
                'ds_mensagem' => $comunicado->DS_MENSAGEM,
                'dt_envio' => $comunicado->DT_ENVIO,
                'flg_lido' => $comunicado->FLG_LIDO,
                'cd_usuario' => $comunicado->CD_USUARIO
            );
            //$gcm->comunicado();
        }
    }

}
