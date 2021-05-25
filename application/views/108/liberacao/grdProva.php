<script type='text/javascript'>//<![CDATA[

    $(function() {
        $('#todos').click(function() {
            var val = this.checked;
            $('input[name=prova[]]').each(function() {
                $(this).prop('checked', val);
            });
        });
    });
    function habilitar(id) {
        if (id != '') {
            $('.btnLiberar').removeAttr('disabled');
            $('.btnRemover').removeAttr('disabled');
            $('.btnEnableNota').removeAttr('disabled');
            $('.btnDisableNota').removeAttr('disabled');


            $('#todos').removeAttr('disabled');
        } else {
            $('.btnRemover').attr('disabled');
            $('.btnLiberar').attr('disabled');
            $('.btnEnableNota').attr('disabled');
            $('.btnDisableNota').attr('disabled');


            $('#todos').attr('disabled');
        }
    }
</script>
<div id="retorno"></div>
<table class="display table table-striped table-hover" id="tblGrid">
    <thead>
        <tr class="panel-footer">
            <td style="width:1%"></td>
            <td style="width:5%"><strong>ID</strong></td>
            <td style="width:8%"><strong>N. PROVA</strong></td>
            <td align="center" style="width:12%"><strong>DT. REALIZAÇÃO</strong></td>
            <td><strong>DISCIPLINA</strong></td>
            <td><strong>SÉRIE</strong></td>
            <td align="center" style="width: 15%"><strong>NOTAS LIBERADAS NO PORTAL</strong></td>
            <td align="center" style="width:15%"><strong>GABARITO LIBERADO</strong></td>
            <td align="center" style="width:5%"><strong>OPÇÕES</strong></td>
        </tr>
    </thead>
    <tbody id="tblBody">
        <?
        $new = new Prova_lib();
        foreach($resultado as $row) {

           $data_atual = date('Y-m-d');
           $data_prova = date('Y-m-d',strtotime(implode("-",array_reverse(explode("/",$row['DT_PROVA'])))));


            //if(strtotime($data_prova) <= strtotime($data_atual) ){
            ?>
            <tr>
                <td><input onchange="habilitar()" class="checkbox" name="prova[]" value="<?= $row['CD_PROVA'] ?>" id="prova_<?= $row['CD_PROVA'] ?>" type="checkbox"></td>
                <td><?= $row['CD_PROVA'] ?></td>
                <td><?= $row['NUM_PROVA'] ?></td>
                <td align="center"><?= date('d/m/Y',strtotime(implode("-",array_reverse(explode("/",$row['DT_PROVA'])))));?></td>
                <td><?= $row['DISCIPLINAS'] ?></td>
                <td><?= $row['NM_SERIE']?></td>
                <td align="center">
                    <?= (($row['FLG_LIB_NOTA_PORTAL'] == 0)? '<small class="label label-danger">NÃO</small>' : '<small class="label label-success">SIM</small>') ?>  
                </td>


                <td align="center">
                    <?= (($row['FLG_WEB'] == 0)? '<small class="label label-danger">NÃO</small>' : '<small class="label label-success">SIM</small>')?>
                </td>
                <td align="center" class="sorting_1">
                    <div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-info btn-xs dropdown-toggle desable">
                            Provas & Gabaritos <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu desable">
                            <li><a class="desable" target="_blank" href="http://server01/academico/108/prova_gabarito/avaliacao/?id=<?= base64_encode($row['CD_PROVA'])?>">Prova Corrigida</a></li>
                            <li class="divider"></li>
                            <li><a class="desable" target="_blank" href="http://server01/gestordeprovas/banco/gabarito/frmImprimir/?id=<?= base64_encode($row['CD_PROVA'])?>">Gabarito Geral</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
        <? } #} ?>
    </tbody>
    <tfoot>


        <tr class="panel-footer">
            <td colspan="9"></td>
        </tr>

        <tr class="panel-footer">
            <td colspan="9">
                <button disabled id="btnLiberar" name="btnLiberar" type="button" class="btn btn-info btnLiberar">
                  Liberar Gabarito
                </button>

                <button disabled id="btnRemover" name="btnRemover" type="button" class="btn btn-danger2 btnRemover">
                  Desabilitar Gabarito
                </button>

                <button disabled id="enableNota" name="btnEnableNota" type="button" class="btn btn-info btnEnableNota" style="margin-left:50px;">
                    Liberar Nota no Portal
                </button>
                <button disabled id="disabledNota" name="btnDisableNota" type="button" class="btn btn-danger2 btnDisableNota"  style="margin-left:50px;">
                    Desabilitar Nota no Portal
                </button>

                <button onclick="imprimir()" class="btn btn-success">Imprimir</button>
            </td>
        </tr>
    </tfoot>
</table>
<script>
    $(function () {
        $('#tblGrid').dataTable();
    });
</script>
<script>
    function imprimir(){
        var conteudo = document.getElementById("tblBody").innerHTML;
        //var tela_impressao = window.open('about:blank');
        var tela_impressao = window.open('', '', 'height=700,width=700');

        var style = "<style>";
        style = style + "table {width: 100%;font: 20px Calibri; border:1px solid #000 !important; }";
        style = style + "table, th, td {border: solid 1px #000 !important; border-collapse: collapse;";
        style = style + "table, td:nth-child(1){display:none;}";
        style = style + "padding: 2px 3px;text-align: center;}";
        style = style + "#tblBody tr td{border: 1px solid #000 !important; }";
        style = style + ".sorting_1{display:none;}";
        style = style + "input[type='checkbox']{display:none}";
        style = style + ".desable{display:none;}";
        style = style + "</style>";

        tela_impressao.document.write('<html><head>');
        tela_impressao.document.write('<title>Relatório de Provas por Data</title>');
        tela_impressao.document.write(style);
        tela_impressao.document.write('</head>');
        tela_impressao.document.write('<body>');
        tela_impressao.document.write('<table><tr><td><strong>ID</strong></td><td><strong>N.PROVA</strong></td><td><strong>DT. REALIZAÇÃO</strong></td><td><strong>DISCIPLINA</strong></td><td><strong>SÉRIE</strong></td><td><strong>NOTA LIBERADA?</strong></td> <td><strong>GABARITO LIBERADO?</strong></td></tr><tr>');
        tela_impressao.document.write(conteudo);
        tela_impressao.document.write('</tr></table>');
        tela_impressao.document.write('</body></html>');
        tela_impressao.window.print();
       // tela_impressao.window.close();
    }

    $('.btnLiberar').click(function() {
        swal({
            title: "Liberação de Gabaritos",
            text: "Você tem certeza que deseja libetrar os gabaritos da(s) prova(s) selecionada(s)?",
            type: "info",
            showCancelButton: true,
            confirmButtonText: "Sim, Liberar!",
            cancelButtonText: "Não, Cancelar!",
            closeOnConfirm: false,
            closeOnCancel: true,
        },
        function(isConfirm) {
            if (isConfirm) {
                // Chama a função que inscreverá o aluno na prova manualmente
                $.post("<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/liberacao/frmLiberacao') ?>", {
                    prova: $("input[name='prova[]']:checked").serialize(),
                    tipo: 1
                },
                function(data) {
                    swal("Sucesso!", "Liberação realizada com sucesso!", "success");
                    txtFiltrar();
                    //$("#retorno").html(data);
                });
            }
        });
    });


    $('.btnRemover').click(function() {
        swal({
            title: "Retirar os Gabaritos",
            text: "Você tem certeza que deseja retirar os gabaritos da(s) prova(s) selecionada(s)?",
            type: "info",
            showCancelButton: true,
            confirmButtonText: "Sim, Retirar!",
            cancelButtonText: "Não, Cancelar!",
            closeOnConfirm: false,
            closeOnCancel: true,
        },
        function(isConfirm) {
            if (isConfirm) {
                // Chama a função que inscreverá o aluno na prova manualmente
                $.post("<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/liberacao/frmLiberacao') ?>", {
                    prova: $("input[name='prova[]']:checked").serialize(),
                    tipo: 0
                },
                function(data) {
                    swal("Sucesso!", "Remoção realizada com sucesso.", "success");
                    txtFiltrar();
                    //$("#retorno").html(data);
                });
            }
        });
    });



    //habilitar nota no portal
    $('.btnEnableNota').click(function(){
        swal({
            title: "Liberação de Notas",
            text: "Você tem certeza que deseja libetrar as notas da(s) prova(s) selecionada(s)?",
            type: "info",
            showCancelButton: true,
            confirmButtonText: "Sim",
            cancelButtonText: "Não",
            closeOnConfirm: false,
            closeOnCancel: true,
        },
        function(isConfirm) {
            if (isConfirm) {

                $.post("<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/liberacao/frmLiberaNota') ?>", {
                    prova: $("input[name='prova[]']:checked").serialize(),
                    flg_lib_nota_portal: 1
                },
                function(data) {
                    swal("Sucesso!", "Atualização realizada com sucesso.", "success");
                    txtFiltrar();
                    //$("#retorno").html(data);
                });
               
            }
        });
    });   


    //desabilitar nota no portal
    $('.btnDisableNota').click(function(){
        swal({
            title: "Desabilitar Notas",
            text: "Você tem certeza que deseja desabilitar as notas da(s) prova(s) selecionada(s)?",
            type: "info",
            showCancelButton: true,
            confirmButtonText: "Sim",
            cancelButtonText: "Não",
            closeOnConfirm: false,
            closeOnCancel: true,
        },
        function(isConfirm) {
            if (isConfirm) {
                $.post("<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/liberacao/frmLiberaNota') ?>", {
                    prova: $("input[name='prova[]']:checked").serialize(),
                    flg_lib_nota_portal: 0
                },
                function(data) {
                    swal("Sucesso!", "Atualização realizada com sucesso.", "success");
                    txtFiltrar();
                    //$("#retorno").html(data);
                });
            }
        });
    });  
</script>
