<? $this->load->view('home/header'); ?>
<div class="content animate-panel">
    <div class="row projects">
        <div class="hpanel hgreen col-sm-6">
            <div class="panel-footer">
                <a class="btn btn-labeled btn-info pull-right" href="<?= base_url('111/sistemas/frmNovoSistema') ?>">
                    <span class="btn-label">
                        <i class="fa fa-plus"></i>
                    </span>
                    Novo Sistema
                </a>
                <br/>
                <strong>Lista de Usuários</strong><br/>
            </div>
            <div class="panel-body">
                <div role="tabpanel">
                    <table id="tbl" class="table table-hover table-striped" cellpadding="0" cellspacing="5" width="100%">
                        <thead>
                            <tr>
                                <th>CÓDIGO</th>
                                <th>NOME</th>
                                <th class="sorting_desc_disabled"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach ($usuarios as $usu) { ?>
                                <tr>
                                    <td width="50px"><?= $usu['CD_USUARIO'] ?></td>
                                    <td><?= $usu['NM_USUARIO'] ?></td>
                                    <td>
                                        <a class="btn btn-danger btn-xs" href="<?= base_url('111/grupos/frmGrupoView/' . $row['CD_GRUPO'] . '') ?>">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <? } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="hpanel hgreen col-sm-12">
            <div class="panel-footer text-right">
                <h5>Lista de Programas</h5>
            </div>
            <div class="panel-body">
                <div id="grdPainelPrograma">
                    <table id="tbl" class="table table-hover table-striped" cellpadding="0" cellspacing="5" width="100%">
                        <thead>
                            <tr>
                                <td>CÓDIGO</td>
                                <td>NOME</td>
                                <td width="5%" class="sorting_desc_disabled text-center">INCLUIR</td>
                                <td width="5%" class="sorting_desc_disabled text-center">EDITAR</td>
                                <td width="5%" class="sorting_desc_disabled text-center">EXCLUIR</td>
                                <td width="5%" class="sorting_desc_disabled text-center">IMPRIMIR</td>
                                <td width="5%" class="sorting_desc_disabled text-center">ESP. 1</td>
                                <td width="5%" class="sorting_desc_disabled text-center">ESP.2</td>
                                <td width="5%" class="sorting_desc_disabled text-center"></td>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach ($programas as $pro) { ?>
                                <tr>
                                    <td width="50px"><?= $pro['CD_PROGRAMA'] ?></td>
                                    <td><?= $pro['NM_PROGRAMA'] ?></td>
                                    <td class="text-center"><?=(($pro['INCLUIR'] == 1)? '<i class="fa fa-check-circle text-success"></i>' : '<i class="fa fa-times-circle text-danger"></i>') ?></td>
                                    <td class="text-center"><?=(($pro['ALTERAR'] == 1)? '<i class="fa fa-check-circle text-success"></i>' : '<i class="fa fa-times-circle text-danger"></i>') ?></td>
                                    <td class="text-center"><?=(($pro['EXCLUIR'] == 1)? '<i class="fa fa-check-circle text-success"></i>' : '<i class="fa fa-times-circle text-danger"></i>') ?></td>
                                    <td class="text-center"><?=(($pro['IMPRIMIR'] == 1)? '<i class="fa fa-check-circle text-success"></i>' : '<i class="fa fa-times-circle text-danger"></i>') ?></td>
                                    <td class="text-center"><?=(($pro['ESPECIAL1'] == 1)? '<i class="fa fa-check-circle text-success"></i>' : '<i class="fa fa-times-circle text-danger"></i>') ?></td>
                                    <td class="text-center"><?=(($pro['ESPECIAL2'] == 1)? '<i class="fa fa-check-circle text-success"></i>' : '<i class="fa fa-times-circle text-danger"></i>') ?></td>
                                    <td class="text-center">
                                        <a class="btn btn-danger btn-xs" href="<?= base_url('111/grupos/frmGrupoView/' . $pro['CD_PROGRAMA'] . '') ?>">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <? } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel-footer">
                <a class="btn btn-labeled btn-info" href="<?= base_url('111/sistemas/frmNovoSistema') ?>">
                    <span class="btn-label">
                        <i class="fa fa-plus"></i>
                    </span>
                    Novo Sistema
                </a>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        // Datatables
        $('.table').DataTable();
    });
</script>
<? $this->load->view('home/footer'); ?>