<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <!-- Page title -->
        <title><?=$this->lang->line('AESSistema')?></title>

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
        <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->

        <!-- Vendor styles -->
        <link rel="stylesheet" href="<?= base_url('assets/css/') ?>/font-awesome.min.css" />
        <link rel="stylesheet" href="<?= base_url('assets/css/') ?>/metisMenu.css" />
        <link rel="stylesheet" href="<?= base_url('assets/css/') ?>/animate.css" />
        <link rel="stylesheet" href="<?= base_url('assets/css/') ?>/bootstrap.css" />

        <link rel="stylesheet" href="<?= base_url('assets/css/') ?>/select2.css" />
        <link rel="stylesheet" href="<?= base_url('assets/css/') ?>/select2-bootstrap.css" />
        <link rel="stylesheet" href="<?= base_url('assets/css/') ?>/awesome-bootstrap-checkbox.css" />

        <!-- App styles -->
        <link rel="stylesheet" href="<?= base_url('assets/css/') ?>/pe-icon-7-stroke.css" />
        <link rel="stylesheet" href="<?= base_url('assets/css/') ?>/helper.css" />
        <link rel="stylesheet" href="<?= base_url('assets/css/') ?>/style.css">

        <link rel="stylesheet" href="<?= base_url('assets/css/') ?>/sweet-alert.css" />
        <link rel="stylesheet" href="<?= base_url('assets/css/') ?>/toastr.min.css" />


        <!-- Vendor scripts -->
        <script src="<?= base_url('assets/js/') ?>/jquery.min.js"></script>
        <script src="<?= base_url('assets/js/') ?>/jquery-ui.min.js"></script>
        <script src="<?= base_url('assets/js/') ?>/jquery.slimscroll.min.js"></script>
        <script src="<?= base_url('assets/js/') ?>/bootstrap.min.js"></script>

    </head>
    <body class="hide-sidebar">

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
        <p class="alert alert-danger">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <!-- Header -->
        <div id="header">
            <div class="color-line">
            </div>
            <div id="logo" class="light-version">
                <span>
                    ACADÊMICO WEB
                </span>
            </div>
            <nav role="navigation">
                <div class="small-logo">
                    <span class="text-primary"><?=$this->lang->line('AESSistema')?></span>
                </div>
                <div class="navbar-right">
                    <ul class="nav navbar-nav no-borders">
                        <li class="dropdown" style="display:none">>
                            <a title="Minhas Mensagens" class="dropdown-toggle label-menu-corner" href="#" data-toggle="dropdown">
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
                        <li class="dropdown">
                            <a title="Sair do Sistema" href="<?=base_url('usuarios/logout')?>">
                                <i class="pe-7s-upload pe-rotate-90"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        
        <!-- Main Wrapper -->
        <div id="wrapper">
            <div class="normalheader transition animated fadeIn small-header">
                <div class="hpanel">
                    <div class="panel-body">
                        <div id="hbreadcrumb" class="pull-right">
                            <ol class="hbreadcrumb breadcrumb">
                                <li>SISTEMA ACADÊMICO</li>
                                <li class="active">
                                    <span><?= $titulo ?></span>
                                </li>
                            </ol>
                        </div>
                        <h2 class="font-light m-b-xs">
                            <?= $titulo ?>
                        </h2>
                        <small><?= $SubTitulo ?></small>
                    </div>
                </div>
            </div>
            <div class="content animate-panel">
                <div class="row">
                    <? 
                    $icon = new Menu_lib(); 
                    foreach($sistema as $l){
                        if($l['SISTEMA'] != 87){
                    ?>
                    <div class="col-md-2">
                        <div class="hpanel no-padding">
                            <div class="panel-body no-padding">
                                <div class="text-center no-padding">
                                    <div class="m">
                                        <?=$icon->icon_sistema($l['SISTEMA'])?>
                                    </div>
                                    <h5 class="font-bold text-success"><?=$l['DC_SISTEMA']//$this->lang->line($l['RF_SISTEMA'])?></h5>
                                    <a href="<?=base_url('sistema/index/'.$l['SISTEMA'].'')?>" class="btn btn-success form-control"><?=$this->lang->line('PGAccess')?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <? } } ?>
                </div>
            </div>
            <footer class="footer" style="position: fixed; bottom: 0px">
                <span class="pull-right">
                     <?=$this->lang->line('AESSistema')?>
                </span>
                Centro Educacional Século :: <strong> <?= FLG_BANCO ?></strong>
            </footer>
        </div>

        <script src="<?= base_url('assets/js/') ?>/metisMenu.min.js"></script>
        <script src="<?= base_url('assets/js/') ?>/icheck.min.js"></script>
        <script src="<?= base_url('assets/js/') ?>/index.js"></script>

        <script src="<?= base_url('assets/js/') ?>/select2.min.js"></script>
        <script src="<?= base_url('assets/js/') ?>/jquery.bootstrap-touchspin.min.js"></script>
        <script src="<?= base_url('assets/js/') ?>/bootstrap-datepicker.min.js"></script>

        <script src="<?= base_url('assets/js/') ?>/jquery.dataTables.min.js"></script>
        <script src="<?= base_url('assets/js/') ?>/dataTables.bootstrap.min.js"></script>

        <!-- App scripts -->
        <script src="<?= base_url('assets/js/') ?>/homer.js"></script>


        <script src="<?= base_url('assets/js/') ?>/sweet-alert.min.js"></script>
        <script src="<?= base_url('assets/js/') ?>/toastr.min.js"></script>

    </body>
</html>