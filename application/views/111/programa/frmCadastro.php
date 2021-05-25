<div class="modal-dialog">
    <? $st = (($operacao == 'D') ? 'disabled="disabled"' : '' ); ?>
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">
            <h5 class="modal-title">Cadastro de Programa</h5>
        </div>
        <form method="POST" name="frmRegistro<?=$id ?>" id="frmRegistro<?=$id ?>">
        <div class="modal-body" >
            <div class="row">
                <div class="col-xs-12">
                    <small>SISTEMA</small>
                    <select <?=$st?> required="required" name='Sistema' id='Sistema<?= $id ?>' class='form-control input-sm'>
                        <option></option>
                        <? foreach($sistema as $s){ ?>
                        <option value="<?=$s->SISTEMA?>" <?php if($filtro->SISTEMA == $s->SISTEMA ) echo 'selected="selected"'; ?>><?=strtoupper($s->DC_SISTEMA)?></option>
                        <? } ?>
                    </select>
                </div>
                <div class="col-xs-3">
                    <small>CÓDIGO</small>
                    <input value="<?= $filtro->CD_PROGRAMA?>" readonly="readonly" type="number" class="form-control input-sm" name="Codigo" id="Codigo<?= $id ?>"/>
                </div>
                <div class="col-xs-9" style='padding-left:0px'>
                    <small>PROGRAMA</small>
                    <input required="required" <?=$st?> value="<?= $filtro->NM_PROGRAMA?>" type="text" class="form-control input-sm" name="Nome" id="Nome<?= $id ?>"/>
                </div>
                <div class="col-xs-12">
                    <small>FORMULÁRIO</small>
                    <input required="required" <?=$st?> value="<?= $filtro->FORMULARIO?>" type="text" class="form-control input-sm" name="Formulario" id="Formulario<?= $id ?>"/>
                </div>
                <div class="col-xs-12">
                    <small>OBSERVAÇÃO</small>
                    <textarea rows="5" <?=$st?> class="form-control input-sm" name="Observacao" id="Observacao<?= $id ?>" ><?= $filtro->OBSERVACAO?></textarea>
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
            url: "<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/programa/frmManter')?>",  // Url to which the request is send
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


