<div class="modal-dialog modal-lg">
    <?
    $dis = (($operacao == 'D')? 'disabled="disabled"': '');
    $id = $codigo;
    ?>
    <script >
    <? if($operacao != 'A'){ ?>
                $.post("<?= base_url('/comum/combobox/serie') ?>", {
                    curso: <?=$filtro->CD_CURSO?>,
              selecionado: <?=$filtro->ORDEM_SERIE?>,
                },
                function(valor) {
                    
                    $("select[id=Serie<?=$id?>]").html(valor);
                });
                
                $.post("<?= base_url('/comum/combobox/turma') ?>", {
                    curso: <?=$filtro->CD_CURSO?>,
                    serie: <?=$filtro->ORDEM_SERIE?>,
              selecionado: '<?=$filtro->CD_TURMA?>',
                },
                function(data) {
                    $("select[id=Turma<?=$id?>]").html(data);
                });
                            
                $.post("<?= base_url('/comum/combobox/disciplina') ?>", {
                    curso: <?=$filtro->CD_CURSO?>,
                    serie: <?=$filtro->ORDEM_SERIE?>,
              selecionado: <?=$filtro->CD_DISCIPLINA?>,
                },
                function(data) {
                    $("select[id=Disciplina<?=$id?>]").html(data);
                });
                
                $.post("<?= base_url('/comum/combobox/professor') ?>", {
                    curso: <?=$filtro->CD_CURSO?>,
               disciplina: <?=$filtro->CD_DISCIPLINA?>,
              selecionado: <?=$filtro->CD_PROFESSOR?>,
                },
                function(data) {
                    $("select[id=Professor<?=$id?>]").html(data);
                });
        
        <? } ?>
    </script>
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">
            <h5 class="modal-title">
                Atendimento ao Docente
                <i class="fa fa-2x fa-graduation-cap"></i>
            </h5>
        </div>
        <div class="modal-body row">
            <div class="col-xs-3">
                <label>CÓDIGO</label>
                <input value="<?=$filtro->CD_ORIENTACAO?>" readonly="readonly" type="text" name="Codigo" id="Codigo<?=$id?>" class="form-control input-sm" />
            </div>

            <div class="col-xs-3 no-padding">
                <label>CURSO</label>
                <select <?=$dis?> name="Curso" id="Curso<?=$id?>" class="form-control input-sm">
                    <option value=""></option>
                    <? foreach ($curso as $row) { ?>
                        <option <?=(($filtro->CD_CURSO == $row['CD_CURSO'])? 'selected="selected"' : '' )?> value="<?= $row['CD_CURSO'] ?>"><?= $row['NM_CURSO_RED'] ?></option>
                    <? } ?>
                </select>
            </div>

            <div class="col-xs-3">
                <label>SÉRIE</label>
                <select <?=$dis?> name="Serie" id="Serie<?=$id?>" class="form-control input-sm">
                    <option value=""></option>
                </select>
            </div>
            
            <div class="col-xs-3 no-padding">
                <label>TURMA</label>
                <select <?=$dis?> name="Turma" id="Turma<?=$id?>" class="form-control input-sm">
                    <option value=""></option>
                </select>
            </div>
            
            <div class="col-xs-3">
                <label>DISCIPLINA</label>
                <select <?=$dis?> name="Disciplina" id="Disciplina<?=$id?>" class="form-control  input-sm">
                    <option value=""></option>
                </select>
            </div>
            
            <div class="col-xs-4 no-padding">
                <label>PROFESSOR</label>
                <select <?=$dis?> name="Professor" id="Professor<?=$id?>" class="form-control input-sm">
                    <option value=""></option>
                </select>
            </div>
            
            <div class="col-sm-3">
                <label>DATA</label>
                <div class="input-group m-b">
                    <input <?=$dis?> value="<?=(($filtro->DT_ORIENTACAO != '')? date('d/m/Y',strtotime(implode("-",array_reverse(explode("/",$filtro->DT_ORIENTACAO))))) : date('d/m/Y'))?> " type="text" class="input-sm form-control" name="Data" id="Data<?=$id?>" />
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span> 
                </div>
            </div>
            
            <div class="col-sm-2 no-padding">
                <label>HORA</label>
                <div class="input-group m-b">
                    <input <?=$dis?> value="<?=$filtro->DC_HORA?>" size="16" type="text" class="form-control input-sm"   name="Hora" id="Hora<?=$id?>" >
                    <span class="input-group-addon">
                        <i class="fa fa-clock-o"></i>
                    </span> 
                </div>
            </div>
            
            <div class="col-xs-4">
                <label>MOTIVO</label>
                <textarea <?=$dis?> class="form-control  input-sm" name="Motivo" id="Motivo<?=$id?>" rows="3"><?=$filtro->DC_MOTIVO?></textarea>
            </div>

            <div class="col-xs-4 no-padding">
                <label>RESUMO DO ATENDIMENTO</label>
                <textarea <?=$dis?> class="form-control  input-sm" name="Resumo" id="Resumo<?=$id?>" rows="3"><?=$filtro->DC_RESUMO?></textarea>
            </div>
            
            <div class="col-xs-4">
                <label>OBSERVAÇÕES</label>
                <textarea <?=$dis?> class="form-control  input-sm" name="Obs" id="Obs<?=$id?>" rows="3"><?=$filtro->DC_OBS?></textarea>
            </div>
            
        </div>
        <div class="modal-footer" id="resp<?=$id?>"></div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger2 pull-left" data-dismiss="modal">
                <i class="fa fa-times"></i> Fechar
            </button>
            <button type="button" class="btn btn-<?=(($operacao == 'A')? 'primary' : (($operacao == 'E')? 'info' : 'danger'))?> " id="frmRegistrar<?=$id?>">
                <i class="fa fa-save"></i> <?=(($operacao == 'A')? 'REGISTRAR' : (($operacao == 'E')? 'EDITAR' : 'DELETAR'))?> 
            </button>
        </div>
        <input type="hidden" name="Operacao" id="Operacao<?=$id?>" value="<?=$operacao?>">
    </div>
    
     
  
    <script type="text/javascript">
    
    $("select[id=Curso<?=$id?>]").change(function() {
        $("select[id=Serie<?=$id?>]").html('<option>Carregando</option>');
        $.post("<?= base_url('/comum/combobox/serie') ?>", {
            curso: $(this).val()
        },
        function(valor) {
            $("select[id=Serie<?=$id?>]").html(valor);
        });
    });
    $("select[name=Serie]").change(function() {
        $("select[name=Turma]").html('Carregando');
        $.post("<?= base_url('/comum/combobox/turma') ?>", {
            curso: $('select[name=Curso]').val(),
            serie: $('select[name=Serie]').val(),
        },
        function(data) {
            $("select[name=Turma]").html(data);
        });
    });
    $("select[name=Serie]").change(function() {
        $("select[name=Disciplina]").html('Carregando');
        $.post("<?= base_url('/comum/combobox/disciplina') ?>", {
            curso: $('select[name=Curso]').val(),
            serie: $('select[name=Serie]').val(),
        },
        function(data) {
            $("select[name=Disciplina]").html(data);
        });
    });
    $("select[name=Disciplina]").change(function() {
        $("select[name=Professor]").html('Carregando');
        $.post("<?= base_url('/comum/combobox/professor') ?>", {
            curso: $('select[name=Curso]').val(),
       disciplina: $('select[name=Disciplina]').val(),
        },
        function(data) {
            $("select[name=Professor]").html(data);
        });
    });
    
    $("#Data<?=$id?>").datepicker({
        format: "dd/mm/yyyy",
        autoclose: true,
        endDate: '+0d',
    });
    $('#Hora<?=$id?>').timepicker();
    
    $("button[id=frmRegistrar<?=$id?>]").click(function() {
        
        if($("select[id=Curso<?=$id?>]").val() == ''){
            $("#resp<?=$id?>").html('<label class="text-danger">Selecione o CURSO</label>');
            
        }else if($("select[id=Serie<?=$id?>]").val() == ''){
            $("#resp<?=$id?>").html('<label class="text-danger">Selecione a SÉRIE </label>');
            
        }else if($("select[id=Turma<?=$id?>]").val() == ''){
            $("#resp<?=$id?>").html('<label class="text-danger">Informe a TURMA </label>');

        }else if($("select[id=Disciplina<?=$id?>]").val() == ''){
            $("#resp<?=$id?>").html('<label class="text-danger">Informe a DISCIPLINA </label>');

        }else if($("select[id=Professor<?=$id?>]").val() == ''){
            $("#resp<?=$id?>").html('<label class="text-danger">Informe a PROFESSOR </label>');

        }else if($("input[id=Data<?=$id?>]").val() == ''){
            $("#resp<?=$id?>").html('<label class="text-danger">Informe a DATA DO ATENDIMENTO </label>');
         
        }else if($("textarea[id=Motivo<?=$id?>]").val() == ''){
            $("#resp<?=$id?>").html('<label class="text-danger">Descreva o MOTIVO </label>');

        }else if($("textarea[id=Resumo<?=$id?>]").val() == ''){
            $("#resp<?=$id?>").html('<label class="text-danger">Descreva o RESUMO DO ATENDIMENTO </label>');

        }else{
        
            $("#resp<?=$id?>").html('<option>Carregando</option>');
            $.post("<?= base_url('101/orientacao_docente/frmManter') ?>", {
               operacao: $("input[id=Operacao<?=$id?>]").val(),
                 codigo: $("input[id=Codigo<?=$id?>]").val(),
                  turma: $("select[id=Turma<?=$id?>]").val(),
             disciplina: $("select[id=Disciplina<?=$id?>]").val(),
              professor: $("select[id=Professor<?=$id?>]").val(),
                   data: $("input[id=Data<?=$id?>]").val(),
                   hora: $("input[id=Hora<?=$id?>]").val(),
                 motivo: $("textarea[id=Motivo<?=$id?>]").val(),
                 resumo: $("textarea[id=Resumo<?=$id?>]").val(),
                    obs: $("textarea[id=Obs<?=$id?>]").val(),
            },
            function(valor) {
                $("#resp<?=$id?>").html(valor);
            });
        }
    });
    
</script>


</div>
