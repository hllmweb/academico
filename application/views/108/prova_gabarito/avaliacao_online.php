<div style="text-align: center">
    <h4><?= $questoes[0]['titulo'] ?></h4>
    <h4><?= $questoes[0]['disciplinas'] ?></h4>
</div>

<?php foreach ($questoes as $row): ?>
    <div style="margin-bottom: 20px;">
        <hr>
        <div style="font-weight: bold;">
            <?= $row['posicao'] . "º QUESTÃO " . ($row['anulada'] == "S" ? "(ANULADA)" : ($row['cancelada'] == "S" ? "(CANCELADA)" : "")) ?>
        </div>
        <hr>

        <div style="float: left; width: 50%; border-right: thin solid black; padding-right: 20px">            
            <div>
                <strong><small style="color:#08C">
                        Tema: <?= strip_tags($row['tema']) ?> <br>
                        Conteúdo: <?= strip_tags($row['conteudo']) ?> <br>
                        Correta: <?= $row['correta'] . ")" ?>
                        </small>
                </strong>
            </div>

            <div style="font-weight: bold">
                <?= $row['questao'] ?>
            </div>
        </div>

        <div style="float: left; width: 35%; border-left: thin solid black; padding-left: 20px">        
            <table>
                <?php foreach ($row['opcoes'] as $opcao): 
                    $style = '';
                    if ($row['resposta'] == $row['correta'] && $row['resposta'] == $opcao['letra']) {
                        $style = "color: green; font-weight: bold;";
                    } elseif ($row['resposta'] == $opcao['letra']) {
                        $style = "color: #cc5200; font-weight: bold;";
                    } elseif ($row['correta'] == $opcao['letra']) {
                        $style = "color: #08C; font-weight: bold;";
                    }
                ?>
                    <tr>
                        <td style="<?= $style ?>">
                            <?= $opcao['letra'] . ") " ?>
                        </td>

                        <td style="<?= $style ?>">
                            <?= $opcao['descricao'] ?>
                        </td>
                    </tr>                
                <?php endforeach; ?>
            </table>
        </div>                
    </div>
<?php endforeach; ?>
