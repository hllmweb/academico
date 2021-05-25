<?php
$checked = !empty($operacao) && $operacao !== "I" ? "checked" : "";
$disabled = $operacao === "D" || $operacao === "V" ? "disabled" : "";
?>
<table class="table table-striped table-hover table-bordered">
    <thead>
        <tr>
            <th class="text-center"><input type="checkbox" id="select-all"></th>
            <th class="text-center">HORÁRIO</th>
            <th class="text-center">TURMA</th>
            <th class="text-center">DISCIPLINA</th>
            <th class="text-center">PROFESSOR</th>
            <th class="text-center">ABRIU</th>
            <th class="text-center">FECHOU</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($aulas as $row): ?>
            <tr>
                <td class="text-center">
                    <input type="checkbox" class="selecionavel" name="aulas[]" value="<?= $row->CD_CL_AULA . "-" . $row->CD_PROFESSOR ?>" <?= $checked . " " . $disabled ?>>
                </td>
                <td class="text-center"><?= $row->HR_TEMPO_INICIO . " - " . $row->HR_TEMPO_FIM ?></td>
                <td class="text-center"><?= $row->CD_TURMA ?></td>
                <td class="text-center"><?= $row->NM_DISCIPLINA ?></td>
                <td class="text-center"><?= $row->NM_PROFESSOR ?></td>
                <td class="text-center"><?= $row->HR_ABERTURA == null ? "NÃO" : "SIM" ?></td>
                <td class="text-center"><?= $row->HR_FECHAMENTO == null ? "NÃO" : "SIM" ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script type="text/javascript">
    var selecionado = false;
    $("#select-all").click(function () {
        selecionado = !selecionado;
        $(".selecionavel").prop("checked", selecionado);
    });
</script>