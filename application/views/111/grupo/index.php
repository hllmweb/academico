<? $this->load->view('home/header'); ?>
<div class="content animate-panel">
    <div class="row projects">
        <div class="hpanel hgreen">
            <div class="panel-footer">
                <h4>Lista de Perfil</h4>
            </div>
            <div class="panel-footer">
                <a data-toggle="frmModal" class="btn btn-labeled btn-info" href="<?= base_url('111/grupo/frmCadastro/I') ?>">
                    <span class="btn-label">
                        <i class="fa fa-plus"></i>
                    </span>
                    Novo Perfil
                </a>
            </div>
            <div class="panel-body">
                <div role="tabpanel">
                    <table id="tbl" class="table table-hover table-striped" cellpadding="0" cellspacing="5" width="100%">
                        <thead>
                            <tr>
                                <th>CÓDIGO</th>
                                <th>PERFIL</th>
                                <th width="10%">STATUS</th>
                                <th width="15%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach ($listar as $row) { ?>
                                <tr class="<?=(($row->FLG_ATIVO == 1) ? '' : 'text-danger')?>">
                                    <td width="50px"><?= $row->CD_GRUPO?></td>
                                    <td><?= $row->DC_GRUPO?></td>
                                    <td><?=(($row->FLG_ATIVO == 1) ? 'ATIVO' : 'INATIVO')?></td>
                                    <td class="text-right">
                                        <a data-toggle="frmModal" class="btn btn-primary btn-xs" href="<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/grupo/frmUsuario/' . $row->CD_GRUPO . '') ?>">
                                            <i class="fa fa-users"></i>
                                        </a>
                                        <a data-toggle="frmModal" class="btn btn-primary2 btn-xs" href="<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/grupo/frmPrograma/' . $row->CD_GRUPO . '') ?>">
                                            <i class="fa fa-list-ol"></i>
                                        </a>
                                        <a data-toggle="frmModal" class="btn btn-warning btn-xs" href="<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/grupo/frmCadastro/U-' . $row->CD_GRUPO . '') ?>">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a data-toggle="frmModal" class="btn btn-danger btn-xs" href="<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/grupo/frmCadastro/D-' . $row->CD_GRUPO . '') ?>">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <? } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="panel-footer">
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