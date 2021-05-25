<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usuarios extends CI_Controller {
     
     function __construct() {
        parent::__construct();

        $this->load->model('usuarios_model', 'user', TRUE);        
        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'session')); 
        
        $this->lang->load('sistema', 'portugues');
    }
    
    function index() {
        
        redirect('usuarios/login', 'refresh');
    }
    
    //Verifica o Proxy e retorna o ip real
    function getRealIPAddress(){ 
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //check ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
        }else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //to check ip is pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
        $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    //retorna nome da máquina remota pelo IP
    function NomeMaquinaRem(){
        $Nome = gethostbyaddr(getRealIPAddress());
        return $Nome;
    }

    //Mac da Máquina remota conectada
    function MacAdressByWindows(){
        $ipAddress = getRealIPAddress();
        #run the external command, break output into lines
        exec("arp -a $ipAddress", $output);
        $IpMac = explode(" ", trim($output[3]));
        return $IpMac[11];
    }
    
    
    function login() {
        
        //echo $_SERVER['REMOTE_ADDR'];
        $this->load->view('usuarios/login');
    }
    
    
    function acesso() {
        
        //remove all session data
        $this->session->unset_userdata('SGP_LANG');
        $this->session->unset_userdata('SGP_USER');
        $this->session->unset_userdata('SGP_NOME');
        $this->session->unset_userdata('SGP_PESSOA');
        $this->session->unset_userdata('SGP_FUNCAO');
        $this->session->unset_userdata('SGP_CODIGO');
        $this->session->unset_userdata('SGP_PROFESSOR');
        $this->session->unset_userdata('SGP_PERIODO');        
        //limpar o ultima pesquisa realizada
        $this->session->unset_userdata('SGP_FILTRO');

        $this->form_validation->set_rules('lguser', ' ', 'trim|required|xss_clean');
        $this->form_validation->set_rules('lglang', ' ', 'trim|required|xss_clean');
        $this->form_validation->set_rules('lgpass', ' ', 'trim|required|xss_clean|callback_validar_usuario');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('usuarios/login');
        } else {
            redirect('home/index', 'refresh');
        }
    }

    function validar_usuario($lgpass) {

        $lguser = $this->input->post('lguser');
        $p = array(
         'operacao' => 'L',
          'usuario' => $lguser,
            'senha' => $lgpass
        );
        $result = $this->user->acesso($p);        
        
        if ($result == FALSE) {
            $this->form_validation->set_message('validar_usuario', "<div class='alert alert-danger'><span class='fa fa-remove-circle'></span> usuário/senha inválidos</div>");
            return FALSE;
        } else {
            
            //if($result[0]['TIPO_TEXTO'] == 'colaborador'){
            if($result[0]['TIPO_TEXTO'] == 'colaborador' || $result[0]['TIPO_TEXTO'] == 'aluno'){
                $sess_array = array();
                $this->session->set_userdata('SGP_LANG',$this->input->post('lglang'));
                $this->session->set_userdata('SGP_USER', $result[0]['USU_LOGIN']);
                $this->session->set_userdata('SGP_NOME', $result[0]['USU_NOME']);
                $this->session->set_userdata('SGP_PESSOA', $result[0]['USU_PESSOA']);
                $this->session->set_userdata('SGP_FUNCAO', $result[0]['TIPO_TEXTO']);
                $this->session->set_userdata('SGP_CODIGO', $result[0]['USU_CODIGO']);
                $this->session->set_userdata('SGP_PROFESSOR', $result[0]['USU_PROFESSOR']);
                $this->session->set_userdata('SGP_PERIODO', $result[0]['PERIODO_ATUAL']);
                return TRUE;
            }else{
                $this->form_validation->set_message('validar_usuario', "<div class='alert alert-danger'><span class='fa fa-remove-circle'></span> usuário/senha inválidos</div>");
                return FALSE;
            }
        }
    }

    function logout() {

        //remove all session data
        $this->session->unset_userdata('SGP_LANG');
        $this->session->unset_userdata('SGP_USER');
        $this->session->unset_userdata('SGP_NOME');
        $this->session->unset_userdata('SGP_PESSOA');
        $this->session->unset_userdata('SGP_FUNCAO');
        $this->session->unset_userdata('SGP_CODIGO');
        $this->session->unset_userdata('SGP_PROFESSOR');
        $this->session->unset_userdata('SGP_PERIODO');
        //limpar o ultima pesquisa realizada
        $this->session->unset_userdata('SGP_FILTRO');

        $this->session->sess_destroy();
        redirect(base_url(), 'refresh');
    }

    function error() {
         $this->load->view('layout/error');
    }
    
    function foto() {
        
         $parametro = array(
            'operacao' => 'FT',
            'usuario' => $this->input->get('codigo'),
        );
        $result = $this->user->acesso($parametro);
        header_remove("Content-Type: image/jpg'"); 
        $img = $result[0]['FOTO'];
        if($img == ''){
            echo "".SCL_IMG."user.png";
        }else{
            header("Content-Type: image/jpg'"); 
            echo $img;
            //echo '<img src="data:image/png;base64,'.base64_encode($img).'" >';
        }
        exit();
    }

}