<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cl_grade_disciplinas_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table = "BD_SICA.CL_GRADE_DISCIPLINAS";
        $this->view = "BD_SICA.VW_CL_GRADE_DISCIPLINAS";
    }
}
