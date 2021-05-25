<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Opcao_Cardapio_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table = "BD_SICA.CL_OPCAO_CARDAPIO";
        $this->view = "BD_SICA.CL_OPCAO_CARDAPIO";
    }

}
