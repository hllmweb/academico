<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tracert {

    public $usuario;

    function modal() {
        $modal = '<meta charset="UTF-8" />
                  <link href="' . base_url('assets/css/bootstrap.min.css') . '" rel="stylesheet">';
        $modal .= '<script src="' . base_url('assets/js/jquery-1.11.0.min.js') . '"></script>';
        $modal .= '<script src="' . base_url('assets/js/bootstrap.min.js') . '"></script>';
        $modal .= '<script>
                    $(document).ready(function(){';
        $modal .= "$('#frmModalAlert').modal('show')";
        $modal .= '});
                </script>';
        $modal .= '<div class="modal fade" id="frmModalAlert"  tabindex="-1" role="dialog" aria-hidden="false" data-backdrop="static" >
                       <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header text-center" style="background: url('.base_url('assets/images/recupera.png') .'); height:100px">
                             <h3 class=" white-text"><i class="fa fa-lock fa-3x"></i> Sessão Expirou!!</h3>
                         </div>
                          <div class="modal-body text-center">
                            <h4>Sua sessão expirou por inatividade, faça novamento o login e continue navegando.</h4>
                            <a href="'.base_url().'" class="btn btn-info"><i class="fa fa-lock"></i> Login</a>
                          </div>
                        </div>
                      </div>
                   </div>';
        return($modal);
    }

    function logado() {
        //session_cache_expire(10);
        if (empty($this->usuario)) {
            echo $this->modal();
        }
    }

    function validar_url() {

        $obj = & get_instance();
        $obj->load->model('controle_model', 'controle', TRUE);
        $obj->load->helper('url');
        $url = $obj->uri->slash_segment(2) . $obj->uri->slash_segment(3);

        $sessao = $obj->session->userdata;

        $params = array('operacao' => 'P',
                         'sistema' => str_replace('/','',$obj->uri->slash_segment(1)));
        $permissao = $obj->controle->weblog($params);
        //-------------- 
        $i = 0;
        $retorno = FALSE;

        foreach ($permissao as $row) {
            $item = explode('/', $row['FORMULARIO']);
            $url_sistema = $item[0] . '/' . $item[1] . '/';

            if ($url_sistema == $url){
                $retorno = TRUE;
                $params = array(
                    'operacao' => 'L',
                    'usuario' => $this->usuario,
                    'programa' => $row['CD_PROGRAMA'] . ' :: ' . $row['NM_PROGRAMA'],
                    'ip' => $sessao['ip_address'],
                    'device' => $sessao['user_agent']
                );                
                $obj->controle->weblog($params);
                return TRUE;
            } else {
                $retorno = FALSE;
            }
        }
        if ($retorno == FALSE) {
           redirect(base_url(),'refresh');
        }
    }
}

?>