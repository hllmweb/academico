<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Evento_Aluno_model extends MY_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table = "BD_SICA.CL_EVENTO_ALUNO";
        $this->view = "BD_SICA.VW_EVENTO_ALUNO";
    }
}

