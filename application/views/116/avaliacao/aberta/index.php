<? $this->load->view('home/header'); ?>
<div class="content animate-panel">
     <div class="col-sm-4"></div>
      <div class="col-sm-4 block-center mt-xl wd-xl" style="top: 10px">
         <!-- START panel-->
         <div class="panel panel-warning">
            <div class="panel-heading">
                <h4><?=$this->lang->line('PGAVALLIB_PANEL')?></h4>
            </div>
            <div class="panel-body">
                <form action="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/avaliacao/validar')?>" method="POST" role="form" data-parsley-validate="" novalidate="novalidate" class="mb-lg">
                  <div class="form-group has-feedback">
                       <input id="tstlibid" type="number" name="tstlibid" placeholder="<?=$this->lang->line('PGAVALLIB_INP_IDPROVA')?>" autocomplete="off" required class="form-control <?=form_error('tstlibid', 'C');?>" required="" aria-required="true" aria-invalid="true">
                       <span class="fa fa-calculator form-control-feedback text-muted <?=form_error('tstlibid', 'I');?>"></span>
                       <?=form_error('tstlibid','A');?>
                  </div>
                    <?=form_button('submit','BTAcesso',$this->lang->line('PGAVALLIB_INP'),'class="btn btn-block btn-primary mt-lg"');?>
               </form>
            </div>
         </div>
      </div>
      <div class="col-sm-4"></div>
</div>

<? $this->load->view('home/footer'); ?>