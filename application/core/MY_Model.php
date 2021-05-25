<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Model extends CI_Model {

    var $tabela = "";
    var $view = "";

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    
    // RETORNA UM OBJETO/ARRAY 
    function auxiliar($view, $param) {

        if (is_array($param) == NULL) {
            return NULL;
        }
        foreach ($param as $p) {
            if ($p['valor'] != '') {
                $this->db->where($p['campo'], $p['valor']);
            } else {
                $this->db->where($p['campo']);
            }
        }

        $result = $this->db->get($view)->result_object();

        return $result;
    }
    

    // FUNÇÃO PARA PEGAR O ULTIMO ID
    function max($campo) {

        $this->db->select(' MAX(' . $campo . ') as id');
        $result = $this->db->get($this->view)->row();
        return $result->ID;
    }

    // FUNÇÃO PARA IR FILTRANDO 
    // ATRASVÉS DOS CAMPOS DA TABELA
    // RETORNA UMA ROW
    function filtro_id($param) {

        if (is_array($param) == NULL) {
            return NULL;
        }
        foreach ($param as $p) {
            $this->db->where($p['campo'], $p['valor']);
        }
        $result = $this->db->get($this->view)->row();

        return $result;
    }

    // FUNCAO PARA UM UNICO REGISTRO
    // ATRASVÉS DO ID
    // RETORNA APENAS UMA LINHA DA TABELA
    function pesquisar_id($param) {
        if (is_array($param) == NULL) {
            return NULL;
        }
        $this->db->where($param['campo'], $param['valor']);
        $result = $this->db->get($this->view)->row();
        return $result;
    }

    // FUNCAO PARA LISTAR
    // TODOS OS REGISTROS
    // DA TABELA
    // RETORNA UM OBJETO/ARRAY 
    function listar($param = NULL) {
        if (!is_array($param) == NULL) {
            $this->db->order_by($param['campo'], $param['ordem']);
        }
        $result = $this->db->get($this->view)->result_object();
        return $result;
    }

    // FUNCAO PARA LISTAR
    // TODOS OS REGISTROS COM CLAUSULAS 'or'
    // DA TABELA
    // RETORNA UM OBJETO/ARRAY 
    function listar_or($param = NULL) {
        if (is_array($param) == NULL) {
            return NULL;
        }
        foreach ($param as $p) {
            if ($p['valor'] != '') {
                $this->db->or_where($p['campo'], $p['valor']);
            }
        }
        $result = $this->db->get($this->view)->result_object();

        return $result;
    }

    // FUNCAO PARA LISTAR 
    // TODOS OS REGISTROS
    // DA TABELA COM LIMITES
    // RETORNA UM OBJETO/ARRAY 
    function limitar($param = NULL, $limite = NULL) {
        if (!is_array($param) == NULL) {
            $this->db->order_by($param['campo'], $param['ordem']);
        }
        $this->db->limit($limite['inicio'], $limite['fim']);
        $result = $this->db->get($this->view)->result_object();
        return $result;
    }

    // FUNÇÃO PARA IR FILTRANDO 
    // ATRASVÉS DOS CAMPOS DA TABELA
    // RETORNA UM OBJETO/ARRAY 
    function filtrar($param) {

        if (is_array($param) == NULL) {
            return NULL;
        }
        foreach ($param as $p) {
            if ($p['valor'] != '') {
                $this->db->where($p['campo'], $p['valor']);
            } else {
                $this->db->where($p['campo']);
            }
        }

        $result = $this->db->get($this->view)->result_object();
        
        //echo $this->db->last_query();

        return $result;
    }

    /**
     * Função para inserir registros
     *     
     * @param array $data Vetor onde a chave é a coluna do banco e o valor o 
     * dado que será cadastrado.
     * 
     * Formato do vetor:
     * 
     * array(
     *    <string> => <string>|<int>
     * )
     * 
     * @return boolean
     */
    function inserir($data) {
        $result = $this->db->insert($this->table, $data);
        $this->log();
        return $result;
    }

    /**
     * Função para inserir vários registros.
     * 
     * @param array $data Um vetor de vetores onde cada elemento do vetor é um
     * registro que será inserido no banco
     * @return boolean 
     */
    function inserirBatch($data) {
        $result = $this->db->insert_batch($this->table, $data);
        $this->log();
        return $result;
    }

    /**
     * Função para editar registros.
     * 
     * @param array $key Vetor com as chaves.
     * @param array $param Vetor com os campos que serão atualizados
     * 
     * Formato do vetor:
     * 
     * array(
     *      array(
     *          'campo' => <string>
     *          'valor' => <string>|<int>
     *      )
     * )
     * 
     * @return boolean
     */
    function editar($key, $param) {
        if (is_array($key) == NULL || is_array($param) == NULL) {
            return NULL;
        }
        // PEGA OS VALOR A SEREM ATUALIZADOS
        foreach ($param as $p) {
            if ($p['type'] === FALSE)
                $this->db->set($p['campo'], $p['valor'], FALSE);
            else
                $this->db->set($p['campo'], $p['valor'], TRUE);
        }
        // PEGA A CHAVE DA TABELA
        foreach ($key as $k) {
            if ($k['type'] === FALSE)
                $this->db->where($k['campo'], $k['valor'], FALSE);
            else
                $this->db->where($k['campo'], $k['valor'], TRUE);
        }

        $result = $this->db->update($this->table);
        $this->log();

        return $result;
    }

    /**
     * Função para deletar registros.
     * 
     * @param array $param Vetor com as chaves
     * 
     * Formato do vetor:
     * 
     * array(
     *      array(
     *          'campo' => <string>
     *          'valor' => <string>|<int>
     *      )
     * )
     * 
     * @return boolean
     */
    function deletar($param) {
        if (is_array($param) == NULL) {
            return NULL;
        }

        foreach ($param as $p) {
            $this->db->where($p['campo'], $p['valor']);
        }

        $result = $this->db->delete($this->table);
        $this->log();

        return $result;
    }

    /**
     * Executa uma procedure.
     * 
     * @param string $pacote
     * @param string $procedure
     * @param array $params
     * @return mixed
     */
    public function procedure($pacote, $procedure, $params) {
        $result = $this->db->procedure($pacote, $procedure, $params);
        $this->log_procedure($pacote, $procedure, $params);
        return $result;
    }

    /**
     * Registra o log da última operação realizada
     */
    private function log() {
        $sql = $this->db->last_query();
        $co = new Weblogs_lib();
        $co->sql = $sql;
        $co->url();
    }

    /**
     * Registra o log da última procedure executada e seus parametros.
     * 
     * @param string $pacote
     * @param string $procedure
     * @param array $params
     */
    private function log_procedure($pacote, $procedure, $params) {
        $co = new Weblogs_lib();
        $parametros = "";

        //obtem cada parametro e o seu respectivo valor que será enviado a procedure
        foreach ($params as $row) {
            $parametros .= "[" . $row['name'] . " => " . $row['value'] . "], \n";
        }

        $co->sql = $pacote . "." . $procedure . " (" . $parametros . ")";
        $co->url();
    }

}
