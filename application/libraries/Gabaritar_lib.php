<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

    /* Library Prova_lib
     * Autor: Silvio de Souza
     * Email: silvio.souza@seculomanaus.com.br
     * Data: 08/04/2015
     * 
     * Retorna:
     * ----------------------------------------
     * 
     */

class Gabaritar_lib {
    
    public $numero_prova;
    public $respostas;
       
    function atualizar() {

        // RETORNA A RELAÇÃO DE ALUNOS DA PROVA
        $obj = & get_instance();
        $obj->load->model('banco/bancoprova_model', 'banco', TRUE);
        
        $p = array(
         'operacao' => 'UG', 
           'numero' => $this->numero_prova,
        'respostas' => $this->respostas,
                );
       
        $alunos = $obj->banco->prova_detalhe($p);
        return($alunos);

    }

}

?>