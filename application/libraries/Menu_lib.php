<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Menu_lib {

    var $usuario;
    var $responsavel;
    var $tipo;
    
    function icon_sistema($sistema) {
        switch ($sistema) {
            // PORTAL ACADEMICO
            case 87: $icon = array('icon'=>'<span class="pe-stack fa-3x">
                                                <i class="pe-7s-users pe-stack-2x"></i>
                                            </span>');
            break;
            // SISTEMA PARA RESPONSÁVEIS
            case 93: $icon = array('icon'=>'<span class="pe-stack fa-3x">
                                                <i class="pe-7s-monitor pe-stack-2x"></i>
                                                <i class="pe-7s-users pe-stack-1x"></i>
                                            </span>');
            break;
            // ORIENTAÇÃO
            case 101: $icon = array('icon'=>'<span class="pe-stack fa-3x">
                                                <i class="pe-7s-note2 pe-stack-2x"></i>
                                             </span>');
            break;
            // INTRANET
            case 103: $icon = array('icon'=>'<span class="pe-stack fa-3x">
                                                <i class="pe-7s-world pe-stack-2x"></i>
                                             </span>');
            break;
            // GESTOR DE PROVA
            case 108: $icon = array('icon'=>'<span class="pe-stack fa-3x">
                                                <i class="pe-7s-albums pe-stack-2x"></i>
                                                <i class="pe-7s-study pe-stack-1x"></i>
                                             </span>');
            break;
            // PESQUISAS
            case 109: $icon = array('icon'=>'<span class="pe-stack fa-3x">
                                                <i class="pe-7s-note2 pe-stack-2x"></i>
                                             </span>');
            break;
            
            // DIARIO WEB
            case 110: $icon = array('icon'=>'<span class="pe-stack fa-3x">
                                                <i class="pe-7s-notebook pe-stack-2x"></i>
                                            </span>');
            break;
            // CONTROLE DE ACESSO
            case 111: $icon = array('icon'=>'<span class="pe-stack fa-3x">
                                                <i class="pe-7s-lock pe-stack-2x"></i>
                                            </span>');
            break;
            // COMUNICAÇÃO
            case 112: $icon = array('icon'=>'<span class="pe-stack fa-3x">
                                                <i class="pe-7s-lock pe-stack-2x"></i>
                                            </span>');
            break;
            // COORDENAÇÃO
            case 113: $icon = array('icon'=>'<span class="pe-stack fa-3x">
                                                <i class="pe-7s-users pe-stack-2x"></i>
                                            </span>');
            break;
            // PROVAS ONLINE
            case 116: $icon = array('icon'=>'<span class="pe-stack fa-3x">
                                                <i class="pe-7s-users pe-stack-2x"></i>
                                            </span>');

//refeitorio
            case 118: $icon = array('icon'=>'<span class="pe-stack fa-3x">
                                                <i class="pe-7s-coffee pe-stack-2x"></i>
                                            </span>');
            break;
            
        }
        return($icon['icon']);        
    }

    function icon($tipo,$r) {
        switch ($tipo) {
            case 'Cadastro': 
                $icon = array('icon'=>'list-alt', 'cor'=>'green');
                break;
            case 'Relatórios': 
                $icon = array('icon'=>'file-text-o', 'cor'=>'green');
                break;
            case 'Solicitações': 
                $icon = array('icon'=>'tasks', 'cor'=>'green');
                break;
            case 'Provas': 
                $icon = array('icon'=>'desktop', 'cor'=>'green');
                break;
            case 'Comunicação': 
                $icon = array('icon'=>'mail', 'cor'=>'green');
                break;
            case 'Diário de Classe': 
                $icon = array('icon'=>'list-alt', 'cor'=>'green');
                break;
        }
        if($r=='icon'){
            return($icon['icon']);
        }else{
            return($icon['cor']);
        }
    }
    

   function show_menu() {
        $obj = & get_instance();
        $obj->load->helper('url');
        $obj->load->library('session');

        //--------------
        // CRIA O MENU
        $obj->load->model('controle_model','controle',TRUE);        
        $params = array('operacao' => 'P',
                         'usuario' => $this->usuario,
                         'sistema' => $obj->session->userdata('SGP_SISTEMA'));
        
        //var_dump($params);
        $permissao = $obj->controle->weblog($params);
        
        $i = 0;
        foreach ($permissao as $row) {
            if($row['SISTEMA'] != 87){
                $item = explode(' - ', $row['NM_PROGRAMA']);
                $input[$i] = $item[0];
                if (!empty($item[1]))
                    $mnu[$i] = $item[1];
                $i = $i + 1;
            }
        }

        $topico = array_keys(array_flip($input));
        
        $menu =  '<li class="active"><a href="'.base_url('home').'"><span class="menu-icon icon-speedometer"></span> Sistemas</a></li>';
        $menu .= '<li><a href="'.base_url(''.$obj->session->userdata('SGP_SISTEMA').'/main').'"><span class="menu-icon icon-speedometer"></span> Início</a></li>';
        
        foreach ($topico as $row) {
            $item = explode(' - ', $row['NM_PROGRAMA']);
            $menu .= '<li>' . anchor('#'.$row.'', '<i class="fa fa-'.$this->icon($row,'icon').'"> <span class="overlay-label '.$this->icon($row,'cor').'"></span></i> ' . $row . '<span class="arrow"></span>', ' data-toggle="collapse" title="'.$row.'"');
            $j = 0;
            $menu .= '<ul id="'.$row.'" class="nav sidebar-subnav collapse">';
            foreach ($permissao as $l) {
                $parte = explode(' - ', $l['NM_PROGRAMA']);
                $item[$j] = $parte[0];
                $mnu[$j] = $parte[1];
                if ($row == $item[$j]) {
                    $menu .= '<li style="font-size:10px">' . anchor(''.$obj->session->userdata('SGP_SISTEMA').'/'.$l['FORMULARIO'],$mnu[$j], 'title="' . $mnu[$j] . '"').'</li>';
                }
                $j = $j + 1;
            }
            $menu .= '</ul>';
            $menu .= '</li>';
        }
        $menu .= '<li><a href="'.base_url('usuarios/logout').'"><span class="menu-icon icon-folder"></span> Sair</a></li>';

        return $menu;
    }
    
    function show_menu_main() {
        $obj = & get_instance();
        $obj->load->helper('url');
        $obj->load->library('session');

        //--------------
        // CRIA O MENU
        $obj->load->model('controle_model','controle',TRUE);        
        $params = array('operacao' => 'P',
                         'usuario' => $this->usuario,
                         'sistema' => $obj->session->userdata('SGP_SISTEMA'));
       
        $permissao = $obj->controle->weblog($params);
        
        $i = 0;
        foreach ($permissao as $row) {
            if($row['SISTEMA'] != 87){
                $item = explode(' - ', $row['NM_PROGRAMA']);
                $input[$i] = $item[0];
                if (!empty($item[1]))
                    $mnu[$i] = $item[1];
                $i = $i + 1;
            }
        }


        //menu
        $topico = array_keys(array_flip($input));

        //var_dump($topico);

        foreach ($topico as $row) {
            $item = explode(' - ', $row['NM_PROGRAMA']);
            $menu .= '<li class="dropdown">
                        <a href="#" 
                          class="dropdown-toggle" 
                          data-toggle="dropdown" 
                          role="button" 
                          aria-haspopup="true" 
                          aria-expanded="false"
                          style="font-size:16px"
                          <i class="fa fa-'.$this->icon($row,'icon').'"></i>
                          '.$row.'
                          <span class="caret"></span></a>';
            $j = 0;
            //var_dump($permissao);
            //submenu
            var_dump($row);

            $menu .= '<ul class="dropdown-menu" >';
            foreach ($permissao as $l) {
                $parte = explode(' - ', $l['NM_PROGRAMA']);
                $item[$j] = $parte[0];
                $mnu[$j] = $parte[1];
                if ($row == $item[$j]) {
                    $menu .= '<li>' . anchor(''.$obj->session->userdata('SGP_SISTEMA').'/'.$l['FORMULARIO'],$mnu[$j], 'title="' . $mnu[$j] . '" role="menuitem"').'</li>';
                }
                $j = $j + 1;
            }

            if($row == "Provas"){
                $menu .= '<li><a href="'.base_url('108/consultar_provas/index').'">Consultar Provas</a></li>';
            }

            $menu .= '</ul>';
            $menu .= '</li>';
        }
        $menu .= '<ul class="nav navbar-nav navbar-right">
                 <li><a class="text-danger" href="'.base_url('home').'" style="margin-right:5px; font-size: 16px">
                    <i class="fa fa-exchange"></i> Outros Sistemas
                </a></li>';
        $menu .= '<li><a class="text-danger" href="'.base_url('111/portaria').'" style="margin-right5px; font-size: 16px">
                   Portaria
                  </a></li>';

        $menu .= '<li><a href="'.base_url('usuarios/logout').'"  style="margin-right:5px; font-size: 16px">
                    <i class="fa fa-sign-out"></i> Sair
                </a></li></ul>';

        return $menu;
    }

}
?>