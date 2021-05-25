<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Diario_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Executa a procedure para retornar uma listagem de conteudos de acordo com
     * a operação informada.
     * 
     * Operações
     * LCB - Lista todos os conteudos de um bimestre
     * LCN - Lista todos os conteudos de um determinado tipo de nota 
     * 
     * @param array $dados
     * @return array 
     */
    function aes_conteudo_ministrado($dados) {
        $params = array(
            array("name" => ":P_OPERACAO", "value" => $dados['operacao']),
            array("name" => ":P_CD_DISCIPLINA", "value" => $dados['cd_disciplina']),
            array("name" => ":P_BIMESTRE", "value" => $dados['bimestre']),
            array("name" => ":P_CD_TURMA", "value" => $dados['cd_turma']),
            array("name" => ":P_PERIODO", "value" => $dados['periodo']),
            array("name" => ":P_CD_TIPO_NOTA", "value" => $dados['tipo_nota']),
            array('name' => ':RC1', 'value' => '', 'type' => OCI_B_CURSOR)
        );

        return $this->db->procedure('BD_PORTAL', "AES_CONTEUDO_MINISTRADO", $params);
    }

    /**
     * Executa a procedure para manter dados referentes ao agendamento de provas
     * conforme a operação informada.     
     * 
     * Operações:
     * I - Insere um novo
     * E - Editar um existente
     * L - Listar todos
     * 
     * @param array $dados
     * @return array
     */
    function aes_prova_agendamento($dados) {
        $params = array(
            array("name" => ":P_OPERACAO", "value" => $dados['operacao']),
            array("name" => ":P_ID_PROVA_CONTEUDO", "value" => $dados['codigo_prova']),
            array("name" => ":P_PERIODO", "value" => $dados['periodo']),
            array("name" => ":P_BIMESTRE", "value" => $dados['bimestre']),
            array("name" => ":P_CD_TIPO_NOTA", "value" => $dados['tipo_nota']),
            array("name" => ":P_CD_DISCIPLINA", "value" => $dados['disciplina']),
            array("name" => ":P_DT_PROVA", "value" => $dados['data_prova']),
            array("name" => ":P_DT_INICIO", "value" => $dados['data_inicio']),
            array("name" => ":P_DT_FIM", "value" => $dados['data_fim']),
            array("name" => ":P_FL_WEB", "value" => $dados['flag']),
            array("name" => ":P_CD_TURMA", "value" => $dados['turma']),
            array('name' => ':RC1', 'value' => '', 'type' => OCI_B_CURSOR)
        );

        return $this->db->procedure("BD_ACADEMICO", "AES_PROVA_AGENDAMENTO", $params);
    }

    /**
     * Executa a procedure para obter dados relacionados ao diário do professor.     
     * 
     * Operações:
     * LAL - Lista todos os assuntos ministrado do livro da disciplina de uma
     * determinada aula.
     * 
     * @param array $dados Parametros da procudere
     * @return mixed
     */
    public function sp_diario($dados) {
        $parametros = array(
            array('name' => ':OPERACAO', 'value' => $dados['operacao']),
            array('name' => ':PERIODO', 'value' => $dados['periodo']),
            array('name' => ':CD_PROFESSOR', 'value' => $dados['cd_professor']),
            array('name' => ':DIA', 'value' => $dados['dia']),
            array('name' => ':CD_CL_AULA', 'value' => $dados['cl_aula']),
            array('name' => ':CD_DISCIPLINA', 'value' => $dados['cd_disciplina']),
            array('name' => ':CD_CURSO', 'value' => $dados['cd_curso']),
            array('name' => ':CD_TURMA', 'value' => $dados['cd_turma']),
            array('name' => ':SUBTURMA', 'value' => $dados['subturma']),
            array('name' => ':CD_ALUNO', 'value' => $dados['cd_aluno']),
            array('name' => ':PRESENCA', 'value' => $dados['frequencia']),
            array('name' => ':CD_PLANO', 'value' => $dados['cd_plano']),
            array('name' => ':CONTEUDO', 'value' => $dados['conteudo']),
            array('name' => ':TAREFA', 'value' => $dados['tarefa']),
            array('name' => ':DATA', 'value' => $dados['data']),
            array('name' => ':ORDEM_SERIE', 'value' => $dados['serie']),
            array('name' => ':OPCAO', 'value' => $dados['opcao']),
            array('name' => ':P_HR_ABERTURA', 'value' => $dados['hr_abertura']),
            array('name' => ':P_HR_FECHAMENTO', 'value' => $dados['hr_fechamento']),
            array('name' => ':RC1', 'value' => '', 'type' => OCI_B_CURSOR)
        );

        return $this->db->procedure('BD_PORTAL', 'AES_DIARIO_ONLINE', $parametros);
    }

    /**
     * Executa a procedure para manter a parte de notas do diario do professor
     * conforme uma determinada operação.
     * 
     * Operações:
     * LN - lista os tipos de nota
     * 
     * @param array $dados
     * @return array
     */
    public function sp_notas($dados) {
        $cursor = "";
        $params = array(
            array('name' => ':OPERACAO', 'value' => $dados['operacao']),
            array('name' => ':CD_DISCIPLINA', 'value' => $dados['cd_disciplina']),
            array('name' => ':PERIODO', 'value' => $dados['periodo']),
            array('name' => ':CD_PROFESSOR', 'value' => $dados['cd_professor']),
            array('name' => ':CD_TURMA', 'value' => $dados['cd_turma']),
            array('name' => ':CD_CURSO', 'value' => $dados['cd_curso']),
            array('name' => ':NUM_NOTA', 'value' => $dados['num_nota']),
            array('name' => ':CD_ESTRUTURA', 'value' => $dados['cd_estrutura']),
            array('name' => ':BIMESTRE', 'value' => $dados['bimestre']),
            array('name' => ':RC1', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_PORTAL', 'AES_DIARIO_NOTAS', $params);
    }

}
