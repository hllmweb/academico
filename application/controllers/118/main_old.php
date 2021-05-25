<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Main extends CI_Controller {
    
     function __construct() {
        parent::__construct();

         $this->load->model("118/nutricao_model","model",true);
        //$this->load->model("geral/colegio_model","model",TRUE);

//        $this->load->helper(array('form', 'url', 'html', 'directory'));
        
                
    }
    
    public function index()
    {

        $this->load->view("118/cabecalho.php");
        $this->load->view("118/index.php");
        $this->load->view("118/rodape.php");
    }


    public function consulta(){
        
        $dataInicial = $this->input->post("dataInicial");
        $dataFinal = $this->input->post("dataFinal");

        $data['registros'] = $this->model->almoco($dataInicial, $dataFinal);
        $this->load->view("118/cabecalho.php");
        $this->load->view("118/consulta.php", $data);
        $this->load->view("118/rodape.php");
    }
}