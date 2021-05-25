<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/* Library Prova_Processamento_lib
 * Autor: Silvio de Souza
 * Email: silvio.souza@seculomanaus.com.br
 * Data: 05/05/2016
 * 
 * Retorna:
 * ----------------------------------------
 * 
 */

class Prova_processamento_lib {

    public $prova;
    
    function processar_cartao() {
        //
        // PROCESSAR CARTÃO RESPOSTA CRUZANDO COM GABARITO
        //
        $obj = & get_instance();
        $obj->load->model('sica/aes_prova_inscritos_model', 'inscritos', TRUE);
        //$obj->load->model('sica/aes_prova_model', 'prova', TRUE);
        $cartoes = $obj->inscritos->filtro_cartao($this->prova);
        print_r($cartoes);
    }
}

?>