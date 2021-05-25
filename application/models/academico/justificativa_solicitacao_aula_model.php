<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Justificativa_Solicitacao_Aula_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table = "BD_ACADEMICO.JUSTIFICATIVA_SOLICITACAO_AULA";
        $this->view = "BD_ACADEMICO.JUSTIFICATIVA_SOLICITACAO_AULA";
    }

}
