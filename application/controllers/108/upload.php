<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Upload extends CI_Controller {
    /* Constructor */

    public function __construct() {
        parent::__construct();
    }

    public function do_upload() {
        $path = "/upload/imagem_questao/";
        $filePath = $_SERVER['DOCUMENT_ROOT'] . '/academico' . $path;

        $response = array(
            "success" => false,
            "location" => ""
        );

        foreach ($_FILES as $row) {
            $aux = explode(".", $row['name']);
            $extensao = $aux[1];

            $nome = uniqid(date('Ymd')) . '.' . $extensao;

            if (move_uploaded_file($row['tmp_name'], $filePath . $nome)) {
                $response['success'] = true;
                //$response['location'] = site_url($path . $nome);
                $response['location'] = $nome;
            }
        }

        echo json_encode($response);
    }

}
