<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Material_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table = "BD_FINANCEIRO.EST_MATERIAL";
        $this->view = "BD_FINANCEIRO.VW_MATERIAL_CARDAPIO";
    }

}
