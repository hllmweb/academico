<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cursos_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table = "BD_SICA.CURSOS";
        $this->view = "BD_SICA.CURSOS";
    }

    function listar() {
        $this->db->where('U.CD_USUARIO', $this->session->userdata('SGP_CODIGO'));
        $this->db->join('BD_SICA.T_CURSO_USER U', 'U.CD_CURSO = C.CD_CURSO');
        $this->db->order_by('C.NM_CURSO_RED', 'ASC');
        $query = $this->db->get('BD_SICA.CURSOS C')->result_array();
        return $query;
    }

    /**
     * Retornas os cursos existentes da escola com exceção da atividade extra.
     * 
     * @return array
     */
    function listarCursosOrdem() {
        $this->db->select('C.NM_CURSO_RED, C.CD_CURSO');
        $this->db->where("DURACAO_ANOS IS NOT NULL");
        $this->db->order_by('C.NM_CURSO_RED', 'ASC');
        $query = $this->db->get('BD_SICA.CURSOS C')->result_array();
        return $query;
    }

    /**
     * Lista todos os cursos regulares, Infantil, Fund. I, Fund. II e Médio.
     * 
     * @return array
     * 
     * @todo Remover método listarCursosOrdem mas primeiro refatorar onde é
     * utilizado para recuperar dados como objetos da stdClass.
     */
    public function listarRegular() {
        $this->db->select('C.CD_CURSO, C.NM_CURSO_RED');
        $this->db->where("DURACAO_ANOS IS NOT NULL");
        $this->db->order_by('C.NM_CURSO_RED', 'ASC');
        $query = $this->db->get('BD_SICA.CURSOS C');
        return $query->result();
    }

    /**
     * Lista os cursos associados ao usuário informado;
     * 
     * @param int $usuario
     * @return object[]
     * 
     * Note: método identifo ao listar mas criado para padrozina o uso de 
     * vetor de objetos nas views
     */
    public function listarCursosUsuario($usuario) {
        $this->db->from('BD_SICA.CURSOS C');
        $this->db->join('BD_SICA.T_CURSO_USER U', 'U.CD_CURSO = C.CD_CURSO');
        $this->db->where('U.CD_USUARIO', $usuario);
        $this->db->order_by('C.NM_CURSO_RED', 'ASC');

        $query = $this->db->get();
        return $query->result();
    }

}
