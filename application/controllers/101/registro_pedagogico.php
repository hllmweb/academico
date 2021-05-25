<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Registro_pedagogico extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('sica/cursos_model', 'cursos', TRUE);
        $this->load->model('sica/responsavel_model', 'responsavel', TRUE);

        $this->load->model('sica/aluno_model', 'aluno', TRUE);
        $this->load->model('academico/aes_tipo_registro_model', 'tipo', TRUE);
        $this->load->model('academico/aes_orientacao_registro_model', 'registro', TRUE);
        $this->load->model('sica/t_periodos_model', 'periodos', TRUE);

        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'session', 'tracert', 'gcm_lib'));
    }

    function index() {

        $log = new Tracert();
        $log->usuario = $this->session->userdata('USU_CODIGO');
        $log->validar_url();

        $data = array(
            'titulo' => 'MÓDULO DE ORIENTAÇÃO',
            'SubTitulo' => 'REGISTRO PEDAGÓGICO',
            'curso' => $this->cursos->listar(),
            'periodo' => $this->periodos->listar(),
            'side_bar' => false
        );
        $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/registro_pedagogico/index', $data);
    }

    function grdRegistro() {

        $param = array(
            'periodo' => $this->input->post('periodo'),
            'curso' => $this->input->post('curso'),
            'serie' => $this->input->post('serie'),
            'turma' => $this->input->post('turma'),
        );

        $data = array(
            'lista' => $this->registro->listar_turma($param)
        );
        $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/registro_pedagogico/grdRegistro', $data);
    }

    function mdlRegistro($id) {

        $item = explode('-', $id);

        $data = array(
            'operacao' => $item[0],
            'codigo' => (($item[1] != '') ? $item[1] : 0),
            'tipo' => $this->tipo->listar(),
            'curso' => $this->cursos->listar(),
            'filtro' => $this->registro->filtro(array('codigo' => $item[1])),
        );
        $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/registro_pedagogico/mdlRegistro', $data);
    }

    function mdlRegistroAluno($id) {

        $data = array(
            'lista' => $this->registro->listar(array('aluno' => $id))
        );
        $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/registro_pedagogico/mdlRegistroAluno', $data);
    }

    function frmManter() {
        
        $result = array(
            'success' => false,
            'titulo' => "Ocorreu um erro ao processar o registro.",
            'mensagem' => ''
        );
        //rodneia
        $registros = array();
        $data = array(
            'operacao' => $this->input->post('operacao'),
            'codigo' => $this->input->post('codigo'),
            'tipo' => $this->input->post('tipo'),
            'aluno' => $this->input->post('aluno'),
            'data' => $this->input->post('data'),
            'descricao' => $this->input->post('descricao'),
            'periodo' => $this->session->userdata('SGP_PERIODO'),
            'usuario' => $this->session->userdata('SGP_CODIGO'),
        );

        $operacao = $this->input->post('operacao');
        switch ($operacao) {
            case 'A':

                $al = $this->input->post('aluno');

                if ($al[0] == '') {
                    echo $retorno = '<label class="text-danger">Selecione o(s) ALUNO(s) </label>';
                    exit;
                }
                foreach ($this->input->post('aluno') as $al) {
                    $data = array(
                        'operacao' => $this->input->post('operacao'),
                        'codigo' => $this->input->post('codigo'),
                        'tipo' => $this->input->post('tipo'),
                        'aluno' => $al,
                        'sms' => 'N',
                        'data' => $this->input->post('data'),
                        'periodo' => $this->session->userdata('SGP_PERIODO'),
                        'usuario' => $this->session->userdata('SGP_CODIGO'),
                        'descricao' => $this->input->post('descricao'),
                        'notificar' => $this->input->post('notificar'),
                    );
                    $this->registro->adicionar($data);
                    $registros[] = $this->registro->max("CD_REGISTRO");
                }

                $result['success'] = true;
                $result['titulo'] = 'Registro(s) Adicionado(s)';
                break;

            case 'E':
                $this->registro->editar($data);

                $registros[] = $data['codigo'];

                $result['success'] = true;
                $result['titulo'] = 'Registros Editados';
                break;

            case 'D':
                $data = array(
                    'operacao' => $this->input->post('operacao'),
                    'codigo' => $this->input->post('codigo')
                );

                $this->registro->deletar($data);

                $result['success'] = true;
                $result['titulo'] = 'Registros Excluídos';
                break;
        }

        if (($operacao == "A" || $operacao == "E") &&
                $this->input->post('notificar') == 'S' &&
                $result['success']) {
            $result['mensagem'] = $this->notificar($registros);
        }

        echo json_encode($result);
    }

    /**
     * Função que irá realizar a notificação do registro pedagógico para os 
     * responsaveis do aluno.
     * 
     * @param int[] $registros
     * @return string Retorna uma string com o nome do aluno que não foi possível
     * enviar notificação para o responsável. String vazia caso contrário.
     */
    private function notificar($registros) {
        $gcm = new Gcm_lib();

        $semNotificacao = "";
        foreach ($registros as $row) {
            $registro = $this->registro->filtro_id(array(
                array('campo' => 'CD_REGISTRO', 'valor' => $row)
            ));

            //obter responsáveis que serão notificados
            $responsaveis = $this->responsavel->listar_token(array(
                'aluno' => $registro->CD_ALUNO
            ));

            //obter o nome de alunos que não houve notificação
            if (empty($responsaveis)) {
                $semNotificacao .= $registro->NM_ALUNO . "<br>";
                continue;
            }

            //obter todos os tokens dos responsaveis do aluno
            $tokens = array();
            foreach ($responsaveis as $resp) {
                $tokens[] = $resp['TOKEN_GCM'];
            }

            //notificar cada um dos reponsáveis do aluno
            $gcm->reg_id = $tokens;
            $gcm->titulo = 'REGISTRO PEDAGÓGICO';
            $gcm->mensagem = $registro->DS_REGISTRO;
            $gcm->dados = array(
                'cd_registro' => $registro->CD_REGISTRO,
                'cd_aluno' => $registro->CD_ALUNO,
                'cd_tipo_registro' => $registro->CD_TIPO_REGISTRO,
                'ds_registro' => $registro->DS_REGISTRO,
                'flg_sms_aviso' => $registro->FLG_SMS_AVISO,
                'cd_usuario' => $registro->CD_USUARIO,
                'dt_registro' => $registro->DT_REGISTRO,
                'periodo' => $registro->PERIODO,
                'flg_ativo' => $registro->FLG_ATIVO,
                'dt_cadastro' => $registro->DT_CADASTRO,
                'opcao_registro' => $registro->OPCAO_REGISTRO,
                'status' => $registro->STATUS,
                'fl_lido' => $registro->FL_LIDO,
                'flg_notificar' => $registro->FLG_NOTIFICAR
            );
            //$gcm->comunicado();
        }

        if (!empty($semNotificacao)) {
            $semNotificacao = "Mas os responsáveis dos seguintes alunos não possuem o aplicativo:<br><br>" . $semNotificacao;
        }

        return $semNotificacao;
    }

}
