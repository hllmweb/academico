<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Weblogs_lib {

    public $sql;

    function url() {
        
        $obj = & get_instance();
        $obj->load->model('sica/weblogs_model', 'weblogs', TRUE);
        $obj->load->helper('url');
        $url = $obj->uri->uri_string;
        $sessao = $obj->session->userdata;
        
        $params = array(
            'usuario' => $obj->session->userdata('SGP_CODIGO'),
           'programa' => $url,
                 'ip' => $sessao['ip_address'],
        'dispositivo' => $sessao['user_agent'],
                'sql' => $this->sql
        );
        
        $obj->weblogs->adicionar($params);
    }
}

?>