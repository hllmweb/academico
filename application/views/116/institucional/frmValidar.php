<? $this->load->view('home/header'); ?>
<div class="content animate-panel">
    <div class="col-sm-3"></div>
    <div class="col-sm-6 text-center">
        <br>
        <br>
        <br>
        <br>
        QUESTIONÁRIO FINALIZADO.<br><br>
        <a class="btn btn-primary2" href="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/institucional/index')?>" >OUTRO PROFESSOR</a> | 
        <a class="btn btn-info" href="<?=base_url('usuarios/logout')?>" >SAIR</a>
    </div>
    <div class="col-sm-3"></div>
</div>

<? $this->load->view('home/footer'); ?>