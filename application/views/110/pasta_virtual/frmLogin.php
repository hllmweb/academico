<? $this->load->view('home/header'); ?>
<div class="content animate-panel">

    <div class="row">
        <div class="col-md-3">
            <div class="hpanel">
                <div class="panel-body">
                    <div class="dropdown">
                        <a class="dropdown-toggle btn btn-primary btn-block" href="#" data-toggle="dropdown">
                            ADICIONAR
                        </a>
                        <ul class="dropdown-menu filedropdown m-l">
                            <li><a href="#" data-toggle="modal" data-target="#mdlPasta"><i class="fa fa-folder-o"></i> Nova Pasta</a></li>
                            <li><a href="#" data-toggle="modal" data-target="#mdlArquivo"><i class="fa fa-file"></i> Upload Arquivo</a></li>
                        </ul>
                    </div>

                    <ul class="h-list m-t">
                        <? foreach ($pastas as $p) { ?>
                            <li class="active"><a href="<?=base_url('110/pasta_virtual/frmPasta?pasta='.urlencode(serialize(array('pasta'=> $p.'/bianca.rocha'))).'')?>"><i class="fa fa-folder"></i> <?=$p?></a></li>
                        <? } ?>
                    </ul>
                </div>

            </div>
            <div class="hpanel">
                <div class="panel-body">
                    <h3>6 GB used</h3>
                    <p>It is 65% of all your storage</p>
                    <div class="progress full m-t-xs">
                        <div style="width: 65%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="65" role="progressbar" class=" progress-bar progress-bar-info">
                            65%
                        </div>
                    </div>
                    <small>Lorem ipsum dolor sit amet, consectetur adipiscing elit vestibulum adipiscing elit.</small>
                </div>

            </div>

        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-3">
                    <div class="hpanel">
                        <div class="panel-body file-body">
                            <i class="fa fa-file-pdf-o text-info"></i>
                        </div>
                        <div class="panel-footer">
                            <a href="#">Document_2016.doc</a>
                        </div>
                    </div>

                </div>
            </div>


        </div>
    </div>
</div>



<div class="modal fade hmodal-info" id="mdlPasta" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="color-line"></div>
            <div class="modal-header">
                <h4 class="modal-title">Criar Pasta</h4>
            </div>
            <div class="modal-body">
                <p>
                    
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary">Criar</button>
            </div>
        </div>
    </div>
</div>

<? $this->load->view('home/footer'); ?>