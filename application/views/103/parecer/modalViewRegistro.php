<?php $disabled = "disabled" ?>
<div class="modal-dialog">
    <div class="color-line"></div>

    <div class="modal-content">
        <form id="formulario-solicitacao">
            <div class="modal-header" style="padding: 15px">
                <h5 class="modal-title text-right"><?= $titulo ?></h5>
            </div>

            <div class="modal-body">             
                <div class="row">
                    <div class="hpanel">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a data-toggle="tab" href="#tab-solicitacao<?= $solicitacao->CD_SOLICITACAO ?>" aria-expanded="true">
                                    <i class="fa fa-list"></i> Solicitação
                                </a>
                            </li>

                            <?php if ($solicitacao->FL_REQUER_PARECER == "S"): ?>
                                <li>
                                    <a data-toggle="tab" href="#tab-parecer<?= $solicitacao->CD_SOLICITACAO ?>" aria-expanded="false">
                                        <i class="fa fa-wrench"></i> Parecer Técnico
                                    </a>
                                </li>
                            <?php endif; ?>

                            <li>
                                <a data-toggle="tab" href="#tab-retorno<?= $solicitacao->CD_SOLICITACAO ?>" aria-expanded="false">
                                    <i class="fa fa-reply"></i> Resposta
                                </a>
                            </li>
                        </ul>

                        <!-- DADOS SOLICITAÇÃO -->
                        <div class="tab-content">
                            <div id="tab-solicitacao<?= $solicitacao->CD_SOLICITACAO ?>" class="tab-pane active">                                
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="form-group col-xs-4">
                                            <label>Professor</label>
                                            <input type="text" class="form-control" value="<?= $solicitacao->NM_PROFESSOR ?>" <?= $disabled ?>>
                                        </div>                    

                                        <div class="form-group col-xs-4">
                                            <label>Data da Pendência</label>
                                            <input type="text" value="<?= date("d/m/Y", strtotime($solicitacao->DT_PENDENCIA)) ?>" class="form-control" <?= $disabled ?>>
                                        </div>

                                        <div class="form-group col-xs-4">
                                            <label>Motivo</label>
                                            <input type="text" class="form-control" value="<?= $solicitacao->NM_MOTIVO ?>" <?= $disabled ?>>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-xs-12">
                                            <label>Descrição</label>
                                            <textarea rows="2" class="form-control" <?= $disabled ?>><?= $solicitacao->DS_SOLICITACAO ?></textarea>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12">
                                            <table class="table table-hover table-striped">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">HORÁRIO</th>
                                                        <th class="text-center">TURMA</th>
                                                        <th class="text-center">DISCIPLINA</th>
                                                        <th class="text-center">ABRIU</th>
                                                        <th class="text-center">FECHOU</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php foreach ($aulas as $row): ?>
                                                        <tr>
                                                            <td class="text-center"><?= $row->HR_TEMPO_INICIO . " - " . $row->HR_TEMPO_FIM ?></td>
                                                            <td class="text-center"><?= $row->CD_TURMA ?></td>
                                                            <td class="text-center"><?= $row->NM_DISCIPLINA ?></td>
                                                            <td class="text-center"><?= $row->HR_ABERTURA == null ? "Não" : "Sim" ?></td>
                                                            <td class="text-center"><?= $row->HR_FECHAMENTO == null ? "Não" : "Sim" ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php if ($solicitacao->FL_REQUER_PARECER == "S"): ?>
                                <!-- DADOS PARECER -->
                                <div id="tab-parecer<?= $solicitacao->CD_SOLICITACAO ?>" class="tab-pane">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="form-group col-xs-6">
                                                <label>Data</label>
                                                <input type="text" value="<?= !empty($solicitacao->DT_PARECER) ? date("d/m/Y", strtotime($solicitacao->DT_PARECER)) : "" ?>" class="form-control" <?= $disabled ?>>
                                            </div>

                                            <div class="form-group col-xs-6">
                                                <label>Situação</label>
                                                <input type="text" value="<?= $solicitacao->DS_FL_PARECER ?>" class="form-control" <?= $disabled ?>>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-xs-12">
                                                <label>Parecer</label>
                                                <textarea rows="2" class="form-control" <?= $disabled ?>><?= $solicitacao->DS_PARECER ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- DADOS RESPOSTA -->
                            <div id="tab-retorno<?= $solicitacao->CD_SOLICITACAO ?>" class="tab-pane">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="form-group col-xs-6">
                                            <label>Data</label>
                                            <input type="text" value="<?= !empty($solicitacao->DT_RETORNO) ? date("d/m/Y", strtotime($solicitacao->DT_RETORNO)) : "" ?>" class="form-control" <?= $disabled ?>>
                                        </div>

                                        <div class="form-group col-xs-6">
                                            <label>Situação</label>
                                            <input type="text" value="<?= $solicitacao->DS_FL_STATUS ?>" class="form-control" <?= $disabled ?>>
                                        </div>
                                    </div>                                    

                                    <div class="row">
                                        <div class="form-group col-xs-12">
                                            <label>Resposta</label>
                                            <textarea rows="2" class="form-control" <?= $disabled ?>><?= $solicitacao->DS_RETORNO ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <input name="codigo" type="hidden" value="<?= $solicitacao->CD_SOLICITACAO ?>"/>
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                    <i class="fa fa-times"></i> Fechar
                </button>                
            </div>
        </form>
    </div>
</div>