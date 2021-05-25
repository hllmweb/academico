<div class="col-lg-12 animated-panel zoomIn no-padding" style="animation-delay: 0.5s;">
    <div class="hpanel hviolet">
        <div class="panel-footer text-right">
            <h4>CONTEÚDO DA PROVA</h4>
        </div>

        <div class="panel-body">
            <table class='table table-hover table-bordered table-striped' id="grid-conteudo">
                <thead>
                    <tr>
                        <th align='center' class="sorting_desc_disabled">CONTEÚDO</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($conteudos as $conteudo) : ?>
                        <tr style="font-size:12px">
                            <td><?=  nl2br($conteudo['CONTEUDO']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<script>
    $(function () {
        // Initialize Example 2
        $('#grid-conteudo').dataTable({language: dataTableOptions});
    });
</script>