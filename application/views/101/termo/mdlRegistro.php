<div class="modal-dialog">
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">
            <h5 class="modal-title">
                Termo de Compromisso
                <i class="fa fa-2x fa-graduation-cap"></i>
            </h5>
        </div>
        <div class="modal-body row">
            <div class="col-xs-2">
                <label>CÓDIGO</label>
                <input readonly="readonly" type="text" name="Codigo" id="Codigo" class="form-control input-sm" />
            </div>
            <div class="col-xs-4 no-padding">
                <label>TIPO TERMO</label>
                <select required="required" name="Tipo" id="Tipo" class="form-control input-sm">
                    <option value=""></option>
                    <option value="1">1 - NORMAL</option>
                    <option value="2">2 - REINCIDÊNCIA</option>
                </select>
            </div>
            <div class="col-xs-3">
                <label>CURSO</label>
                <select required="required" name="Curso" id="Curso" class="form-control input-sm">
                    <option value=""></option>
                    <? foreach ($curso as $row) { ?>
                        <option value="<?= $row['CD_CURSO'] ?>"><?= $row['NM_CURSO_RED'] ?></option>
                    <? } ?>
                </select>
            </div>
            <div class="col-xs-3" style="padding-left:0px">
                <label>SÉRIE</label>
                <select required="required" name="Serie" id="Serie" class="form-control input-sm">
                    <option value=""></option>
                </select>
            </div>
            <div class="col-xs-12">
                <label>ALUNO</label>
                <select required="required" name="Aluno" id="Aluno" class="form-control input-sm">
                </select>
            </div>
            <div class="col-xs-12">
                <label>RESPONSÁVEL</label>
                <select required="required" name="Responsavel" id="Responsavel" class="form-control input-sm">
                </select>
            </div>
        </div>
        <div class="modal-footer" id="resp"></div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger2 pull-left" data-dismiss="modal">
                <i class="fa fa-times"></i> Fechar
            </button>
            <button type="button" class="btn btn-warning2" id="frmRegistrar">
                <i class="fa fa-save"></i> Salvar 
            </button>
        </div>
        <input type="hidden" name="Operacao" id="Operacao" value="<?=$operacao?>">
    </div>
    
    <script type="text/javascript">
    $("select[id=Curso]").change(function() {
        $("select[id=Serie]").html('<option>Carregando</option>');
        $.post("<?= base_url('/comum/combobox/serie') ?>", {
            curso: $(this).val()
        },
        function(valor) {
            $("select[id=Serie]").html(valor);
        });
    });
    $("select[name=Serie]").change(function() {
        $("select[name=Aluno]").html('Carregando');
        $.post("<?= base_url('/comum/combobox/alunos') ?>", {
            curso: $('select[name=Curso]').val(),
            serie: $('select[name=Serie]').val(),
        },
        function(data) {
            $("select[name=Aluno]").append("<option></option>");
            $("select[name=Aluno]").append(data);
        });
    });
    
    $("select[name=Aluno]").change(function() {
        $("select[name=Responsavel]").html('Carregando');
        $.post("<?= base_url('/comum/combobox/responsavel') ?>", {
            aluno: $('select[name=Aluno]').val(),
        },
        function(data) {
            $("select[name=Responsavel]").html(data);
        });
    });
    
    $("button[id=frmRegistrar]").click(function() {
        
        if($("select[id=Tipo]").val() == ''){
            $("#resp").html('<label class="text-danger">Informe o TIPO DE TERMO</label>');
            
        }else if($("select[id=Curso]").val() == ''){
            $("#resp").html('<label class="text-danger">Selecione o CURSO</label>');
            
        }else if($("select[id=Serie]").val() == ''){
            $("#resp").html('<label class="text-danger">Selecione a SÉRIE </label>');
            
        }else if($("select[name=Aluno]").val() == '') {
            $("#resp").html('<label class="text-danger">Selecione o ALUNO </label>');
            
        }else if($("select[name=Responsavel]").val() == ''){
            $("#resp").html('<label class="text-danger">Selecione o RESPONSÁVEL </label>');
            
        }else{
            $("#resp").html('<option>Carregando</option>');
            $.post("<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/termo/frmManter') ?>", {
               operacao: $("input[id=Operacao]").val(),
                 codigo: $("input[id=Codigo]").val(),
                   tipo: $("select[id=Tipo]").val(),
                  aluno: $("select[id=Aluno]").val(),
            responsavel: $("select[id=Responsavel]").val(),
            },
            function(valor) {
                $("#resp").html(valor);
            });
        }
    });
    
</script>
</div>
