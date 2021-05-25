<div class="modal-dialog modal-lg" id="mdlUsuario">
    <script type="text/javascript">
        
        function deletar(perfil,usuario) {
            $("#mdlBodyUsuario").html('Enviando dados...');
            $.post("<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/grupo/frmManterUsuario')?>", {
                Operacao: 'D',
                Codigo: perfil,
                Usuario: usuario,
            },
            function(valor) {
                $("#mdlBodyUsuario").html(valor);
            });
        };
    </script>
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">
            <h5 class="modal-title">Lista de Usuários</h5>
        </div>
        <div class="modal-body" id="mdlBodyUsuario">
            <table id="tbl" class="table table-hover table-striped" cellpadding="0" cellspacing="5" width="100%">
                <thead>
                    <tr>
                        <th>CÓDIGO</th>
                        <th>USUÁRIO</th>
                        <th>FUNÇÃO</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <? foreach ($listar as $row) { ?>
                        <tr>
                            <td><?= $row->CD_USUARIO?></td>
                            <td width="50%"><?= $row->NM_USUARIO?> <?=(($row->ATIVO == 0)? ' - <small class="text-danger">{ demitido }</small>' : '' )?></td>
                            <td><?= $row->FUNCAO ?></td>
                            <td width="5%">
                                <button type="button" onclick="deletar(<?=$row->CD_GRUPO?>,<?=$row->CD_USUARIO?>)" class="btn btn-danger btn-xs">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <? } ?>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default btn-outline pull-left" data-dismiss="modal">
                <i class="fa fa-close"></i> FECHAR
            </button>
        </div>
    </div>
</div>
