<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Aval_prova_calendario_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model("sica/aval_tipo_prova_model", "tipoProva", true);
        $this->table = 'BD_SICA.AVAL_PROVA_CALENDARIO';
        $this->view = 'BD_SICA.VW_AVAL_PROVA_CALENDARIO';
    }

    /**
     * Verifica se o tipo de prova informado é unica conforme:
     * 
     * - Caso a prova seja simulado a função verifica se já existe algum 
     * simulado na mesma data e turma; 
     * - Caso seja uma avaliação ou outros verifica se já existe uma prova da
     * disciplina informada na mesma data e turma.
     * 
     * @param array $params
     * @param boolean $novo
     * @return boolean TRUE quando a prova é única. FALSE caso contrário;
     */
    public function isUnicaProva($params, $novo = true) {        
        $tipoProva = $this->tipoProva->pesquisar_id(array(
            "campo" => "CD_TIPO_PROVA", "valor" => $params['CD_TIPO_PROVA']
        ));        
        
        $this->db->from($this->view);                
        $this->db->where("PERIODO", $params['PERIODO']);        
        $this->db->where("CD_TURMA", $params['CD_TURMA']);
        $this->db->where("DT_PROVA", $params['DT_PROVA']);
        
        //verificar se é simulado
        if ($tipoProva->FLG_SIMULADO === "S") {
            $this->db->where("CD_TIPO_PROVA", $params['CD_TIPO_PROVA']);
        } else {
            $this->db->where("CD_DISCIPLINA", $params['CD_DISCIPLINA']);
        }

        //evitar na edição de comparar com o proprio arquivo
        if (!$novo) {
            $this->db->where("CD_CALENDARIO !=", $params['CD_CALENDARIO']);
        }

        $query = $this->db->get();
        return $query->num_rows() === 0;
    }

}
