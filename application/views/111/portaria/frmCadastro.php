<div class="modal-dialog">
    <?php echo $operacao; ?>

    <? $st = (($operacao == 'D') ? 'disabled="disabled"' : '' ); ?>
    <div class="modal-content">    
        <div class="color-line"></div>
        <div class="modal-footer">
            <h5 class="modal-title">Liberação de Portaria</h5>
        </div>


        <form id="formPortaria">
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-6">
                        <small>CÓDIGO</small>
                         <input type="text" class="form-control input-sm" name="Codigo" id="Codigo" disabled="disabled" />                    
                        <!-- <input readonly="readonly" type="text" class="form-control input-sm" name="" id=""/> -->
                    </div>
                    <div class="col-xs-6">
                        <small>Nome</small>
                        <input type="text" class="form-control input-sm typeahead" name="Nome" id="Nome">
                    </div>
                    <div class="col-xs-3">
                        <small>Data Atual</small>
                        <input type="text" class="form-control input-sm" name="Data_Atual" id="Data_Atual">
                    </div>
                    <div class="col-xs-3">  
                        <small>Data Fim</small>
                        <input type="text" class="form-control input-sm" name="Data_Inicial" id="Data_Inicial">
                    </div>
                    <div class="col-xs-3">
                        <small>Horário Início</small>
                        <input type="text" class="form-control input-sm" name="Horario_Inicial" id="Horario_Inicial">
                    </div>
                    <div class="col-xs-3">
                        <small>Horário Fim</small>
                        <input type="text" class="form-control input-sm" name="Horario_Fim" id="Horario_Fim">
                    </div>
                    <div class="col-xs-12">
                        <small>Tipo de Passagem</small>
                        <select id="Tipo_Saida" name="Tipo_Saida" class="form-control input-sm">
                            <option selected>Selecione a opção...</option>
                            <option value="E">Somente Entrada</option>
                            <option value="S">Somente Saída</option>
                            <option value="*">Entrada ou Saída</osption>
                        </select>
                    </div> 
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-outline pull-left" data-dismiss="modal"><i class="fa fa-close"></i> FECHAR</button>
                <button type="submit" id="btnSubmit<?=$id?>" class="btn btn-primary btn-outline" > <?=(($operacao == 'I')? 'ADICIONAR' : (($operacao == 'U')?  'ATUALIZAR' : 'DELETAR' ))?></button>
            </div>
        </form>
    </div>
</div>

<script>
// var Nomes = [
//     "Teste",
//     "Hugo",
//     "Janderson",
//     "Mauricio",
//     "Carlos Henrique",
//     "Carlos Vinicius"
// ];   

// input.typeahead({
//     source: Nomes,
//     autoSelect: true
// });



var input = $(".typeahead");

$.getJSON("<?= site_url($this->session->userdata('SGP_SISTEMA')."/portaria/listNome") ?>", function(valor){
    console.log(valor);

    input.typeahead({
        source: valor,
        display: 'name',
        autoSelect: true
    });

    input.change(function(){
        var current = input.typeahead("getActive");
         if (current) {
            if (current.name == input.val()) {
                 console.log(current.cd_usuario);
                 $("#Codigo").val(current.cd_usuario);
                 //  $.each(current, function (key, item) {
                 //    console.log(key+item);
                 // });
            } 
          } 
    });


});





$("#formPortaria").submit(function(e){
    //var dados = $(this).serialize();
    var dados = {   
            Codigo :            $("#Codigo").val(), 
            Data_Atual :        $("#Data_Atual").val(), 
            Data_Inicial :      $("#Data_Inicial").val(),
            Horario_Inicial:    $("#Horario_Inicial").val(),
            Horario_Fim:        $("#Horario_Fim").val(),
            Tipo_Saida:         $("#Tipo_Saida").val()
    };

    $.ajax({
        url: "<?= site_url($this->session->userdata('SGP_SISTEMA') . "/portaria/insertPortaria") ?>",
        data: dados,
        type: "POST",
        success: function(data){
            console.log(data);
        }

    });
    
    e.preventDefault();
});
</script>
