<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Suspensao extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('sica/cursos_model', 'cursos', TRUE);
        $this->load->model('sica/responsavel_model', 'responsavel', TRUE);
        $this->load->model('sica/aluno_model', 'aluno', TRUE);
        $this->load->model('sica/aluno_suspensao_model', 'suspender', TRUE);
        $this->load->model('sica/t_periodos_model', 'periodos', TRUE);

        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('gcm_lib'));
        $this->lang->load('sistema', $this->session->userdata('SGP_LANG'));
    }

    function index() {

        $data = array(
            'titulo' => 'MÓDULO DE ORIENTAÇÃO',
            'SubTitulo' => 'SUSPENSÃO ESCOLAR',
            'side_bar' => false,
            'curso' => $this->cursos->listar(),
            'periodo' => $this->periodos->listar(),
            'TituloSistema' => 'RESERVA DE LOCAL',
        );
        $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/suspensao/index', $data);
    }

    function grdRegistro() {
        $param = array(
            'periodo' => $this->input->post('periodo'),
            'curso' => $this->input->post('curso'),
            'serie' => $this->input->post('serie'),
            'turma' => $this->input->post('turma'),
        );
        $data = array(
            'lista' => $this->suspender->listar_turma($param)
        );
        $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/suspensao/grdRegistro', $data);
    }

    function mdlRegistro($id) {
        $item = explode('-', $id);
        $data = array(
            'operacao' => $item[0],
            'codigo' => (($item[1] != '') ? $item[1] : 0),
            'curso' => $this->cursos->listar(),
            'filtro' => $this->suspender->filtro(array('codigo' => $item[1])),
        );
        $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/suspensao/mdlRegistro', $data);
    }

    function mdlRegistroAluno($id) {

        $data = array(
            'lista' => $this->suspender->listar(array('aluno' => $id))
        );
        $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/suspensao/mdlRegistroAluno', $data);
    }

    function frmManter() {
        $result = array(
            'success' => false,
            'titulo' => "Ocorreu um erro ao processar o registro.",
            'mensagem' => ''
        );

        $suspensoes = array();

        $param = array(
            'codigo' => $this->input->post('codigo'),
            'periodo' => $this->session->userdata('SGP_PERIODO'),
            'inicio' => $this->input->post('inicio'),
            'fim' => $this->input->post('fim'),
            'motivo' => $this->input->post('motivo'),
            'web' => 'N'
        );

        $operacao = $this->input->post('operacao');
        switch ($operacao) {
            case 'A':
                $al = $this->input->post('aluno');

                if ($al[0] == '') {
                    echo $retorno = '<label class="text-danger">Selecione o(s) ALUNO(s) </label>';
                    exit;
                }

                foreach ($this->input->post('aluno') as $aluno) {
                    $param = array(
                        'codigo' => $this->input->post('codigo'),
                        'periodo' => $this->session->userdata('SGP_PERIODO'),
                        'aluno' => $aluno,
                        'inicio' => $this->input->post('inicio'),
                        'fim' => $this->input->post('fim'),
                        'motivo' => $this->input->post('motivo'),
                        'web' => 'N',
                        'notificar' => $this->input->post('notificar')
                    );

                    $this->suspender->adicionar($param);
                    $suspensoes[] = $this->suspender->max("CD_SUSPENSAO");
                }

                $result['success'] = true;
                $result['titulo'] = "Suspensão Processada!";
                break;
            case 'E':
                $this->suspender->editar($param);
                $suspensoes[] = $param['codigo'];

                $result['success'] = true;
                $result['titulo'] = "Suspensão Atualizada!";
                break;
            case 'D':
                $this->suspender->deletar($param);

                $result['success'] = true;
                $result['titulo'] = "Suspensão Excluída!";

                break;
        }

        if (($operacao == "A" || $operacao == "E") &&
                $this->input->post('notificar') == 'S' &&
                $result['success']) {
            $result['mensagem'] = $this->notificar($suspensoes);
        }

        echo json_encode($result);
    }

    function termo($id) {

        $data = array(
            'dados' => $this->suspender->filtro(array('codigo' => $id))
        );

        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF();

        $body = $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/suspensao/termo', $data, true);

        $mpdf->SetHTMLHeader($this->load->view('impressao/header_doc', $data, true));
        $mpdf->AddPage('P', // L - landscape, P - portrait
                '', '', '', '', 0, // margin_left
                0, // margin right
                30, // margin top
                30, // margin bottom
                0, // margin header
                0); // margin footer
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHTMLFooter($this->load->view('impressao/footer_doc', $data, true));
        $mpdf->WriteHTML($body);
        $mpdf->Output('TERMO-DE-SUSPESAO-' . str_replace(' ', '_', $data['dados']->NM_ALUNO) . '.pdf', 'I');
    }

    /**
     * Função que irá realizar a notificação das supensões para os responsaveis 
     * do aluno.
     * 
     * @param int[] $suspensoes
     * @return string Retorna uma string com o nome do aluno que não foi possível
     * enviar notificação para o responsável. String vazia caso contrário.
     */
    private function notificar($suspensoes) {
        $gcm = new Gcm_lib();

        $semNotificacao = "";
        foreach ($suspensoes as $row) {
            $suspensao = $this->suspender->filtro_id(array(
                array('campo' => 'CD_SUSPENSAO', 'valor' => $row)
            ));

            //obter responsáveis que serão notificados
            $responsaveis = $this->responsavel->listar_token(array(
                'aluno' => $suspensao->CD_ALUNO
            ));

            //obter o nome de alunos que não houve notificação
            if (empty($responsaveis)) {
                $semNotificacao .= $suspensao->NM_ALUNO . "<br>";
                continue;
            }

            //obter todos os tokens dos responsaveis do aluno
            $tokens = array();
            foreach ($responsaveis as $resp) {
                $tokens[] = $resp['TOKEN_GCM'];
            }

            $gcm->reg_id = $tokens;
            $gcm->titulo = 'SUSPENSÃO';
            $gcm->mensagem = $suspensao->MOTIVO;
            $gcm->dados = array(
                'cd_suspensao' => $suspensao->CD_SUSPENSAO,
                'periodo' => $suspensao->PERIODO,
                'cd_aluno' => $suspensao->CD_ALUNO,
                'dt_inicio' => $suspensao->DT_INICIO,
                'dt_fim' => $suspensao->DT_FIM,
                'flg_web' => $suspensao->FLG_WEB,
                'flg_ativo' => $suspensao->FLG_ATIVO,
                'cd_usuario' => $suspensao->CD_USUARIO,
                'dt_cadastro' => $suspensao->DT_CADASTRO,
                'dc_motivo' => $suspensao->MOTIVO,
                'flg_notificar' => $suspensao->FLG_NOTIFICAR,
                'flg_lido' => $suspensao->FLG_LIDO
            );
            //$gcm->comunicado();
        }

        if (!empty($semNotificacao)) {
            $semNotificacao = "Mas os responsáveis dos seguintes alunos não possuem o aplicativo:<br><br>" . $semNotificacao;
        }

        return $semNotificacao;
    }

}
