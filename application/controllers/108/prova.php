<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Prova extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("sica/aval_prova_calendario_model", "calendario", true);
        $this->load->model('sica/cursos_model', 'curso', true);
        $this->load->model('sica/turma_model', 'turma', true);

        $this->load->model('prova_model', 'banco', TRUE);
        $this->load->model('cadastro_model', 'cadastro', TRUE);
        $this->load->model('geral/secretaria_model', 'secretaria', TRUE);
        $this->load->model('geral/colegio_model', 'colegio', TRUE);

        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'session', 'prova_lib'));
    }

    function index() {
        $data = array(
            'curso' => $this->secretaria->aluno_turma(array('operacao' => 'C')),
            'titulo' => 'BANCO DE PROVAS',
            'SubTitulo' => 'BANCO DE PROVAS',
            'TituloSistema' => 'GERENCIADOR DE AVALIAÇÕES',
            'tipo_prova' => $this->banco->banco_prova(array('operacao' => 'TP')),
            'side_bar' => false
        );

        $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/provas/index', $data);
    }

    /*
     * FUNÇÃO QUE MOSTRA O RESULTADO DA CONSULTA DA PAGINA INDEX DO BANCO DE PROVAS
     */

    function grdProva() {
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

        $data = array(
            'resultado' => $this->banco->banco_prova($p),
        );
        $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/provas/grdProva', $data);
    }

    /**
     * FUNÇÃO PARA MONTAR UMA NOVA PROVA
     */
    function frmNovaProva() {
        $data = array(
            'curso' => $this->curso->listar(),
            'titulo' => 'BANCO DE PROVAS',
            'SubTitulo' => 'CALENDÁRIO DE PROVAS',
        );

        $this->load->view($this->session->userdata('SGP_SISTEMA') . '/provas/frmNovaProva', $data);
    }

    /**
     * Função que irá retornar os registros do calendário de provas.
     *
     * @return json
     */
    function calendario() {
        $inicio = $this->input->post("inicio");
        $fim = $this->input->post("fim");
        $bimestre = $this->input->post("bimestre");
        $curso = $this->input->post("curso");
        $serie = $this->input->post("serie");

        $params = array(
            array("campo" => "DT_PROVA BETWEEN TO_DATE('" . $inicio . "', 'YYYY-MM-DD') "
                . "AND TO_DATE('" . $fim . "','YYYY-MM-DD')", "valor" => ""),
        );

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
                'modal' => site_url($this->session->userdata('SGP_SISTEMA') . "/prova/mdlDetalhesCalendario/" . $row->CD_CALENDARIO),
                'start' => date("Y-m-d", strtotime($row->DT_PROVA)),
                'color' => $row->CD_PROVA === null ? "#d9534f" : "#5cb85c",
            );

            $response[] = $aux;
        }

        echo json_encode($response);
    }



    /**
     * Função que irá exibir um modal com detalhes de uma prova do calendário.
     */
    function mdlDetalhesCalendario($codigo) {
        $calendario = $this->calendario->filtro_id(array(
            array("campo" => "CD_CALENDARIO", "valor" => $codigo)
        ));

        $estrutura = $this->turma->filtro_id(array(
            array('campo' => 'CD_TURMA', 'valor' => $calendario->CD_TURMA),
            array('campo' => 'PERIODO', 'valor' => $calendario->PERIODO)
        ));

        $data = array(
            'calendario' => $calendario,
            'estrutura' => $estrutura
        );

        $this->load->view($this->session->userdata('SGP_SISTEMA') . '/provas/mdlDetalhesCalendario', $data);
    }

    function frmManterProvas() {

        // RECEBE OS DADOS DO FORMULARIO
        $params = array(
            'operacao' => $this->input->post('txtOperacao'),
            'avalResultado' => $this->input->post('avalResultado'),
            'prova' => $this->input->post('avalProva'),
            'num_prova' => $this->input->post('avalNumProva'),
            'curso' => $this->input->post('avalCurso'),
            'serie' => $this->input->post('avalSerie'),
            'bimestre' => $this->input->post('avalBimestre'),
            'chamada' => $this->input->post('avalChamada'),
            'estrutura' => $this->input->post('avalEstrutura'),
            'tipo_nota' => $this->input->post('avalTipoNota'),
            'num_nota' => $this->input->post('avalNumNota'),
            'data_prova' => $this->input->post('avalDataProva'),
            'hora_inicio' => $this->input->post('horaInicio'),

            'hora_fim' => $this->input->post('horaFim'),
            'titulo' => strtoupper($this->input->post('avalTitulo')),
            'professor' => $this->input->post('avalProfessor'),
            'flg_pend' => 1,
            'flg_web' => 0,
            'anuladas' => 1,
            'usuario' => $this->session->userdata('CES_CODIGO'),
            'tipo_prova' => $this->input->post('avalTipoProva'),
            /* NOTAS REFERENTES A PROVA OBJETIVA  */
            'avalQtdeObj' => (($this->input->post('avalQtdeObj') == '') ? 0 : $this->input->post('avalQtdeObj')),
            'avalTTPontoObj' => (($this->input->post('avalTTPontoObj') == '') ? 0 : $this->input->post('avalTTPontoObj')),
            'avalVlQuestaoObj' => (($this->input->post('avalVlQuestaoObj') == '') ? 0 : $this->input->post('avalVlQuestaoObj')),
            /* NOTAS REFERENTES A PROVA OBJETIVA  */
            'avalQtdeDis' => (($this->input->post('avalQtdeDis') == '') ? 0 : $this->input->post('avalQtdeDis')),
            'avalTTPontoDis' => (($this->input->post('avalTTPontoDis') == '') ? 0 : $this->input->post('avalTTPontoDis')),
            'avalVlQuestaoDis' => (($this->input->post('avalVlQuestaoDis') == '') ? 0 : $this->input->post('avalVlQuestaoDis')),
            'avalFormato' => $this->input->post('avalFormato')

        );

        /*REFATORAR E INSERIR OPERACAO NA PROCEDURE*/
        if($this->input->post('txtOperacao') == "I"){

             $this->db->where('CD_PROVA',$this->input->post('avalProva'));
             $this->db->set('MIN_LIBERACAO',$this->input->post('minLiberacao'));
             $this->db->insert('BD_SICA.AVAL_PROVA');


        }elseif($this->input->post('txtOperacao') == "U"){

             $this->db->where('CD_PROVA',$this->input->post('avalProva'));
             $this->db->set('MIN_LIBERACAO',$this->input->post('minLiberacao'));
             $this->db->update('BD_SICA.AVAL_PROVA');
        }

        // VERIFICA O TIPO DA OPERAÇÃO A SER REALIZADA
         $r = $this->banco->banco_prova($params);
         $this->db->set('LIB_NOTA', $this->input->post('gerarNota'));
         $this->db->where('CD_PROVA',$this->input->post('avalProva'));
         $this->db->update('BD_SICA.AVAL_PROVA');

        if (!empty($r)) {
            $keys = array(
                array('campo' => 'CD_CALENDARIO', 'valor' => $this->input->post('avalCalendario'))
            );

            $params = array(
                array('campo' => 'CD_PROVA', 'valor' => $r)
            );

            $this->calendario->editar($keys, $params);
        }

        switch ($this->input->post('txtOperacao')) {
            case 'I':
                redirect('' . $this->session->userdata('SGP_SISTEMA') . '/prova/frmNovaProvaConfiguracao/' . $r . '', 'refresh');
                break;
            case 'U':
                print_r($params);
                break;
        }
    }

	
	function frmManterProvaDisciplina_new() {
        $s = array(
            'operacao' => $this->input->post('operacao'),
            'prova' => $this->input->post('avalProva'),
            'disciplina' => $this->input->post('avalDisciplina'),
            'inicio' => $this->input->post('avalPosInicial'),
            'fim' => $this->input->post('avalPosFinal'),
            'peso' => 1,
            'tipo' => $this->input->post('avalTipoQuestoes'),
            'valor' => '0.0000', //$this->input->post('vlQuestao'),
			'id_aval_prova_disc' => $this->input->post('id_aval_prova_disc')	
        );

        
		
        $l = $this->banco->prova_disciplina_new($s);

	
        // VERIFICA O TIPO DA OPERAÇÃO A SER REALIZADA
        switch ($this->input->post('operacao')) {
            case 'I':
                print_r($params);
                break;
            case 'C':
                print_r($params);
                break;
        }
    }
	
	
    function frmManterProvaDisciplina() {
        $s = array(
            'operacao' => $this->input->post('operacao'),
            'prova' => $this->input->post('avalProva'),
            'disciplina' => $this->input->post('avalDisciplina'),
            'inicio' => $this->input->post('avalPosInicial'),
            'fim' => $this->input->post('avalPosFinal'),
            'peso' => 1,
            'tipo' => $this->input->post('avalTipoQuestoes'),
            'valor' => $this->input->post('vlQuestao'),
        );
        $l = $this->banco->prova_disciplina($s);

        // VERIFICA O TIPO DA OPERAÇÃO A SER REALIZADA
        switch ($this->input->post('operacao')) {
            case 'I':
                print_r($params);
                break;
            case 'C':
                print_r($params);
                break;
        }
    }

    /*MOSTRA DETALHES*/
    function frmNovaProvaConfiguracao($id) {

        $this->session->set_userdata('SGP_PROVA_ATUAL', $id);

        $prova = $this->banco->banco_prova(array('operacao' => 'VFC', 'prova' => $id));



        $professor = $this->secretaria->aluno_turma(array(
                                    'operacao'      => 'PS', 
                                    'turma'         => $prova[0]['CD_TURMA'],
                                    'disciplina'    => $prova[0]['CD_DISCIPLINA']
                                ));

        
        //var_dump($professor);


        //echo $prova[0]['CD_TURMA']." - ".$prova[0]['CD_DISCIPLINA'];
        
       
        $data = array(
            // INICIO DE RECUPERAÇÃO DE  DADOS
            'prova' => $prova,
            'curso' => $this->secretaria->aluno_turma(array('operacao' => 'C')),
            'serie' => $this->secretaria->aluno_turma(array('operacao' => 'S', 'curso' => $prova[0]['CD_CURSO'])),
            'tipo_nota' => $this->colegio->aes_colegio($a = array('operacao' => 'NF', 'curso' => $prova[0]['CD_CURSO'], 'bimestre' => $prova[0]['BIMESTRE'])),
            //'professor' => $this->secretaria->aluno_turma(array('operacao' => 'PS')),
            'professor'  => $professor,
            'disciplina' => $this->secretaria->aluno_turma(array('operacao' => 'DE', 'curso' => $prova[0]['CD_CURSO'], 'ordem' => $prova[0]['ORDEM_SERIE'])),
            'prova_disciplina' => $this->banco->prova_disciplina(array('operacao' => 'FD', 'prova' => $prova[0]['CD_PROVA'])),
            'prova_candidatos' => $this->banco->prova_alunos(array('operacao' => 'LA', 'prova' => $prova[0]['CD_PROVA'])),
            'prova_versoes' => $this->banco->banco_prova(array('operacao' => 'FVERSAO', 'prova' => $prova[0]['CD_PROVA'])),
            // -- FIM
            'tipo_prova' => $this->banco->banco_prova(array('operacao' => 'TP')),
            'titulo' => 'CONFIGURAÇÃO DA PROVA <strong style="font-size:16px">Nº ' . $this->session->userdata('SGP_PROVA_ATUAL') . '</strong>',
            'TituloSistema' => 'GESTOR DE PROVAS',
            'side_bar' => false
        );

        $data['gerar_nota'] = $this->db->query('SELECT LIB_NOTA FROM BD_SICA.AVAL_PROVA WHERE CD_PROVA = '.$id);



        $data['exibe_resultado'] =  $this->db->query("SELECT FLG_EXIBE_RESULTADO FROM BD_SICA.AVAL_PROVA_CALENDARIO WHERE
                                 CD_PROVA = '".$id."'");

       // echo "<pre>";
       // print_r($data);exit;
        $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/provas/frmNovaProvaConfiguracao', $data);
    }

    /*
     * FUNÇÃO QUE MOSTRA A LISTA DE DISCIPLINAS DA PROVA
     */

    function grdDisciplinasProva() {

        $p = array(
            'operacao' => 'FCN',
            'tipo_prova' => $this->input->post('tipo'),
            'curso' => $this->input->post('curso'),
            'serie' => $this->input->post('serie'),
            'disciplina' => $this->input->post('disciplina'),
            'bimestre' => $this->input->post('bimestre'),
            'num_nota' => $this->input->post('nota'),
        );
        $data = array(
            'resultado' => $this->banco->banco_prova($p),
        );
        $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/provas/grdDisciplinasProva', $data);
    }

    /*
     * FUNÇÃO QUE CHAMA O MODAL DISCIPLINAS
     */

    function mdlDisciplinasProva() {

        $p = array(
            'operacao' => 'FDP',
            'prova' => $this->input->get('prova'),
            'disciplina' => $this->input->get('disciplina'),
            'tipo' => $this->input->get('tipo')
        );


        $disciplina_id = $this->banco->prova_disciplina(array(
                'operacao' => 'LT',
                'prova'    => $this->input->get('prova')
        ));

        $data = array(
            'operacao' => $this->input->get('operacao'),
            'prova' => $this->input->get('prova'),
            'tipo_prova' => $this->input->get('tipo'),
            'filtro' => $this->banco->prova_disciplina($p),
            'disciplina' => $this->secretaria->aluno_turma(
                array('operacao' => 'DE', 
                      'curso' => $this->input->get('curso'), 
                      'ordem' => $this->input->get('serie')
                    )
            ),
            'disciplina_id' => $disciplina_id

        );



        $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/provas/mdlDisciplinasProva', $data);
    }

    function frmProvaMontarQuestoes() {

        $this->session->set_userdata('SGP_PROVA_ATUAL', $this->input->get('prova'));
        $this->session->set_userdata('SGP_DISCIPLINA_ATUAL', $this->input->get('disciplina'));

        $prova = $this->banco->banco_prova(array('operacao' => 'VFC', 'prova' => $this->session->userdata('SGP_PROVA_ATUAL')));
        $questoes = $this->banco->prova_questao(array('operacao' => 'FD', 'prova' => $prova[0]['CD_PROVA'], 'disciplina' => $this->session->userdata('SGP_DISCIPLINA_ATUAL')));

        // var_dump($prova);
        // var_dump($questoes);

        $lista = array();
        foreach ($questoes as $q) {
            $lista[] = array(
                'codigo' => $q['CD_QUESTAO'],
                'questao' => $q['DC_QUESTAO'],
                'tipo' => $q['FLG_TIPO'],
                'disciplina' => $this->session->userdata('SGP_DISCIPLINA_ATUAL'),
                'posicao' => $q['POSICAO'],
                'nivel' => $q['DIFICULDADE'],
                'usuario' => $q['CADASTROU'],
                'dia' => $q['CADASTROU_EM'],
                'prova' => $prova[0]['CD_PROVA'],
                'opcao' => $this->cadastro->questao_resposta(array('operacao' => 'FK', 'questao' => $q['CD_QUESTAO'])),
                'conteudo' => $this->cadastro->questao_conteudo(array('operacao' => 'FK', 'questao' => $q['CD_QUESTAO'])),
            );
        }

        $data = array(
            'prova' => $prova,
            'titulo' => 'CONFIGURAÇÃO DE PROVA :: QUESTÕES DA PROVA <strong style="font-size:16px">Nº ' . $this->session->userdata('SGP_PROVA_ATUAL') . '</strong>',
            'tema' => $this->cadastro->tema(array('operacao' => 'FN', 'curso' => $prova[0]['CD_CURSO'], 'serie' => $prova[0]['ORDEM_SERIE'], 'disciplina' => $this->session->userdata('SGP_DISCIPLINA_ATUAL'))),
            'listar' => $lista,
            'disciplina' => $this->session->userdata('SGP_DISCIPLINA_ATUAL'),
        );
       // echo "<pre>";
        //print_r($data); exit;
        $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/provas/frmProvaMontarQuestoes', $data);
    }

    function excluirVersoes() {


        $prova = $this->input->post('prova');

        $exclusao = $this->banco->excluirVersoes($prova);

        //echo $exclusao;
        // redirect('108/prova/index');
    }

    function verificaHorarioDuplicado(){

        $param = array( 'P_CD_PROVA' => $this->input->post('cd_prova') ,
                        'P_DATA' => $this->input->post('p_data'),
                        'P_HR_INICIO' => $this->input->post('hr_inicio'),
                        'P_CD_CURSO' => $this->input->post('cd_curso'),
                        'P_ORDEM_SERIE' => $this->input->post('ordem_serie')
                         );


      $verificaProvaDuplicada = $this->banco->modelVerificaHoraProva($param);

        if($verificaProvaDuplicada->result_array[0]['TITULO'] != ""){

            echo $verificaProvaDuplicada->result_array[0]['TITULO'];
        }
    }


}
