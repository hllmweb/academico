<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Aula_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table = "BD_PAJELA.PJ_CL_AULA";
        $this->view = "BD_SICA.PJ_VW_AULA";
    }

    /**
     * Lista todas as aulas do professor que não foram abertas ou fechadas em
     * uma data especifica.
     * 
     * @param int $professor
     * @param string $data 
     * @return object[]
     */
    public function listaPendenteHorario($professor, $data) {
        $this->db->select("CD_CL_AULA,
                PERIODO,
                CD_TURMA,
                CD_DISCIPLINA,
                NM_DISCIPLINA,
                CD_PROFESSOR,
                NM_PROFESSOR,                
                TURNO,
                TEMPO_AULA,
                HR_TEMPO_INICIO,
                HR_TEMPO_FIM,
                HR_ABERTURA,
                HR_FECHAMENTO"
        );
        $this->db->from($this->view);
        $this->db->where_in("CD_PROFESSOR", $professor);
        $this->db->where("TRUNC(DT_AULA)", $data);
        $this->db->where("(HR_ABERTURA IS NULL OR HR_FECHAMENTO IS NULL)");
        $this->db->where("CD_CL_AULA NOT IN (SELECT CD_CL_AULA FROM BD_ACADEMICO.JUSTIFICATIVA_SOLICITACAO_AULA)");
        $this->db->order_by("NM_PROFESSOR, TURNO, TEMPO_AULA, HR_TEMPO_INICIO");

        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Lista todas as aulas com as seguintes pendências: 
     * 
     * - aulas que não foram fechadas;
     * - aulas que não foram abertas;
     * - aulas sem conteúdo;
     * - aulas sem chamada;
     * 
     * @param array $params Vetor no seguinte formato:
     * array(
     *      array("campo" => <string>, "valor" => <string|int>),     
     * )
     * @return object[]
     */

    public function listaPendencias($params) {
        $this->db->from("BD_SICA.VW_AULA_PENDENCIAS");

        foreach ($params as $row) {
            $this->db->where($row['campo'], $row['valor']);
        }
        
        $query = $this->db->get();
        return $query->result();
    }

}
