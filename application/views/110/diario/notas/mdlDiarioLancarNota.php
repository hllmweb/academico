<div id="mdlListarAluno">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">
            <h4 class="modal-title">Lançamento de Nota</h4>
        </div>
        <script>
            function habilitar(id){
                if(id != ''){
                    $('.btnSalvarDados').removeAttr('disabled');
                }else{
                    $('.btnSalvarDados').attr('disabled');
                }
            }
        </script>
        <div class="modal-footer">
            <h5>Selecione o Tipo de Nota</h5>
            <select name="avalNumNota" id="avalNumNota" class="form-control" onchange="habilitar(this.value)">
                <option value=""></option>
                <?  foreach ($tipo_nota as $row) { ?>
                    <option value="<?= $row['NUM_NOTA'] ?>"><?=$row['NM_MINI']?></option>
                <? } ?>
            </select>
        </div>
        <div class="modal-footer">
            <input name="avalBimestre" id="avalBimestre" type="hidden" value="<?=$tipo_nota[0]['BIMESTRE']?>" />
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
            <button disabled type="button" class="btn btn-info btnSalvarDados">Lançar Nota</button>
        </div>
    </div>
    <script>
     function mdlProvaListarAluno() {
        $.post("<?= base_url('110/diario_prova/mdlDiarioProvaAluno') ?>", {
            prova: $("#avalProva").val(),
        },
        function(data) {
            if(data != 0){
                $("#mdlProvaAluno").html(valor);
                return ( 1 );
            }else{
                return ( 0 );
            }
        });
    };
    
    $(function() {
        $('.btnSalvarDados').click(function() {
            swal({
                title: "Notas Dissertativas",
                text: "Deseja realmente lançar as Notas Dissertativas desta prova?",
                type: "info",
                showCancelButton: true,
                confirmButtonText: "Sim, Lançar Agora!",
                cancelButtonText: "Não, Cancelar!",
                closeOnConfirm: true,
                closeOnCancel: true,
            },
            function(isConfirm) {
                if (isConfirm) {
                    setTimeout(function(){
                        swal("Aguarde!", "Estou montando a lista.", "success");
                    }, 500);
                    setTimeout(function(){
                        // função que verifica no banco se a prova esta processada 
                        $.post("<?= base_url('110/diario_prova/mdlDiarioListarAluno') ?>", {
                            nota: $("#avalNumNota").val(),
                        bimestre: $("#avalBimestre").val(),
                            mini: $("#avalNumNota option:selected").text(),
                        },
                        function(data) {
                            $("#mdlListarAluno").html(data);
                            swal("Pronto!", "Muita atenção na hora de colocar as notas.", "success");
                        });
                    }, 2000);
                } else {
                    swal("Tudo bem!", "Você tem até o fim do bimestre ou até a prova ser bloqueada.", "error");
                }
            });
        });

    });
</script>
</div>
</div>
