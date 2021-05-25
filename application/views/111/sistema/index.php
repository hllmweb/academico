<? $this->load->view('home/header'); ?>
<div class="content animate-panel">
    <div class="row projects">
        <div class="hpanel hgreen">
            <div class="panel-footer">
                <h4>Lista de Sistemas</h4>
            </div>
            <div class="panel-footer">
                <a data-toggle="frmModal" class="btn btn-labeled btn-info" href="<?= base_url('111/sistema/frmCadastro/I') ?>">
                    <span class="btn-label">
                        <i class="fa fa-plus"></i>
                    </span>
                    Novo Sistema
                </a>
            </div>
            <div class="panel-body">
                <div role="tabpanel">
                    <table id="tbl" class="table table-hover table-striped" cellpadding="0" cellspacing="5" width="100%">
                        <thead>
                            <tr>
                                <th>CÓDIGO</th>
                                <th>SISTEMA</th>
                                <th width="10%">VERSÃO</th>
                                <th width="10%">STATUS</th>
                                <th width="10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach ($listar as $row) { ?>
                                <tr class="<?=(($row->ATIVO == 'S') ? '' : 'text-danger')?>">
                                    <td width="50px"><?= $row->SISTEMA?></td>
                                    <td><?= $row->DC_SISTEMA?></td>
                                    <td><?= $row->VERSAO ?></td>
                                    <td><?=(($row->ATIVO == 'S') ? 'ATIVO' : 'INATIVO')?></td>
                                    <td>
                                        <a data-toggle="frmModal" class="btn btn-primary2 btn-xs" href="<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/sistema/frmPrograma/' . $row->SISTEMA . '') ?>">
                                            <i class="fa fa-list-ol"></i>
                                        </a>
                                        <a data-toggle="frmModal" class="btn btn-warning btn-xs" href="<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/sistema/frmCadastro/U-' . $row->SISTEMA . '') ?>">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a data-toggle="frmModal" class="btn btn-danger btn-xs" href="<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/sistema/frmCadastro/D-' . $row->SISTEMA . '') ?>">
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
                                        <i class="fa fa-list-ol"></i> Lista de Programas
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