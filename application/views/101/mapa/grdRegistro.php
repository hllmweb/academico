<div class="row">

    <div class="col-lg-2">
        <div class="panel-heading">
            Alunos da Turma
        </div>
        <div class="panel-body">
            <? foreach($lista as $l){ ?>
                <span class="<?=(($l['NR_FILA'] != '')? 'text-info': 'text-danger')?>" >
                    <?=$l['NM_ALUNO']?>
                    <? if($l['NR_FILA'] != ''){ ?>
                        <br><small>FILA: <?=$l['NR_FILA']?> | POSIÇÃO: <?=$l['NR_POSICAO']?></small>
                    <? } ?>
                </span>
                <hr>
            <? } ?>
        </div>
    </div>
    <? for($j=1; $j <= 5; $j++){ ?>
    <div class="col-lg-2 mapa" style="min-height: 100px" data-id-colunn="1">
        <? 
            for($i=1; $i <= 5; $i++){
                $p = '';
                $p = array_search(''.$j.'-'.$i.'',$posicao);
                $p = ((!is_numeric($p))? -1: $p);
        ?>
        <div class="hpanel">
            <div class="panel-heading">
                <small>FILA: 0<?=$j?> | POSIÇÃO: 0<?=$i?></small>
                <? if ($lista[$p]['NR_FILA'] != ''){ ?>
                    <a class="panel-tools" href="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/mapa/mdlDesalocacaoAluno/'.$lista[$p]['CD_ALUNO'].'-'.$lista[$p]['CD_TURMA'].'')?>" data-toggle="frmModalInfo"> 
                        <i class="fa fa-times-circle text-danger fa-2x"></i>
                    </a>
                <? } ?>
            </div>
            <div class="panel-body">
                <div class="m-t-xs m-b-xs text-center">
                <?php if ($lista[$p]['NR_FILA'] != ''){ 
                    echo $lista[$p]['NM_ALUNO'];
                }else{
                    echo '<i class="fa fa-user-times text-danger fa-2x"></i> Vazio.';
                }
                ?>
                </div>
            </div>
            <? if ($lista[$p]['NR_FILA'] == ''){ ?>
            <div class="panel-footer">
                <button
                    href="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/mapa/mdlAlocacaoAluno/'.$curso.'-'.$serie.'-'.$turma.'-'.$j.'-'.$i.'')?>" 
                    data-toggle="frmModalInfo" 
                    type="button" 
                    class="btn btn-info btn-xs form-control"> 
                    <i class="fa fa-plus"></i> ALOCAR ALUNO
                </button>
            </div>
            <? } ?>
        </div>
        <? } ?>
    </div>
    <? } ?>
</div>
<script src="<?=base_url('assets/js/jquery.min.js')?>"></script>
<script src="<?=base_url('assets/js/bootstrap.min.js')?>"></script>
<script type="text/javascript">
$('[data-toggle="frmModalInfo"]').on('click',
        function(e) {
            $('#frmModalInfo').remove();
            e.preventDefault();
            var $this = $(this)
                    , $remote = $this.data('remote') || $this.attr('href')
                    , $modal = $('<div class="modal fade hmodal-danger no-padding"  id="frmModalInfo"  tabindex="-1" role="dialog" ><div class="modal-dialog no-padding" ><div class="modal-content no-padding"></div></div></div>');
            $('body').append($modal);
            $modal.modal({backdrop: 'static', keyboard: false});
            $modal.load($remote);
        }
);
</script>