<table class="display table table-hover" id="tblGrid">
    <thead>
        <tr class="panel-footer">
            <td><strong>ID</strong></td>
            <td><strong>N. PROVA</strong></td>
            <td><strong>DT. PROVA</strong></td>
            <td><strong>SÉRIE</strong></td>
            <td><strong>DISCIPLINA</strong></td>
            <td class="text-center"><strong>CH</strong></td>
            <td class="text-center"><strong>NOTA</strong></td>
            <td class="text-center"><strong>STATUS</strong></td>
            <td class="text-center"><strong></strong></td>
        </tr>
    </thead>
    <tbody id="tblBodyImprimir">
        <? foreach ($resultado as $row) { ?>
            <tr>
                <td><?= $row['CD_PROVA'] ?></td>
                <td><?= $row['NUM_PROVA'] ?></td>
                <td><?= date('d/m/Y',strtotime(implode("-",array_reverse(explode("/",$row['DT_PROVA'])))));?></td>
                <td><?= $row['NM_SERIE'] ?></td>
                <td><?= $row['DISCIPLINAS'] ?></td>
                <td class="text-center"><?= $row['CHAMADA'].'ª'?></td>
                <td class="text-center"><?= $row['NM_MINI'] ?></td>
                <td class="text-center sorting_1">
                    <?= (($row['FLG_PEND_PROCESSAMENTO'] == 0)? '<small class="label label-success"><i class="fa fa-check"></i></small>' : '<small class="label label-danger"><i class="fa fa-times"></i></small>')?>
                </td>
                <td class="text-center sorting_1">
                    <a class="btn btn-xs" href="<?=base_url($tela.'frmRelatorio?p='.base64_encode(json_encode($row)).'')?>">
                        <i class="fa fa-search-plus"></i> Exibir
                    </a>
                    
                    <a target='_blank' class="btn btn-xs" href="<?=base_url('108/prova_gabarito/relatorio_opcao/?id='.base64_encode($row['CD_PROVA']).'')?>">
                        <i class="fa fa-search-plus"></i> Prova Gabaritada
                    </a>
                </td>
            </tr>
        <? } ?>
    </tbody>

    <tfoot>



        <tr class="panel-footer">
            <td colspan="9">
                <button onclick="imprimirRelatorio()" class="btn btn-success">Imprimir</button>
            </td>
        </tr>
    </tfoot>

</table>
<script>
    $(function () {
        $('#tblGrid').dataTable();
    });

    function imprimirRelatorio(){
        var conteudo = document.getElementById("tblBodyImprimir").innerHTML;
        //var tela_impressao = window.open('about:blank');
        var tela_impressao = window.open('', '', 'height=700,width=700');

        var style = "<style>";
        style = style + "table {width: 100%;font: 20px Calibri; border:1px solid #000 !important; }";
        style = style + "table, th, td {border: solid 1px #000 !important; border-collapse: collapse;";
        // style = style + "table, td:nth-child(1){display:none;}";
        style = style + "padding: 2px 3px;text-align: center;}";
        style = style + "#tblBody tr td{border: 1px solid #000 !important; }";
        style = style + ".sorting_1{display:none;}";
        // style = style + "input[type='checkbox']{display:none}";
        // style = style + ".desable{display:none;}";
        style = style + "</style>";

        tela_impressao.document.write('<html><head>');
        tela_impressao.document.write('<title>Relatório de Provas por Data</title>');
        tela_impressao.document.write(style);
        tela_impressao.document.write('</head>');
        tela_impressao.document.write('<body>');
        tela_impressao.document.write('<table><tr><td><strong>N.PROVA</strong></td><td><strong>DT. REALIZAÇÃO</strong></td><td><strong>SÉRIE</strong></td><td><strong>DISCIPLINA</strong></td><td><strong>CH</strong></td><td><strong>NOTA</strong></td></tr><tr>');
        tela_impressao.document.write(conteudo);
        tela_impressao.document.write('</tr></table>');
        tela_impressao.document.write('</body></html>');
        tela_impressao.window.print();
       // tela_impressao.window.close();
    }

</script>