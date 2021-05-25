<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Funcionario_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table = 'BD_RH.PNT_FUNCIONARIO';
        $this->view  = 'BD_RH.VW_FUNCIONARIO';
    }

}