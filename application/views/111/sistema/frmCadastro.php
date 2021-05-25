<div class="modal-dialog">
    <? $st = (($operacao == 'D') ? 'disabled="disabled"' : '' ); ?>
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">
            <h5 class="modal-title">Cadastro de Sistema</h5>
        </div>
        <form method="POST" name="frmRegistro<?=$id ?>" id="frmRegistro<?=$id ?>">
        <div class="modal-body" >
            <div class="row">
                <div class="col-xs-4">
                    <label>CÓDIGO</label>
                    <input value="<?= $filtro->SISTEMA?>" readonly="readonly" type="number" class="form-control input-sm" name="Codigo" id="Codigo<?= $id ?>"/>
                </div>
                <div class="col-xs-4" style='padding-left:0px'>
                    <label>VERSÃO</label>
                    <input required="required" <?=$st?> value="<?= $filtro->VERSAO?>" type="text" class="form-control input-sm" name="Versao" id="Versao<?= $id ?>"/>
                </div>
                <div class="col-xs-4" style='padding-left:0px'>
                    <label>STATUS</label>
                    <select <?=$st?> required="required" name='Status' id='Status<?= $id ?>' class='form-control input-sm'>
                        <option></option>
                        <option <?php if($filtro->ATIVO == 'S' ) echo 'selected="selected"'; ?> value="S">ATIVO</option>
                        <option <?php if($filtro->ATIVO == 'N' ) echo 'selected="selected"'; ?> value="N">INATIVO</option>
                    </select>
                </div>
                <div class="col-xs-12">
                    <label>SISTEMA</label>
                    <input required="required" <?=$st?> value="<?= $filtro->DC_SISTEMA?>" type="text" class="form-control input-sm" name="Nome" id="Nome<?= $id ?>"/>
                </div>
                <div class="col-xs-12">
                    <label>TITULO</label>
                    <input required="required" <?=$st?> value="<?= $filtro->TITULO?>" type="text" class="form-control input-sm" name="Titulo" id="Titulo<?= $id ?>"/>
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
            url: "<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/sistema/frmManter')?>",  // Url to which the request is send
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


