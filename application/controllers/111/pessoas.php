<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pessoas extends CI_Controller {

	public function __construct() {
        parent::__construct();
		//$this->load->library("Gennera_lib"); 
    }


	public function index()
	{			

        //$gennera = new Gennera_lib();

        //var_dump(json_decode($gennera->getAllPeople()));

        //exit();
        echo "string";

        //$data['pessoas'] = json_decode($gennera->getAllPeople());

		//$this->load->view('gennera/vw_pessoas',$data);
	}

    public function inserePessoa(){

        

    }

    

}
