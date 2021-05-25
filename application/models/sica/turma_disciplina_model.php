<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Turma_Disciplina_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table = "BD_SICA.CL_TURMA_DISCIPLINAS";
        $this->view = "BD_SICA.VW_TURMA_DISCIPLINA";
    }

}
