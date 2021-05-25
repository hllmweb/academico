<div class="modal-dialog modal-lg">
    <div class="color-line"></div>

    <div class="modal-content">
        <form id="formulario-solicitacao">
            <div class="modal-header" style="padding: 15px">
                <h5 class="modal-title text-right"><?=  $titulo; ?></h5>
            </div>

            <div class="modal-body">             
                <div class="row">
                    <div class="form-group col-xs-12">
                        <label>MOTIVO</label>
                        <input type="text" name="txt_motivo" id="txt_motivo" class="form-control">
                    </div>
                </div>


            </div>

            <div class="modal-footer">
                <div id="resposta">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                    <i class="fa fa-times"></i> Fechar
                </button>

                <button type="button" id="btnConfirmar" class="btn btn-success pull-right">
                    <i class="fa fa-save"></i>
                    Adicionar
                </button> 
            </div>
        </form>        
    </div>

    <script type="text/javascript">
        $("#btnConfirmar").click(function(){
            var motivo = $("#txt_motivo").val();     
            $.ajax({
                url: "<?= site_url("113/justificativa_solicitacao/formAddMotivo") ?>",
                type: "POST",
                data: {
                    motivo: motivo
                },
                success: function(data){
                    if(data == 1){
                        alert("Motivo inserido com sucesso!");
                        window.location.href="/academico/113/justificativa_solicitacao";
                    }else{
                        $("#resposta").html("Erro ao inserir motivo");
                    }
                }

            });
        });
    </script>
</div>