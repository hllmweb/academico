<div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">
            <h5 class="modal-title">
                Alunos da Turma
            </h5>
        </div>
        <div class="modal-body row">
            <div class="col-xs-12">
                <label>ALUNO</label>
                <select name="Aluno" id="Aluno" class="form-control input-sm">
                    <option value=""></option>
                    <? 
                    foreach($lista as $l){ 
                        if($l['NR_FILA'] == '' || $l['NR_POSICAO'] == ''){
                        ?>
                    <option value="<?=$l['CD_ALUNO']?>"><?=$l['NM_ALUNO']?></option>
                    <? } } ?>
                </select>
            </div>
        </div>
        <div class="modal-footer" id="resp">
            <button type="button" class="btn btn-warning2" id="frmRegistrar">
                <i class="fa fa-save"></i> Salvar 
            </button>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger2 pull-left" data-dismiss="modal">
                <i class="fa fa-times"></i> Fechar
            </button>
            <input type="hidden" id="Periodo" name="Periodo" value="<?=$periodo?>">
            <input type="hidden" id="Turma" name="Turma" value="<?=$turma?>">
            <input type="hidden" id="Fila" name="Fila" value="<?=$fila?>">
            <input type="hidden" id="Posicao" name="Posicao" value="<?=$posicao?>">
        </div>
    </div>
    
    <script type="text/javascript">
    
    $("button[id=frmRegistrar]").click(function() {
        
        $("#resp").html('<option>Carregando</option>');
        $.post("<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/mapa/frmManter') ?>", {
           operacao: 'A',
            periodo: $("input[id=Periodo]").val(),
              turma: $("input[id=Turma]").val(),
              aluno: $("select[id=Aluno]").val(),
               fila: $("input[id=Fila]").val(),
            posicao: $("input[id=Posicao]").val(),
        },
        function(valor) {
            $("#resp").html(valor);
            txtFiltrar();
            $('#frmModalInfo').modal('hide');
        });
    });
    
</script>
</div>
