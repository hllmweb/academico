<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class App_Token_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table = "BD_APLICACAO.APP_TOKEN";
        $this->view = "BD_APLICACAO.APP_TOKEN";
    }

    /**
     * Lista todos os tokens ids do usuário informado.
     * 
     * @param string $usuario
     * @return array Vetor com todos os tokens do usuário informado. Pronto para
     * envio na GCM_Lib
     */
    public function listarTokens($usuario) {
        $registros = $this->filtrar(array(
            array('campo' => 'CD_USUARIO', 'valor' => $usuario)
        ));

        $tokens = array();
        foreach ($registros as $row) {
            $tokens[] = $row->TOKEN_GCM;
        }

        return $tokens;
    }

}
