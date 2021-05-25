<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Programa_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table = 'BD_SICA.PROGRAMAS';
        $this->view = 'BD_SICA.VW_PROGRAMA';
    }
    
}



