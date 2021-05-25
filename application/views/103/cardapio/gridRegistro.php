<?php if (empty($registros)): ?>
    <small>Nenhuma opção cadastrada nesta semana.</small>
<?php else: ?>
    <table class="table table-bordered table-hover" id="tabela-cardapio">
        <thead>
            <tr class="bg-primary">
                <?php foreach ($dias as $key => $value): ?>
                    <th style="text-align: center; text-transform: uppercase">
                        <?= $value ?>
                    </th>
                <?php endforeach; ?>
            </tr>
        </thead>

        <?php foreach ($registros as $tipo => $opcoes): ?>
            <thead>
                <tr class="bg-info">
                    <th style="text-align: center; text-transform: uppercase" colspan="<?= count($dias) ?>">
                        <?= strtoupper($tipo) ?>
                    </th>
                </tr>
            </thead>

            <tbody>            
                <?php foreach ($opcoes as $opcao => $datas): ?>
                    <tr>
                        <td class="bg-warning" style="text-align: right; font-weight: bold; text-transform: uppercase"><?= $opcao ?></td>

                        <?php
                        
                        foreach ($dias as $dia => $nome):
                            if ($dia == "") {
                                continue;
                            }

                            $row = $datas[$dia];
                            ?>

                            <td style="text-align: center">
                                
                                <?php
                                foreach($row as $r){ 
                                    echo $r->NM_MATERIAL;
                                    if (!empty($r)): 
                                ?>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-xs btn-warning" 
                                                title="Editar" data-toggle="modalWarningRegistro" 
                                                data-remote="<?= site_url($this->session->userdata('SGP_SISTEMA') . "/cardapio/modalRegistro/E-" . $r->CD_CARDAPIO) ?>">
                                            <i class="fa fa-edit"></i>
                                        </button>

                                        <button type="button" class="btn btn-xs btn-danger" 
                                                title="Excluir" data-toggle="modalDangerRegistro"
                                                data-remote="<?= site_url($this->session->userdata('SGP_SISTEMA') . "/cardapio/modalRegistro/D-" . $r->CD_CARDAPIO) ?>">
                                            <i class="fa fa-close"></i>
                                        </button>
                                    </div><br/>
                                <?php endif; } ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        <?php endforeach; ?>    
    </table>
<?php endif; ?>

<input type="hidden" id="dataInicio" value="<?= $inicio ?>">
<input type="hidden" id="dataFim" value="<?= $fim ?>">

<script type="text/javascript">
    function atualizarCardapio() {
        var inicio = $("#dataInicio").val();
        var fim = $("#dataFim").val();

        $("#grid-registro").html('<?= LOAD ?>');

        $.post("<?= site_url($this->session->userdata("SGP_SISTEMA") . "/cardapio/gridRegistro") ?>", {
            semana: inicio + " - " + fim
        }, function (response) {
            $("#grid-registro").html(response);
        });
    }

    $('#tabela-cardapio').on('click', '[data-toggle="modalWarningRegistro"]',
            function (e) {
                $('#modalWarningRegistro').remove();
                e.preventDefault();
                var $this = $(this)
                        , $remote = $this.data('remote') || $this.attr('href')
                        , $modal = $('<div class="modal fade hmodal-warning" id="modalWarningRegistro"  tabindex="-1" role="dialog" ><div class="modal-dialog" ><div class="modal-content"></div></div></div>');
                $('body').append($modal);
                $modal.modal({backdrop: 'static', keyboard: false});
                $modal.load($remote);
            }
    );

    $('#tabela-cardapio').on('click', '[data-toggle="modalDangerRegistro"]',
            function (e) {
                $('#modalDangerRegistro').remove();
                e.preventDefault();
                var $this = $(this)
                        , $remote = $this.data('remote') || $this.attr('href')
                        , $modal = $('<div class="modal fade hmodal-danger" id="modalDangerRegistro"  tabindex="-1" role="dialog" ><div class="modal-dialog" ><div class="modal-content"></div></div></div>');
                $('body').append($modal);
                $modal.modal({backdrop: 'static', keyboard: false});
                $modal.load($remote);
            }
    );
</script>