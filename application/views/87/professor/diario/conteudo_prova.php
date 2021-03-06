<?php $this->load->view("home/header"); ?>

<div class="content animate-panel">    
    <div class="row">
        <?php if ($this->session->flashdata('success') != null): ?>
            <div class="alert alert-success">
                <?= $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>
        
        <?php if ($this->session->flashdata('error') != null): ?>
            <div class="alert alert-danger">
                <?= $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>        
    </div>

    <div class="row">        
        <div class="panel panel-primary">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr class="panel-heading">
                        <th class="text-center">TURMA</th>
                        <th class="text-center">DISCIPLINA</th>
                        <th class="text-center">AÇÕES</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($turmas as $turma): ?>
                        <tr>
                            <td class="text-center"><?= $turma['CD_TURMA'] ?></td>
                            <td class="text-center"><?= $turma['NM_DISCIPLINA'] ?></td>
                            <td class="text-center">
                                <button id class="btn btn-success" type="button" data-toggle="modal" data-target="#tipo_nota<?= str_replace("+", "", $turma['CD_DISCIPLINA'] . $turma['CD_TURMA']); ?>">
                                    <i class="fa fa-book"></i>
                                    Lançar Conteúdo
                                </button>
                            </td>
                        </tr>            

                    <div class="modal" id="tipo_nota<?= str_replace("+", "", $turma['CD_DISCIPLINA'] . $turma['CD_TURMA']); ?>">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header btn-warning">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Selecione o Tipo de Nota</h4>
                                </div>

                                <form action="<?= site_url("87/professor/diario/lancar_conteudo_prova") ?>" method="post">
                                    <div class="modal-body">
                                        <input type="hidden" name="codigo-disciplina" value="<?= $turma['CD_DISCIPLINA'] ?>">
                                        <input type="hidden" name="descricao-disciplina" value="<?= $turma['NM_DISCIPLINA'] ?>">
                                        <input type="hidden" name="turma" value="<?= $turma['CD_TURMA'] ?>">                                                                                        

                                        <div class="row">
                                            <div class="col-xs-4">
                                                Turma: <label><?= $turma['CD_TURMA'] ?></label>
                                            </div>

                                            <div class="col-xs-8">
                                                Disciplina: <label><?= $turma['NM_DISCIPLINA'] ?></label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-12">
                                                <?php if (count($turma['notas']) == 0): ?>
                                                    <p>Não é mais possível realizar o lançamento.</p>
                                                <?php else: ?>
                                                    <div class="form-group">
                                                        Tipo de Nota:
                                                        <select name="tipo-nota" class="form-control" required="true">
                                                            <option></option>
                                                            <?php foreach ($turma['notas'] as $nota): ?>
                                                                <option value="<?= $nota['CD_TIPO_NOTA'] . "-" . $nota['BIMESTRE'] ?>">
                                                                    <?= $nota['DC_TIPO_NOTA'] . "(" . $nota['NM_MINI'] . ") - " . $nota['BIMESTRE'] . "º Bimestre"; ?>
                                                                </option>
                                                            <?php endforeach;
                                                            ?>
                                                        </select>                                                        
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>  

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-rotate-left"></i> Cancelar</button>
                                        <?php if (count($turma['notas']) != 0) { ?>
                                            <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i> Lançar</button>
                                        <?php } ?>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>    
</div>

<?php $this->load->view("home/footer"); ?>