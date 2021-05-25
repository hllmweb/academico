<div class="modal-dialog">
    <? if($operacao == 'I'){
            $params = $filtro[0]['CD_PROVA'] . $filtro[0]['CD_DISCIPLINA'] . $filtro[0]['TIPO_QUESTAO']; 
        }elseif($operacao == 'C'){
            $params = $filtro[0]['ID_AVAL_PROVA_DISC'];
			$campo = '<input type="hidden" name="id_aval_prova_disc"  value="'.$params.'" />';
	       #$params = $filtro[0]['CD_PROVA'] . $filtro[0]['CD_DISCIPLINA'] . $filtro[0]['TIPO_QUESTAO']; 
        }
	
	?>
    <script type="text/javascript">

        function svDisciplina() {
            var dados = jQuery('#frmProvaDisiplina<?= $params ?>').serialize();
            jQuery.ajax({
                type: "POST",
                url: "<?= base_url('108/prova/frmManterProvaDisciplina_new') ?>",
                data: dados,
                success: function(data) {
                    $("#rs<?= $params ?>").html(data);
                    swal("Dados Salvos!", "Alterações realizadas. Por favor verifique!", "success");
                    window.setTimeout(refreshPage, 2000 );
                },
            });
            return false;
        };

        function pxNumeroFinal() {
            var inicial = $("[id='avalPosInicial<?= $params ?>']").val();
            var res = (parseInt(inicial) + parseInt(10));
            $("input[id='avalPosFinal<?= $params ?>']").val(res);
        }
        ;

        function vlNotasProvas() {
            var inicial = $("[id='avalNotaMaxima<?= $params ?>']").val();
            var res = (parseInt(10) - parseInt(inicial));
            $("input[id='avalNotaDissertativa<?= $params ?>']").val(res);
        }
        ;


    </script>
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-header">
            <h4 class="modal-title">Disciplinas</h4>
        </div>
        <div class="modal-body">
            <form name="frmProvaDisiplina<?= $params ?>" id="frmProvaDisiplina<?= $params ?>">
                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-8 animated-panel zoomIn" style="animation-delay: 0.3s;">
                            <div class="form-group">
                                <label>Disciplina</label>
                                <select name="avalDisciplina<?= (($operacao == 'E' || $operacao == 'C' || $operacao == 'U' || $operacao == 'D') ? $params : '') ?>" id="avalDisciplina<?= $params ?>" class="form-control avalProfessorLista input-sm" <?= (($operacao == 'C' || $operacao == 'E' || $operacao == 'U' || $operacao == 'D') ? '' : '') ?>>
                                    <option value=""></option>
                                   <!-- <option value="723">LÍNGUA PORTUGUESA</option>-->
                                    <? foreach ($disciplina as $row) { ?>
                                        <option <?= (($row['CD_DISCIPLINA'] == $filtro[0]['CD_DISCIPLINA']) ? 'selected="selected"' : '') ?> value="<?= $row['CD_DISCIPLINA'] ?>"><?= $row['NM_DISCIPLINA'] ?></option>
                                    <? } ?>
                                </select>
                                <?php if ($operacao == 'E' || $operacao == 'C' || $operacao == 'U' || $operacao == 'D') { ?>
                                    <input type="hidden" name="avalDisciplina"  value="<?= $filtro[0]['CD_DISCIPLINA'] ?>" />
                                <?php } ?>

                            </div>
                        </div>
                        
                        <div class="col-xs-4 border-right animated-panel zoomIn" style="animation-delay: 0.3s;">
                            <div class="form-group">
                                <label>Tipo</label><br>
                                <select name="avalTipoQuestoes" id="avalTipoQuestoes<?= $params ?>" class="form-control input-sm">
                                    <option value=""></option>
                                    <option <?= (($filtro[0]['TIPO_QUESTAO'] == 'D') ? 'selected="selected"' : '') ?> value="D">Dissertativas</option>
                                    <option <?= (($filtro[0]['TIPO_QUESTAO'] == 'O') ? 'selected="selected"' : '') ?> value="O">Objetivas</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-xs-4 border-right animated-panel zoomIn" style="animation-delay: 0.3s;">
                            <div class="form-group">
                                <label>Posição Inicial</label>
                                <div class="input-group bootstrap-touchspin">
                                    <input onchange="pxNumeroFinal()" name="avalPosInicial" id="avalPosInicial<?= $params ?>" value="<?= $filtro[0]['POSICAO_INICIAL'] ?>" readonly="readonly" type="text" class="form-control" style="display: block;">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6  animated-panel zoomIn" style="animation-delay: 0.4s;">
                            <div class="form-group">
                                <label>Posição Final</label>
                                <div class="input-group bootstrap-touchspin">
                                    <input name="avalPosFinal" id="avalPosFinal<?= $params ?>" readonly="readonly" type="text" value="<?= $filtro[0]['POSICAO_FINAL'] ?>" class="form-control" style="display: block;">
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xs-4  animated-panel zoomIn" style="animation-delay: 0.4s;">
                            <div class="form-group">
                                <label>Valor Questão</label>
                                <div class="input-group bootstrap-touchspin">
                                    <input name="vlQuestao" id="vlQuestao<?= $params ?>" type="text" value="<?= $filtro[0]['VL_QUESTAO'] ?>" class="form-control" style="display: none;">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4  animated-panel zoomIn" style="animation-delay: 0.4s;" id="rs"></div>
                    </div>

                </div>
                <input type="hidden" name="avalProva"  value="<?= (($filtro[0]['CD_PROVA'] == '') ? $prova : $filtro[0]['CD_PROVA']) ?>" />
                <input type="hidden" name="operacao"  value="<?= $operacao ?>" />
				<?= $campo; ?>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-<?= (($operacao == 'U') ? 'warning' : (($operacao == 'D') ? 'danger' : 'info')) ?> btnSalvarDisciplinas"><?= (($operacao == 'D') ? 'Remover Disciplina' : 'Salvar Dados') ?></button>
        </div>
    </div>
    <script>
        $(function() {
            $("#avalPosInicial<?= $params ?>").TouchSpin({
                min: 1,
                max: 100,
                step: 1,
                decimals: 0,
                boostat: 5,
                maxboostedstep: 10,
            });
            $("#avalPosFinal<?= $params ?>").TouchSpin({
                min: 1,
                max: 100,
                step: 1,
                decimals: 0,
                boostat: 5,
                maxboostedstep: 10,
            });
            $("#vlQuestao<?= $params ?>").TouchSpin({
                min: 0,
                max: 10,
                step: 0.0001,
                decimals: 4,
                boostat: 5,
                maxboostedstep: 10,
            });

            $('.btnSalvarDisciplinas').click(function() {
                swal({
                    title: "Salvar as Alterações?",
                    text: "Salvar alterações realizadas nesta prova, caso haja alguma versão elas também serão atualizadas.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Sim, Salvar Dados!",
                    cancelButtonText: "Não, Cancelar!",
                    closeOnConfirm: false,
                    closeOnCancel: false},
                function(isConfirm) {
                    if (isConfirm) {
                        svDisciplina();
                    } else {
                        swal("Cancelado", "Operação cancelada!", "error");
                    }
                });
            });

        });

    </script>
</div>
