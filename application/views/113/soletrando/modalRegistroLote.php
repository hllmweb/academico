<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="color-line"></div>

        <div class="modal-footer">
            <h6 class="modal-title">
                PALAVRA SOLETRANDO
                <i class="fa fa-2x fa-graduation-cap"></i>
            </h6>
        </div>

        <div class="modal-body">            
            <form id="formulario-registro">                
                <div class="row">
                    <div class="col-xs-4">
                        <div class="form-group">
                            <label>CURSO</label>
                            <select name="curso" id="Curso" class="form-control input-sm">
                                <option value=""></option>
                                <? foreach ($curso as $row) { ?>
                                    <option  value="<?= $row['CD_CURSO'] ?>"><?= $row['NM_CURSO_RED'] ?></option>
                                <? } ?>
                            </select>
                        </div>
                    </div>                

                    <div class="col-xs-4">
                        <div class="form-group">
                            <label>SÉRIE</label>
                            <select name="serie" id="Serie" class="form-control input-sm">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>                

                    <div class="col-xs-4">
                        <div class="form-group">
                            <label>BIMESTRE</label>
                            <select name="bimestre" id="Bimestre" class="form-control input-sm">
                                <option value=""></option>
                                <option value="1">1º BIMESTRE</option>
                                <option value="2">2º BIMESTRE</option>
                                <option value="3">3º BIMESTRE</option>
                                <option value="4">4º BIMESTRE</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-6">
                        <div class="row form-group">
                            <div class="col-xs-8">                        
                                <label>PALAVRA</label>
                                <input onblur="javascript:{this.value = this.value.toUpperCase(); }" class="form-control input-sm" name="Palavra" id="Palavra">
                            </div>

                            <div class="col-xs-4">                        
                                <label>NÍVEL</label>
                                <select name="Nivel" id="Nivel" class="form-control input-sm">
                                    <option value=""></option>
                                    <option value="F">FÁCIL</option>
                                    <option value="M">MÉDIO</option>
                                    <option value="D">DIFÍCIL</option>
                                </select>
                            </div>                    
                        </div>

                        <div class="row form-group">
                            <div class="col-xs-12">                        
                                <label>APLICAÇÃO NA FRASE</label>
                                <input class="form-control input-sm" name="Aplicacao" id="Aplicacao">
                            </div>                    
                        </div>

                        <div class="row form-group">
                            <div class="col-xs-12">                        
                                <label>DICA</label>
                                <div class="input-group">
                                    <input class="form-control input-sm" name="Dica" id="Dica">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-sm btn-primary add pull-left">
                                            <i class="fa fa-plus"></i> Adicionar                        
                                        </button>
                                    </span>
                                </div>
                            </div>                    
                        </div>
                    </div>

                    <div class="col-xs-6">
                        <div style="height: 200px; overflow: auto">
                            <strong>LISTA DE PALAVRAS</strong>                        
                            <table id="grid-palavras" class="table table-striped table-bordered table-condensed table-hover">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>PALAVRA</th>
                                        <th>NÍVEL</th>
                                        <th>APLICAÇÃO</th>
                                        <th>FRASE</th>
                                    </tr>
                                </thead>

                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>            
            </form>
        </div>        

        <div class="modal-footer" id="resp">            
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-danger2 pull-left" data-dismiss="modal">
                <i class="fa fa-times"></i> Fechar
            </button>

            <button type="button" class="btn btn-success" id="frmRegistrar">
                <i class="fa fa-save"></i> Salvar 
            </button>
        </div>        
    </div>

    <script type="text/javascript">
        function validarPalavra() {
            var validou = true;

            if ($("input[id=Palavra]").val() === '') {
                validou = false;
                $("#resp").html('<label class="text-danger">Informe a PALAVRA </label>');

            } else if ($("select[id=Nivel]").val() === '') {
                validou = false;
                $("#resp").html('<label class="text-danger">Selecione o NÍVEL DE DIFICULDADE </label>');
            }

            //verificar se digitou uma frase
            var palavra = $("#Palavra").val();
            palavra = palavra.trim();
            var aux = palavra.split(" ");
            if (aux.length > 1) {
                validou = false;
                $("#resp").html('<label class="text-danger">O texto informado é uma frase e não uma palavra.</label>');
            }

            var linhas = $("#grid-palavras").find("tbody tr");
            for (i = 0; i < linhas.length; i++) {
                var colunas = $(linhas[i]).find("td");

                //verificar se o campo palavra já foi inserido
                if ($(colunas[1]).text() === $("#Palavra").val()) {
                    validou = false;
                    $("#resp").html('<label class="text-danger">A palavra informada já foi adicionada na lista de palavras.</label>');
                    break;
                }
            }

            return validou;
        }

        function validarRegistro() {
            var validou = true;

            if ($("select[id=Curso]").val() === '') {
                validou = false;
                $("#resp").html('<label class="text-danger">Selecione o CURSO</label>');

            } else if ($("select[id=Serie]").val() === '') {
                validou = false;
                $("#resp").html('<label class="text-danger">Selecione a SÉRIE </label>');

            } else if ($("select[id=Bimestre]").val() === '') {
                validou = false;
                $("#resp").html('<label class="text-danger">Selecione o BIMESTRE </label>');

            } else if ($("#grid-palavras").find("tbody tr").length === 0) {
                validou = false;
                $("#resp").html('<label class="text-danger">Adicione pelo menos uma PALAVRA </label>');
            }

            return validou;
        }

        $(document).on("click", ".remove", function () {
            $(this).closest("tr").remove();
        });

        $(".add").click(function () {
            if (validarPalavra()) {
                var palavra = $("#Palavra").val();
                var nivel = $("#Nivel").val();
                var dica = $("#Dica").val();
                var aplicacao = $("#Aplicacao").val();

                var ultimaLinha = $("#grid-palavras").find("tbody tr:last");
                var id = 0;

                if (ultimaLinha.length > 0) {
                    id = $(ultimaLinha).attr("data-id");
                    id++;
                } else {
                    id = 1;
                }

                var campoBotao = '<td class="text-center"><button type="button" class="btn btn-xs btn-danger remove"><i class="fa fa-close"></i></button></td>';
                var campoPalavra = '<td>' + palavra + '<input type="hidden" value="' + palavra + '" name="palavra[' + id + '][descricao]"></td>';
                var campoNivel = '<td>' + nivel + '<input type="hidden" value="' + nivel + '" name="palavra[' + id + '][nivel]"></td>';
                var campoDica = '<td>' + dica + '<input type="hidden" value="' + dica + '" name="palavra[' + id + '][dica]"></td>';
                var campoAplicacao = '<td>' + aplicacao + '<input type="hidden" value="' + aplicacao + '" name="palavra[' + id + '][aplicacao]"></td>';

                var linha = "<tr data-id=" + id + ">" + campoBotao + campoPalavra + campoNivel + campoDica + campoAplicacao + "</tr>";
                $("#grid-palavras").find("tbody").append(linha);

                var palavra = $("#Palavra").val("");
                var nivel = $("#Nivel").val("");
                var dica = $("#Dica").val("");
                var aplicacao = $("#Aplicacao").val("");
            }
        });

        $("select[id=Curso]").change(function () {
            $("select[id=Serie]").html('<option>Carregando</option>');
            $.post("<?= base_url('/comum/combobox/serie') ?>", {
                curso: $(this).val()
            },
            function (valor) {
                $("select[id=Serie]").html(valor);
            });
        });

        $("button[id=frmRegistrar]").click(function () {
            if (validarRegistro()) {
                $("#resp").html('<?= LOAD ?>');

                var dados = $("#formulario-registro").serialize();
                $.ajax({
                    url: "<?= base_url($this->session->userdata('SGP_SISTEMA') . '/soletrando/formManterLote') ?>",
                    data: dados,
                    dataType: "json",
                    method: "post",
                    success: function (response) {
                        if (response['success']) {
                            $("#resp").html(response['mensagem']);
                            $("#grid-palavras").find("tbody tr").remove();

                            $("#Curso").val("");
                            $("#Serie").val("");
                            $("#Bimestre").val("");
                            txtFiltrar(true);
                        } else {
                            $("#resp").html(response['mensagem']);
                        }
                    }
                });
            }
        });
    </script>
</div>