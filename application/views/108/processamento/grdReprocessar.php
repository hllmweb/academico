<table class="display table table-hover table-responsive" id="tblGrid">
    <thead>
        <tr class="panel-footer">
            <td><strong>ID</strong></td>
            <td width="5%"><strong>N. PROVA</strong></td>
            <td width="10%" class="text-center"><strong>NOTA</strong></td>
            <td><strong>DISCIPLINA</strong></td>
            <td class="text-center"><strong>QUESTÕES</strong></td>
            <td class="text-center"><strong>VERSÕES</strong></td>
            <!-- <td class="text-center"><strong>VALOR QUESTAO</strong></td> -->
            <td class="text-center"><strong>QTD. REALIZARAM PROVAS</strong></td>
            <td class="text-center"><strong>DATA DO REPROCESSAMENTO</strong></td>
            <td class="text-center"><strong>AÇÃO</strong></td>
        </tr>
    </thead>
    <tbody>
        <? foreach ($resultado as $row) { ?>
            <tr class="text-info font-bold">
                <td><?= $row['CD_PROVA'] ?></td>
                <td><?= $row['NUM_PROVA'] ?></td>
                <td class="text-center"><?= $row['NM_MINI'] ?></td>
                <td><?= $row['DISCIPLINAS'] ?></td>
                <td class="text-center"><?= $row['QUESTOES']?></td>
                <td class="text-center"><?= $row['VERSOES'] ?></td>
                <!-- <td class="text-center"><?= (float)$row['VALOR_QUESTAO'] ?></td> -->
                <td class="text-center">
                <?php 
                    echo "<span class='btn btn-primary btn-xs'>".$row['TOTAL_FEZ_PROVA']."</span>";
                ?> 
                </td>
                <td class="text-center">
                    <?= $row['DT_REPROCESSADO']; ?>
                </td>
                <td class="text-center">
                    <?php if($row['TOTAL_FEZ_PROVA'] == 0): ?>
                    <button class="btn btn-ddanger btn-xs" onclick="alert('Não é Possível processar, essa Prova. Nenhum inscrito realizou essa prova!');">PROVA NÃO REALIZADA</button>
                    <?php else: ?>
                    <button onclick="reprocessar(this.id)" type="button" id="<?= $row['NUM_PROVA']; ?>"  class="btn btn-warning btn-xs">REPROCESSAR</button>
                    <?php endif; ?>
                </td>
            </tr>
        <? } ?>
    </tbody>
    <tfoot>
        <tr class="panel-footer">
            <td colspan="11">
            </td>
        </tr>
    </tfoot>
</table>
<script type="text/javascript">

function reprocessar(atributo) {
    $("#tblFiltro").html('<div class="text-center"><img src="http://server01.seculomanaus.com.br/academico/assets/images/loading-bars.svg" width="64" height="64" /></div>');
    
    $.post("<?=  base_url('/108/processamento/reprocessar') ?>", {
        // numProva: $("#NumProva").val()
        numProva: atributo
    },
    function(valor) {
        $("#tblFiltro").html('<div class="text-center"><p class="success">Processado com sucesso.</p></div>');
        console.log(valor);
        // $("#tblFiltro").html(valor);
    });
};
</script>
