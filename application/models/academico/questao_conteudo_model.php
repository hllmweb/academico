<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Questao_Conteudo_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table = 'BD_ACADEMICO.AVAL_QUESTAO_CONTEUDO';
        $this->view = 'BD_ACADEMICO.AVAL_QUESTAO_CONTEUDO';
    }

    /**
     * Lista todos os conteúdo de uma determinada questão
     * 
     * @param int $questao
     * @reuturn array
     */
    public function obterConteudo($questao) {
        $this->db->select("
            TE.CD_TEMA,
            TE.DC_TEMA,
            TC.CD_CONTEUDO,
            TC.DC_CONTEUDO"
        );
        $this->db->from("BD_ACADEMICO.AVAL_TEMA TE");
        $this->db->join("BD_ACADEMICO.AVAL_TEMA_CONTEUDO TC", "TC.CD_TEMA = TE.CD_TEMA");
        $this->db->join("BD_ACADEMICO.AVAL_QUESTAO_CONTEUDO QC", "QC.CD_CONTEUDO = TC.CD_CONTEUDO");
        $this->db->where("QC.CD_QUESTAO", $questao);

        $query = $this->db->get();
        return $query->row();
    }

}
