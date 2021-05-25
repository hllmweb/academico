<div class="modal-dialog">
    <script type="text/javascript" src="<?=base_url('assets/css/select2-bootstrap.css')?>"></script>
    <? $st = (($operacao != 'I') ? 'readonly="readonly"' : '' ); ?>
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">
            <h5 class="modal-title">Cadastro de Usuário</h5>
        </div>
        <form method="POST" name="frmRegistro<?=$id ?>" id="frmRegistro<?=$id ?>">
        <div class="modal-body" >
            <div class="row">
                <div class="col-xs-6">
                    <small>CÓDIGO</small>
                    <input value="<?= $filtro->CD_USUARIO?>" readonly="readonly" type="number" class="form-control input-sm" name="Codigo" id="Codigo<?= $id ?>"/>
                </div>
                <div class="col-xs-6" style='padding-left:0px'>
                    <small>TIPO DE USUÁRIO</small>
                    <select <?=$st?> required="required" name='Tipo' id='Tipo<?= $id ?>' class='form-control input-sm'>
                        <option></option>
                        <option <?php if($filtro->FLG_TERCEIROS == 0 && $filtro->CD_PROFESSOR == '' && $filtro->CD_FUNCIONARIO != '') echo 'selected="selected"'; ?> value="F">FUNCIONÁRIO</option>
                        <option <?php if($filtro->FLG_TERCEIROS == 0 && $filtro->CD_PROFESSOR != '') echo 'selected="selected"'; ?> value="P">PROFESSOR</option>
                        <option <?php if($filtro->FLG_TERCEIROS == 1) echo 'selected="selected"'; ?> value="T">TERCEIROS</option>
                    </select>
                </div>
                <div class="col-xs-12">
                    <small>USUÁRIO</small>                    
                    <input required="required" <?=$st?> value="<?= $filtro->NM_USUARIO?>" type="text" class="form-control input-sm" name="Nome" id="Nome<?= $id ?>"/>
                    <select <?=$st?> required="required" name='Nome' id='Nome<?= $id ?>' class='form-control input-sm'>
                        <option></option>
                    </select>
                </div>
                <div class="col-xs-6">
                    <small>LOGIN</small>
                    <input required="required" <?=$st?> value="<?= $filtro->LOGIN?>" type="text" class="form-control input-sm" name="Login" id="Login<?= $id ?>"/>
                </div>
                <div class="col-xs-6" style='padding-left:0px'>
                    <small>FUNÇÃO</small>
                    <input required="required" <?=$st?> value="<?= $filtro->FUNCAO?>" type="text" class="form-control input-sm" name="Funcao" id="Funcao<?= $id ?>"/>
                </div>
                <div class="col-xs-12">
                    <small>EMAIL</small>
                    <input value="<?= $filtro->EMAIL?>" type="text" class="form-control input-sm" name="Email" id="Email<?= $id ?>"/>
                </div>
                <div class="col-xs-12">
                    <small>PERFIL</small>
                    <select required="required" name='Perfil' id='Perfil<?= $id ?>' class='form-control input-sm'>
                        <option></option>
                        <? foreach($perfil as $p){ ?>
                            <option <?php if($filtro->CD_PERFIL == $p->CD_GRUPO) echo 'selected="selected"'; ?>  value="<?=$p->CD_GRUPO?>"><?=$p->DC_GRUPO?></option>
                        <? } ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="col-xs-12" id="FRMRetorno<?= $id ?>"></div>
            <input value="<?= $filtro->CD_PROFESSOR?>"   type="hidden" name="Professor"   id="Professor<?= $id ?>"/>
            <input value="<?= $filtro->CD_FUNCIONARIO?>" type="hidden" name="Funcionario" id="Funcionario<?= $id ?>"/>
            <input value="<?= $filtro->CD_PESSOA?>"      type="hidden" name="Pessoa"      id="Pessoa<?= $id ?>"/>
            <input type="hidden" name="Cpf" id="Cpf<?= $id ?>" />
            <input value="<?= $operacao ?>" type="hidden" name="Operacao" id="Operacao<?= $id ?>"/>
            <button type="button" class="btn btn-default btn-outline pull-left" data-dismiss="modal"><i class="fa fa-close"></i> FECHAR</button>
            <button type="submit" id="btnSubmit<?=$id?>" class="btn btn-primary btn-outline" > <?=(($operacao == 'I')? 'ADICIONAR' : (($operacao == 'U')?  'ATUALIZAR' : 'DELETAR' ))?></button>
        </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="<?=base_url('assets/js/bootstrap-multiselect.js')?>"></script>
<script type="text/javascript">
    
    $('select[name=Nome]').hide();
    
    $("select[name=Tipo]").change(function() {
        $("select[name=Nome]").multiselect('destroy');
        $("select[name=Nome]").html('<option>Carregando...</option>');
        $.post("<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/usuario/selecaoTipo/') ?>", {
            tipo: $(this).val()
        },
        function(valor) {
            if($("select[name=Tipo]").val() == 'T'){
                $('input[name=Nome]').show();
                
                $('select[name=Nome]').hide();
                $('select[name=Nome]').attr('disable', true);
            
            }else{
                $('input[name=Nome]').hide();
                $('input[name=Nome]').attr('disable', true);
                
                
                $("select[name=Nome]").html(valor);
                $('select[name=Nome]').multiselect({
                    enableFiltering: true,
                });
            }
        });
    });
    $("select[name=Nome]").change(function() {
        $.post("<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/usuario/frmPessoa/') ?>", {
            tipo: $("select[name=Tipo]").val(),
            pessoa: $(this).val(),
        },
        function(data) {
            
            $('input[name=Funcao]').attr('readonly', true);
            
            var json = $.parseJSON(data);
            $("input[name=Funcao]").val(json.funcao);
            $("input[name=TXTNome]").val(json.funcao);
            $("input[name=Pessoa]").val(json.pessoa);
            $("input[name=Email]").val(json.email);
            $("input[name=Funcionario]").val(json.funcionario);
            $("input[name=Professor]").val(json.professor);
            $("input[name=Cpf]").val(json.cpf);
        });
    });
</script>
<script type="text/javascript">
$(document).ready(function (e) {
    $("#frmRegistro<?=$id ?>").on('submit',(function(e) {
    	e.preventDefault();
        $("#FRMRetorno<?= $id ?>").html('Enviando dados...');
	$.ajax({
            url: "<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/usuario/frmManter')?>",  // Url to which the request is send
            type: "POST",      			     // Type of request to be send, called as method
            data:  new FormData(this), 		     // Data sent to server, a set of key/value pairs representing form fields and values 
            contentType: false,       		     // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
            cache: false,		             // To unable request pages to be cached
            processData:false,  		     // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
            success: function(data){  		
                $("#FRMRetorno<?= $id ?>").html(data);
            }
       });
    }));
});
</script>


