<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Aval_Tipo_Prova_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table = "BD_SICA.AVAL_TIPO_PROVA";
        $this->view = "BD_SICA.AVAL_TIPO_PROVA";
    }

}
