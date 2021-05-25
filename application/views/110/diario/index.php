<? $this->load->view('home/header'); ?>
<div class="panel-footer no-margins">
    <a href="<?= base_url('' . $this->session->userdata('SGP_SISTEMA') . '/main') ?>" class="btn btn-xs btn-primary2 "><i class="fa fa-refresh fa-2x"></i> <br/>Outra Turma</a>
    | 
    <span style="font-size:15px">TURMA: <?= $this->session->userdata('SGP_TURMA') ?> | DISCIPLINA: <?= $info[0]['NM_DISCIPLINA'] ?></span>
    <div class="panel-tools">
        <button onclick="location.href='<?=base_url('' . $this->session->userdata('SGP_SISTEMA') . '/diario/frmDiarioFrequencia')?>'" class="btn btn-xs btn-success " type="button"><i class="fa fa-check-circle-o fa-2x"></i> <br/>Frequência</button>
        <button class="btn btn-xs btn-info " type="button"><i class="fa fa-list-alt fa-2x"></i> <br/>Meus Conteúdos</button>
        <button onclick="location.href='<?=base_url('' . $this->session->userdata('SGP_SISTEMA') . '/diario/frmDiarioNota')?>'" class="btn btn-xs btn-warning " type="button"><i class="fa fa-list-ol fa-2x"></i> <br/>Notas da Turma</button>
        <button class="btn btn-xs btn-danger " type="button"><i class="fa fa-times-circle-o fa-2x"></i> <br/>Aulas Abertas</button>
    </div>
</div>
<div class="content animate-panel">

    <div class="row">
        <div class="col-lg-4 animated-panel zoomIn" style="animation-delay: 0.5s;">
            <div class="hpanel horange">
                <div class="panel-heading">
                    <div class="panel-tools">
                        <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                    </div>
                    Último conteúdo
                </div>
                <div class="panel-body">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan. Aliquam ornare lacus adipiscing, posuere lectus et, fringilla augue.Lorem
                        ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 animated-panel zoomIn" style="animation-delay: 0.5s;">
            <div class="hpanel hred">
                <div class="panel-heading">
                    <div class="panel-tools">
                        <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                    </div>
                    Panel red
                </div>
                <div class="panel-body">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan. Aliquam ornare lacus adipiscing, posuere lectus et, fringilla augue.Lorem
                        ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 animated-panel zoomIn" style="animation-delay: 0.6s;">
            <div class="hpanel hred">
                <div class="panel-heading">
                    <div class="panel-tools">
                        <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                        <a class="closebox"><i class="fa fa-times"></i></a>
                    </div>
                    Panel red
                </div>
                <div class="panel-body">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan. Aliquam ornare lacus adipiscing, posuere lectus et, fringilla augue.Lorem
                        ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan.
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>
<? $this->load->view('home/footer'); ?>