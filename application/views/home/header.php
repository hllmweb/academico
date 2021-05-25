<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page title -->
    <title>ACADÊMICO WEB</title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->

    <!-- Vendor styles -->
    
    <link rel="stylesheet" href="<?=base_url('assets/css/')?>/font-awesome.min.css" />
    <link rel="stylesheet" href="<?=base_url('assets/css/')?>/metisMenu.css" />
    <link rel="stylesheet" href="<?=base_url('assets/css/')?>/animate.css" />
    <link rel="stylesheet" href="<?=base_url('assets/css/')?>/bootstrap.css" />

    <link rel="stylesheet" href="<?=base_url('assets/css/')?>/select2.css" />
    <link rel="stylesheet" href="<?=base_url('assets/css/')?>/select2-bootstrap.css" />
    <link rel="stylesheet" href="<?=base_url('assets/css/')?>/awesome-bootstrap-checkbox.css" />
        
    <link rel="stylesheet" href="<?= base_url("assets/css/bootstrap-datepicker.min.css")?>" />
    <link rel="stylesheet" href="<?= base_url("assets/css/daterangepicker.css")?>" />

    <!-- App styles -->
    <link rel="stylesheet" href="<?=base_url('assets/css/dataTables.bootstrap.css')?>" />
    <link rel="stylesheet" href="<?=base_url('assets/css/')?>/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="<?=base_url('assets/css/')?>/helper.css" />
    <link rel="stylesheet" href="<?=base_url('assets/css/')?>/style.css">
    
    <script src="<?=base_url('assets/js/')?>/sweetalert.min.js"></script>
    <link rel="stylesheet" href="<?=base_url('assets/css/')?>/sweetalert.css" />
    <link rel="stylesheet" href="<?=base_url('assets/css/')?>/toastr.min.css" />


    <link rel="stylesheet" href="<?=base_url('assets/css/bootstrap-multiselect.css')?>" type="text/css"/>   
    <link href="<?=base_url('assets/css/')?>/bootstrap-datetimepicker.css" rel="stylesheet">    
    <link href="<?=base_url('assets/css/')?>/bootstrap-material-datetimepicker.css" rel="stylesheet">

    <!-- FULL CALENDAR -->
    <link rel='stylesheet' href='<?= base_url("libs/fullcalendar/fullcalendar.css") ?>' />
    
    <!-- Vendor scripts -->
    <script src="<?=base_url('assets/js/')?>/jquery.min.js"></script>
    <script src="<?=base_url('assets/js/') ?>/jquery.mask.js"></script>
    <script src="<?=base_url('assets/js/')?>/jquery-ui.min.js"></script>
    <!-- <script src="<?php #echo base_url('assets/js/')?>/bootstrap-typeahead.min.js"></script> -->
    <script src="<?=base_url('assets/js/')?>/jquery.slimscroll.min.js"></script>
    <script src="<?=base_url('assets/js/')?>/bootstrap.min.js"></script>
    <script src="<?=base_url('assets/js/')?>/jquery.validate.min.js"></script>
    <script src="<?=base_url('assets/js/')?>/bootstrap-datepicker.min.js"></script>
    <script src="<?=base_url('assets/js/')?>/bootstrap-timepicker.js"></script>
    <script src="<?=base_url('assets/js/')?>/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="<?=base_url('assets/js/')?>/moment-with-locales.js"></script>
    <script type="text/javascript" src="<?=base_url('assets/js/')?>/bootstrap-material-datetimepicker.js"></script>

</head>
<body class="hide-sidebar <? //(($side_bar == true)? 'show-sidebar' : 'hide-sidebar')?>">
<!-- Simple splash screen-->
<div class="splash"> 
    <div class="color-line"></div>
    <div class="splash-title">
        <h1><?=$this->lang->line('AESSistema')?></h1>
        <p><?=$this->lang->line('PGRefresh')?> </p>
        <img src="<?= base_url('assets/images/loading-bars.svg') ?>" width="64" height="64" /> 
    </div> 
</div>
<!--[if lt IE 7]>
    <p class="alert alert-danger">
        You are using an <strong>outdated</strong> browser. 
        Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.
    </p>
<![endif]-->
<!-- Header -->
<div id="header">
    <div class="color-line">
    </div>
    <div id="logo" class="light-version">
        <span>
            ACADEMICO WEB
        </span>
    </div>
    <nav role="navigation">
        <div class="header-link hide-menu" style="display: none"><i class="fa fa-bars"></i></div>
        <div class="small-logo">
            <span class="text-primary"><?=$this->lang->line('AESSistema')?></span>
        </div>
        <div class="navbar-right">
            <ul class="nav navbar-nav no-borders" style="background-color: darkgrey;">
                <li class="dropdown"  style="display:none">
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                        <i class="pe-7s-speaker"></i>
                    </a>
                    <ul class="dropdown-menu hdropdown notification animated flipInX">
                        <li>
                            <a>
                                <span class="label label-success">NEW</span> It is a long established.
                            </a>
                        </li>
                        <li>
                            <a>
                                <span class="label label-warning">WAR</span> There are many variations.
                            </a>
                        </li>
                        <li>
                            <a>
                                <span class="label label-danger">ERR</span> Contrary to popular belief.
                            </a>
                        </li>
                        <li class="summary"><a href="#">See all notifications</a></li>
                    </ul>
                </li>
                <li class="dropdown"  style="display:none">
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                        <i class="pe-7s-keypad"></i>
                    </a>

                    <div class="dropdown-menu hdropdown bigmenu animated flipInX">
                        <table>
                            <tbody>
                            <tr>
                                <td>
                                    <a href="projects.html">
                                        <i class="pe pe-7s-portfolio text-info"></i>
                                        <h5>Projectssss</h5>
                                    </a>
                                </td>
                                <td>
                                    <a href="mailbox.html">
                                        <i class="pe pe-7s-mail text-warning"></i>
                                        <h5>Email</h5>
                                    </a>
                                </td>
                                <td>
                                    <a href="contacts.html">
                                        <i class="pe pe-7s-users text-success"></i>
                                        <h5>Contacts</h5>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </li>
                <li class="dropdown"  style="display:none">
                    <a class="dropdown-toggle label-menu-corner" href="#" data-toggle="dropdown">
                        <i class="pe-7s-mail"></i>
                        <span class="label label-success">4</span>
                    </a>
                    <ul class="dropdown-menu hdropdown animated flipInX">
                        <div class="title">
                            Mensagens
                        </div>
                        <li>
                            <a>
                                Nova mensagem
                            </a>
                        </li>
                        <li class="summary"><a href="#">Todas as Mensagens</a></li>
                    </ul>
                </li>
                <li  style="display:none">
                    <a href="#" id="sidebar" class="right-sidebar-toggle">
                        <i class="pe-7s-upload pe-7s-news-paper"></i>
                    </a>
                </li>
                <li>
                    <a class="dropdown-toggle label-menu-corner" href="#" data-toggle="dropdown" style="font-size: 12px; padding:10px; margin: 0px 20px ; ">
                        <? $foto = (($this->session->userdata('SGP_FUNCAO') == 'aluno')? $this->session->userdata('SGP_USER') : $this->session->userdata('SGP_PESSOA'));?>
                        <span class="font-extra-bold font-uppercase"><?=  substr($this->session->userdata('SGP_NOME'),0,20)?></span>
                    </a>
                    <ul class="dropdown-menu hdropdown animated flipInX">
                        <div class="title">
                            Mudar senha
                        </div>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</div>
<!-- Navigation -->
<aside id="menu" style="display: none">
    <div id="navigation">
        <div class="profile-picture">
            <a href=#>
                <? $foto = (($this->session->userdata('SGP_FUNCAO') == 'aluno')? $this->session->userdata('SGP_USER') : $this->session->userdata('SGP_PESSOA'));?>
                <img src="<?=base_url('usuarios/foto?codigo='.$foto.'')?>" width="76" height="76" class="img-circle m-b" alt="logo">
            </a>

            <div class="stats-label text-color">
                <span class="font-extra-bold font-uppercase"><?=$this->session->userdata('SGP_NOME')?></span>
            </div>
        </div>

        <ul class="nav" id="side-menu">
           <?php
            $this->load->library('menu_lib');
            $menu = new Menu_lib;
            $menu->usuario = $this->session->userdata('SGP_CODIGO');
            $menu->responsavel = $this->session->userdata('SGP_USER');
            $menu->tipo = $this->session->userdata('CES_TIPO');
            echo $menu->show_menu();
            ?>
        </ul>
    </div>
</aside>
<!-- Main Wrapper -->
<div id="wrapper">
    <nav class="navbar navbar-default">
        <div class="navbar-header">
            <ul class="nav navbar-nav">
                <? echo $menu->show_menu_main();?>
            </ul>
        </div>
    </nav>
    <small>
        <ul class="breadcrumb text-right" style="margin-top: 0px">
            <li> <?=$titulo?> </li>
            <li class="active"> <?=$SubTitulo?> </li>
        </ul>
    </small>