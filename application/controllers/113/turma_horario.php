<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Turma_horario extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('sica/cursos_model', 'curso', true);
        $this->load->model('rh/turma_horario_model', 'horario', true);
        $this->load->model('rh/cl_professor_horario_model', 'horario_pro', true);
        $this->load->model('sica/turma_model', 'turma', true);
        

        $this->load->helper(array('url'));
        $this->load->library(array('session', 'tracert', 'form_validation'));
    }

    function index() {
        //$log = new Tracert();
        //$log->validar_url();

        // LIMPA A SESSÃO QUE CONTEM O CODIGO DO ULTIMO PROFESSOR VISTO
        $this->session->unset_userdata('SGP_SEL_PROFESSOR');
        
        $data = array(
            'titulo' => 'ACADÊMICO',
            'SubTitulo' => 'CALENDÁRIO DE EVENTOS'
        );

        $this->load->view($this->session->userdata('SGP_SISTEMA') . '/tempos/index', $data);
    }
    
    function frmManter() {
        
        switch($this->input->get_post('Operacao')){
            
            case 'I':
                
                $param = array(
                    array('campo'=>'CD_TURMA', 'valor'=> $this->input->post('Turma')),
                    array('campo'=>'PERIODO', 'valor'=> $this->session->userdata('SGP_PERIODO')),
                );
                $turma = $this->turma->filtrar($param);
                
                $this->form_validation->set_rules('DTInicio', 'Data Início', 'trim|required|xss_clean');
                $this->form_validation->set_rules('Professor', 'Professor', 'trim|required|xss_clean');
                $this->form_validation->set_rules('Turma', 'Turma', 'trim|required|xss_clean');
                
                if ($this->form_validation->run() == FALSE) {
                    
                    $res = array(
                        'mensagem' => '<lable class="text-danger">'.validation_errors().'</lable>',
                        'status' => FALSE
                    );
                    print_r(json_encode($res));

                }else{                
                
                    $param = array(
                        'PERIODO' => $this->session->userdata('SGP_PERIODO'),
                       'CD_TURMA' => $this->input->post('Turma'),
                     'DIA_SEMANA' => (int)$this->input->post('Dia'),
                     'TEMPO_AULA' => (int)$this->input->post('Tempo'),
                    'TURNO_TEMPO' => $this->input->post('Turno'),
                        
                     'DT_INICIO' => (($this->input->post('DTInicio') != '')? date('d-M-y', strtotime(implode("-", array_reverse(explode("/", $this->input->post('DTInicio')))))): NULL),
                         'DT_FIM' => (($this->input->post('DTFim') != '')? date('d-M-y', strtotime(implode("-", array_reverse(explode("/", $this->input->post('DTFim')))))): NULL),
                     'CD_HORARIO' => (int)((substr($this->input->post('Turma'),0,1) == 'A')? 1 : 2),
                       'CD_CURSO' => (int)$turma[0]->CD_CURSO,
                    'ORDEM_SERIE' => (int)$turma[0]->CD_SERIE,
                        
                  'CD_DISCIPLINA' => (int)$this->input->post('Disciplina'),
                   'CD_PROFESSOR' => (int)$this->input->post('Professor')
                    );                    
                    $rs = $this->horario->inserir($param);
                    
                    $res = array(
                      'mensagem' => '<lable class="text-sucess">Cadastro realizado!</lable>',
                      'status' => TRUE
                    );
                    print_r(json_encode($res));
                }
            break;
            case 'U':
                $param = array(
                    array('campo' => 'DT_INICIO', 'valor' => (($this->input->post('DTInicio') != '')? date('d-M-y', strtotime(implode("-", array_reverse(explode("/", $this->input->post('DTInicio')))))): NULL), 'type' => TRUE),
                    array('campo' => 'DT_FIM', 'valor' => (($this->input->post('DTFim') != '')? date('d-M-y', strtotime(implode("-", array_reverse(explode("/", $this->input->post('DTFim')))))): NULL), 'type' => TRUE),
                );
                $key = array(
                    array('campo' => 'CD_CL_TURMA_HORARIO', 'valor' => $this->input->post('Horario'))
                );
                $this->horario->editar($key,$param);
                echo 'Atualizado com sucesso!';
            break;
            case 'D': 
                $param = array(
                    //array('campo' => "DT_FIM", 'valor' => "TO_DATE('".date('d/m/Y')."','DD/MM/YYYY')", 'type' => FALSE),
                    array('campo' => 'DT_FIM', 'valor' => '(SYSDATE - 1)', 'type' => FALSE),
                );
                $key = array(
                    array('campo'=>'CD_CL_TURMA_HORARIO', 'valor'=> (int)$this->input->get_post('Horario'))
                );
                 $this->horario->editar($key,$param);
            break;
            // ENCERRAR TODOS OS HORÁRIOS DE UMA TURMA
            case 'ET': 
                $param = array(
                    //array('campo' => "DT_FIM", 'valor' => "TO_DATE('".date('d/m/Y')."','DD/MM/YYYY')", 'type' => FALSE),
                    array('campo' => "DT_FIM = (SYSDATE-1)", 'valor' => ''),
                );
                $key = array(
                    array('campo'=>'PERIODO', 'valor'=> $this->session->userdata('SGP_PERIODO')),
                    array('campo'=>'CD_TURMA', 'valor'=> $this->input->get_post('Turma'), 'type' => TRUE),
                    array('campo'=>"(TRUNC(DT_FIM) > TO_DATE('".date('d/m/Y')."','DD/MM/YYYY') OR DT_FIM IS NULL)", 'valor' => "", 'type' => FALSE),
                );
                $this->horario->editar($key,$param);
            break;
            // ENCERRAR TODOS OS HORÁRIOS DO PROFESSOR
            case 'EP': 
                $param = array(
                    array('campo' => "DT_FIM", 'valor' => "TO_DATE('".date('d/m/Y')."','DD/MM/YYYY')", 'type' => FALSE),
                );
                $key = array(
                    array('campo' => 'CD_PROFESSOR', 'valor'=> $this->input->get_post('Professor'), 'type' => FALSE),
                    array('campo' => 'PERIODO',      'valor'=> $this->session->userdata('SGP_PERIODO'), 'type' => TRUE),
                    array('campo' => "(TRUNC(DT_FIM) > TO_DATE('".date('d/m/Y')."','DD/MM/YYYY') OR DT_FIM IS NULL)", 'valor' => "", 'type' => FALSE),
                );
                //print_r($key);
                $this->horario->editar($key,$param);
            break;
        }
    }
    
    function prtHorarioTurma() {

        $param = array(
            array('campo'=>'CD_TURMA', 'valor'=> $this->session->userdata('SGP_SEL_TURMA')),
            array('campo'=>'PERIODO', 'valor'=>$this->session->userdata('SGP_PERIODO')),
            array('campo'=>'(DT_FIM IS NULL OR TRUNC(DT_FIM) > TRUNC(SYSDATE))', 'valor'=>''),
        );

        $horario = $this->horario_pro->filtrar($param);

         // Array com os os DETALHES dos Tempos da Manhã / Tarde
        $manha = array();
        $tarde = array();

        foreach($horario as $h){
            $turno = substr($h->TURNO_TEMPO,0,1);
            
            if($turno == 'A'){
                $manha[$turno][$h->DIA_SEMANA][$h->TEMPO_AULA] = '<div data-disciplina-id="'.$h->CD_DISCIPLINA.'">'
                    .'<span style="font-weight: bold">'.$h->NM_DISCIPLINA_REDUZIDO.'</span><br/>'
                    .'<small>'.$h->HR_INICIO.' - '.$h->HR_FIM.'</small><br/>'
                    .'<small style="font-weight: bold">'.$h->APELIDO.'</small><br/>'
                    .$h->CD_TURMA.'</div>';

            }else{
                $tarde[$turno][$h->DIA_SEMANA][$h->TEMPO_AULA] = '<div data-disciplina-id="'.$h->CD_DISCIPLINA.'">'
                    .'<span style="font-weight: bold">'.$h->NM_DISCIPLINA_REDUZIDO.'</span><br/>'
                    .'<small>'.$h->HR_INICIO.' - '.$h->HR_FIM.'</small><br/>'
                    .'<small style="font-weight: bold">'.$h->APELIDO.'</small><br/>'
                    .$h->CD_TURMA.'</div>';

            }
        }

        $data = array(
            'titulo' => 'Horário da Turma<br/><h3>'.$this->session->userdata('SGP_SEL_TURMA').'</h3>',
            'manha'  => $manha,
            'tarde'  => $tarde,
        );

        $body = $this->load->view($this->session->userdata('SGP_SISTEMA') . '/tempos/prtHorarioTurma', $data,true);

        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF('','A4',9,'Arial Narrow');
        $mpdf->SetHTMLHeader($this->load->view('impressao/header_doc', $data, true));
        $mpdf->AddPage('P', // L - landscape, P - portrait
                'A4', '', '', '', 
                2, // margin_left
                2, // margin right
                30, // margin top
                20, // margin bottom
                0, // margin header
                0); // margin footer
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHTMLFooter($this->load->view('impressao/footer_doc', $data, true));
        $mpdf->WriteHTML($body);
        $mpdf->Output();
    }
    
    function prtHorarioProfessor() {

        $param = array(
            array('campo'=>'CD_PROFESSOR', 'valor'=> $this->session->userdata('SGP_SEL_PROFESSOR')),
            array('campo'=>'PERIODO', 'valor'=>$this->session->userdata('SGP_PERIODO')),
            array('campo'=>'(DT_FIM IS NULL OR TRUNC(DT_FIM) > TRUNC(SYSDATE))', 'valor'=>''),
        );
        $horario = $this->horario_pro->filtrar($param);

         // Array com os os DETALHES dos Tempos da Manhã / Tarde
        $manha = array();
        $tarde = array();

        foreach($horario as $h){
            $turno = substr($h->TURNO_TEMPO,0,1);
            
            if($turno == 'A'){
                $manha[$turno][$h->DIA_SEMANA][$h->TEMPO_AULA] = '<div data-disciplina-id="'.$h->CD_DISCIPLINA.'">'
                    .'<span style="font-weight: bold">'.$h->NM_DISCIPLINA_REDUZIDO.'</span><br/>'
                    .'<small>'.$h->HR_INICIO.' - '.$h->HR_FIM.'</small><br/>'
                    .'<small style="font-weight: bold">'.$h->APELIDO.'</small><br/>'
                    .$h->CD_TURMA.'</div>';

            }else{
                $tarde[$turno][$h->DIA_SEMANA][$h->TEMPO_AULA] = '<div data-disciplina-id="'.$h->CD_DISCIPLINA.'">'
                    .'<span style="font-weight: bold">'.$h->NM_DISCIPLINA_REDUZIDO.'</span><br/>'
                    .'<small>'.$h->HR_INICIO.' - '.$h->HR_FIM.'</small><br/>'
                    .'<small style="font-weight: bold">'.$h->APELIDO.'</small><br/>'
                    .$h->CD_TURMA.'</div>';

            }
        }

        $data = array(
            'titulo' => 'Horário da Turma<br/><h3>'.$this->session->userdata('SGP_SEL_PROFESSOR').'</h3>',
            'manha'  => $manha,
            'tarde'  => $tarde,
        );

        $body = $this->load->view($this->session->userdata('SGP_SISTEMA') . '/tempos/prtHorarioTurma', $data,true);

        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF('','A4',9,'Arial Narrow');
        $mpdf->SetHTMLHeader($this->load->view('impressao/header_doc', $data, true));
        $mpdf->AddPage('P', // L - landscape, P - portrait
                'A4', '', '', '', 
                2, // margin_left
                2, // margin right
                30, // margin top
                20, // margin bottom
                0, // margin header
                0); // margin footer
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHTMLFooter($this->load->view('impressao/footer_doc', $data, true));
        $mpdf->WriteHTML($body);
        $mpdf->Output();
    }

}
