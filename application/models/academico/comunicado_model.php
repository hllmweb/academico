<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Comunicado_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table = "BD_ACADEMICO.COMUNICADO";
        $this->view = "BD_ACADEMICO.VW_COMUNICADO";
    }

}
