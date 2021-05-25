<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cl_turma_horario_log_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table = 'BD_RH.CL_TURMA_HORARIO_LOG';
        $this->view  = 'BD_RH.VW_CL_TURMA_HORARIO_LOG';
    }
}