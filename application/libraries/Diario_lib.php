<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Diario_lib {

    public $periodo;
    public $aluno;
    public $disciplina;
    public $turma;
    public $bimestre;
    public $tipo_nota;
    public $num_nota;
    public $estrutura;
    
    private $cursor = array();
    

    function notas_turma_disciplina() {
        $obj = & get_instance();
        $obj->load->model('professor_model', 'professor', TRUE);
        
        $p = array('operacao' => 'ND',
                 'disciplina' => $this->disciplina,
                      'turma' => $this->turma,
                    'periodo' => $this->periodo,
                  );
        $list = $obj->professor->aes_diario_notas($p);
        
        // FAZ AS LISTA DE ALUNOS
        foreach($list as $l){
            $alu[] = $l['CD_ALUNO'];
        }
        $alunos = array_keys(array_flip($alu));
        
        $i = 1;
        foreach($alunos as $al){
            // Guarda o CD_ALUNO dentro do array
            $this->cursor[$i]['CD_ALUNO'] = $al;
            // Recupera a linha das colunas
            foreach($list as $l){
                
                
                if($al == $l['CD_ALUNO']){
                   $this->cursor[$i]['NM_ALUNO'] = $l['NM_ALUNO'];
                   $this->cursor[$i]['TIPO'] = $l['TIPO'];
                   $this->cursor[$i]['STATUS'] = $l['STATUS'];
                   
                   $this->cursor[$i]['FALTAS_1B'] = $l['FALTAS_1B'];
                   $this->cursor[$i]['FALTAS_2B'] = $l['FALTAS_2B'];
                   $this->cursor[$i]['FALTAS_3B'] = $l['FALTAS_3B'];
                   $this->cursor[$i]['FALTAS_4B'] = $l['FALTAS_4B'];

                   switch($l['BIMESTRE']){
                       case 1:
                           if($l['NM_MINI'] === 'P1'){
                               $this->cursor[$i]['BIMESTRE'][1]['P1'] = $l['NOTA'];
                           }elseif($l['NM_MINI'] === 'P2'){
                               $this->cursor[$i]['BIMESTRE'][1]['P2'] = $l['NOTA'];
                           }elseif($l['NM_MINI'] === 'MAIC'){
                               $this->cursor[$i]['BIMESTRE'][1]['MAIC'] = $l['NOTA'];
                           }elseif($l['NM_MINI'] === 'NQ'){
                               $this->cursor[$i]['BIMESTRE'][1]['NQ'] = $l['NOTA'];
                           }elseif($l['NM_MINI'] === 'MB'){
                               $this->cursor[$i]['BIMESTRE'][1]['MB'] = $l['NOTA'];
                           }
                       break;

                       case 2:
                           if($l['NM_MINI'] === 'P1'){
                               $this->cursor[$i]['BIMESTRE'][2]['P1'] = $l['NOTA'];
                           }elseif($l['NM_MINI'] === 'P2'){
                               $this->cursor[$i]['BIMESTRE'][2]['P2'] = $l['NOTA'];
                           }elseif($l['NM_MINI'] === 'MAIC'){
                               $this->cursor[$i]['BIMESTRE'][2]['MAIC'] = $l['NOTA'];
                           }elseif($l['NM_MINI'] === 'NQ'){
                               $this->cursor[$i]['BIMESTRE'][2]['NQ'] = $l['NOTA'];
                           }elseif($l['NM_MINI'] === 'MB'){
                               $this->cursor[$i]['BIMESTRE'][2]['MB'] = $l['NOTA'];
                           }
                       break;

                       case 3:
                           if($l['NM_MINI'] === 'P1'){
                               $this->cursor[$i]['BIMESTRE'][3]['P1'] = $l['NOTA'];
                           }elseif($l['NM_MINI'] === 'P2'){
                               $this->cursor[$i]['BIMESTRE'][3]['P2'] = $l['NOTA'];
                           }elseif($l['NM_MINI'] === 'MAIC'){
                               $this->cursor[$i]['BIMESTRE'][3]['MAIC'] = $l['NOTA'];
                           }elseif($l['NM_MINI'] === 'NQ'){
                               $this->cursor[$i]['BIMESTRE'][3]['NQ'] = $l['NOTA'];
                           }elseif($l['NM_MINI'] === 'MB'){
                               $this->cursor[$i]['BIMESTRE'][3]['MB'] = $l['NOTA'];
                           }
                       break;

                       case 4:
                           if($l['NM_MINI'] === 'P1'){
                               $this->cursor[$i]['BIMESTRE'][4]['P1'] = $l['NOTA'];
                           }elseif($l['NM_MINI'] === 'P2'){
                               $this->cursor[$i]['BIMESTRE'][4]['P2'] = $l['NOTA'];
                           }elseif($l['NM_MINI'] === 'MAIC'){
                               $this->cursor[$i]['BIMESTRE'][4]['MAIC'] = $l['NOTA'];
                           }elseif($l['NM_MINI'] === 'NQ'){
                               $this->cursor[$i]['BIMESTRE'][4]['NQ'] = $l['NOTA'];
                           }elseif($l['NM_MINI'] === 'MB'){
                               $this->cursor[$i]['BIMESTRE'][4]['MB'] = $l['NOTA'];
                           }
                       break;
                   } 
                }
            }
            $i = $i+1;
        }
        return($this->cursor);
    }
}

?>