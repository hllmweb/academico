<table id="tblregistros" class="display table table-hover">
    <thead>
        <tr>            
            <th class="text-center"></th>                        
            <th class="text-center">PROFESSOR</th>            
            <th class="text-center">MOTIVO</th>                  
            <th class="text-center">DATA PENDÊNCIA</th>            
            <th class="text-center">DATA SOLICITAÇÃO</th>            
            <th class="text-center">AÇÕES</th>                        
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
            <tr> 
                <td class="text-center"><i class="fa fa-circle <?= $p ?>"></i></td>                

                <td class="text-center">
                    <?= $row->NM_PROFESSOR ?>
                </td>

                <td class="text-center">
                    <?= $row->NM_MOTIVO ?>
                </td>

                <td class="text-center">
                    <?= date("d/m/Y", strtotime($row->DT_PENDENCIA)) ?>
                </td>
                
                <td class="text-center">
                    <?= date("d/m/Y", strtotime($row->DT_SOLICITACAO)) ?>
                </td>

                <td class="text-center">  
                    <a data-toggle="frmModalRegistro" data-tipo="info" href="<?= base_url('113/justificativa_solicitacao/modalViewRegistro?codigo=' . $row->CD_SOLICITACAO) ?>" class="btn btn-info btn-xs">
                        <i class='fa fa-search'></i>
                    </a>

                    <?php
                    /**
                     * Somente edita se a notificação for nova ou estiver necessitando
                     * de mais informações. 
                     */
                    if ($row->FL_PARECER == "N" && $row->FL_STATUS == "N" || 
                            $row->FL_STATUS == "I" && $row->FL_PARECER == "I" || 
                            $row->FL_REQUER_PARECER == "N" && ($row->FL_STATUS == "N" || $row->FL_STATUS == "I")):
                        ?>
                        <a data-toggle="frmModalRegistro" data-tipo="warning" href="<?= base_url('113/justificativa_solicitacao/modalRegistro?operacao=E&codigo=' . $row->CD_SOLICITACAO) ?>" class="btn btn-warning btn-xs">
                            <i class='fa fa-edit'></i>
                        </a>
                    <?php endif; ?>

                    <?php if ($row->FL_PARECER === 'N' && $row->FL_STATUS === "N"): ?>
                        <a data-toggle="frmModalRegistro" data-tipo="danger" href="<?= base_url('113/justificativa_solicitacao/modalRegistro?operacao=D&codigo=' . $row->CD_SOLICITACAO) ?>" class="btn btn-danger2 btn-xs">
                            <i class='fa fa-trash-o'></i>
                        </a>
                    <?php endif; ?>
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