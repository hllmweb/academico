<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gpermissoes_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table = 'BD_SICA.GPERMISSOES';
        $this->view = 'BD_SICA.VW_GPERMISSAO';
    }
    
}



