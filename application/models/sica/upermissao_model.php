<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Upermissao_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table = 'BD_SICA.UPERMISSOES';
        $this->view = 'BD_SICA.VW_UPERMISSAO';
    }
    
}



