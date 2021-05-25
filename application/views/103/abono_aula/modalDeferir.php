<div class="modal-dialog" id="frmNovaSolicitacao">
    <div class="modal-content">
        <div class="color-line">            
        </div>

        <div class="modal-footer">
            <h4>AVALIAR SOLICITAÇÃO</h4>
        </div>

        <div class="modal-body">
            <div class="row text-center">
                <label>DESCRIÇÃO</label>                
                <textarea class='form-control' id='ABNRetorno' spellcheck="true"><?= $solicitacao->DS_RETORNO ?></textarea>

                <hr>

                <button target="_blank" class="btn btn-danger btnReprovar pull-left">
                    <i class="fa fa-thumbs-o-down"></i>
                    Reprovar
                </button>

                <button target="_blank" class="btn btn-warning btnInformacao text-center">
                    <i class="fa fa-info-circle"></i>
                    Mais Informações
                </button>

                <button target="_blank" class="btn btn-success btnAprovar pull-right">
                    <i class="fa fa-thumbs-o-up"></i>
                    Aprovar
                </button>

                <input type="hidden" id="ABNCodigo" value="<?= $solicitacao->CD_SOLICITACAO ?>">
            </div>
        </div>        

        <div class="modal-footer">
            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
                <i class="fa fa-times"></i> Fechar
            </button>
        </div>

        <script type="text/javascript">
            $('.btnInformacao').click(function () {
                swal({
                    title: "Mais Informações",
                    text: "Você deseja solicitar mais informações da equipe técnica?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Sim",
                    cancelButtonText: "Não",
                    closeOnConfirm: false,
                    closeOnCancel: true
                },
                function (isConfirm) {
                    if (isConfirm) {
                        enviar("I");
                    }
                });
            });

            $('.btnReprovar').click(function () {
                swal({
                    title: "Reprovar",
                    text: "Você tem certeza de que deseja reprovar a solicitação?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Sim",
                    cancelButtonText: "Não",
                    closeOnConfirm: false,
                    closeOnCancel: true
                },
                function (isConfirm) {
                    if (isConfirm) {
                        enviar("R");
                    }
                });
            });

            $('.btnAprovar').click(function () {
                swal({
                    title: "Aprovar",
                    text: "Você tem certeza de que deseja aprovar a solicitação?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Sim",
                    cancelButtonText: "Não",
                    closeOnConfirm: false,
                    closeOnCancel: true
                },
                function (isConfirm) {
                    if (isConfirm) {
                        enviar("A");
                    }
                });
            });

            function enviar(status) {
                var solicitacoes = $(".solicitacao:checked").map(function () {
                    return $(this).val();
                }).get();
                var descricao = $("#ABNRetorno").val();

                $.ajax({
                    url: "<?= base_url('103/abono_aula/formManterDeferir') ?>",
                    method: "post",
                    data: {
                        status: status,
                        solicitacoes: solicitacoes,
                        descricao: descricao
                    },
                    dataType: "json",
                    success: function (response) {
                        if (response['success']) {
                            $("#frmModalDeferir").modal("hide");
                            swal("Sucesso!", response['mensagem'], "success");
                            txtFiltrar();
                        } else {
                            swal("Erro", response['mensagem'], "error");
                        }
                    }
                });
            }
        </script>
    </div>
</div>