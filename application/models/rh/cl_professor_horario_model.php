<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cl_professor_horario_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table = 'BD_RH.CL_TURMA_HORARIO';
        $this->view  = 'BD_RH.PNT_VW_COL_HORARIO_PROFESSOR';
    }
}