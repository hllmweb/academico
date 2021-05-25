<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Justificativa_Motivo_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table = "BD_ACADEMICO.JUSTIFICATIVA_MOTIVO";
        $this->view = "BD_ACADEMICO.JUSTIFICATIVA_MOTIVO";
    }


        // $data = array(
        //      'CD_PROVA' => $p['prova'],
        //      'CD_ALUNO' => $p['aluno'],
        // 'CD_DISCIPLINA' => $p['disciplina'],
        //     'NR_ACERTO' => $p['acerto'],
        //     'PC_ACERTO' => $p['p_acerto'],
        //       'NR_ERRO' => $p['erro'],
        //       'PC_ERRO' => $p['p_erro'],
        //       'NR_NOTA' => $p['nota'],
        // );
        // $this->db->insert('BD_SICA.AVAL_PROVA_ALUNO_DISC', $data); 

    public function addMotivo($p){
    	$data = array(
    		'NM_MOTIVO' => $p['NM_MOTIVO']
    	);


    	$query = $this->db->insert('BD_ACADEMICO.JUSTIFICATIVA_MOTIVO', $data);
    	if($query):
    		return 1;
    	else:
    		return 0;
    	endif;
    	/*$query = $this->db->query("INSERT INTO BD_ACADEMICO.JUSTIFICATIVA_MOTIVO (NM_MOTVIO) VALUES (".$txt_motivo.")");
    	if($query):
    		return 1;
    	else:
    		return 0;
    	endif;*/

    }

}
