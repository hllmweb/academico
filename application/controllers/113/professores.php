<?php

// TO_CHAR(DT_AULA,'MM/YYYY') = '07/2015' AND HR_ABERTURA IS NULL AND CD_PROFESSOR = 555395
// TO_CHAR(DT_AULA,'DD/MM/YYYY') = '31/10/2015'  AND CD_PROFESSOR = 555397


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Professores extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('academico_model', 'academico', TRUE);
        $this->load->model('professor_model', 'professor', TRUE);
        $this->load->model('113/diario_model', 'diario', TRUE);

        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'Menu_lib', 'diario_lib'));
    }

    function index() {
        $data = array(
            'TituloSistema' => 'COORDENADORES',
            'titulo' => 'ACADÊMICO',
            'SubTitulo' => 'PROFESSORES',
            'professor' => $this->academico->consultas(array('operacao' => 'PRF')),
            'side_bar' => false
        );


        $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/professores/index', $data);
    }

    function grdAcompanhamentoProfessor() {
        $consultar = $this->input->post('consultar');

        if (strpos($consultar, '-') !== FALSE) {
            $aux = explode("-", $consultar);
            $bimestre = $aux[0];
            $tipoNota = $aux[1];

            //obter apenas os conteudos que foram agendados para uma nota e bimestre
            $result = $this->diario->aes_conteudo_ministrado(array(
                'operacao' => 'LCN',
                'bimestre' => $bimestre,
                'tipo_nota' => $tipoNota,
                'cd_disciplina' => $this->input->post('disciplina'),
                'cd_turma' => $this->input->post('turma')
            ));

            //obter os assuntos de livros            
            $conteudos = array();
            foreach ($result as $row) {
                $assuntos = $this->diario->sp_diario(array(
                    'operacao' => 'LAL',
                    'cl_aula' => $row['CD_CL_AULA'],
                ));
                $row['ASSUNTO_LIVRO'] = $assuntos;
                $conteudos[] = $row;
            }

            $data = array(
                'conteudos' => $conteudos,
            );

            $this->load->view('113/professores/grid_professor_conteudo', $data);
        }

        switch ($consultar) {
            case 'F': // FREQUENCIA
                $fdisc = $this->professor->aes_diario_online(
                        $a = array('operacao' => 'DT',
                    'turma' => $this->input->post('turma'),
                    'disciplina' => $this->input->post('disciplina'))
                );

                $p = array(
                    'periodo'    => $fdisc[0]['PERIODO'],
                    'curso'      => $fdisc[0]['CD_CURSO'],
                    'serie'      => $fdisc[0]['ORDEM_SERIE'],
                    'turma'      => $fdisc[0]['CD_TURMA'],
                    'disciplina' => $fdisc[0]['CD_DISCIPLINA'],
                    'professor'  => $this->input->post('professor'),
                );
               
                $data = array(
                    'lista' => $this->professor->cl_gera_diario_classe($p)
                );
                $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/professores/grdProfessorFrequencia', $data);

                break;
            case 'D': // DEMONSTRATIVO
                /* Chama a biblioteca Diario */
                $Diario_lib = new Diario_lib();

                /* passando parametros para a biblioteca */
                $Diario_lib->disciplina = $this->input->post('disciplina');
                $Diario_lib->turma = $this->input->post('turma');
                $Diario_lib->periodo = $this->session->userdata('SGP_PERIODO');
                $data = array(
                    'lista' => $Diario_lib->notas_turma_disciplina()
                );
                $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/professores/grdProfessorDemonstrativo', $data);
            break;
            case 'B': // BOLETIM
                /* Chama a biblioteca Diario */
                $Diario_lib = new Diario_lib();

                /* passando parametros para a biblioteca */
                $Diario_lib->disciplina = $this->input->post('disciplina');
                $Diario_lib->turma      = $this->input->post('turma');
                $Diario_lib->periodo    = $this->session->userdata('SGP_PERIODO');
                $data = array(
                    'lista' => $Diario_lib->notas_turma_disciplina()
                );
                $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/professores/grdProfessorBoletim', $data);
            break;
            case 'C':
                $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/professores/grdProfessorConteudo', $data);
            break;
        }
    }

    /**
     * Retorna os valores da combo que informa o que será consultado.
     * 
     * @return array
     */
    public function combo_consultar() {
        $notas = $this->diario->sp_notas(array(
            'operacao' => 'LTN',
            'cd_turma' => $this->input->post('turma'),
        ));

        $combo = "<option value=''></option>";
        $combo .= "<option value='D'>DEMONSTRATIVO DE NOTAS</option>";
        $combo .= "<option value='B'>BOLETIM</option>";
        $combo .= "<option value='F'>FREQUÊNCIA</option>";

        if (count($notas) > 0) {
            $combo .= "<optgroup label='Conteúdo Provas'>";
            foreach ($notas as $nota) {
                $descricao = $nota['BIMESTRE'] . "° Bimestre" . " - " . $nota['NM_MINI'];
                $value = $nota['BIMESTRE'] . "-" . $nota['CD_TIPO_NOTA'];
                $combo .= "<option value='" . $value . "'>" . $descricao . "</option>";
            }
            $combo .="</optgroup>";
        }

        echo $combo;
    }

}
