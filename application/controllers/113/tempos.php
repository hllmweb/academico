<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tempos extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        //$this->load->model('sica/cursos_model', 'curso', true);
        $this->load->model('sica/turma_model', 'turma', true);
        $this->load->model('rh/professor_model', 'professor', true);
        $this->load->model('rh/cl_turma_horario_log_model', 'horario_log', true);
        $this->load->model('rh/turma_horario_model', 'horario', true);
        $this->load->model('rh/cl_professor_horario_model', 'horario_pro', true);
        $this->load->model('sica/cl_grade_disciplinas_model', 'grade', true);
        
        
        $this->load->model('sica/turma_professor_model', 'turma_professor', true);

        $this->load->helper(array('url'));
        $this->load->library(array('session', 'tracert'));
    }

    function index()
    {
        //$log = new Tracert();
        //$log->validar_url();

        // LIMPA A SESSÃO QUE CONTEM O CODIGO DO ULTIMO PROFESSOR VISTO
        $this->session->unset_userdata('SGP_SEL_PROFESSOR');
        $this->session->unset_userdata('SGP_SEL_TURMA');
        
        $data = array(
            'titulo' => 'ACADÊMICO',
            'SubTitulo' => 'CALENDÁRIO DE EVENTOS'
        );

        $this->load->view($this->session->userdata('SGP_SISTEMA') . '/tempos/index', $data);
    }
    
    // FUNÇÃO PARA DIAS DA SEMANA POR EXTENSO
    private function semana($dia)
    {
        $string = '';
        switch ($dia){
            case 1: $string = 'Segunda'; break;
            case 2: $string = 'Terça';   break;
            case 3: $string = 'Quarta';  break;
            case 4: $string = 'Quinta';  break;
            case 5: $string = 'Sexta';   break;
            case 6: $string = 'Sábado';  break;
        }
        return $string;
    }

    /*************************************************/
    /**************************************************
                   HORARIO PROFESSOR
    **************************************************/
    /*************************************************/


    /*
     * Função:
     * Formulario para seleção do professor e seus horários
     * 
     * Tipo: 
     * MODAL
     */
    function mdlHorarioProfessor() 
    {
        $data = array(
            'professor' => $this->professor->filtrar(array(array('campo'=>'DT_DEMISSAO IS NULL'))),
        );
        $this->load->view($this->session->userdata('SGP_SISTEMA') . '/tempos/mdlHorarioProfessor', $data);
    }
    
    /*
     * Função:
     * Detalha os tempos de aula do professor e o histórico de mudanças
     * 
     * Tipo: 
     * TELA ( VIEW )
     */
    function frmHorarioProfessor()
    {

        $params = base64_decode($this->input->get('p'));
        $param  = json_decode($params);
        
        // COLOCA O CÓDIGO DO PROFESSOR DENTRO DE UMA SESSÃO
        $this->session->set_userdata('SGP_SEL_PROFESSOR', $param[0]->value);

        $plog = array(
            array('campo'=>'CD_PROFESSOR', 'valor'=>$param[0]->value),
            array('campo'=>'PERIODO', 'valor'=>$this->session->userdata('SGP_PERIODO')),
        );

        $data = array(
            'titulo' => 'ACADÊMICO',
            'SubTitulo' => 'HORÁRIOS',
            // Código do professor
            'codigo' => $param[0]->value,
            'professor' => $this->professor->pesquisar_id(array('campo'=>'CD_PROFESSOR', 'valor'=>$param[0]->value)),
            'horario_log' => $this->horario_log->filtrar($plog),
        );

        $this->load->view($this->session->userdata('SGP_SISTEMA') . '/tempos/frmHorarioProfessor', $data);
    }
    
    /*
     * Função:
     * Mostra um grid com os tempos de aula do professor ( Manha e Tarde) 
     * 
     * Tipo: 
     * DATAGRID
     */
    function datagridHorarioProfessor() 
    {
        
        $param = array(
            array('campo'=>'CD_PROFESSOR', 'valor'=> $this->session->userdata('SGP_SEL_PROFESSOR')),
            array('campo'=>'PERIODO', 'valor'=>$this->session->userdata('SGP_PERIODO')),
            array('campo'=>'( DT_FIM IS NULL OR TRUNC(DT_FIM) > TRUNC(SYSDATE) )', 'valor'=>''),
        );

        $horario = $this->horario_pro->filtrar($param);
        
         // Array com os os DETALHES dos Tempos da Manhã / Tarde
        $manha = array();
        $tarde = array();
        
         // Array com os CD_CL_TURMA_HORARIO dos Tempos da Manhã / Tarde
        $idmanha = array();
        $idtarde = array();
        
         // Arrays Ponteiros para identificar se o o Horario esta finalizando ou não.
        $manhacor = array();
        $tardecor = array();
        
        $disciplina = array();

        foreach($horario as $h){
            $turno = substr($h->TURNO_TEMPO,0,1);
            
            switch ($h->FLG_STATUS){
                case 'HORÁRIO FINALIZADO.': $color = 'bg-danger'; break;
                case 'HORÁRIO SEM PRAZO LIMITE ESTIPULADO.': $color = 'bg-success'; break;
                case 'HORÁRIO SENDO FINLIZADO.': $color = 'bg-warning'; break;
                case 'HORÁRIO DENTRO DO PRAZO LIMITE.': $color = 'bg-info'; break;
            }
            
            
            
            if($turno == 'A'){
                $manha[$turno][$h->DIA_SEMANA][$h->TEMPO_AULA] = '<div data-disciplina-id="'.$h->CD_DISCIPLINA.'"><span style="font-weight: bold">'.$h->NM_DISCIPLINA_REDUZIDO.'</span>'.
                    '<br/><small class="text-primary">'.$h->HR_INICIO.' - '.$h->HR_FIM.'</small><br/>'.
                    $h->CD_TURMA.'</div>';

                $idmanha[$turno][$h->DIA_SEMANA][$h->TEMPO_AULA] = $h->CD_CL_TURMA_HORARIO;
                $disciplina[$turno][$h->DIA_SEMANA][$h->TEMPO_AULA] = $h->CD_DISCIPLINA.$h->CD_PROFESSOR;
                $manhacor[$turno][$h->DIA_SEMANA][$h->TEMPO_AULA] = $color;

            }else{
                $tarde[$turno][$h->DIA_SEMANA][$h->TEMPO_AULA] = '<span style="font-weight: bold">'.$h->NM_DISCIPLINA_REDUZIDO.'</span>'.
                    '<br/><small>'.$h->HR_INICIO.' - '.
                    $h->HR_FIM.'</small><br/>'.
                    $h->CD_TURMA;

                $idtarde[$turno][$h->DIA_SEMANA][$h->TEMPO_AULA] = $h->CD_CL_TURMA_HORARIO;
                $disciplina[$turno][$h->DIA_SEMANA][$h->TEMPO_AULA] = $h->CD_DISCIPLINA.$h->CD_PROFESSOR;
                $tardecor[$turno][$h->DIA_SEMANA][$h->TEMPO_AULA] = $color;
            }
        }

        $data = array(
            'manha' => $manha,
            'tarde' => $tarde,
            'idmanha' => $idmanha,
            'idtarde' => $idtarde,
            'manhacor' => $manhacor,
            'tardecor' => $tardecor,
            'disciplina' => $disciplina
        );
        $this->load->view($this->session->userdata('SGP_SISTEMA') . '/tempos/datagridHorarioProfessor', $data);
    }

    /*
     * Função:
     * Detalha os tempos de aula do professor e o histórico de mudanças
     * 
     * Tipo: 
     * MODAL
     */
    function mdlProfessorHorarioTempo($tempo){

        $t = explode(':',$tempo);
        $dia = $this->semana($t[2]);

        $schema = 'BD_SICA';
        $table = 'AES_CL_HORARIO_VAGO_PROFESSOR';
        $cursor = '';
        $params = array(
            array('name' => ':P_TIPO',         'value' => 'P'),
            array('name' => ':P_DIA_SEMANA',   'value' => $t[2]),
            array('name' => ':P_TURNO_TEMPO',  'value' => ''.$t[0].$t[1].''),
            array('name' => ':P_CD_PROFESSOR', 'value' => $this->session->userdata('SGP_SEL_PROFESSOR')),
            array('name' => ':P_CD_TURMA',     'value' => ''),
            array('name' => ':RC1',            'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        $tempo = $this->horario->procedure($schema,$table,$params);


        $data = array(
            'titulo' => 'ACADÊMICO',
            'SubTitulo' => 'HORÁRIOS',
            'turno_extenso' => (($t[0] == 'A')? 'Manhã' : 'Tarde' ),
            'turno' => $t[0].$t[1],
            'tempo' => $t[1],
            'dia' => $t[2],
            'dia_extenso' => $dia,
            'professor' => $this->session->userdata('SGP_SEL_PROFESSOR'),
            'lista' => $tempo
        );

        $this->load->view($this->session->userdata('SGP_SISTEMA') . '/tempos/mdlProfessorHorarioTempo', $data);
    }
    
    /*
     * Função:
     * Formulario para Edição do tempo
     * 
     * Tipo: 
     * MODAL
     */
    function mdlHorarioEditarProfessor($id) 
    {
        $tempo = $this->horario_pro->pesquisar_id($ar = array('campo'=>'CD_CL_TURMA_HORARIO', 'valor'=> $id));

        $data = array(
            'titulo' => 'ACADÊMICO',
            'SubTitulo' => 'HORÁRIOS',
            'turno_extenso' => ((substr($tempo->TURNO_TEMPO,0,1) == 'A')? 'Manhã' : 'Tarde' ),
            'turno' => $tempo->TURNO_TEMPO,
            'tempo' => $tempo->TEMPO_AULA ,
            'turma' => $tempo->CD_TURMA,
            'dia' => $tempo->DIA_SEMANA,
            'dia_extenso' => $this->semana($tempo->DIA_SEMANA),
            'dados' => $tempo,
        );
        $this->load->view($this->session->userdata('SGP_SISTEMA') . '/tempos/mdlHorarioEditarProfessor', $data);
    }
    

    /*************************************************/
    /**************************************************
                   HORARIO TURMA
    **************************************************/
    /*************************************************/

    /*
     * Função:
     * Formulario para seleção do professor e seus horários
     * 
     * Tipo: 
     * MODAL
     */
    function mdlHorarioTurma() 
    {
        $param = array(
            array('campo'=>'PERIODO = (SELECT CL_PERIODO_ATUAL FROM BD_SICA.CONFIGURACAO)', 'valor' => ''),
            array('campo'=>'STATUS', 'valor' => 'A'),
        );
        $ordem = array('campo'=>'TIPO', 'valor' => "('N','X','L','+')");
        $data = array(
            'lista' => $this->turma->filtrar($param,$ordem),
        );
        $this->load->view($this->session->userdata('SGP_SISTEMA') . '/tempos/mdlHorarioTurma', $data);
    }

    /*
     * Função:
     * Detalha os tempos de aula do professor e o histórico de mudanças
     * 
     * Tipo: 
     * TELA ( VIEW )
     */
    function frmHorarioTurma()
    {

        $params = base64_decode($this->input->get('p'));
        $param  = json_decode($params);
        
        // COLOCA O CÓDIGO DO PROFESSOR DENTRO DE UMA SESSÃO
        $this->session->set_userdata('SGP_SEL_TURMA', $param[0]->value);

        $plog = array(
            array('campo'=>'CD_TURMA', 'valor'=>$param[0]->value),
            array('campo'=>'PERIODO', 'valor'=>$this->session->userdata('SGP_PERIODO')),
        );
        $ordem = array('campo'=>'NM_DISCIPLINA', 'ordem'=>'ASC');

        $data = array(
            'titulo' => 'ACADÊMICO',
            'SubTitulo' => 'HORÁRIOS',
            // Código da turma (CD_TURMA)
            'codigo' => $param[0]->value,
            // lista de professores
            'lista' => $this->turma_professor->filtrar($plog,$ordem),
            // Relação de logs de alteração da turma
            'horario_log' => $this->horario_log->filtrar($plog),
        );

        $this->load->view($this->session->userdata('SGP_SISTEMA') . '/tempos/frmHorarioTurma', $data);
    }

    /*
     * Função:
     * Mostra um grid com os tempos de aula do professor ( Manha e Tarde) 
     * 
     * Tipo: 
     * DATAGRID
     */
    function datagridHorarioTurma() 
    {
        
        $param = array(
            array('campo'=>'CD_TURMA', 'valor'=> $this->session->userdata('SGP_SEL_TURMA')),
            array('campo'=>'PERIODO', 'valor'=>$this->session->userdata('SGP_PERIODO')),
            array('campo'=>'(DT_FIM IS NULL OR TRUNC(DT_FIM) > TRUNC(SYSDATE))', 'valor'=>''),
        );
        
        $horario = $this->horario_pro->filtrar($param);
        
         // Array com os os DETALHES dos Tempos da Manhã / Tarde
        $manha = array();
        $tarde = array();
        
         // Array com os CD_CL_TURMA_HORARIO dos Tempos da Manhã / Tarde
        $idmanha = array();
        $idtarde = array();
        
         // Arrays Ponteiros para identificar se o o Horario esta finalizando ou não.
        $manhacor = array();
        $tardecor = array();
        
        $disciplina = array();

        foreach($horario as $h){
            $turno = substr($h->TURNO_TEMPO,0,1);
            
            switch ($h->FLG_STATUS){
                case 'HORÁRIO FINALIZADO.': $color = 'bg-danger'; break;
                case 'HORÁRIO SEM PRAZO LIMITE ESTIPULADO.': $color = 'bg-success'; break;
                case 'HORÁRIO SENDO FINLIZADO.': $color = 'bg-warning'; break;
                case 'HORÁRIO DENTRO DO PRAZO LIMITE.': $color = 'bg-info'; break;
            }
            
            
            
            if($turno == 'A'){
                $manha[$turno][$h->DIA_SEMANA][$h->TEMPO_AULA] = '<div data-disciplina-id="'.$h->CD_DISCIPLINA.'"><span style="font-weight: bold">'.$h->NM_DISCIPLINA_REDUZIDO.'</span>'.
                    '<br/><small class="text-primary">'.$h->HR_INICIO.' - '.$h->HR_FIM.'</small><br/>'.
                    $h->CD_TURMA.'</div>';

                $idmanha[$turno][$h->DIA_SEMANA][$h->TEMPO_AULA] = $h->CD_CL_TURMA_HORARIO;
                $disciplina[$turno][$h->DIA_SEMANA][$h->TEMPO_AULA] = $h->CD_DISCIPLINA.$h->CD_PROFESSOR;
                $manhacor[$turno][$h->DIA_SEMANA][$h->TEMPO_AULA] = $color;

            }else{
                $tarde[$turno][$h->DIA_SEMANA][$h->TEMPO_AULA] = '<span style="font-weight: bold">'.$h->NM_DISCIPLINA_REDUZIDO.'</span>'.
                    '<br/><small>'.$h->HR_INICIO.' - '.
                    $h->HR_FIM.'</small><br/>'.
                    $h->CD_TURMA;

                $idtarde[$turno][$h->DIA_SEMANA][$h->TEMPO_AULA] = $h->CD_CL_TURMA_HORARIO;
                $disciplina[$turno][$h->DIA_SEMANA][$h->TEMPO_AULA] = $h->CD_DISCIPLINA.$h->CD_PROFESSOR;
                $tardecor[$turno][$h->DIA_SEMANA][$h->TEMPO_AULA] = $color;
            }
        }

        $data = array(
            'manha' => $manha,
            'tarde' => $tarde,
            'idmanha' => $idmanha,
            'idtarde' => $idtarde,
            'manhacor' => $manhacor,
            'tardecor' => $tardecor,
            'disciplina' => $disciplina
        );
        $this->load->view($this->session->userdata('SGP_SISTEMA') . '/tempos/datagridHorarioTurma', $data);
    }

    /*
     * Função:
     * Detalha os tempos de aula da turma e o histórico de mudanças
     * 
     * Tipo: 
     * MODAL
     */
    function mdlTurmaHorarioTempo($tempo)
    {
        
        $t = explode(':',$tempo);
        $dia = $this->semana($t[2]);
        
        $schema = 'BD_SICA';
        $table = 'AES_CL_HORARIO_VAGO_PROFESSOR';
        $cursor = '';
        $params = array(
            array('name' => ':P_TIPO',         'value' => 'T'),
            array('name' => ':P_DIA_SEMANA',   'value' => $t[2]),
            array('name' => ':P_TURNO_TEMPO',  'value' => ''.$t[0].$t[1].''),
            array('name' => ':P_CD_PROFESSOR', 'value' => ''),
            array('name' => ':P_CD_TURMA',     'value' => $this->session->userdata('SGP_SEL_TURMA')),
            array('name' => ':RC1',            'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        $tempo = $this->horario->procedure($schema,$table,$params);
        
        
        $param = array(
            array('campo'=>'CD_TURMA', 'valor'=> $this->session->userdata('SGP_SEL_TURMA')),
            array('campo'=>'PERIODO', 'valor'=> $this->session->userdata('SGP_PERIODO')),
        );
        
        $turma = $this->turma->filtrar($param);
        
        $data = array(
            'titulo' => 'ACADÊMICO',
            'SubTitulo' => 'HORÁRIOS',
            'turno_extenso' => (($t[0] == 'A')? 'Manhã' : 'Tarde' ),
            'turno' => $t[0].$t[1],
            'tempo' => $t[1],
            'turma' => $turma,
            'dia' => $t[2],
            'dia_extenso' => $dia,
            'professor' => $tempo,
            //'turma' => $this->session->userdata('SGP_SEL_TURMA')
        );
        
        $this->load->view($this->session->userdata('SGP_SISTEMA') . '/tempos/mdlTurmaHorarioTempo', $data);
    }

    /*
     * Função:
     * Formulario para Edição do tempo
     * 
     * Tipo: 
     * MODAL
     */
    function mdlHorarioEditar($id) 
    {
        $tempo = $this->horario_pro->pesquisar_id($ar = array('campo'=>'CD_CL_TURMA_HORARIO', 'valor'=> $id));

        $data = array(
            'titulo' => 'ACADÊMICO',
            'SubTitulo' => 'HORÁRIOS',
            'turno_extenso' => ((substr($tempo->TURNO_TEMPO,0,1) == 'A')? 'Manhã' : 'Tarde' ),
            'turno' => $tempo->TURNO_TEMPO,
            'tempo' => $tempo->TEMPO_AULA ,
            'turma' => $tempo->CD_TURMA,
            'dia' => $tempo->DIA_SEMANA,
            'dia_extenso' => $this->semana($tempo->DIA_SEMANA),
            'dados' => $tempo,
        );
        $this->load->view($this->session->userdata('SGP_SISTEMA') . '/tempos/mdlHorarioEditar', $data);
    }

}
