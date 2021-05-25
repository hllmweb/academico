<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Configuracao_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table = "BD_RH.PNT_CONFIGURACAO";
        $this->view = "BD_RH.PNT_CONFIGURACAO";
    }

}
