<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Justificativa_Solicitacao_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model("academico/justificativa_solicitacao_aula_model", "justificar_aula", true);
        $this->load->model("academico/justificativa_motivo_model", "motivo", true);
        $this->load->model("pajela/aula_model", "aula", true);

        $this->table = "BD_ACADEMICO.JUSTIFICATIVA_SOLICITACAO";
        $this->view = "BD_ACADEMICO.VW_JUSTIFICATIVA_SOLICITACAO";
    }

    /**
     * Insere os dados da solicitação
     * 
     * @param array $data
     * @return boolean 
     */
    public function adicionar($data) {
        $this->db->trans_start();

        $professores = $data['PROFESSOR'];

        //inserir solicitação para cada professor
        foreach ($professores as $row) {
            $params = array(
                'CD_MOTIVO' => $data['CD_MOTIVO'],
                'CD_PROFESSOR' => $row,
                'DS_SOLICITACAO' => $data['DS_SOLICITACAO'],
                'DT_PENDENCIA' => $data['DT_PENDENCIA'],
                'CD_USU_SOLICITOU' => $data['CD_USU_SOLICITOU'],
            );

            parent::inserir($params);

            //associar as aulas com pendência a solicitação                                    
            $codigo = parent::max("CD_SOLICITACAO");
            foreach ($data['AULA'] as $aula) {
                $aux = explode("-", $aula);
                $codAula = $aux[0];
                $codProfessor = $aux[1];

                //verificar se a aula informada é do mesmo professor
                if ($codProfessor === $row) {
                    $params = array(
                        "CD_SOLICITACAO" => $codigo,
                        "CD_CL_AULA" => $codAula
                    );

                    $this->justificar_aula->inserir($params);
                }
            }
        }

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    /**
     * Edita os dados da solicitação
     *      
     * @param array $data
     * @return boolean
     */
    public function alterar($data) {
        $this->db->trans_start();

        $professores = $data['PROFESSOR'];
        foreach ($professores as $row) {
            //filtro do registro
            $keys = array(
                array('campo' => 'CD_SOLICITACAO', 'valor' => $data['CD_SOLICITACAO']),
            );

            $solicitacao = $this->filtro_id($keys);

            //preparar dados para edição
            $params = array(
                array('campo' => 'CD_MOTIVO', 'valor' => $data['CD_MOTIVO']),
                array('campo' => 'CD_PROFESSOR', 'valor' => $row),
                array('campo' => 'DS_SOLICITACAO', 'valor' => $data['DS_SOLICITACAO']),
                array('campo' => 'DT_PENDENCIA', 'valor' => $data['DT_PENDENCIA']),
            );

            $motivo = $this->motivo->pesquisar_id(array(
                "campo" => 'CD_MOTIVO', "valor" => $data['CD_MOTIVO']
            ));

            //verificar quais status devem ser atualizados de acordo com o motivo
            if ($motivo->FL_REQUER_PARECER == "S" && $solicitacao->FL_PARECER == "I") {
                $params[] = array('campo' => 'FL_PARECER', 'valor' => "N");
                $params[] = array('campo' => 'FL_STATUS', 'valor' => "N");
            } else if ($motivo->FL_REQUER_PARECER == "N" && $solicitacao->FL_STATUS == "I") {
                $params[] = array('campo' => 'FL_STATUS', 'valor' => "N");
            }

            parent::editar($keys, $params);

            //remover aulas associadas a solicitação
            $keys = array(
                array('campo' => 'CD_SOLICITACAO', 'valor' => $data['CD_SOLICITACAO']),
            );
            $this->justificar_aula->deletar($keys);

            //associar novas aulas a solicitação
            foreach ($data['AULA'] as $aula) {
                $aux = explode("-", $aula);
                $codAula = $aux[0];
                $codProfessor = $aux[1];

                //verificar se a aula informada é do mesmo professor
                if ($codProfessor === $row) {
                    $params = array(
                        "CD_SOLICITACAO" => $data['CD_SOLICITACAO'],
                        "CD_CL_AULA" => $codAula
                    );

                    $this->justificar_aula->inserir($params);
                }
            }
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    /**
     * Remove os registro de uma solicitação
     * 
     * @param int $solicitacao
     * @return boolean       
     */
    public function excluir($solicitacao) {
        $keys = array(
            array("campo" => "CD_SOLICITACAO", "valor" => $solicitacao)
        );

        $this->db->trans_start();

        //remover aulas associadas a solicitaçao
        $this->justificar_aula->deletar($keys);

        //deletar a solicitação
        parent::deletar($keys);

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    /**
     * Atualiza a solicitação com parecer da parte técnica de TI
     * 
     * @param array $params
     * @return boolean 
     */
    public function deferirParecer($params) {
        $solicitacoes = $params['solicitacoes'];

        $this->db->trans_start();
        foreach ($solicitacoes as $row) {
            $keys = array(
                array("campo" => "CD_SOLICITACAO", "valor" => $row)
            );

            $values = array(
                array("campo" => "DS_PARECER", "valor" => $params['DS_PARECER']),
                array("campo" => "FL_PARECER", "valor" => $params['FL_PARECER']),
                array("campo" => "CD_USU_PARECER", "valor" => $params['CD_USU_PARECER']),
                array("campo" => "DT_PARECER", "valor" => date("d-M-y"))
            );

            if ($params['FL_PARECER'] == "I") {
                $values[] = array("campo" => "FL_STATUS", "valor" => "I");
            } else {
                $values[] = array("campo" => "FL_STATUS", "valor" => "N");
            }

            parent::editar($keys, $values);
        }
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    /**
     * Atualiza a solicitação com a decisão do setor que aprova ou não a 
     * solicitação.
     * 
     * @param array $params
     * @return boolean 
     */
    public function deferirRetorno($params) {
        $solicitacoes = $params['solicitacoes'];

        $this->db->trans_start();
        foreach ($solicitacoes as $row) {
            $keys = array(
                array("campo" => "CD_SOLICITACAO", "valor" => $row)
            );

            $values = array(
                array("campo" => "DS_RETORNO", "valor" => $params['DS_RETORNO']),
                array("campo" => "FL_STATUS", "valor" => $params['FL_STATUS']),
                array("campo" => "CD_USU_RETORNO", "valor" => $params['CD_USU_RETORNO']),
                array("campo" => "DT_RETORNO", "valor" => date("d-M-y"))
            );

            //verificar se vai modificar status do parecer técnico
            $solicitacao = $this->filtro_id($keys);            
            if ($solicitacao->FL_REQUER_PARECER == "S" && $params['FL_STATUS'] == "I") {
                $values[] = array("campo" => "FL_PARECER", "valor" => "N");
            }

            parent::editar($keys, $values);
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    /**
     * Lista as aulas que foram vinculadas a solicitação para serem justificadas
     * 
     * @param int $solicitacao
     * @return object[]
     */
    public function listaAulas($solicitacao) {
        $this->db->select("AL.CD_CL_AULA,
                AL.PERIODO,
                AL.CD_TURMA,
                AL.CD_DISCIPLINA,
                AL.NM_DISCIPLINA,
                AL.CD_PROFESSOR,
                AL.NM_PROFESSOR,                
                AL.TURNO,
                AL.TEMPO_AULA,
                AL.HR_TEMPO_INICIO,
                AL.HR_TEMPO_FIM,
                AL.HR_ABERTURA,
                AL.HR_FECHAMENTO"
        );
        $this->db->from("BD_ACADEMICO.JUSTIFICATIVA_SOLICITACAO_AULA JSA");
        $this->db->join("BD_SICA.PJ_VW_AULA AL", "AL.CD_CL_AULA = JSA.CD_CL_AULA");
        $this->db->where("JSA.CD_SOLICITACAO", $solicitacao);
        $this->db->order_by("NM_PROFESSOR, AL.TURNO, AL.TEMPO_AULA, AL.HR_TEMPO_INICIO");

        $query = $this->db->get();
        return $query->result();
    }

}
