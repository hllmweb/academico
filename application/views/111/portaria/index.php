<? $this->load->view('home/header'); ?>

<div class="content animate-panel">
    <div class="row projects">
        <div class="hpanel hgreen">
            
            <div class="panel-footer">
                <h4>Portaria</h4>
            </div>
            <div class="panel-footer">
                <a data-toggle="frmModal" class="btn btn-labeled btn-info" href="<?= base_url('111/portaria/frmCadastro/I') ?>">
                    <span class="btn-label">
                        <i class="fa fa-plus"></i>
                    </span>
                    Adicionar
                </a>
            </div>
			
            <div class="panel-body">
                <div role="tabpanel">
                    <table id="tbl" class="table table-hover table-striped" cellpadding="0" cellspacing="5" width="100%">
                        <thead>
                            <tr>
                                <th>MATRICULA</th>
                                <th>NOME</th>
                                <th>DATA E HORÁRIO DE LIBERAÇÃO</th>
                                <th>SISTEMA</th>
                                <th width="10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                        	<?php foreach($listar as $row): ?>
                    	  	<tr>
                                <td width="50px"><?= $row->CD_USUARIO; ?></td>
                                <td></td>
                                <td><?= $row->DT_INICIO." ".$row->HR_FIM ?></td>
                                <td><?= $row->FLG_PASSAGEM; ?></td>
                                <td></td>
                            </tr>
                       		<?php endforeach; ?>
                        </tbody>
                        <!-- <tfoot>
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
                        </tfoot> -->
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