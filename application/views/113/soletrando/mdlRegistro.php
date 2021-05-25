<div class="modal-dialog">
    <?
    $obj = (($operacao != 'A') ? 'readonly="readonly"' : '' );
    $id = date('dmYhms');
    ?>
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">
            <h6 class="modal-title">
                PALAVRA SOLETRANDO
                <i class="fa fa-2x fa-graduation-cap"></i>
            </h6>
        </div>

        <div class="modal-body row">
            <div class="col-xs-2">
                <label>CÓDIGO</label>
                <input value="<?= $filtro->CD_PALAVRA ?>"  readonly="readonly" type="text" name="codigo" id="Codigo<?= $id ?>" class="form-control input-sm" />
            </div>

            <div class="col-xs-3 no-padding">
                <label>CURSO</label>
                <select <?= $obj ?> required="required" name="curso" id="Curso<?= $id ?>" class="form-control input-sm">
                    <option value=""></option>
                    <? foreach ($curso as $row) { ?>
                        <option  <?= (($operacao == 'A') ? '' : (($filtro->CD_CURSO == $row['CD_CURSO']) ? 'selected="selected"' : '') ) ?> value="<?= $row['CD_CURSO'] ?>"><?= $row['NM_CURSO_RED'] ?></option>
                    <? } ?>
                </select>
            </div>

            <div class="col-xs-3">
                <label>SÉRIE</label>
                <select <?= $obj ?> required="required" name="serie" id="Serie<?= $id ?>" class="form-control input-sm">
                    <option value=""></option>
                </select>
            </div>

            <div class="col-xs-4" style="padding-left:0px">
                <label>BIMESTRE</label>
                <select <?= $obj ?> required="required" name="bimestre" id="Bimestre<?= $id ?>" class="form-control input-sm">
                    <option value=""></option>
                    <option <?= (($filtro->BIMESTRE == 1) ? 'selected="selected"' : '') ?> value="1">1º BIMESTRE</option>
                    <option <?= (($filtro->BIMESTRE == 2) ? 'selected="selected"' : '') ?> value="2">2º BIMESTRE</option>
                    <option <?= (($filtro->BIMESTRE == 3) ? 'selected="selected"' : '') ?> value="3">3º BIMESTRE</option>
                    <option <?= (($filtro->BIMESTRE == 4) ? 'selected="selected"' : '') ?> value="4">4º BIMESTRE</option>
                </select>
            </div>

            <div class="col-xs-8">
                <label>PALAVRA</label>
                <input onblur="javascript:{this.value = this.value.toUpperCase(); }" <?= $obj ?> required="required" value="<?= $filtro->DC_PALAVRA ?>" class="form-control input-sm" name="descricao" id="Palavra<?= $id ?>">
            </div>

            <div class="col-xs-4" style="padding-left:0px">
                <label>NÍVEL</label>
                <select required="required" name="nivel" id="Nivel<?= $id ?>" class="form-control input-sm">
                    <option value=""></option>
                    <option <?= (($filtro->FLG_DIFICULDADE == 'F') ? 'selected="selected"' : '') ?> value="F">FÁCIL</option>
                    <option <?= (($filtro->FLG_DIFICULDADE == 'M') ? 'selected="selected"' : '') ?> value="M">MÉDIO</option>
                    <option <?= (($filtro->FLG_DIFICULDADE == 'D') ? 'selected="selected"' : '') ?> value="D">DIFÍCIL</option>
                </select>
            </div>

            <div class="col-xs-12">
                <label>APLICAÇÃO NA FRASE</label>
                <input required="required" value="<?= $filtro->DC_DICA_APLICACAO_FRASE ?>" class="form-control input-sm" name="aplicacao" id="Aplicacao<?= $id ?>">
            </div>

            <div class="col-xs-12">
                <label>DICA</label>
                <input required="required" value="<?= $filtro->DC_DICA_EXEMPLO ?>" class="form-control input-sm" name="Dica" id="Dica<?= $id ?>">
            </div>
        </div>

        <div class="modal-footer" id="resp<?= $id ?>"></div>

        <div class="modal-footer">
            <button type="button" class="btn btn-danger2 pull-left" data-dismiss="modal">
                <i class="fa fa-times"></i> Fechar
            </button>
            <button type="button" class="btn btn-warning2" id="frmRegistrar<?= $id ?>">
                <i class="fa fa-save"></i> Salvar 
            </button>
        </div>

        <input type="hidden" name="operacao" id="Operacao<?= $id ?>" value="<?= $operacao ?>">
    </div>

    <script type="text/javascript">
<?php if ($operacao != 'A') { ?>
            $(function () {
                $.post("<?= base_url('/comum/combobox/serie') ?>", {
                    curso: <?= $filtro->CD_CURSO ?>,
                    selecionado: <?= $filtro->ORDEM_SERIE ?>
                },
                function (valor) {
                    $("select[id=Serie<?= $id ?>]").html(valor);
                });
            });
<?php } ?>

        $("select[id=Curso<?= $id ?>]").change(function () {
            $("select[id=Serie<?= $id ?>]").html('<option>Carregando</option>');
            $.post("<?= base_url('/comum/combobox/serie') ?>", {
                curso: $(this).val()
            },
            function (valor) {
                $("select[id=Serie<?= $id ?>]").html(valor);
            });
        });

        $("button[id=frmRegistrar<?= $id ?>]").click(function () {

            if ($("select[id=Curso<?= $id ?>]").val() === '') {
                $("#resp<?= $id ?>").html('<label class="text-danger">Selecione o CURSO</label>');

            } else if ($("select[id=Serie<?= $id ?>]").val() === '') {
                $("#resp<?= $id ?>").html('<label class="text-danger">Selecione a SÉRIE </label>');

            } else if ($("select[id=Bimestre<?= $id ?>]").val() === '') {
                $("#resp<?= $id ?>").html('<label class="text-danger">Selecione o BIMESTRE </label>');

            } else if ($("input[id=Palavra<?= $id ?>]").val() === '') {
                $("#resp<?= $id ?>").html('<label class="text-danger">Informe a PALAVRA </label>');

            } else if ($("select[id=Nivel<?= $id ?>]").val() === '') {
                $("#resp<?= $id ?>").html('<label class="text-danger">Selecione o NÍVEL DE DIFICULDADE </label>');

            } else {
                $("#resp<?= $id ?>").html('Carregando');
                $.post("<?= base_url('' . $this->session->userdata('SGP_SISTEMA') . '/soletrando/frmManter') ?>", {
                    operacao: $("input[id=Operacao<?= $id ?>]").val(),
                    codigo: $("input[id=Codigo<?= $id ?>]").val(),
                    curso: $("select[id=Curso<?= $id ?>]").val(),
                    serie: $("select[id=Serie<?= $id ?>]").val(),
                    bimestre: $("select[id=Bimestre<?= $id ?>]").val(),
                    nivel: $("select[id=Nivel<?= $id ?>]").val(),
                    palavra: $("input[id=Palavra<?= $id ?>]").val(),
                    aplicacao: $("input[id=Aplicacao<?= $id ?>]").val(),
                    dica: $("input[id=Dica<?= $id ?>]").val()
                },
                function (valor) {
                    $("#resp<?= $id ?>").html(valor);
                    txtFiltrar(true);
                });
            }
        });
    </script>
</div>
