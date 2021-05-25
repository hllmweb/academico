<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Portaria_model extends MY_Model {
    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->view = "BD_SICA.PRODUTOS";
    }
    // RETORNA UM ARRAY 
    // function listar($p) {
       // $sql = "SELECT L.*, U.NM_USUARIO, DC_FUNCAO, NM_CENTRO_CUSTO,
          // DECODE(L.FLG_PASSAGEM,'E','ENTRADA','S','SAÍDA','ENTRADA/SAÍDA') DC_PASSAGEM
           // FROM BD_CONTROLE.CT_USUARIO_LIBERACOES L
              // INNER JOIN BD_CONTROLE.USUARIOS U ON U.CD_USUARIO = L.CD_USUARIO              
              // LEFT JOIN BD_RH.VW_PESSOA_ALL P ON P.CD_RM = L.CD_USUARIO                                                  
          // WHERE U.TIPO_USUARIO NOT IN ('A','R')
          // ORDER BY U.NM_USUARIO, L.DATA_CAD";

    //     $query = $this->db->query($sql);

    //     $result = $query->result();

    //     return $result;
    // }

    // function listar($p){
    //     $query = $this->db->query("SELECT L.*, U.NM_USUARIO, DC_FUNCAO, NM_CENTRO_CUSTO, DECODE(L.FLG_PASSAGEM,'E','ENTRADA','S','SAÍDA','ENTRADA/SAÍDA') DC_PASSAGEM FROM BD_CONTROLE.CT_USUARIO_LIBERACOES L INNER JOIN BD_CONTROLE.USUARIOS U ON U.CD_USUARIO = L.CD_USUARIO LEFT JOIN BD_RH.VW_PESSOA_ALL P ON P.CD_RM = L.CD_USUARIO WHERE U.TIPO_USUARIO NOT IN ('A','R') ORDER BY U.NM_USUARIO, L.DATA_CAD");
     
    //     return $query->result();   
    // }


    //Lista todos os campos da tebela
    function get_listar($p){
      /*$this->db->select('MOTIVO');
      $this->db->from('BD_CONTROLE.CT_USUARIO_LIBERACOES');
      $this->db->order_by($p['campo'], $p['ordem']);
      $query = $this->db->get();
      return $query->result_array();*/
      //$sql = "SELECT * FROM BD_CONTROLE.CT_USUARIO_LIBERACOES";
      //return $this->db->query($sql)->result_array();

      /*$this->db->select('USERNAME_CAD, CD_USUARIO');
      $this->db->from('BD_CONTROLE.CT_USUARIO_LIBERACOES'); 
      $this->db->order_by('USERNAME_CAD','ASC');
      $this->db->limit(5,1);*/

      // $this->db->select("L.*, 
      //   U.NM_USUARIO, 
      //   DC_FUNCAO, 
      //   NM_CENTRO_CUSTO, 
      //   DECODE(L.FLG_PASSAGEM,'E','ENTRADA','S','SAÍDA','ENTRADA/SAÍDA') DC_PASSAGEM FROM BD_CONTROLE.CT_USUARIO_LIBERACOES L");
      // // $this->db->from("BD_CONTROLE.CT_USUARIO_LIBERACOES L");
      // $this->db->join("BD_CONTROLE.USUARIOS U", "U.CD_USUARIO = L.CD_USUARIO");
      // $this->db->join("BD_RH.VW_PESSOA_ALL P", "P.CD_RM = L.CD_USUARIO","left");
      // $this->db->where_not_in("U.TIPO_USUARIO", "A","R");
      // // $this->db->limit(5,1);
      // $query = $this->db->get()->result_array(); 
      // return  $query;

    }



    function get_userListagem($p){
      $sql = "SELECT NM_USUARIO FROM BD_SICA.USUARIOS WHERE NM_USUARIO LIKE '{$p['nome']}%'";
      return $this->db->query($sql)->result_array();
    }
      
    //Insere na tabela
    function set_libPortaria($p){
      $data = array(
        'USERNAME_CAD'        => $this->session->userdata('SGP_USER'),
        'CD_USUARIO'          => $p['CD_USUARIO'],
        'DT_INICIO'           =>  date('d-M-y',strtotime(implode("-",array_reverse(explode("/",$p['DT_INICIO']))))),
        'DT_FIM'              =>  date('d-M-y',strtotime(implode("-",array_reverse(explode("/",$p['DT_FIM']))))),
        'HR_INICIO'           => $p['HR_INICIO'],
        'HR_FIM'              => $p['HR_FIM'],
        'FLG_PASSAGEM'        => $p['FLG_PASSAGEM'],
        'FLG_HORARIO'         => 1
      );
      

      $query = $this->db->insert('BD_CONTROLE.CT_USUARIO_LIBERACOES', $data);

      if($query):
        echo "ok";
      else:
        echo "erro";
      endif;


    }


    //lista usuarios na tabela
    function set_lstNome($p){
      // $data = array(
      //   'NM_USUARIO' => $p['NM_USUARIO']
      // );

      // var_dump($p["NM_USUARIO"]);
      // exit;

      $this->db->select('NM_USUARIO');
      $this->db->from('BD_SICA.USUARIOS');
      $this->db->like('NM_USUARIO', $p['NM_USUARIO'], 'before');
      $query = $this->db->get();


      foreach($query->result_array() as $row){
        echo $row["NM_USUARIO"];
      }
    }

    function fetch_data($query){
      $this->db->like('NM_USUARIO', $query);
      $query = $this->db->get('BD_SICA.USUARIOS');
      if($query->num_rows() > 0) {
         foreach($query->result_array() as $row){
          $output[] = array(
           'name'  => $row["NM_USUARIO"]
          );
      }
      echo json_encode($output);
      }
    }


}
?>