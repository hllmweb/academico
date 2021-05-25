<div class="col-lg-12 animated-panel zoomIn no-padding" style="animation-delay: 0.5s;">
    <div class="hpanel hviolet">
        <div class="panel-body">
            <table class='table table-hover'>
                <thead>
                    <tr>
                        <td colspan="9" class='border-right' valign='center'></td>
                        <td colspan="4" class='border-right' align='center'><strong>CONTEÚDO MINISTRADO</strong></td>
                    </tr>
                    <tr>
                        <th class='border-right' valign='center'>COD. AULA</th>
                        <th class='border-right' valign='center'>DT. AULA</th>
                        <th class='border-right' align='center'>TURMA</th>
                        <th class='border-right' align='center'>DISCIPLINA</th>
                        <th class='border-right' align='center'>PROFESSOR</th>
                        <th class='border-right' align='center'>T</th>
                        <th class='border-right' valign='center'>TP</th>
                        <th class='border-right' align='center'>ABERTURA</th>
                        <th class='border-right' align='center'>FECHAMENTO</th>
                        <th class='border-right' align='center'>CHAMADA</th>
                        <th class='border-right' align='center'>CONTEÚDO</th>
                        <th class='border-right' align='center'>LISTA</th>
                        <th class='border-right' align='center'>TAREFA</th>
                        <th class='border-right' align='center'>VÍDEO</th>
                    </tr>
                </thead>
                <tbody>                    
                    <?
                    foreach ($lista as $l) {
                        if ($l->HR_ABERTURA == null || $l->HR_FECHAMENTO == null ||
                                ($l->REQUER_CHAMADA == "S" && $l->REALIZOU_CHAMADA == "N") ||
                                ($l->CONTEUDO == null && $l->OUTRAS == 0)) {
                            $status = 'danger';
                        } else {
                            $status = 'success';
                        }
                        ?>
                        <tr style="font-size:12px" class="bg-<?= $status ?> ">
                            <td class='border-right' align='center'><?= $l->CD_CL_AULA ?></td>
                            <td class='border-right' align='center'><?= date('d/m/Y', strtotime($l->DT_AULA)) ?></td>
                            <td class='border-right' align='center'><?= $l->CD_TURMA ?></td>
                            <td class='border-right'><?= $l->NM_DISCIPLINA ?></td>
                            <td class='border-right'><?= $l->NM_PROFESSOR ?></td>
                            <td class='border-right'><?= $l->TURNO ?></td>
                            <td class='border-right' align='center'><?= $l->TEMPO_AULA ?>º</td>
                            <td class='border-right' align='center'><?= $l->HR_ABERTURA ?></td>
                            <td class='border-right' align='center'><?= $l->HR_FECHAMENTO ?></td>
                            <td class='border-right' align='center'>
                                <?php
                                if ($l->REQUER_CHAMADA == "N") {
                                    echo '<i class="fa fa-exclamation-triangle text-warning"></i>';
                                } else if ($l->REQUER_CHAMADA == 'S' && $l->REALIZOU_CHAMADA == 'S') {
                                    echo '<i class="fa fa-check text-success"></i>';
                                } else {
                                    echo '<i class="fa fa-times-circle-o text-danger"></i>';
                                }
                                ?>
                            </td>
                            <td class='border-right' align='center'><?= (($l->CONTEUDO == '') ? '<i class="fa fa-times-circle-o text-danger"></i>' : '<i class="fa fa-check text-success"></i>') ?></td>
                            <td class='border-right' align='center'><?= (($l->OUTRAS > 0) ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times-circle-o text-danger"></i>') ?></td>
                            <td class='border-right' align='center'><?= (($l->TAREFA_CASA == '') ? '<i class="fa fa-times-circle-o text-danger"></i>' : '<i class="fa fa-check text-success"></i>') ?></td>
                            <td class='border-right' align='center'><?= (($l->LINK_VIDEO == '') ? '<i class="fa fa-times-circle-o text-danger"></i>' : '<i class="fa fa-check text-success"></i>') ?></td>
                        </tr>
                    <? } ?>
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="13" class='border-right' valign='center'>
                            | <i class="fa fa-exclamation-triangle text-warning"></i> NÃO NECESSITA CHAMADA | 
                            <i class="fa fa-check text-success"></i> AÇÃO REALIZADA | 
                            <i class="fa fa-times-circle-o text-danger"></i> AÇÃO NÃO REALIZADA |
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>