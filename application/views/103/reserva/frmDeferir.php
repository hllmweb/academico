<div class="modal-dialog modal-sm" id="frmNovaSolicitacao">
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">
            <h4>Deferir Solicitação</h4>
        </div>
        <div class="modal-body">

            <div class="row text-center">
                <label>Observação</label>
                <? if($reserva->DS_OCORRENCIA != ''){ ?>
                    <textarea class='form-control' id='Ocorrencia01' name='Ocorrencia01' readonly="readonly" style="font-size:10px"><?=$reserva->DS_OCORRENCIA->load()?></textarea>
                <? } ?>
                <textarea class='form-control' id='Ocorrencia' name='Ocorrencia'></textarea>
                <hr>
                <button target="_blank" class="btn btn-danger btnReprovar" >
                    <i class="fa fa-hand-o-down"></i>
                    Reprovar
                </button>
                <button target="_blank" class="btn btn-info btnAprovar" >
                    <i class="fa fa-hand-o-up"></i>
                    Aprovar
                </button>
            </div>

        </div>        
        <div class="modal-footer">

            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
                <i class="fa fa-times"></i> Fechar
            </button>

        </div>
        <script type="text/javascript">
            $('.btnReprovar').click(function() {
                swal({
                    title: "Reprovar",
                    text: "Você tem certeza que deseja reprovar essa solicitação de reserva? ",
                    type: "error",
                    showCancelButton: true,
                    confirmButtonText: "Sim!",
                    cancelButtonText: "Não!",
                    closeOnConfirm: false,
                    closeOnCancel: true,
                },
                function(isConfirm) {
                    if (isConfirm) {
                        $.post("<?= base_url('' . $this->session->userdata('SGP_SISTEMA') . '/reserva/frmManterDeferir') ?>", {
                            status: 'R',
                            codigo: <?=$reserva->CD_RESERVA?>,
                        ocorrencia: $("#Ocorrencia").val() + '\n usuario: <?=$this->session->userdata('SGP_NOME')?> \n\n' + $("#Ocorrencia01").val() + '\n\n',
                        },
                        function(valor) {
                            swal("Sucesso!", "Solicitação de reserva criada.", "success");
                            toastr.error('Você reprovou essa solicitação!');
                            txtFiltrar();
                        });
                    }
                });
            });

            $('.btnAprovar').click(function() {
                swal({
                    title: "Aprovar",
                    text: "Você tem certeza que deseja aprovar essa solicitação de reserva?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Sim, finalizar!",
                    cancelButtonText: "Não, Cancelar!",
                    closeOnConfirm: false,
                    closeOnCancel: true,
                },
                function(isConfirm) {
                    if (isConfirm) {

                        $.post("<?= base_url('' . $this->session->userdata('SGP_SISTEMA') . '/reserva/frmManterDeferir') ?>", {
                            status: 'A',
                            codigo: <?=$reserva->CD_RESERVA?>,
                        ocorrencia: 'Usuario: <?=$this->session->userdata('SGP_NOME')?> \n' + $("#Ocorrencia").val() + (($("#Ocorrencia01").val() != '')? '\n\n' + $("#Ocorrencia01").val() : '') + '\n\n',
                        },
                        function(valor) {
                            swal("Sucesso!", "Solicitação de reserva criada.", "success");
                            toastr.success('Você aprovou essa solicitação!');
                            txtFiltrar();
                        });
                    }
                });
            });
        </script>
    </div>
</div>
