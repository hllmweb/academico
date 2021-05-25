<div class="col-lg-12 animated-panel zoomIn no-padding" style="animation-delay: 0.5s;">
    <div class="hpanel hviolet">
        <div class="panel-body">
            <table class='table table-hover' id="tblGrid">
                <thead>
                    <tr class="panel-footer">
                        <th class="text-center">
                            <input id="select-all" type="checkbox">
                        </th>                           
                        <th class="text-center">SITUAÇÃO</th>
                        <th class="text-center">PROFESSOR</th>                 
                        <th class="text-center">MOTIVO</th>
                        <th class="text-center">DATA PENDÊNCIA</th>
                        <th class="text-center">DATA SOLICITAÇÃO</th>
                        <th class="text-center">PARECER TÉCNICO</th>
                        <th class="text-center">DETALHES</th>
                    </tr>
                </thead>

                <tbody>
                    <?
                    foreach ($registros as $row) {
                        switch ($row->FL_STATUS) {
                            case 'N': // NOVO
                                $p = 'text-info';
                                break;
                            case 'R': // REPROVADO
                                $p = 'text-danger';
                                break;
                            case 'A': // APROVADO
                                $p = 'text-success';
                                break;
                            case 'I': // AGUARDANDO INFORMAÇÕES
                                $p = 'text-warning';
                                break;
                        }
                        ?>
                        <tr style="font-size:12px">
                            <td class="text-center">
                                <?php
                                /**
                                 * Somente permite avaliar caso equipe técnica
                                 * tenha avaliado a solicitação e RH não tenha
                                 * aprovado ou reprovado.
                                 */
                                if ((($row->FL_PARECER == "A" || $row->FL_PARECER == "R") && $row->FL_STATUS == "N") ||
                                        ($row->FL_REQUER_PARECER == "N" && $row->FL_STATUS == "N")):
                                    ?>
                                    <input type="checkbox" class="solicitacao" name="solicitacao[]" value="<?= $row->CD_SOLICITACAO ?>">
                                <?php endif; ?>
                            </td>
                            <td class="text-center"><i class="fa fa-circle <?= $p ?>"></i></td>
                            <td class="text-center"><?= $row->NM_PROFESSOR ?></td>                            
                            <td class="text-center"><?= $row->NM_MOTIVO ?></td>
                            <td class="text-center"><?= date("d/m/Y", strtotime($row->DT_PENDENCIA)) ?></td>                            
                            <td class="text-center"><?= date("d/m/Y", strtotime($row->DT_SOLICITACAO)) ?></td>                            
                            <td class="text-center"><?= $row->FL_REQUER_PARECER == "N" ? "-" : $row->DS_FL_PARECER ?></td>
                            <td class="text-center">
                                <a data-toggle="frmModalInfo" href="<?= base_url('103/abono_aula/modalViewRegistro?codigo=' . $row->CD_SOLICITACAO) ?>">
                                    <i class="fa fa-search fa-lg"></i>
                                </a>
                            </td>
                        </tr>
                    <? } ?>
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="7"></td>
                    </tr>

                    <tr>
                        <td colspan="7" style="border-top: none">
                            <strong>LEGENDA: </strong>
                            <i class="fa fa-circle text-info"></i> NOVA | 
                            <i class="fa fa-circle text-danger"></i> REPROVADA | 
                            <i class="fa fa-circle text-success"></i> APROVADA |                             
                            <i class="fa fa-circle text-warning"></i> AGUARDANDO INFORMAÇÕES
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    var selecionado = false;
    $("#select-all").click(function () {
        selecionado = !selecionado;
        $(".solicitacao").prop("checked", selecionado);
    });

    $('[data-toggle="frmModalInfo"]').on('click',
            function (e) {
                e.preventDefault();
                $('#frmModalInfo').remove();
                var $this = $(this)
                        , $remote = $this.data('remote') || $this.attr('href')
                        , $modal = $('<div class="modal fade hmodal-warning no-padding"  id="frmModalInfo"  tabindex="-1" role="dialog" ><div class="modal-dialog no-padding" ><div class="modal-content no-padding"></div></div></div>');
                $('body').append($modal);
                $modal.modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $modal.load($remote);
            }
    );
</script>    