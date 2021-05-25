<? $this->load->view('home/header'); ?>
<script type="text/javascript" src="<?= base_url('assets/js') ?>/jquery.form.js"></script>
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
                            <li class="active"><a href="<?= base_url('110/pasta_virtual/frmPasta?pasta=' . urlencode(serialize(array('pasta' => $p . '/bianca.rocha'))) . '') ?>"><i class="fa fa-folder"></i> <?= $p ?></a></li>
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
                <?
                foreach ($aberta as $ab) {
                    
                    
                    $arquivo = str_replace($this->session->userdata('SGP_PASTA_ATUAL').'/','',$ab);
                    $primeira = substr($arquivo, 0, 1);
                    $fim = explode('.', $arquivo);                    

                    if ($fim[1] == '') {
                        $tipo = 'folder text-warning'; $img = 'N';
                    } else {
                        
                        switch (strtolower($fim[1])) {
                            case 'doc': $tipo = 'file-word-o text-info'; $img = 'N';
                                break;
                            case 'docx': $tipo = 'file-word-o text-info'; $img = 'N';
                                break;
                            case 'pptx': $tipo = 'file-powerpoint-o text-info'; $img = 'N';
                                break;
                            case 'ppt': $tipo = 'file-powerpoint-o text-info'; $img = 'N';
                                break;
                            case 'xlsx': $tipo = 'file-excel-o text-success'; $img = 'N';
                                break;
                            case 'xlsx': $tipo = 'file-excel-o text-success'; $img = 'N';
                                break;
                            case 'pdf': $tipo = 'file-pdf-o text-danger'; $img = 'N';
                                break;
                            case 'png': $tipo = 'file-image-o text-success'; $img = 'S';
                                break;
                            case 'jpg': $tipo = 'file-image-o text-success'; $img = 'S';
                                break;
                            case 'doc': $tipo = 'file-pdf-o text-danger'; $img = 'N';
                                break;
                        }
                    }
                    ?>
                    <div class="col-md-3">
                        <div class="hpanel">
                            <table width="100%">
                                <tr>
                                    <td width="20%"><i class="fa fa-<?= $tipo ?> fa-3x "></i></td>
                                    <td><a href="<?= base_url('110/pasta_virtual/frmPasta?pasta=' . urlencode(serialize(array('pasta' => $ab))) . '') ?>"><?= $arquivo?> </a></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="left">
                                        <small><button class="btn btn-info btn-xs"><i class="fa fa-download"></i></button></small> 
                                        <small><button class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button></small>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                <? } ?>
            </div>
        </div>
    </div>
</div>



<div class="modal fade hmodal-info" id="mdlPasta" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="color-line"></div>
            <div class="modal-footer">
                <h4 class="modal-title">Criar Pasta</h4>
            </div>
            <div class="modal-body">
                <p>
                    <?= $titulo ?>
                <div class="input-group">
                    <input id="pvNovaPasta" name="pvNovaPasta" type="text" class="form-control">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-primary btnCriarPasta">Criar</button>
                    </span>
                </div>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade hmodal-info" id="mdlArquivo" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="color-line"></div>
            <div class="modal-footer">
                <h4 class="modal-title">Upload de Arquivos</h4>
            </div>
            <div class="modal-body">
                <p>
                    <script type="text/javascript" >
                        $(document).ready(function() {
                            $('#form').ajaxForm({
                                uploadProgress: function(event, position, total, percentComplete) {
                                    $('progress').attr('value', percentComplete);
                                    $('#porcentagem').html(percentComplete + '%');
                                },
                                success: function(data) {
                                    $('progress').attr('value', '100');
                                    $('#porcentagem').html('100%');
                                    $('pre').html(data);
                                    
                                    setTimeout(function() {
                                        location.reload();
                                    }, 500);
                                }
                            });
                        });
                    </script>
                <form action="<?= base_url('110/pasta_virtual/fctEnviarArquivo') ?>" id="form" method="post" enctype="multipart/form-data">
                    <?= $titulo ?>
                    <div class="input-group">
                        <input id="arquivo" name="arquivo" type="file" class="form-control">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-primary" id="btnUpload">Enviar</button>
                        </span>
                    </div>
                    <div id="progress">
                        <progress value="0" max="100"></progress><span id="porcentagem">0%</span>
                    </div>
                </form>
                <pre></pre>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>




<script>

    $(function() {
        $('.btnCriarPasta').click(function() {
            swal({
                title: "Criar Nova Pasta",
                text: "Deseja criar uma nova pasta neste local?",
                type: "info",
                showCancelButton: true,
                confirmButtonText: "Sim, Criar!",
                cancelButtonText: "Não, Cancelar!",
                closeOnConfirm: true,
                closeOnCancel: true,
            },
                    function(isConfirm) {
                        if (isConfirm) {
                            setTimeout(function() {
                                $.post("<?= base_url('110/pasta_virtual/fctCriarPasta') ?>", {
                                    novaPasta: $("#pvNovaPasta").val(),
                                },
                                        function(data) {
                                            swal(data, '', "success");
                                        });
                            }, 3000);
                        } else {
                            swal("Tudo bem!", "Você tem até o fim do bimestre ou até a prova ser bloqueada.", "error");
                        }
                    });
        });
    });
</script>
<? $this->load->view('home/footer'); ?>