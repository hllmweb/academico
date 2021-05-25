<div class="modal-dialog modal-lg hmodal-warning">
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">
            <h4 class="modal-title">Lançar Nota <?= $txtNota ?></h4>
            <small>Olá profº(ª) <strong><?= $this->session->userdata('SGP_NOME') ?></strong>,<br/>
                muito cuidado nesta área, você esta montando uma nota da grade curricular,
                qualquer erro aqui só poderá ser <strong>REVERTIDO PELA SECRETARIA.</strong>
            </small>
        </div>
        <script type="text/javascript">
            function PJCLNOTAALUNO(nota, aluno, numNota) {
                jQuery.ajax({
                    type: "POST",
                    url: "<?= base_url('110/diario_prova/frmLancarNota') ?>",
                    data: {
                     numNota: numNota,
                       aluno: aluno,
                        nota: nota,
                    },
                    success: function(data) {
                        $("#" + aluno + "").html(data);
                    },
                });
                return false;
            }
            ;
        </script>
        <div class="modal-body no-padding">
            <table class="table table-striped table-hover">
                <thead>
                    <tr class="panel-footer">
                        <td>MAT.</td>
                        <td>ALUNO</td>
                        <td width="15%" align="center">NOTA</td>
                        <td width="15%" align="center"></td>
                    </tr>
                </thead>
                <tbody>
                    <? foreach ($alunos as $row) { ?>
                        <tr height="10px">
                            <td><?= $row['CD_ALUNO'] ?></td>
                            <td valign="middle"><?= '<strong>' . ($row['NM_ALUNO']) . '</strong>' ?></td>
                            <td align="center"><?= (($row['NOTA'] != '') ? '<strong>' . number_format($row['NOTA'], 1, '.', '') . '</strong>' : '<input onchange="PJCLNOTAALUNO(this.value,' . $row['CD_ALU_DISC'] . ',' . $nota . ')" value="" class="class_spin" />') ?></td>
                            <td align="center" id="<?= $row['CD_ALU_DISC'] ?>"></td>
                        </tr>
                    <? } ?>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <a type="button" class="btn btn-info" href="<?=base_url('110/diario_prova/emlLancarNota?b='.$bimestre.'&n='.$nota.'')?>">Finalizar</a>
        </div>
    </div>
    <script>
        $(function() {
            $(".class_spin").TouchSpin({
                min: 0,
                max: <?=(($txtNota == 'NQ')? '1' : '10')?>,
                step: 0.01,
                decimals: 2,
                boostat: 5,
                maxboostedstep: 10,
            });
        });
    </script>

</div>
