<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Aval_Prova_Questoes_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table = "BD_SICA.AVAL_PROVA_QUESTOES";
        $this->view = "BD_SICA.VW_AVAL_PROVA_QUESTOES";
    }

    /**
     * Realiza a troca de posição entre duas questões e a adição de espaços 
     * em brancos para a questão informada.
     * 
     * @param array $params Vetor no formato:
     * array(
     *      CD_PROVA => <int>,
     *      QUESTAOA => array(
     *          CD_QUESTAO => <int>
     *          POSICAO => <int>
     *      ),
     *      QUESTAOB => array(
     *          CD_QUESTAO => <int>
     *          POSICAO => <int>
     *      ),
     *      ESPACO => array(
     *          CD_QUESTAO => <int>
     *          QTD_ESPACO => <int>
     *      )
     * )
     * 
     * @return boolean
     */
    public function salvar($params) {
        $result = true;

        $this->db->trans_start();

        //realizar a troca de posição
        if (!empty($params['QUESTAOA']) && !empty($params['QUESTAOB'])) {
            $keysA = array(
                array("campo" => "CD_PROVA", "valor" => $params['CD_PROVA']),
                array("campo" => "CD_QUESTAO", "valor" => $params['QUESTAOA']['CD_QUESTAO']),
            );

            $keysB = array(
                array("campo" => "CD_PROVA", "valor" => $params['CD_PROVA']),
                array("campo" => "CD_QUESTAO", "valor" => $params['QUESTAOB']['CD_QUESTAO']),
            );

            $paramsA = array(
                array("campo" => "POSICAO", "valor" => $params['QUESTAOB']['POSICAO'])
            );

            $paramsB = array(
                array("campo" => "POSICAO", "valor" => $params['QUESTAOA']['POSICAO'])
            );

            $result = $this->editar($keysA, $paramsA) === false ? false : $result;
            $result = $this->editar($keysB, $paramsB) === false ? false : $result;
        }

        //adicionar espaço a questão
        if (!empty($params['ESPACO'])) {
            $keys = array(
                array("campo" => "CD_PROVA", "valor" => $params['CD_PROVA']),
                array("campo" => "CD_QUESTAO", "valor" => $params['ESPACO']['CD_QUESTAO']),
            );

            $dados = array(
                array("campo" => "QTD_ESPACO", "valor" => $params['ESPACO']['QTD_ESPACO'])
            );

            $result = $this->editar($keys, $dados) === false ? false : $result;
        }

        if ($result) {
            $this->db->trans_commit();
        } else {
            $this->db->trans_rollback();
        }

        return $result;
    }

}
