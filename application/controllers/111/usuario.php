<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usuario extends CI_Controller {
    
     function __construct() {
        parent::__construct();
        $this->load->model('sica/grupo_model', 'grupo', TRUE);
        $this->load->model('sica/grupos_usuarios_model', 'grupo_usuario', TRUE);
        $this->load->model('sica/usuario_model', 'usuario', TRUE);
        $this->load->model('sica/grupo_model', 'perfil', TRUE);
        $this->load->model('sica/upermissao_model', 'permissao', TRUE);
        $this->load->model('rh/funcionario_model', 'funcionario', TRUE);
        $this->load->model('rh/professor_model', 'professor', TRUE);

        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'Senha_lib'));
    }
    
    
    function index() {
        
        $data = array(
            'side_bar' => false,
            'TituloSistema' => 'CONTROLE DE ACESSO',
            'titulo' => 'CONTROLE DE ACESSO',
            'SubTitulo' => 'USUÁRIOS',
            'listar'   => $this->usuario->listar(array('campo'=>'NM_USUARIO', 'ordem'=>'ASC')),
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/usuario/index', $data);
    }
    
    function frmPrograma($id) {
        $data = array(
            'listar'   => $this->permissao->filtrar(array(array('campo' => 'CD_USUARIO', 'valor' => (int)$id))),
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/usuario/frmPrograma',$data);
    }
    

    function frmCadastro($id) {
        $item = explode('-',$id); 
        $data = array(            
            'operacao' => $item[0],
            'id'       => $item[1],
            'filtro'   => $this->usuario->pesquisar_id(array('campo'=>'CD_USUARIO', 'valor'=>$item[1])),
            'perfil'   => $this->perfil->listar(array('campo'=>'DC_GRUPO', 'ordem'=>'ASC')),
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/usuario/frmCadastro',$data);
    }
    
    function frmManter() {
        
        switch($this->input->post('Operacao')){
            case 'I': 
                $param = array(
                         'LOGIN' => $this->input->post('Login'),
                    'NM_USUARIO' => $this->input->post('Nome'),
                        'FUNCAO' => $this->input->post('Funcao'),
                         'EMAIL' => $this->input->post('Email'),
                'SENHA_INTERNET' => $this->input->post('Nome'),
                'CD_FUNCIONARIO' => $this->input->post('Funcionario'),
                     'CD_PESSOA' => $this->input->post('Pessoa'),
                  'CD_PROFESSOR' => $this->input->post('Professor'),
                     'CD_PERFIL' => $this->input->post('Perfil'),
                );
                //print_r($param);
                //$retorno = $this->usuario->inserir($param);
                
                // ATUALIZA A PERMISSÃO DO USUÁRIO
                $this->frmManterPerfil();
                
            break;
            case 'U':
                $param = array(
                    array('campo' => 'EMAIL',     'valor' => $this->input->post('Email')),
                    array('campo' => 'CD_PERFIL', 'valor' => $this->input->post('Perfil')),
                );
                // PK DA TABELA PAR ATUALIZAR REGISTRO
                $key = array(
                    array('campo' => 'CD_USUARIO', 'valor' => $this->input->post('Codigo')),
                );
                // ATUALIZA O REGISTRO
                $retorno = $this->usuario->editar($key,$param);
                
                // ATUALIZA A PERMISSÃO DO USUÁRIO
                $this->frmManterPerfil();
                
            break;
            case 'D':
                $param = array(
                    array('campo' => 'ATIVO', 'valor' => 0),
                );
                $key = array(
                    array('campo' => 'CD_USUARIO', 'valor' => $this->input->post('Codigo')),
                );
                $retorno = $this->usuario->editar($key,$param);
            break;
        }
        echo $retorno;
        sleep(2);
        echo '<script>window.location.reload();</script>';
    }
    
    function frmManterPerfil() {
        
        // PEGA OS REGISTROS DO USUÁRIO PARA ATUALIZAÇÃO
        $usuario = $this->usuario->pesquisar_id(array('campo'=>'CD_USUARIO', 'valor'=> $this->input->post('Codigo')));
        print_r($usuario);
        exit;
        // LIMPA O PERFIL ANTERIOR
        $p = array(
            array('campo' => 'CD_USUARIO', 'valor' => $usuario->CD_USUARIO),
        );
        $retorno = $this->grupo_usuario->deletar($key,$param);
        
        // ATUALIZA O PERFIL
        $param = array(
            'CD_USUARIO' => $usuario->CD_USUARIO,
            'CD_GRUPO'   => $this->input->post('Perfil'),
        );
        $retorno = $this->grupo_usuario->inserir($param);
    }
    
    function frmPessoa() {
        
        $data = array();
        switch($this->input->post('tipo')){
            case 'F':
                // LISTA DE FUNCIONÁRIOS
                $result = $this->funcionario->pesquisar_id(array('campo'=>'CD_FUNCIONARIO', 'valor'=>$this->input->post('pessoa')));
                $data =  array(
               'funcionario' => $result->CD_FUNCIONARIO,
                 'professor' => '',
                    'pessoa' => $result->CD_PESSOA,
                    'nome'   => $result->NM_FUNCIONARIO,
                    'funcao' => $result->NM_FUNCAO,
                    'email'  => $result->EMAIL,
                    'cpf'    => $result->CPF,
                );
            break;
            case 'P':
                // LISTA DE PROFESSOR
                $result = $this->professor->pesquisar_id(array('campo'=>'CD_PROFESSOR', 'valor'=>$this->input->post('pessoa')));
                
                $data =  array(
               'funcionario' => '',
                 'professor' => $result->CD_PROFESSOR,
                    'pessoa' => $result->CD_PESSOA,
                    'nome'   => $result->NM_PROFESSOR,
                    'funcao' => $result->NM_FUNCAO,
                    'email'  => $result->EMAIL,
                    'cpf'    => $result->CPF,
                );
                
            break;
        }
        $dados = json_encode($data);        
        print_r($dados);

    }
    
    /* SELEÇÃO TIPO
     * {
     *    FUNÇÃO PARA MONTAR O COMBO LIST APÓS 
     *    SELECIONAR O TIPO DE USUÁRIO QUE SERÁ CRIADO
     *    OU EDITADO
     * }
     */
    function selecaoTipo() {
        
        switch($this->input->post('tipo')){
            case 'F':
                // LISTA DE FUNCIONÁRIOS
                $result = $this->funcionario->filtrar(array(array('campo'=>'ATIVO_FUNC', 'valor'=>1)));
                $combo = '<option value="">ESCOLHA O FUNCIONÁRIO</option>';
                foreach($result as $r){
                    $combo .= '<option value="'.$r->CD_FUNCIONARIO.'">'.$r->NM_FUNCIONARIO.'</option>';
                }
            break;
            case 'P':
                // LISTA DE PROFESSOR
                $result = $this->professor->filtrar(array(array('campo'=>'ATIVO_PROF', 'valor'=>1)));
                $combo = '<option value="">ESCOLHA O PROFESSOR</option>';
                foreach($result as $r){
                    $combo .= '<option value="'.$r->CD_PROFESSOR.'">'.$r->NM_PROFESSOR.'</option>';
                }
            break;
            case 'T':
                // FUNÇÃO PARA TERCERIZADO
                //$result = $this->usuario->listar(array('campo'=>'NM_USUARIO', 'ordem'=>'ASC'));
            break;
        }
        echo $combo;
        
    }
    
}