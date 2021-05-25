<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Grupos_usuarios_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table = 'BD_SICA.USUARIOS_GRUPOS';
        $this->view = 'BD_SICA.VW_USUARIOS_GRUPOS';
    }
    
}



