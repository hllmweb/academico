<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">
            <h4 class="modal-title">Relatório Pedagógico Infantil</h4>
        </div>
        <div class="modal-body">

            <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="64%" align="left">
                        <table width="100%" border="0" cellspacing="4" cellpadding="4">
                            <tr>
                                <td width="9%" align="right" style="font-size:11px">Matrícula:</td>
                                <td width="91%" style="font-size:12px"><strong>
                                        <?= $aluno[0]['CD_ALUNO'] ?>
                                    </strong></td>
                            </tr>
                            <tr>
                                <td width="9%" align="right" style="font-size:11px">Nome:</td>
                                <td width="91%" style="font-size:12px"><strong>
                                        <?= $aluno[0]['NM_ALUNO'] ?>
                                    </strong></td>
                            </tr>
                            <tr>
                                <td align="right" style="font-size:11px">Turma:</td>
                                <td style="font-size:12px"><strong>
                                        <?= $aluno[0]['CD_TURMA'] ?>
                                    </strong></td>
                            </tr>
                            <tr>
                                <td align="right" style="font-size:11px">Curso:</td>
                                <td style="font-size:12px"><strong>
                                        <?= $aluno[0]['NM_CURSO'] ?>
                                    </strong></td>
                            </tr>
                            <tr>
                                <td align="right" style="font-size:11px">Série:</td>
                                <td style="font-size:12px"><strong>
                                        <?= $aluno[0]['NM_SERIE'] ?>
                                    </strong></td>
                            </tr>
                        </table></td>
                    <td width="26%" align="right" valign="middle">&nbsp;</td>
                </tr>
            </table>
            <br/>
            
            
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#tab-bim1"> 1 BIMESTRE</a></li>
                <li class=""><a data-toggle="tab" href="#tab-bim2">2 BIMESTRE</a></li>
                <li class=""><a data-toggle="tab" href="#tab-bim3">3 BIMESTRE</a></li>
                <li class=""><a data-toggle="tab" href="#tab-bim4">4 BIMESTRE</a></li>
            </ul>
            <div class="tab-content">
                <div id="tab-bim1" class="tab-pane active">
                    <div class="panel-body">
                        <?
            $div = array();
            foreach ($listar as $row) {
                $div[] = $row['DC_DIVISAO'];
            }
            $divisao = array_keys(array_flip($div));            
            foreach ($divisao as $d) { 
            ?>
                <h4><?= $d ?></h4>
                <table width="100%" cellpadding="2" class="table table-hover table-striped">
                    <thead>
                        <tr class="bg-info">
                            <td class="border-right"><strong>Pergunta</strong></td>
                            <td class="border-right" width="15%" align="center"><strong>1 BIMESTRE</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?
                        foreach ($listar as $r) {
                            if (str_replace(' ', '', $d) == str_replace(' ', '', $r['DC_DIVISAO'])) { ?>
                                <tr>
                                    <td class="border-right" style="font-size:10px"><?= $r['DC_PERGUNTA'] ?></td>
                                    <td class="border-right" align="center" style="font-size:10px">
                                        <strong><? echo $r['DC_RESPOSTA_PADRAO']; ?></strong>
                                    </td>
                                </tr>
                            <? } } ?>
                    </tbody>
                </table>
            <? } ?>
                    </div>
                </div>
                
                <div id="tab-bim2" class="tab-pane">
                    <div class="panel-body">
                    </div>
                </div>
                
                <div id="tab-bim3" class="tab-pane">
                    <div class="panel-body">
                    </div>
                </div>
                
                <div id="tab-bim4" class="tab-pane">
                    <div class="panel-body">
                    </div>
                </div>
                
            </div>

            
            
            
            
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger2 pull-left" data-dismiss="modal">Fechar</button>
            <a target="_blank" class="btn btn-info" href="<?=base_url('113/infantil/impAcompanhamentoInfantil/'.$aluno[0]['CD_ALUNO'].'-'.$r['CD_QUEST'].'')?>">
                <i class="fa fa-print"></i> Imprimir
            </a>
        </div>
    </div>
</div>
