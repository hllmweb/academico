<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Senha_lib {

    public $senha;
    
    var $chave = array(
            1 => '0fbdfd6d73be6ca01888a1f568c8743f',
            2 => '18bcb2c013c60d26263236df037cd4fa',
            3 => '24a497b20ebd3a330ae7cd21695ec398',
            4 => '5bed4b1757cd4a3167eceeab2dd42fd7',
            5 => '1d28a8522b10ae5309caa20b156f8800',
            6 => '28bd63a4732cb6953150d7687a68340b',
            7 => '744a1a010ec792ab0eab5c311008d1f1',
            8 => '4cc163dc500e6a4b7a5a27dd2bc7fe0a',
            9 => '26451dac500a35a74967ee666b249f03',
            10 => '73116b4d6f3b0bbb6ad9435778ecfd3b'
        );
    var $dv = 256;
    
    function init($p) {

       static $sp = '', $s = array();
       if ($sp   == $p){
          return $s;
       }

       $sp   = $p;
       $plen = strlen($p);

       for ($i = 0; $i < $this->dv; $i++){
          $a[$i]        = ord($p{$i % $plen});
          $s[$i]        = $i;
       }
       unset($p);
       for ($i = 0, $j = 0; $i < $this->dv; $i++){
          $j            = ($j + $s[$i] + $a[$i]) % $this->dv;
          $t            = $s[$i];
          $s[$i]        = $s[$j];
          $s[$j]        = $t;
       }
       return $s;    
    }

    function chave($aTexto){
        $aSoma = 0;
        $tamanho = strlen($aTexto);

        for($i = 0;
            $i<=$tamanho;
            $i++){
            $aSoma = $aSoma + ord($aTexto[$i]);
        }
        $aSoma = $aSoma % 10;
        return $this->chave[$aSoma + 1];
    }

    function encode($p, $d){
        /*
         * p = Senha
         * d = Chave
         */
        
        $c  = '';
        $s  = $this->init($p);

        for ($i = 0, $j = 0, $k = 0, $len = strlen($d); $i < $len; $i++){
          $j            = ($j + 1) % $this->dv;
          $k            = ($k + $s[$j]) % $this->dv;
          $t            = $s[$j];
          $s[$j]        = $s[$k];
          $s[$k]        = $t;
          $c           .= chr(ord($d{$i}) ^ $s[($s[$j] + $s[$k]) % $this->dv]);
        }
       return $c;
    }

    function Gerar(){

    }

}

?>