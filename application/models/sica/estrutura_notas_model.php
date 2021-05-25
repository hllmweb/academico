<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Estrutura_Notas_model extends MY_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table = "BD_SICA.CL_ESTRUT_NOTAS";
        $this->view = "BD_SICA.VW_CL_ESTRUT_NOTA";
    }

}

