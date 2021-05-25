<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Alerta extends CI_Controller {
    
     function __construct() {
        parent::__construct();
        
        $this->load->model('sica/aluno_model', 'aluno', TRUE);
        $this->load->model('sica/sms_model', 'sms', TRUE);
        
        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('soapsms', 'table', 'email'));
    }
    
    function cobranca_cantina() {
        
        $sms = new Soapsms();
        $listar = $this->aluno->listaDevedores();
        $datahr = date('dmyhm');
        
        foreach($listar as $l){
            if(strlen(str_replace(' ','',$l->RES_TEL_CEL)) == 11){
                // parametros para inserir no sistema
                $array = array(
                    'CD_AUTENTICACAO' => $l->CD_ALUNO.$datahr,
                    'NR_TELEFONE' => $l->RES_TEL_CEL,
                    'DS_MENSAGEM' => 'SECULO: Aluno: '.$l->NM_ALUNO.' Almoco: '.$l->SALDO_ALMOCO.' UND. - Credito: R$ '.number_format($l->VL_SALDO,2,',','.').'',
                    'CD_DESTINATARIO' => $l->RES_CPF,
                    'TIPO' => 'SALDO BAIXO',
                    'CD_USUARIO' => 5281,
                    'CD_ALUNO' => $l->CD_ALUNO,
                );

                $this->sms->inserir($array);

                // RECUPERA O ÚLTIMO REGISTRO
                $codigo = $this->sms->max('CD_SMS');

                // PASSA OS PARAMETROS PARA A REQUISIÇÃO SOAP            
                $sms->mensagem = 'SECULO: Aluno: '.$l->NM_ALUNO.' Almoco: '.$l->SALDO_ALMOCO.' UND. - Credito: R$ '.number_format($l->VL_SALDO,2,',','.').'';
                $sms->cliente = $l->RES_CPF;
                $sms->celular = $l->RES_TEL_CEL;
                $sms->codigo = $codigo.'<br>';

                $as = $sms->enviar();
            }
        }
                
        /// ENVIA EMAIL PARA O FINANCEIRO
        $nemail   = 'CENTRO EDUCACIONAL SÉCULO - COBRANÇA WEB';
        $assunto  = 'Relatório de Cobrança - SALDO CANTINA BAIXO';
        $sistema  = 'CENTRO EDUCACIONAL SÉCULO - COBRANÇA WEB';
        $de       = 'sistema.ti@seculomanaus.com.br';
        $para     = 'iolanda.castro@seculomanaus.com.br';
        $para01   = 'sandra.fernandes@seculomanaus.com.br';
        $para02   = 'suporte.ti@seculomanaus.com.br';
        
        // MONTAR A TABELA PARA ENVIAR VIA EMAIL
        $template = array(
            'table_open' => '<table border="1" cellpadding="2" cellspacing="1" style="font-size: 10px">'
        );
        $this->table->set_template($template);
        
        // MONTA O HEADER DO TABLE
        $this->table->set_heading(
            array('CÓDIGO', 
                  'ALUNO', 
                  'RESPONSAVEL',
                  'CPF',
                  'CELULAR',
                  'SALDO',
                  'REFEIÇÃO'
            )
        );
        
        // MONTA AS LINHAS DA TABELA
        foreach($listar as $l){
            $this->table->add_row(
                array($l->CD_ALUNO, 
                      $l->NM_ALUNO,
                      $l->NM_RESPONSAVEL,
                      $l->RES_CPF,
                      $l->RES_TEL_CEL,
                      $l->VL_SALDO,
                      $l->SALDO_ALMOCO
                )
            );
        }
        // COLOCA A TABELA NA VARIÁVEL
        $mensagem = $this->table->generate();
        
        $config = array();
        $config['mailtype']    = 'html';
        $config['charset']     = 'utf-8';
        $config['smtp_crypto'] = 'TLS';
        $config['newline']     = "\r\n";
        $config['wordwrap']    = TRUE;
        
        $this->email->initialize($config);
        $this->email->from($de,$sistema);
        $this->email->to($para);
        $this->email->cc($para01,$para02);
        $this->email->subject($assunto);
        $this->email->message($mensagem);
        $this->email->send();
        //echo $this->email->print_debugger();
    }
}