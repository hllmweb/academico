<div class="modal-dialog">
<div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-header">
            <h4 class="modal-title">Provas</h4>
        </div>
        <div class="modal-body">
             <select id="avalProva" name="avalProva">
                <option selected="selected">Selecione a Prova</option>
                <?php foreach($lista as $dadosProva): ?>
                <option value="<?php echo $dadosProva['CD_PROVA']."-".$dadosProva['CD_ALUNO']?>"><?php echo "PROVA ".$dadosProva['CD_PROVA']." - RA ".$dadosProva['CD_ALUNO']?></option>
                <?php endforeach; ?>
            </select> 
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
    
        </div>
    </div>
</div>
</div>  
<script>
    $(function(){
        $(document).on("change","#avalProva",function(e){
            that = $(this).val();
            dados = that.split("-");
            cd_prova = dados[0];
            cd_aluno = dados[1];
           
            window.open("<?= base_url($this->session->userdata('SGP_SISTEMA')); ?>/impressao/simulado?id="+cd_prova+"&aluno="+cd_aluno);

            e.preventDefault();
        });

    });
</script>