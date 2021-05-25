<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Grupo extends CI_Controller {

     function __construct() {
        parent::__construct();

        $this->load->model('sica/grupo_model', 'grupo', TRUE);
        $this->load->model('sica/programa_model', 'programa', TRUE);
        $this->load->model('sica/sistema_model', 'sistema', TRUE);
        $this->load->model('sica/gpermissoes_model', 'permissao', TRUE);
        $this->load->model('sica/grupos_usuarios_model', 'gusuarios', TRUE);

        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'table'));

    }
    
    function index() {
        
        $data = array(
            'side_bar' => false,
            'TituloSistema' => 'CONTROLE DE ACESSO',
            'titulo' => 'CONTROLE DE ACESSO',
            'SubTitulo' => 'PERFIL',
            'listar'   => $this->grupo->listar(array('campo'=>'DC_GRUPO', 'ordem'=>'ASC')),
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/grupo/index', $data);
    }

    function frmPrograma($id) {
        $data = array(
            'filtrar' => $this->grupo->pesquisar_id(array('campo'=>'CD_GRUPO', 'valor'=>$id)),
             'listar' => $this->permissao->filtrar(array(array('campo'=>'CD_GRUPO', 'valor'=>$id))),
            'sistema' => $this->sistema->listar(array('campo'=>'DC_SISTEMA', 'ordem'=>'ASC')),
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/grupo/frmPrograma',$data);
    }

    function frmUsuario($id) {
        $data = array(
            'listar'   => $this->gusuarios->filtrar(array(array('campo'=>'CD_GRUPO', 'valor'=>$id))),
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/grupo/frmUsuario',$data);
    }

    function frmCadastro($id) {
        $item = explode('-',$id); 
        $data = array(            
            'operacao' => $item[0],
            'id'       => $item[1],
            'filtro'   => $this->grupo->pesquisar_id(array('campo'=>'CD_GRUPO', 'valor'=>$item[1])),
        );
        $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/grupo/frmCadastro',$data);
    }

    function frmManter() {
        
        switch($this->input->post('Operacao')){
            case 'I': 
                $param = array(
                    'CD_GRUPO'  => $this->grupo->max('CD_GRUPO')+1,
                    'DC_GRUPO'  => $this->input->post('Nome'),
                    'FLG_ATIVO' => $this->input->post('Status')
                );
                $retorno = $this->grupo->inserir($param);
            break;
            case 'U':
                $param = array(
                    array('campo' => 'DC_GRUPO', 'valor' => $this->input->post('Nome')),
                    array('campo' => 'FLG_ATIVO',     'valor' => $this->input->post('Status')),
                );
                $key = array(
                    array('campo' => 'CD_GRUPO', 'valor' => $this->input->post('Codigo')),
                );
                $retorno = $this->grupo->editar($key,$param);
            break;
            case 'D': 
                $key = array(
                    array('campo' => 'CD_GRUPO', 'valor' => $this->input->post('Codigo'))
                );
                $retorno = $this->grupo->deletar($key);
            break;
        }
        echo $retorno;
        sleep(2);
        echo '<script>window.location.reload();</script>';
    }

    function frmManterUsuario() {
        
        switch($this->input->post('Operacao')){
            case 'I': 
                echo '<div class="alert alert-alt alert-success alert-dismissible" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">×</span></button>Usuário inserido no perfil.</div>'; 
                
                $param = array(
                    'CD_GRUPO'  => $this->input->post('Codigo'),
                    'CD_USUARIO' => $this->input->post('Usuario')
                );
                $retorno = $this->gusuarios->inserir($param);
            break;
            case 'D': 
                echo '<div class="alert alert-alt alert-danger alert-dismissible" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">×</span></button> Usuário removido do perfil.</div>'; 
                
                $key = array(
                    array('campo' => 'CD_GRUPO', 'valor' => $this->input->post('Codigo')),
                    array('campo' => 'CD_USUARIO', 'valor' => $this->input->post('Usuario'))
                );
                $retorno = $this->gusuarios->deletar($key);                
            break;
        }
        $this->grdUsuario($this->input->post('Codigo'));
    }

    function grdUsuario($id) {
        
        /** Retorna a lista de usuários do Grupo **/
        $listar = $this->gusuarios->filtrar(array(array('campo'=>'CD_GRUPO', 'valor'=>$id)));
        /** Monta Grid de Usuários **/
        $template = array(
                'table_open' => '<table id="tbl" class="table table-hover table-striped" cellpadding="0" cellspacing="5" width="100%">'
        );
        $this->table->set_template($template);        
        $this->table->set_heading('Código', 'Usuário', 'Função', '');
        foreach($listar as $l){
            $this->table->add_row(
                    $l->CD_USUARIO, 
                    $l->NM_USUARIO.(($l->ATIVO == 0)? ' - <small class="text-danger">{ demitido }</small>' : '' ), 
                    $l->FUNCAO,
                    '<button type="button" onclick="deletar('.$l->CD_GRUPO.','.$l->CD_USUARIO.')" class="btn btn-danger btn-xs">
                        <i class="fa fa-trash"></i>
                    </button>'
            );
        }
        echo $this->table->generate($data);
    }

    function frmManterPrograma() {
        
        switch($this->input->post('Operacao')){
            case 'I': 
                echo '<div class="alert alert-alt alert-success alert-dismissible" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">×</span></button>Programa inserido ao perfil.</div>'; 
                
                $param = array(
                     'CD_GRUPO' => $this->input->post('Perfil'),
                  'CD_PROGRAMA' => $this->input->post('Programa'),
                );

                foreach($this->input->post('Acao') as $ac){
                    switch ($ac){
                        // INCLUIR
                        case 'I': $param['INCLUIR'] = 1; break;
                        // ALTERAR
                        case 'A': $param['ALTERAR'] = 1; break;
                        // EXCLUIR
                        case 'E': $param['EXCLUIR'] = 1; break;
                        // IMPRIMIR
                        case 'I': $param['IMPRIMIR'] = 1; break;
                        // ESPECIAL 01
                        case 'E1': $param['ESPECIAL1'] = 1; break;
                        // ESPECIAL 02
                        case 'E2': $param['ESPECIAL2'] = 1; break;
                    }
                }
                $retorno = $this->permissao->inserir($param);
            break;
            case 'D': 
                echo '<div class="alert alert-alt alert-danger alert-dismissible" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">×</span></button>Programa removido do perfil.</div>'; 
                
                $key = array(
                    array('campo' => 'CD_GRUPO', 'valor' => $this->input->post('Codigo')),
                    array('campo' => 'CD_PROGRAMA', 'valor' => $this->input->post('Programa'))
                );
                $retorno = $this->permissao->deletar($key);                
            break;
        }
        $this->grdPrograma($this->input->post('Perfil'));
    }

    function grdPrograma($id) {
        
        /** Retorna a lista de usuários do Grupo **/
        $listar = $this->permissao->filtrar(array(array('campo'=>'CD_GRUPO', 'valor'=>$id)));
        
        $sistema = array();
        foreach ($listar as $row) { 
            $sistema[] = $row->DC_SISTEMA;
        }
        $sistema = array_keys(array_flip($sistema));
        
        /** Monta Grid de Usuários **/
        $template = array(
            'table_open' => '<table class="table table-hover table-striped" style="margin:10px; width:98%">'
        );
        $this->table->set_template($template);        
        
        foreach($sistema as $s){
            
            $cell = array('data' => 'SISTEMA { <strong>'.$s.'</strong> }', 'class' => 'panel-footer', 'colspan' => 4);
            $this->table->add_row($cell);
            
            foreach($listar as $l){
                if($s == $l->DC_SISTEMA){
                    $this->table->add_row(
                            $l->CD_PROGRAMA, 
                            $l->NM_PROGRAMA, 
                            $l->FORMULARIO,
                            '<button type="button" onclick="deletar('.$l->CD_GRUPO.','.$l->CD_PROGRAMA.')" class="btn btn-danger btn-xs">
                                <i class="fa fa-trash"></i>
                            </button>'
                    );
                }
            }
        }
        echo $this->table->generate($data);
    }
    
    
    function pntPrograma($id) {
        
        $perfil = $this->grupo->pesquisar_id(array('campo'=>'CD_GRUPO', 'valor'=>$id));
        $data = array(
            'titulo' => 'Controle de Acesso <br/>Relação de Programas do Perfil <br/> '.$perfil->DC_GRUPO.'',
            'filtrar' => $perfil,
             'listar' => $this->permissao->filtrar(array(array('campo'=>'CD_GRUPO', 'valor'=>$id))),
            'sistema' => $this->sistema->listar(array('campo'=>'DC_SISTEMA', 'ordem'=>'ASC')),
        );
        $body = $this->load->view(''.$this->session->userdata('SGP_SISTEMA').'/grupo/pntPrograma',$data, TRUE);
        
        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF('','A4',9,'Arial Narrow');

        $mpdf->SetHTMLHeader($this->load->view('impressao/header_doc', $data, true));

        $mpdf->AddPage('P', // L - landscape, P - portrait
                'A4', '', '', '', 
                2, // margin_left
                2, // margin right
                30, // margin top
                30, // margin bottom
                0, // margin header
                0); // margin footer
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHTMLFooter($this->load->view('impressao/footer_doc', $data, true));
        $mpdf->WriteHTML($body);
        $mpdf->Output();
    }
    
}