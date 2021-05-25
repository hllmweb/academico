<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sms_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table = 'BD_SICA.SMS';
        $this->view  = 'BD_SICA.SMS';
    }
    
}



