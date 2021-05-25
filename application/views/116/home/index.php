<? $this->load->view('home/header'); ?>
<div class="content animate-panel">

    <div class="row">
        <div class="col-md-9">
            <div class="row">

                <div class="col-md-3">
                    <div class="hpanel">
                        <div class="panel-body file-body">
                            <i class="fa fa-users text-info"></i>
                        </div>
                        <div class="panel-footer text-center">
                            <a href="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/institucional/')?>">
                                AVALIAÇÃO INSTITUCIONAL
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

<? $this->load->view('home/footer'); ?>