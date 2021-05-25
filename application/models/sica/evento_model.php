<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Evento_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model("sica/evento_aluno_model", "eventoAluno", true);
        $this->load->model("sica/matricula_model", "matricula", true);
        $this->table = "BD_SICA.CL_EVENTO";
        $this->view = "BD_SICA.CL_EVENTO";
    }

    /**
     * Cadastro o evento e os alunos que irão participar.
     * 
     * @param array $evento Dados do Evento
     * @param array $alunos Cursos, séries ou turmas que participarão do evento
     * @return array
     */
    public function adicionar($evento, $alunos) {
        $this->db->trans_start();

        //inserir dados do evento        
        $evento['operacao'] = "I";
        $codigo = $this->procedure_manter_evento($evento);

        //associar cada aluno ao evento        
        $participantes = $this->matricula->listaAlunos($alunos['CURSOS'], $alunos['SERIES'], $alunos['TURMAS']);
        foreach ($participantes as $row) {
            $aux = array(
                'CD_EVENTO' => $codigo,
                'CD_ALUNO' => $row->CD_ALUNO,
                'NR_CPF' => $row->CPF_RESPONSAVEL
            );
            $this->eventoAluno->inserir($aux);
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    /**
     * O excluir apenas muda o valor da FL_ATIVO para 0
     * 
     * @param array $keys Código do evento
     * @return boolean
     */
    public function excluir($keys) {
        $params = array(
            array("campo" => "FL_ATIVO", "valor" => false),
        );

        return $this->editar($keys, $params);
    }

    /**
     * Executa a procedure para inserir e editar um evento
     * 
     * @param array $params Valores de cada campo a ser passado para a procedure.
     * 
     * Note: essa abordagem de utilizar procedure foi adotada devido em campos
     * de texto livre a inserção de caracteres especiais não é realizado o 
     * escape adequado pelo codeigniter.
     */
    public function procedure_manter_evento($params) {
        $cursor = '';

        $parametros = array(
            array('name' => ':P_OPERACAO', 'value' => $params['operacao']),
            array('name' => ':P_CD_EVENTO', 'value' => $params['CD_EVENTO']),
            array('name' => ':P_NM_EVENTO', 'value' => $params['NM_EVENTO']),
            array('name' => ':P_DS_EVENTO', 'value' => $params['DS_EVENTO']),
            array('name' => ':P_DS_IMAGEM', 'value' => $params['DS_IMAGEM']),
            array('name' => ':P_DS_COR', 'value' => $params['DS_COR']),
            array('name' => ':P_DT_INICIO', 'value' => $params['DT_INICIO']),
            array('name' => ':P_DT_FIM', 'value' => $params['DT_FIM']),
            array('name' => ':P_DT_VENCIMENTO', 'value' => $params['DT_VENCIMENTO']),
            array('name' => ':P_HR_INICIO', 'value' => $params['HR_INICIO']),
            array('name' => ':P_HR_FIM', 'value' => $params['HR_FIM']),
            array('name' => ':P_CD_PRODUTO', 'value' => $params['CD_PRODUTO']),
            array('name' => ':P_FL_NOTIFICAR', 'value' => $params['FL_NOTIFICAR']),
            array('name' => ':P_CD_USUARIO', 'value' => $params['CD_USUARIO']),
            array('name' => ':P_FL_ATIVO', 'value' => $params['FL_ATIVO']),
            array('name' => ':v_RETORNO', 'value' => 0, 'type' => OCI_B_ROWID),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->procedure('BD_SICA', 'MANTER_EVENTO', $parametros);
    }

}
