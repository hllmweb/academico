<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page title -->
    <title>SISTEMA ACADÊMICO :: GESTÃO DE PROVAS</title>

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

    <!-- App styles -->
    <link rel="stylesheet" href="<?=base_url('assets/css/')?>/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="<?=base_url('assets/css/')?>/helper.css" />
    <link rel="stylesheet" href="<?=base_url('assets/css/')?>/style.css">
    
    <link rel="stylesheet" href="<?=base_url('assets/css/')?>/sweet-alert.css" />
    <link rel="stylesheet" href="<?=base_url('assets/css/')?>/toastr.min.css" />
    
    
    <!-- Vendor scripts -->
<script src="<?=base_url('assets/js/')?>/jquery.min.js"></script>
<script src="<?=base_url('assets/js/')?>/jquery-ui.min.js"></script>
<script src="<?=base_url('assets/js/')?>/jquery.slimscroll.min.js"></script>
<script src="<?=base_url('assets/js/')?>/bootstrap.min.js"></script>

</head>
<body class="page-small <?=(($side_bar == true)? 'show-sidebar' : 'hide-sidebar')?>">

<!-- Simple splash screen-->
<div class="splash"> 
    <div class="color-line"></div>
    <div class="splash-title">
        <h1>SISTEMA ACADÊMICO :: GESTÃO DE PROVAS</h1>
        <p>aguarde, carregando página... </p>
        <img src="<?=base_url('assets/images/loading-bars.svg')?>" width="64" height="64" /> 
    </div> 
</div>
<!--[if lt IE 7]>
<p class="alert alert-danger">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
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
        <div class="header-link hide-menu"><i class="fa fa-bars"></i></div>
        <div class="small-logo">
            <span class="text-primary">SISTEMA ACADÊMICO</span>
        </div>
        <form role="search" class="navbar-form-custom" method="post" action="#">
            <div class="form-group">
            </div>
        </form>
        <div class="navbar-right">
            <ul class="nav navbar-nav no-borders">
                <li class="dropdown">
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
                <li class="dropdown">
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
                                        <h5>Projects</h5>
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
                            <tr>
                                <td>
                                    <a href="forum.html">
                                        <i class="pe pe-7s-comment text-info"></i>
                                        <h5>Forum</h5>
                                    </a>
                                </td>
                                <td>
                                    <a href="analytics.html">
                                        <i class="pe pe-7s-graph1 text-danger"></i>
                                        <h5>Analytics</h5>
                                    </a>
                                </td>
                                <td>
                                    <a href="file_manager.html">
                                        <i class="pe pe-7s-box1 text-success"></i>
                                        <h5>Files</h5>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle label-menu-corner" href="#" data-toggle="dropdown">
                        <i class="pe-7s-mail"></i>
                        <span class="label label-success">4</span>
                    </a>
                    <ul class="dropdown-menu hdropdown animated flipInX">
                        <div class="title">
                            You have 4 new messages
                        </div>
                        <li>
                            <a>
                                It is a long established.
                            </a>
                        </li>
                        <li>
                            <a>
                                There are many variations.
                            </a>
                        </li>
                        <li>
                            <a>
                                Lorem Ipsum is simply dummy.
                            </a>
                        </li>
                        <li>
                            <a>
                                Contrary to popular belief.
                            </a>
                        </li>
                        <li class="summary"><a href="#">See All Messages</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" id="sidebar" class="right-sidebar-toggle">
                        <i class="pe-7s-upload pe-7s-news-paper"></i>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="login.html">
                        <i class="pe-7s-upload pe-rotate-90"></i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</div>

<!-- Navigation -->
<aside id="menu">
    <div id="navigation">
        <div class="profile-picture">
            <a href=#>
                <img width="76" height="76" src="<?=base_url('usuarios/foto/'.$this->session->userdata('SGP_PESSOA').'')?>" class="img-circle m-b" alt="logo">
            </a>

            <div class="stats-label text-color">
                <span class="font-extra-bold font-uppercase"><?=$this->session->userdata('SGP_NOME')?></span>
            </div>
        </div>

        <ul class="nav" id="side-menu">
           <?
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

<div class="normalheader transition animated fadeIn small-header">
    <div class="hpanel">
        <div class="panel-body">
            <div id="hbreadcrumb" class="pull-right">
                <ol class="hbreadcrumb breadcrumb">
                    <li>SISTEMA ACADÊMICO</li>
                    <li>GESTOR DE PROVAS</li>
                    <li class="active">
                        <span><?=$titulo?></span>
                    </li>
                </ol>
            </div>
            <h2 class="font-light m-b-xs">
                <?=$titulo?>
            </h2>
            <small><?=$SubTitulo?></small>
        </div>
    </div>
</div>