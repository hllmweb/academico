<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

    /* Library GCM_lib
     * 
     * Author: Silvio de Souza
     * Mail: silvio.souza@seculomanaus.com.br
     * Date: 04/10/2016
     *   
     * Classe para envio de Mensagens por Notifications para 
     * Devices ( mobile ) através do GCM do google notifications
     * 
     */

class Gcm_lib {

    private $key = 'AIzaSyB5iUSTEoUkVD8Iats6pe_C5rCufu555s4';
    private $url = 'https://android.googleapis.com/gcm/send';
    private $action = 'OPEN_MAIN_ACTIVITY';
    private $fields;

    public $reg_id = array();
    public $codigo;
    public $mensagem;
    public $dados;

    private function enviar() {
            
        header("Content-Type: text/html; charset=utf-8");
        /*
         * Função para enviar as Notificações para
         * os devices após registrar no firebird
         */

        $headers = array(
            'Authorization: key=' . $this->key,
            'Content-Type: application/json'
        );        
        /*
         * CURL para envio direto para o Servidor Google
         */        
        // Iniicia a transação
        $ch = curl_init();
        // Monta a URL
        curl_setopt($ch, CURLOPT_URL, $this->url);
        // Informa o método de envio
        curl_setopt($ch, CURLOPT_POST, true);
        // Monta o header da transação
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // Converte o Encode para UTF - 8
        curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
        // Retorno da transaferência 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Se o CURL solicitado precisa de certificado SSL
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // Envia os campos para o CURL
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->fields));
        // executa os processos iniciados acima e.
        $result = curl_exec($ch);
        // Casdo o resultado da execução seja um erro
        if ($result === FALSE) {
            die('Ocorreu um Problema: ' . curl_error($ch));
        }
        // Fecha a transação
        curl_close($ch);
        // retorna o resultado
        echo $result;
     }

    function evento_cobrado() {

        /*
         * Função para enviar as Notificações para
         * os devices após registrar no firebird
         */

        $this->fields = array(
            'registration_ids' => $this->reg_id,
            'content_available' => true,
            'notification' => array(
                'title' => $this->titulo,
                 'body' => $this->mensagem,
         'click_action' => $this->action
            ),
            'data' => $this->dados,
            'delay_while_idle' => false
        );
        
        //print_r(json_encode($this->fields));exit;
        
        // ENVIA OS CAMPOS POR CURL
        $this->enviar();
     }

    function evento_naocobrado() {

        /*
         * Função para enviar as Notificações para
         * os devices após registrar no firebird
         */

        $this->fields = array(
            'registration_ids' => $this->reg_id,
            'content_available' => true,
            'notification' => array(
                'title' => $this->titulo,
                 'body' => $this->mensagem,
         'click_action' => $this->action
            ),
            'data' => $this->dados,
            'delay_while_idle' => false
        );
        //print_r(json_encode($this->fields));
        // ENVIA OS CAMPOS POR CURL
        $this->enviar();
     }

    function comunicado() {

        /*
         * Função para enviar as Notificações para
         * os devices após registrar no firebird
         */

        $this->fields = array(
            'registration_ids' => $this->reg_id,
            'content_available' => true,
            'notification' => array(
                'title' => $this->titulo,
                 'body' => $this->mensagem,
         'click_action' => $this->action
            ),
            'data' => $this->dados,
            'delay_while_idle' => false
        );
        // ENVIA OS CAMPOS POR CURL
        $this->enviar();
    }

}