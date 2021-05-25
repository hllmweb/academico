<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sistema_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table = 'BD_SICA.T_SISTEMAS';
        $this->view = 'BD_SICA.T_SISTEMAS';
    }
    
}



