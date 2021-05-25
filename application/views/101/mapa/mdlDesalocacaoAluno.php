<div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">
            <h5 class="modal-title">
                Remover Aluno
            </h5>
        </div>
        <div class="modal-body row">
            Você Deseja realmente Remover esse Aluno desta Posição?
        </div>
        <div class="modal-footer" id="resp">
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger2 pull-left" data-dismiss="modal">
                <i class="fa fa-times"></i> Fechar
            </button>
            <button type="button" class="btn btn-warning2" id="frmRegistrar">
                <i class="fa fa-save"></i> Sim
            </button>
            <input type="hidden" id="Periodo" name="Periodo" value="<?=$periodo?>">
            <input type="hidden" id="Turma" name="Turma" value="<?=$turma?>">
            <input type="hidden" id="Aluno" name="Aluno" value="<?=$aluno?>">
        </div>
    </div>
    
    <script type="text/javascript">
    
    $("button[id=frmRegistrar]").click(function() {
        
            $("#resp").html('<option>Carregando</option>');
            $.post("<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/mapa/frmManter') ?>", {
               operacao: 'D',
                periodo: $("input[id=Periodo]").val(),
                  turma: $("input[id=Turma]").val(),
                  aluno: $("input[id=Aluno]").val()
            },
            function(valor) {
                $("#resp").html(valor);
                txtFiltrar();
                $('#frmModalInfo').modal('hide');
            });
    });
    
</script>
</div>
