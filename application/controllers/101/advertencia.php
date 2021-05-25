<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Advertencia extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('sica/cursos_model', 'cursos', TRUE);
        $this->load->model('sica/aluno_model', 'aluno', TRUE);
        $this->load->model('sica/aluno_advertencia_model', 'adverter', TRUE);
        $this->load->model('sica/t_periodos_model', 'periodos', TRUE);
        $this->load->model('sica/responsavel_model', 'responsavel', TRUE);

        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'session', 'tracert', 'gcm_lib'));

        $this->lang->load('sistema', $this->session->userdata('SGP_LANG'));
    }

    function index() {

        $log = new Tracert();
        $log->usuario = $this->session->userdata('USU_CODIGO');
        $log->validar_url();

        $data = array(
            'titulo' => 'MÓDULO DE ORIENTAÇÃO',
            'SubTitulo' => 'ADVERTÊNCIA',
            'side_bar' => false,
            'curso' => $this->cursos->listar(),
            'periodo' => $this->periodos->listar(),
        );
        $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/advertencia/index', $data);
    }

    function grdRegistro() {
        $param = array(
            'curso' => $this->input->post('curso'),
            'serie' => $this->input->post('serie'),
            'turma' => $this->input->post('turma'),
            'periodo' => $this->input->post('periodo'),
        );
        $data = array(
            'lista' => $this->adverter->listar_turma($param)
        );
        $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/advertencia/grdRegistro', $data);
    }

    function mdlRegistro($id) {
        $item = explode('-', $id);
        $data = array(
            'operacao' => $item[0],
            'codigo' => (($item[1] != '') ? $item[1] : 0),
            'curso' => $this->cursos->listar(),
            'filtro' => $this->adverter->filtro(array('codigo' => $item[1])),
        );
        $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/advertencia/mdlRegistro', $data);
    }

    function mdlRegistroAluno($id) {

        $data = array(
            'lista' => $this->adverter->listar(array('aluno' => $id))
        );
        $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/advertencia/mdlRegistroAluno', $data);
    }

    function frmManter() {
        $result = array(
            'success' => false,
            'titulo' => "Ocorreu um erro ao processar a advertência.",
            'mensagem' => ''
        );

        $advertencias = array();

        $param = array(
            'codigo' => $this->input->post('codigo'),
            'tipo' => $this->input->post('tipo'),
            'data' => $this->input->post('data'),
            'motivo' => $this->input->post('motivo'),
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
                        'tipo' => $this->input->post('tipo'),
                        'data' => $this->input->post('data'),
                        'motivo' => $this->input->post('motivo'),
                        'notificar' => $this->input->post('notificar'),
                    );

                    $this->adverter->adicionar($param);
                    $advertencias[] = $this->adverter->max("CD_ADVERTENCIA");
                }

                $result['success'] = true;
                $result['titulo'] = "Advertência Processada!";
                break;
            case 'E':
                $advertencias[] = $param['codigo'];
                $retorno = $this->adverter->editar($param);

                $result['success'] = true;
                $result['titulo'] = "Advertência Atualizada!";
                break;
            case 'D':
                $retorno = $this->adverter->deletar($param);

                $result['success'] = true;
                $result['titulo'] = "Advertência Excluída!";
                break;
        }

        if (($operacao == "A" || $operacao == "E") &&
                $this->input->post('notificar') == 'S' &&
                $result['success']) {
            $result['mensagem'] = $this->notificar($advertencias);
        }

        echo json_encode($result);
    }

    function termo($id) {
        $item = explode('-', $id);

        $data = array(
            'dados' => $this->adverter->filtro(array('codigo' => $item[0]))
        );
        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF();

        if ($item[1] == 'D') {
            $body = $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/advertencia/termo_disciplinar', $data, true);
        } elseif ($item[1] == 'P') {
            $body = $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/advertencia/termo_pedagogico', $data, true);
        }

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
        $mpdf->Output('TERMO-DE-ADVERTENCIA-' . str_replace(' ', '_', $data['dados']->NM_ALUNO) . '.pdf', 'I');
    }

    /**
     * Função que irá realizar a notificação da advertencia para os responsaveis
     * do aluno
     * 
     * @param int[] $advertencias
     * @return string Retorna uma string com o nome do aluno que não foi possível
     * enviar notificação para o responsável. String vazia caso contrário.
     */
    private function notificar($advertencias) {
        $gcm = new Gcm_lib();

        $semNotificacao = "";
        foreach ($advertencias as $row) {
            $advertencia = $this->adverter->filtro_id(array(
                array('campo' => 'CD_ADVERTENCIA', 'valor' => $row)
            ));

            //obter responsáveis que serão notificados
            $responsaveis = $this->responsavel->listar_token(array(
                'aluno' => $advertencia->CD_ALUNO
            ));

            //obter o nome de alunos que não houve notificação
            if (empty($responsaveis)) {
                $semNotificacao .= $advertencia->NM_ALUNO . "<br>";
                continue;
            }

            //obter todos os tokens dos responsaveis do aluno
            $tokens = array();
            foreach ($responsaveis as $resp) {
                $tokens[] = $resp['TOKEN_GCM'];
            }

            //notificar cada um dos reponsáveis do aluno
            $gcm->reg_id = $tokens;
            $gcm->titulo = 'ADVERTÊNCIA';
            $gcm->mensagem = $advertencia->MOTIVO;
            $gcm->dados = array(
                'cd_advertencia' => $advertencia->CD_ADVERTENCIA,
                'periodo' => $advertencia->PERIODO,
                'cd_aluno' => $advertencia->CD_ALUNO,
                'flg_tipo' => $advertencia->FLG_TIPO,
                'id_responsavel' => $advertencia->ID_RESPONSAVEL,
                'dt_advertencia' => $advertencia->DT_ADVERTENCIA,
                'cd_usuario' => $advertencia->CD_USUARIO,
                'dt_cadastro' => $advertencia->DT_CADASTRO,
                'dc_motivo' => $advertencia->MOTIVO,
                'flg_ativo' => $advertencia->FLG_ATIVO,
                'flg_lido' => $advertencia->FLG_LIDO,
                'flg_notificar' => $advertencia->FLG_NOTIFICAR
            );
            //$gcm->comunicado();
        }

        if (!empty($semNotificacao)) {
            $semNotificacao = "Mas os responsáveis dos seguintes alunos não possuem o aplicativo:<br><br>" . $semNotificacao;
        }

        return $semNotificacao;
    }

}
