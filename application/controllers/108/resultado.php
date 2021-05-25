<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Resultado extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('cadastro_model', 'cadastro', TRUE);
        $this->load->model('prova_model', 'banco', TRUE);
        $this->load->model('108/questao_model', 'questao', TRUE);

        $this->load->model('academico/questao_opcao_model', 'quest_opcao', TRUE);
        $this->load->model('sica/aes_prova_questao_model', 'prova_questao', TRUE);
        $this->load->model('sica/aes_cartoes_lidos_model', 'cartoes', TRUE);
        $this->load->model('sica/aes_cl_alu_nota_model', 'notas', TRUE);

        $this->load->model('geral/secretaria_model', 'secretaria', TRUE);
        $this->load->model('geral/colegio_model', 'colegio', TRUE);
        $this->load->model('sica/t_periodos_model', 'periodo', TRUE);

        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'session', 'prova_lib', 'gabarito_lib', 'tracert'));
    }

    function index() {
        $log = new Tracert();
        $log->usuario = $this->session->userdata('USU_CODIGO');
        $log->validar_url();

        $data = array(
            'curso' => $this->secretaria->aluno_turma(array('operacao' => 'C')),
            'titulo' => 'GESTOR DE AVALIAÇÕES',
            'SubTitulo' => 'RESULTADOS',
            'tipo_prova' => $this->banco->banco_prova(array('operacao' => 'TP')),
            'periodo' => $this->periodo->listar(),
            'side_bar' => false
        );
        $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/resultado/index', $data);
    }

    function grdProva() {

        // VERIFICA O TIPO DE FILTRO
        if ($this->input->post('filtro') == 0) {
            $p = array(
                'operacao' => (($this->input->post('tipo') == 2) ? 'FCN' : 'FCNA'), //'FCN',
                'periodo' => $this->input->post('periodo'),
                'tipo_prova' => $this->input->post('tipo'),
                'curso' => $this->input->post('curso'),
                'serie' => $this->input->post('serie'),
                'disciplina' => (($this->input->post('disciplina') == '') ? NULL : $this->input->post('disciplina')),
                'bimestre' => (($this->input->post('bimestre') == '') ? NULL : $this->input->post('bimestre')),
                'tipo_nota' => (($this->input->post('tipo_nota') == '') ? NULL : $this->input->post('tipo_nota')),
                'chamada' => (($this->input->post('chamada') == '') ? NULL : $this->input->post('chamada')),
            );
        } else {
            $p = array(
                'operacao' => 'CHECK',
                'num_prova' => $this->input->post('numProva'),
            );
        }


        // FAZ AS CONSULTAS E ARMAZENA NA VARIAVEL RESULTADO
        $data = array(
            'resultado' => $this->banco->banco_prova($p),
        );
        $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/resultado/grdProva', $data);
    }

    function frmProvaObjetiva($id) {

        $item = explode('-', $id);

        $listar = $this->cartoes->prova_detalhe($item[1]);

        foreach ($listar as $l) {
            if ($l['P_OBJETIVA'] != '') {
                $param = array(
                    'aluno' => $l['CD_ALU_DISC'],
                    'num_nota' => $l['NUM_NOTA'],
                    'nota' => $l['P_OBJETIVA'],
                );
                if ($l['NOTA'] == '') {
                    // CASO NÃO HAJA NOTA LANÇADA
                    $this->notas->adicionar($param);
                } else {
                    // ATUALIZA A NOTA
                    $this->notas->editar($param);
                }
            }
        }
        // PROCESSAR PROVAS
        $p = array(
            'prova' => $item[1],
        );
        $this->cartoes->processar_prova($p);

        $data = array(
            'listar' => $this->cartoes->prova_detalhe($item[1]),
            'original' => $item[1]
        );
        $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/resultado/mdlDetalhes', $data);
    }

    function frmProvaSimulado($id) {

        $item = explode('-', $id);

        $listar = $this->cartoes->prova_detalhe_simulado($item[1]);

        foreach ($listar as $l) {
            if ($l['ACERTOS'] != '') {
                $param = array(
                    'aluno' => $l['CD_ALU_DISC'],
                    'num_nota' => $l['NUM_NOTA'],
                    'nota' => ($l['ACERTOS'] * $l['VALOR_QUESTAO']),
                );
                //print_r($param);
                if ($l['NOTA'] == '') {
                    // CASO NÃO HAJA NOTA LANÇADA
                    $this->notas->adicionar($param);
                } else {
                    // ATUALIZA A NOTA
                    $this->notas->editar($param);
                }
            }
        }
        $data = array(
            'listar' => $this->cartoes->prova_detalhe_simulado($item[1]),
            'original' => $item[1]
        );
        $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/resultado/mdlDetalhesSimulado', $data);
    }



    //exporta nota p/ o rm
    function exporta_nota(){
        $cd_prova_pai = $this->input->get_post('cd_prova_pai');

        $param = array(
            'cd_prova_pai'  => $cd_prova_pai
        );

        $query        = $this->banco->exporta_nota_rm($param);
        
        echo $query[0]['MENSAGEM'];
        //var_dump($query);

    }


    function mdlDetalhes($id) {

        $cod = explode('-', $id);

        if ($cod[0] == 2) {
            $listar = $this->cartoes->prova_detalhe($cod[1]);
        } else {
            $listar = $this->cartoes->prova_detalhe_simulado($cod[1]);
        }

////////////////////////////////////////////////////////////////////
        foreach ($listar as &$ane) {
            if($ane['NR_ERRO'] == NULL){
                $ne = 20 - intval($ane['NR_ACERTO']);
                $ane['NR_ERRO'] = strval($ne);
            }
        }


        $data = array(
            'listar' => $listar,
            'nota'   => $this->banco->banco_prova(array('operacao' => 'LIBNOTA_RM', 'pai' => $cod[1])),
            'listar_nao_fez' => $this->cartoes->prova_detalhe_fez_prova($cod[1]),
            'original' => $cod[1]
        );


        if ($cod[0] == 2) {
            $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/resultado/mdlDetalhes', $data);
        } else {
            $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/resultado/mdlDetalhesSimulado', $data);
        }
    }



    function pntDetalhes($id) {

        $cod = explode('-', $id);

        if ($cod[0] == 2) {
            $listar = $this->cartoes->prova_detalhe($cod[1]);
        } else {
            $listar = $this->cartoes->prova_detalhe_simulado($cod[1]);
        }

        $data = array(
            'listar' => $listar,
            'original' => $cod[1],
            'titulo' => 'RESULTADO DO PROCESSAMENTO'
        );

        if ($cod[0] == 2) {
            $body = $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/resultado/pntDetalhes', $data, true);
        } else {
            $body = $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/resultado/pntDetalhesSimulado', $data, true);
        }

        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF();

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
        $mpdf->Output('RESULTADOS-DA-PROVA-' . $listar[0]['NUM_PROVA'] . '.pdf', 'I');
    }

    function frmDetalhesAluno($id) {

        $item = explode('-', $id);

        $param = array(
            'aluno' => $item[0],
            'prova' => $item[1],
        );

        $data = array(
            'aluno' => $this->cartoes->prova_detalhe_aluno($param),
            'original' => $id
        );

        //var_dump($data);
        //$ProvaOnline = $this->cartoes->getRespostaProvaOnline($param['prova']);
        $ProvaOnline = $this->cartoes->getRespostaProvaOnline($param['prova'],$param['aluno']);
        //var_dump($ProvaOnline);

        if ($ProvaOnline[0]['FL_FORMATO'] == 'O' || $ProvaOnline[0]['FL_FORMATO'] == 'I'):
            foreach ($ProvaOnline as $Resp):
                $Valor    .= $Resp['VALOR'].","; 
                $Resposta .= $Resp['RESPOSTA'];
                $Gabarito .= $Resp['CORRETA'];
            endforeach;
            $data['aluno'][0]['VALOR']      = $Valor;
            $data['aluno'][0]['RESPOSTAS']  = $Resposta;
            $data['aluno'][0]['GABARITO']   = $Gabarito;
        endif;
        //var_dump($ProvaOnline);


        $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/resultado/frmDetalhesAluno', $data);
    }

}
