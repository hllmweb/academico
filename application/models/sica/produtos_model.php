<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Produtos_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table = "BD_SICA.PRODUTOS";
        $this->view = "BD_SICA.PRODUTOS";
    }

}
