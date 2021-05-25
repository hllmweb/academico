<br />
<div class="col-sm-12">
<? foreach($alunos as $al){ ?>
<div class="col-lg-3 animated-panel zoomIn" style="animation-delay: 0.1s;">
        <div class="hpanel hgreen contact-panel ">
            <div class="panel-body">
                <span class="pull-right">
                    <?/*
                        switch($al['BIMESTRE']){
                            case 1:
                                echo '<i class="fa fa-'.(($al['TPERGUNTA'] == $al['TRESULTADO']) ? 'star text-warning' : 'star-o' ).' fa-2x"></i>';
                            break;
                            case 2:
                                echo '<i class="fa fa-star text-warning fa-2x"></i>';
                                echo '<i class="fa fa-'.(($al['TPERGUNTA'] == $al['TRESULTADO']) ? 'star text-warning' : 'star-o' ).' fa-2x"></i>';
                            break;
                            case 3:
                                echo '<i class="fa fa-star text-warning fa-2x"></i>';
                                echo '<i class="fa fa-star text-warning fa-2x"></i>';
                                echo '<i class="fa fa-'.(($al['TPERGUNTA'] == $al['TRESULTADO']) ? 'star text-warning' : 'star-o' ).' fa-2x"></i>';
                            break;
                            case 4:
                                echo '<i class="fa fa-star text-warning fa-2x"></i>';
                                echo '<i class="fa fa-star text-warning fa-2x"></i>';
                                echo '<i class="fa fa-star text-warning fa-2x"></i>';
                                echo '<i class="fa fa-'.(($al['TPERGUNTA'] == $al['TRESULTADO']) ? 'star text-warning' : 'star-o' ).' fa-2x"></i>';
                            break;
                        }*/
                    ?>
                </span>
                <h5><a data-toggle="frmModalInfo" href="<?=base_url('113/infantil/mdlViewAcompanhamento/'.$al['CD_ALUNO'].'-'.$al['CD_QUEST'])?>"> <?=substr($al['NM_ALUNO'],0,20)?></a></h5>
                <div class="text-muted font-bold m-b-xs"><?=$al['CD_ALUNO']?></div>
            </div>
            <div class="panel-footer contact-footer">
                <div class="row">
                    <div class="col-md-4 border-right animated-panel zoomIn" style="animation-delay: 0.2s;"> <div class="contact-stat"><span>Bimestre: </span> <strong><?=$al['BIMESTRE']?></strong></div> </div>
                    <div class="col-md-4 border-right animated-panel zoomIn" style="animation-delay: 0.2s;"> <div class="contact-stat"><span>Perguntas: </span> <strong><?=$al['TPERGUNTA']?></strong></div> </div>
                    <div class="col-md-4 animated-panel zoomIn" style="animation-delay: 0.3s;"> <div class="contact-stat"><span>Respostas: </span> <strong><?=$al['TRESULTADO']?></strong></div> </div>
                </div>
            </div>
        </div>
    </div>
<? } ?>
</div>

<script>
$('[data-toggle="frmModalInfo"]').on('click',
        function(e) {
            $('#frmModalInfo').remove();
            e.preventDefault();
            var $this = $(this)
                    , $remote = $this.data('remote') || $this.attr('href')
                    , $modal = $('<div class="modal fade hmodal-danger"  id="frmModalInfo"  tabindex="-1" role="dialog" ><div class="modal-dialog" ><div class="modal-content"></div></div></div>');
            $('body').append($modal);
            $modal.modal({backdrop: 'static', keyboard: false});
            $modal.load($remote);
        }
);
</script>