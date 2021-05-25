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
                        <th class="text-center">DATA DA SOLICITAÇÃO</th>                        
                        <th class="text-center">REQUER MAIS INFORMAÇÃO</th>
                        <th class="text-center">DETALHES</th>
                    </tr>
                </thead>

                <tbody>
                    <?
                    foreach ($registros as $row) {
                        switch ($row->FL_PARECER) {
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
                                <?php if ($row->FL_PARECER === "N"): ?>
                                    <input type="checkbox" class="solicitacao" name="solicitacao[]" value="<?= $row->CD_SOLICITACAO ?>">
                                <?php endif; ?>
                            </td>
                            <td class="text-center"><i class="fa fa-circle <?= $p ?>"></i></td>                            
                            <td class="text-center"><?= $row->NM_PROFESSOR ?></td>                            
                            <td class="text-center"><?= $row->NM_MOTIVO ?></td>                                
                            <td class="text-center"><?= $row->DTHR_PENDENCIA ?></td>
                            <td class="text-center"><?= $row->DTHR_SOLICITACAO?></td>
                            <td class="text-center"><?= $row->FL_STATUS === "I" ? "SIM" : "NÃO" ?></td>
                            <td class="text-center">
                                <a data-toggle="frmModalInfo" href="<?= base_url('103/parecer/modalViewRegistro?codigo=' . $row->CD_SOLICITACAO) ?>">
                                    <i class="fa fa-search fa-lg"></i>
                                </a>                                
                            </td>
                        </tr>
                    <? } ?>
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="5"></td>
                    </tr>

                    <tr>
                        <td colspan="5" style="border-top: none">
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