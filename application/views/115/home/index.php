<? $this->load->view('home/header'); ?>
<div class="content animate-panel">
    <div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-hidden="false" style="display: block; padding-right: 17px;">
      <div class="modal-backdrop fade in" style="height: 667px;"></div>
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="color-line"></div>
                <div class="modal-footer text-center">
                    <h4>Plano de Ensino:</h4>
                </div>
                <form id="formulario" method="POST" name="formulario" action="<?=base_url('115/plano/index/')?>">
                    <div class="modal-body">
                        <label>Curso</label>
                            <select name="aesCurso" id="aesCurso" class="form-control">
                            <option value=""></option>
                            <? foreach ($curso as $cur) { ?>
                                <option value="<?= $cur['CD_CURSO'] ?>"><?=$cur['NM_CURSO']?></option>
                            <? } ?>
                        </select>
                        <label>Série</label>    
                        <select name="aesSerie" id="aesSerie" class="form-control">
                           <option value=""></option>
                           <? foreach ($curso as $cur) { ?>
                           <option value="<?= $cur['CD_CURSO'] ?>"><?=$cur['NM_CURSO']?></option>
                           <? } ?>
                        </select>
                        <label>Disciplina</label>    
                        <select name="aesDisciplina" id="aesDisciplina" class="form-control">
                           <option value=""></option>
                           <? foreach ($curso as $cur) { ?>
                           <option value="<?= $cur['CD_CURSO'] ?>"><?=$cur['NM_CURSO']?></option>
                           <? } ?>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Próximo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $("select[id=aesCurso]").change(function() {
        $("select[id=aesSerie]").html('<option>Carregando</option>');
        $.post("<?= base_url('/comum/combobox/serie') ?>", {
            curso: $(this).val()
        },
        function(valor) {
            $("select[id=aesSerie]").html(valor);
        });
    });
</script>
<? $this->load->view('home/footer'); ?>