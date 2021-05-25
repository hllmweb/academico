<div class="modal-dialog">
    <? $st = (($operacao == 'D') ? 'disabled="disabled"' : '' ); ?>
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">
            <h5 class="modal-title">Cadastro de Grupo</h5>
        </div>
        <form method="POST" name="frmRegistro<?=$id ?>" id="frmRegistro<?=$id ?>">
        <div class="modal-body" >
            <div class="row">
                <div class="col-xs-3">
                    <label>CÓDIGO</label>
                    <input value="<?= $filtro->CD_GRUPO?>" readonly="readonly" type="number" class="form-control input-sm" name="Codigo" id="Codigo<?= $id ?>"/>
                </div>
                <div class="col-xs-9" style='padding-left:0px'>
                    <label>GRUPO</label>
                    <input required="required" <?=$st?> value="<?= $filtro->DC_GRUPO?>" type="text" class="form-control input-sm" name="Nome" id="Nome<?= $id ?>"/>
                </div>
                <div class="col-xs-12">
                    <label>STATUS</label>
                    <select <?=$st?> required="required" name='Status' id='Status<?= $id ?>' class='form-control input-sm'>
                        <option></option>
                        <option <?php if($filtro->FLG_ATIVO == 1 ) echo 'selected="selected"'; ?> value="1">ATIVO</option>
                        <option <?php if($filtro->FLG_ATIVO == 0 ) echo 'selected="selected"'; ?> value="0">INATIVO</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="col-xs-12" id="FRMRetorno<?= $id ?>"></div>
            <input value="<?= $operacao ?>" type="hidden" name="Operacao" id="Operacao<?= $id ?>"/>
            <button type="button" class="btn btn-default btn-outline pull-left" data-dismiss="modal"><i class="fa fa-close"></i> FECHAR</button>
            <button type="submit" id="btnSubmit<?=$id?>" class="btn btn-primary btn-outline" > <?=(($operacao == 'I')? 'ADICIONAR' : (($operacao == 'U')?  'ATUALIZAR' : 'DELETAR' ))?></button>
        </div>
        </form>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function (e) {
    $("#frmRegistro<?=$id ?>").on('submit',(function(e) {
    	e.preventDefault();
        $("#FRMRetorno<?= $id ?>").html('Enviando dados...');
	$.ajax({
            url: "<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/grupo/frmManter')?>",  // Url to which the request is send
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


