<? $this->load->view('home/header'); ?>
<div class="content animate-panel">
    <div class="row projects">
        <div class="hpanel hgreen">
            <div class="panel-footer">
                <h4>Lista de Programa</h4>
            </div>
            <div class="panel-footer">
                <a data-toggle="frmModal" class="btn btn-labeled btn-info" href="<?= base_url('111/programa/frmCadastro/I') ?>">
                    <span class="btn-label">
                        <i class="fa fa-plus"></i>
                    </span>
                    Novo Programa
                </a>
            </div>
            <div class="panel-body">
                <div role="tabpanel">
                    <table id="tbl" class="table table-hover table-striped" cellpadding="0" cellspacing="5" width="100%">
                        <thead>
                            <tr>
                                <th>CÓDIGO</th>
                                <th>PROGRAMA</th>
                                <th>FORMULÁRIO</th>
                                <th>SISTEMA</th>
                                <th width="10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach ($listar as $row) { ?>
                                <tr>
                                    <td width="50px"><?= $row->CD_PROGRAMA?></td>
                                    <td><?= $row->NM_PROGRAMA?></td>
                                    <td><?= $row->FORMULARIO?></td>
                                    <td><?= $row->DC_SISTEMA ?></td>
                                    <td>
                                        <a data-toggle="frmModal" class="btn btn-primary2 btn-xs" href="<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/programa/frmDependencia/' . $row->CD_PROGRAMA . '') ?>">
                                            <i class="fa fa-sitemap"></i>
                                        </a>
                                        <a data-toggle="frmModal" class="btn btn-warning btn-xs" href="<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/programa/frmCadastro/U-' . $row->CD_PROGRAMA . '') ?>">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a data-toggle="frmModal" class="btn btn-danger btn-xs" href="<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/programa/frmCadastro/D-' . $row->CD_PROGRAMA . '') ?>">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <? } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="panel-footer">
                                    <a class="btn btn-primary2 btn-xs">
                                        <i class="fa fa-sitemap"></i> Dependências
                                    </a>
                                    <a class="btn btn-warning btn-xs">
                                        <i class="fa fa-edit"></i> Editar
                                    </a>
                                    <a class="btn btn-danger btn-xs">
                                        <i class="fa fa-trash"></i> Deletar
                                    </a>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        // Datatables
        $('#tbl').DataTable();
    });
</script>
<? $this->load->view('home/footer'); ?>