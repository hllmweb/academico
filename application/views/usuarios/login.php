<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
   <meta name="description" content="SISTEMA DE GESTÃO ACADÊMICA ONLINE">
   <meta name="auhor" content="Silvio Silva de Souza">
   <meta name="mail" content="silvio.souza@seculomanaus.com.br">
   <title>SISTEMA DE GESTÃO ACADÊMICA ONLINE</title>
   <!-- =============== VENDOR STYLES ===============-->
   <!-- FONT AWESOME-->
   <link rel="stylesheet" href="<?=base_url('assets/css/font-awesome.min.css')?>">
   <!-- SIMPLE LINE ICONS-->
   <link rel="stylesheet" href="<?=base_url('assets/css/simple-line-icons.css')?>">
   <!-- =============== BOOTSTRAP STYLES ===============-->
   <link rel="stylesheet" href="<?=base_url('assets/css/bootstrap.css')?>" id="bscss">
   <!-- =============== APP STYLES ===============-->
   <link rel="stylesheet" href="<?=base_url('assets/css/app.css')?>" id="maincss">
</head>
<body style="background: #337ab7; background-image: url(<?=base_url('assets/images/bgw.jpg')?>); background-repeat: no-repeat; background-size: 100%; background-position-y: -350px">
   <div class="wrapper">
       <div class="col-sm-4"></div>
      <div class="col-sm-3 block-center mt-xl wd-xl" style="top: 100px">
         <!-- START panel-->
         <div class=" panel-dark panel-flat">
            <div class="panel-heading text-center">
               <a href="#">
                  <img src="<?=base_url('assets/images/logo_branca.png')?>" style="width:70%" alt="Image" class="block-center">
               </a>
                <hr />
            </div>
            <div class="panel-body">
                <form action="<?=base_url('usuarios/acesso')?>" method="POST" role="form" data-parsley-validate="" novalidate="novalidate" class="mb-lg">

                  <div class="form-group has-feedback">
                      <input id="lguser" type="text" name="lguser" placeholder="<?=$this->lang->line('LGPlaceHolderUser')?>" autocomplete="off" required class="form-control <?=form_error('lguser', IMPUT_ERROR);?>" required="" aria-required="true" aria-invalid="true">
                     <span class="fa fa-user form-control-feedback text-muted"></span>
                     <?=form_error('lguser', ALERT_REQUIRED);?>
                  </div>

                  <div class="form-group has-feedback">
                     <input id="lgpass" name="lgpass" type="password" placeholder="<?=$this->lang->line('LGPlaceHolderPass')?>" required class="form-control <?=form_error('sgppass', IMPUT_ERROR);?>">
                     <span class="fa fa-lock form-control-feedback text-muted"></span>
                     <?=form_error('lgpass', ALERT_REQUIRED);?>
                  </div>

                  <div class="form-group has-feedback" style="display: none">
                     <select id="sgppass" name="lglang" required class="form-control <?=form_error('lglang', IMPUT_ERROR);?>">
                         <option value="portugues">Português</option>
                     </select>
                     <span class="fa fa-globe form-control-feedback text-muted"></span>
                     <?=form_error('lglang', ALERT_REQUIRED);?>
                  </div>

                    <?=form_button('submit','BTAcesso',$this->lang->line('LGBTLogin'),'class="btn btn-block btn-warning mt-lg"');?>
                    <? //form_button('none','BTSenha',$this->lang->line('LGBTSenha'),'class="btn btn-block btn-warning mt-lg"');?>

               </form>
            </div>
             <hr />
         </div>
         <!-- END panel-->
         <div class="p-lg text-center" style="color:#FFF">
            <span>&copy; 2018</span>
         </div>
      </div>
       <div class="col-sm-4"></div>

   </div>
   <!-- =============== VENDOR SCRIPTS ===============-->
   <!-- MODERNIZR-->
   <script src="<?=base_url('assets/js/modernizr.js')?>"></script>
   <!-- JQUERY-->
   <script src="<?=base_url('assets/js/jquery.js')?>"></script>
   <!-- BOOTSTRAP-->
   <script src="<?=base_url('assets/js/bootstrap.js')?>"></script>
   <!-- STORAGE API-->
   <script src="<?=base_url('assets/js/jquery.storageapi.js')?>"></script>
   <script src="<?=base_url('assets/js/jquery.validate.min.js')?>"></script>
   <!-- PARSLEY-->
   <script src="<?=base_url('assets/js/parsley.min.js')?>"></script>
   <!-- =============== APP SCRIPTS ===============-->
   <script src="<?=base_url('assets/js/app.js')?>"></script>
</body>

</html>
