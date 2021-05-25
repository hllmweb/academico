<? $this->load->view('home/header'); ?>
<div class="content animate-panel">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
        <!-- START panel-->
        <div class="panel panel-warning">
            <div class="panel-heading" style="padding:4px 10px">
                <h5><strong><?=$this->lang->line('PGAVAL_INI')?></strong></h5>
            </div>
            
            <div class="panel-body">
                <div class="col-sm-3" style="vertical-align: middle; text-align: center">
                    <br/>
                    <img class="img-rounded" style="width:90%" src="<?=('http://server01/academico/usuarios/foto/'.$this->session->userdata('SGP_USER').'')?>">
                </div>
                <div class="col-sm-9">
                    <small><?=$this->lang->line('PGAVAL_INI_COD')?>:</small>
                    <h5><?=$avaliacao[0]['NUM_PROVA']?></h5>

                    <small><?=$this->lang->line('PGAVAL_INI_TIT')?>:</small>
                    <h5><?=$avaliacao[0]['TITULO']?></h5>

                    <small><?=$this->lang->line('PGAVAL_INI_DIS')?>:</small>
                    <h5><?=$avaliacao[0]['DISCIPLINAS']?></h5>

                    <small><?=$this->lang->line('PGAVAL_INI_QQS')?>:</small>
                    <h5><?=$avaliacao[0]['QTDE_QUESTOES']?></h5>
                </div>
            </div>
            <div class="panel-footer">
                <button class="btn btn-danger2"><i class="fa fa-times-circle"></i> <?=$this->lang->line('PGAVAL_INI_BTN_VLT')?></button>
                <button class="btn btn-info pull-right"><i class="fa fa-check-circle"></i> <?=$this->lang->line('PGAVAL_INI_BTN_COM')?></button>
            </div>
        </div>
    </div>
    <div class="col-sm-3"></div>
</div>

<? $this->load->view('home/footer'); ?>