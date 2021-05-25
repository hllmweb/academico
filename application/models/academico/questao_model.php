<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Questao_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model("academico/questao_conteudo_model", "conteudo", true);
        $this->load->model("academico/questao_opcao_model", "opcao", true);
        $this->table = 'BD_ACADEMICO.AVAL_QUESTAO';
        $this->view = 'BD_ACADEMICO.VW_AVAL_QUESTAO';
        $this->load->library(array("prova_lib"));
    }

    /**
     * Salva a questão com todos os dados que ela possui.
     * 
     * @param array $questao
     * @param array $opcoes
     * @param array $conteudo   
     * @return boolean
     */
    public function inserirDados($questao, $opcoes, $conteudo) {
        $this->db->trans_start();

        //salvar questao e os dados
        $questao['operacao'] = "I";
        $codigo = $this->procedure_manter_questao($questao);

        //salvar opcoes caso seja questao objetiva        
        foreach ($opcoes as $row) {
            $row['operacao'] = "I";
            $row['CD_QUESTAO'] = $codigo;
            $this->opcao->procedure_manter_questao_opcao($row);

            //gabaritar a questão
            $keys = array(
                array("campo" => "CD_QUESTAO", "valor" => $row['CD_QUESTAO']),
                array("campo" => "CD_OPCAO", "valor" => $row['CD_OPCAO'])
            );

            $set = array(
                array("campo" => "FLG_CORRETA", "valor" => $row['FLG_CORRETA']),
            );

            $this->opcao->editar($keys, $set);
        }

        //salvar o conteudo a qual pertence a questao
        $conteudo['CD_QUESTAO'] = $codigo;
        $this->conteudo->inserir($conteudo);

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    /**
     * Exclui todos os dados da questão como o conteúdo a qual pertence e opções
     * caso seja uma questão objetiva.
     * 
     * @param int $codigo Código da questão que será deletados os dados.
     * @return boolean
     */
    public function excluirDados($codigo) {
        $this->db->trans_start();

        $params = array(
            array(
                'campo' => 'CD_QUESTAO',
                'valor' => $codigo,
            ),
        );

        $this->conteudo->deletar($params);
        $this->opcao->deletar($params);
        $this->questao->deletar($params);

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    /**
     * Verifica se a questão informada foi utilizada em alguma prova.
     * 
     * @param int $questao
     * @return boolean
     */
    public function isUtilizada($questao) {
        $this->db->from("BD_SICA.AVAL_PROVA_QUESTOES");
        $this->db->where("CD_QUESTAO", $questao);

        $query = $this->db->get();
        return $query->num_rows() > 0;
    }

    /**
     * Verifica se a questão objetiva possui gabarito.
     * 
     * @param int $questao
     * @return boolean
     */
    public function isGabaritada($questao) {
        $this->db->from("BD_ACADEMICO.AVAL_QUESTAO_OPCAO");
        $this->db->where("CD_QUESTAO", $questao);
        $this->db->where("FLG_CORRETA", 1);

        $query = $this->db->get();
        return $query->num_rows() > 0;
    }

    /**
     * Verifica se a questão objetiva possui alternativas cadastradas
     * 
     * @param int $questao
     * @return boolean
     */
    public function hasAlternativa($questao) {
        $this->db->from('BD_ACADEMICO.AVAL_QUESTAO_OPCAO');
        $this->db->where('CD_QUESTAO', $questao);

        $query = $this->db->get();
        return $query->num_rows() > 0;
    }

    /**
     * Realiza a limpeza da questão para ser exibida na pre-visualização, similar
     * a como seria exibida na prova.
     * 
     * @param object $questao
     * @param object[] $alternativas
     * @param boolean $isObject Indicar quando a descrição é um objeto.
     */
    public function formatar($questao, $alternativas, $isObject = false) {
        $formatador = new Prova_lib();
        $descricao = "";

        //limpar enunciado
        if ($isObject) {
            $descricao = $formatador->formata_texto_com_richtext($questao->DC_QUESTAO->read($questao->DC_QUESTAO->size()));
        } else {
            $descricao = $formatador->formata_texto_com_richtext($questao->DC_QUESTAO);
        }

        //limpar as alternativas
        if (!empty($alternativas)) {
            $opcoes = array();
            foreach ($alternativas as $row) {
                $aux = $isObject ? $row->DC_OPCAO->read($row->DC_OPCAO->size()) : $row->DC_OPCAO;
                $opcoes[] = $formatador->formata_texto_com_richtext_alternativa($aux);
            }

            $i = 0;
            $letras = array("A)", "B)", "C)", "D)", "E)");
            $descricao .= '<table style="margin-top:5px">';
            foreach ($opcoes as $row) {
                $resposta = $alternativas[$i];
                $style = $resposta->FLG_CORRETA == true ? "style='font-weight:bold'" : "";
                $check = $resposta->FLG_CORRETA == true ? "<i class='fa fa-check bg-success'></i>" : "";
                $descricao .= '<tr><td valign="top">' . $check . '</td><td valign="top" ' . $style . '>' . $letras[$i] . '</td><td style="text-align:justify">' . $row . '</td></tr>';
                $i++;
            }
            $descricao .= '</table>';
        }

        return $descricao;
    }

    /**
     * Executa a procedure para inserir e editar a questão.
     * 
     * @param array $params Valores de cada campo a ser passado para a procedure.
     * 
     * Note: A utilização da procedure ocorreu pelo fato do frame não conseguir
     * realizar o escape adequado nos campos do tipo clob da descrição da 
     * questão e alternativas. Ocorria erro ao inserir quando o usuário digitava
     * alguns caracteres especiais e aspas simples.
     */
    public function procedure_manter_questao($params) {
        $cursor = '';
        $parametros = array(
            array('name' => ':P_OPERACAO', 'value' => $params['operacao']),
            array('name' => ':P_CD_QUESTAO', 'value' => $params['CD_QUESTAO']),
            array('name' => ':P_CD_CURSO', 'value' => $params['CD_CURSO']),
            array('name' => ':P_ORDEM_SERIE', 'value' => $params['ORDEM_SERIE']),
            array('name' => ':P_FLG_TIPO', 'value' => $params['FLG_TIPO']),
            array('name' => ':P_DC_QUESTAO', 'value' => $params['DC_QUESTAO']),
            array('name' => ':P_DC_QUESTAO_RODAPE', 'value' => $params['DC_QUESTAO_RODAPE']),
            array('name' => ':P_CD_DISCIPLINA', 'value' => $params['CD_DISCIPLINA']),
            array('name' => ':P_CD_PROFESSOR', 'value' => $params['CD_PROFESSOR']),
            array('name' => ':P_CD_USUARIO', 'value' => $params['CD_USU_CADASTRO']),
            array('name' => ':P_NR_DIFICULDADE', 'value' => $params['NR_DIFICULDADE']),
            array('name' => ':P_CD_TEMA', 'value' => $params['CD_TEMA']),
            array('name' => ':v_RETORNO', 'value' => 0, 'type' => OCI_B_ROWID),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_ACADEMICO', 'AVAL_MANTER_QUESTAO', $parametros);
    }

}
