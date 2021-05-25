<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">
            <h5 class="modal-title">
                Termo(s) Gerado(s)
                <i class="fa fa-2x fa-graduation-cap"></i>
            </h5>
        </div>
        <div class="modal-body row">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr class="panel-footer">
                        <td><strong>MATRÍCULA</strong></td>
                        <td><strong>ALUNO</strong></td>
                        <td><strong>RESPONSÁVEL</strong></td>
                        <td><strong>TIPO</strong></td>
                        <td><strong>DATA</strong></td>
                        <td align="center"></td>
                    </tr>
                </thead>
                <tbody>
                    <? foreach ($lista as $row) { ?>
                        <tr>
                            <td><?= $row['CD_ALUNO']?></td>
                            <td><?= $row['NM_ALUNO']?></td>
                            <td><?= $row['NM_RESPONSAVEL']?></td>
                            <td><?= (($row['CD_TIPO_TERMO'] == 1)? 'NORMAL' : 'REINCIDÊNCIA')?></td>
                            <td><?=date('d/m/Y',strtotime(implode("-",array_reverse(explode("/",$row['DT_EMISSAO'])))))?> </td>
                            <td>
                                <a target='_blank' href="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/termo/imprimir/'.$row['CD_TERMO'].'-'.$row['CD_TIPO_TERMO'].'')?>" class="btn btn-xs btn-warning">
                                    <i class='fa fa-eye'></i> Ver
                                </a>
                            </td>
                        </tr>
                    <? } ?>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger2 pull-left" data-dismiss="modal">
                <i class="fa fa-times"></i> Fechar
            </button>
        </div>
    </div>
</div>
