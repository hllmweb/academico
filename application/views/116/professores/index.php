<? $this->load->view('home/header'); ?>
<div class="content animate-panel">

    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <? foreach($docente as $p){ ?>
                <div class="col-md-3">SSS
                    <div class="hpanel">
                        <div class="panel-body hbgblue">
                            <div class="col-xs-3">
                                <img width="50" src="https://www.seculomanaus.com.br/portal/restrito/foto?codigo=<?=$p->CD_P?>" class="img-rounded" alt="logo">
                            </div>
                            <div class="col-xs-9">
                                <a href="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/institucional/')?>">
                                    <?=$p->NM_PROFESSOR?><br>
                                    <?=$p->NM_DISCIPLINA?>
                                </a>
                            </div>
                        </div>
                        
                        <div class="panel-footer text-center">
                            <? if($p->CD_QUEST == ''){ ?>
                            <a class="btn btn-info form-control" href="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/institucional/questionario/?token='.base64_encode($p->CD_PROFESSOR).'&tokName='.base64_encode($p->CD_DISCIPLINA).'')?>">
                                INICIAR AVALIAÇÃO
                            </a>
                            <? }else{ ?>
                            <a class="btn btn-success form-control">
                                FINALIZADO
                            </a>
                            <? } ?>
                        </div>
                        
                    </div>
                </div>
                <? } ?>

            </div>
        </div>
    </div>

</div>

<? $this->load->view('home/footer'); ?>