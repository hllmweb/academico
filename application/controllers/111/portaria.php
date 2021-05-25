<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Portaria extends CI_Controller {

	public function __construct() {
        parent::__construct();
		//$this->load->library("Gennera_lib"); 

        $this->load->model('sica/portaria_model', 'portaria', TRUE);
        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation'));
    }

	public function index(){			
        //$gennera = new Gennera_lib();

        //var_dump(json_decode($gennera->getAllPeople()));

        //exit();
        // echo "string";

        //$data['pessoas'] = json_decode($gennera->getAllPeople());
		// $data = array(
		//  	'listar'   => ''
		// );

		//$data['listar'] => $this->sistema->listar();

        // $sql = "'SELECT L.*, U.NM_USUARIO, DC_FUNCAO, NM_CENTRO_CUSTO, DECODE(L.FLG_PASSAGEM,'E','ENTRADA','S','SAÍDA','ENTRADA/SAÍDA') DC_PASSAGEM FROM BD_CONTROLE.CT_USUARIO_LIBERACOES L INNER JOIN BD_CONTROLE.USUARIOS U ON U.CD_USUARIO = L.CD_USUARIO LEFT JOIN BD_RH.VW_PESSOA_ALL P ON P.CD_RM = L.CD_USUARIO WHERE U.TIPO_USUARIO NOT IN ('A','R') ORDER BY U.NM_USUARIO, L.DATA_CAD'";
        
        // // $query = $this->db->query($sql);
        // // $data['listar'] = $query->result();
        
        // $query = $this->db->query($sql);
        // $data['lista'] = $query->result();


        // $data = array(
        //     'listar' => $this->portaria->get_listagem()
        // );

        // var_dump($data);

        /*
        $data = array(
            'side_bar'      => false,
            'TituloSistema' => 'CONTROLE DE ACESSO',
            'titulo'        => 'CONTROLE DE ACESSO',
            'SubTitulo'     => 'PORTARIA',
            'listar'        => $this->portaria->get_listagem(array('campo'=>'NM_PROGRAMA', 'ordem'='ASC')),
        );

        var_dump($data);
        exit;*/

        $data = array(
            'side_bar'      => false,
            'TituloSistema' => 'CONTROLE DE ACESSO',
            'titulo'        => 'CONTROLE DE ACESSO',
            'SubTitulo'     => 'PORTARIA',
            'listar'        => $this->portaria->get_listar(),
        );
        
        var_dump($data);
        // exit;
       
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/portaria/index',$data);
	}

    
    function frmCadastro($id) {
        $item = explode('-',$id); 
        $data = array(            
            'operacao' => $item[0],
        );

        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/portaria/frmCadastro',$data);
    }


    /*function lstUsuarios(){
        $pesquisa =  array(
                'listar' => $this->input->post("nome")
        );

        return $this->portaria->get_userListagem($pesquisa);
    }*/

    function listNome(){

        // $json = '["country1","country2","country3","hugo","carlos"]';
        // echo $json;
    
        $campoNome = $this->input->get_post("Nome");
        $this->db->select('CD_USUARIO, NM_USUARIO');
        //$this->db->where('TIPO_USUARIO','F');
        $this->db->where_not_in('TIPO_USUARIO', 'V','R', 'A');
        $this->db->like('NM_USUARIO', $campoNome, 'before');
        $query = $this->db->get("BD_CONTROLE.USUARIOS");

        $output = array();
        if($query->num_rows() > 0){
            foreach($query->result_array() as $row){
                $output[] = array(
                    'name' => $row['NM_USUARIO'],
                    'cd_usuario' => $row['CD_USUARIO']
                );
            }
            echo json_encode($output);
        }



        // $sql = "SELECT NM_USUARIO FROM BD_SICA.USUARIOS 
        //     WHERE NM_USUARIO LIKE '%".$query."%'
        //     LIMIT 10"; 
        // $result = $this->db->query($sql);

        // $json = [];
        // while($row = $result->fetch_assoc()){
        //     $json[] = $row["NM_USUARIO"];
        // }

    }

    function fetch(){
      echo $this->portaria->fetch_data($this->uri->segment(3));
    }

    function insertPortaria(){
        $params = array(
            'CD_USUARIO'        =>  $this->input->post("Codigo"),
            'DT_INICIO'         =>  $this->input->post("Data_Atual"),
            'DT_FIM'            =>  $this->input->post("Data_Inicial"),
            'HR_INICIO'         =>  $this->input->post("Horario_Inicial"),
            'HR_FIM'            =>  $this->input->post("Horario_Fim"),
            'FLG_PASSAGEM'      =>  $this->input->post("Tipo_Saida"),
        );

        $retorn = $this->portaria->set_libPortaria($params);

        echo $retorn;
        
        #sleep(2);
        #echo '<script>window.location.reload();</script>';
    }

}