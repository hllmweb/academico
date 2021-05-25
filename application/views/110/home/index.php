<? $this->load->view('home/header'); ?>
<div class="content animate-panel">


    <div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-hidden="false" style="display: block; padding-right: 17px;"><div class="modal-backdrop fade in" style="height: 667px;"></div>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="color-line"></div>
                <div class="modal-header text-center">
                    <h4 class="modal-title">ESCOLHA DE TURMA</h4>
                    <small class="font-bold">antes de prosseguir, informe a turma que deseja monitorar.</small>
                </div>
                <form action="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/diario')?>" method="POST">
                <div class="modal-body">
                    
                        <select name="frmSelTurma" id="frmSelTurma" class="form-control">
                            <? 
                            foreach($turmas as $t){ 
                                ?>
                               <option value="<?=$t['CD_TURMA']?>"><?=$t['CD_TURMA']?></option>
                            <? } ?>
                        </select>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">SELECIONAR</button>
                </div>
                </form>
            </div>
        </div>
    </div>

</div>
<? $this->load->view('home/footer'); ?>