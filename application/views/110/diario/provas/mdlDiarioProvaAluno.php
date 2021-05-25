<div class="modal-dialog modal-lg hmodal-warning">
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">
            <h4 class="modal-title">Prova Nº <?= $prova[0]['NUM_PROVA'] ?></h4>
            <small>Olá profº(ª) <strong><?= $this->session->userdata('SGP_NOME') ?></strong>,<br/>
                muito cuidado nesta área, você esta montando uma nota da grade curricular,
                qualquer erro aqui só poderá ser <strong>REVERTIDO PELA SECRETARIA.</strong>
            </small>
        </div>
        <script type="text/javascript">
            function PJCLNOTAS(nota, aluno, prova) {
                jQuery.ajax({
                    type: "POST",
                    url: "<?= base_url('110/diario_prova/frmLancarNotaAluno') ?>",
                    data: {
                        prova: prova,
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
                        <td width="15%" align="center">OBJETIVA</td>
                        <td width="15%" align="center">DISSERTATIVA</td>
                        <td width="15%" align="center" >TOTAL</td>
                    </tr>
                </thead>
                <tbody>
                    <? foreach ($alunos as $row) { ?>
                        <tr height="10px">
                            <td><?= $row['CD_ALUNO'] ?></td>
                            <td valign="middle"><?= '<strong>' . ($row['NM_ALUNO']) . '</strong>' ?></td>
                            <td valign="middle" align="center"><?= '<strong>' . number_format($row['TOTAL_PONTOS'], 1, '.', '') . '</strong>' ?></td>
                            <td align="center"><?= (($row['TOTAL_PONTOS_DISSERTATIVAS'] != '') ? '<strong>' . number_format($row['TOTAL_PONTOS_DISSERTATIVAS'], 1, '.', '') . '</strong>' : '<input onchange="PJCLNOTAS(this.value,' . $row['CD_ALUNO'] . ',' . $row['CD_PROVA'] . ')" value=""  class="class_spin" />') ?></td>
                            <td align="center" id="<?= $row['CD_ALUNO'] ?>">
                                <?= (($row['TOTAL_PONTOS_DISSERTATIVAS'] != '') ? '<strong>' . number_format($row['TOTAL_PONTOS_DISSERTATIVAS'] + $row['TOTAL_PONTOS'], 1, '.', '') . '</strong>' : '') ?>
                            </td>
                        </tr>
                    <? } ?>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-info btnProcessarDados">Finalizar</button>
        </div>
    </div>
    <script>
        function mdlProvaListarAluno() {
            $.post("<?= base_url('110/diario_prova/mdlDiarioProvaAluno') ?>", {
                prova: $("#avalProva").val(),
            },
            function(data) {
                if (data != 0) {
                    $("#mdlProvaAluno").html(valor);
                    return (1);
                } else {
                    return (0);
                }
            });
        };

        $(function() {
            $(".class_spin").TouchSpin({
                min: 0,
                max: 4,
                step: 0.01,
                decimals: 2,
                boostat: 5,
                maxboostedstep: 10,
            });

            $(function() {
                $('.btnProcessarDados').click(function() {
                    swal({
                        title: "Processar Nota",
                        text: "Aceita que o sistema lance a somatória das notas no Demonstrativo do aluno?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Sim, Lançar Agora!",
                        cancelButtonText: "Apenas fechar!",
                        closeOnConfirm: true,
                        closeOnCancel: true,
                        html: true
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            swal("Atenção!", "Quarde enquanto verifico as notas lançadas.", "warning");
                            setTimeout(function() {
                                // função que verifica no banco se a prova esta processada 
                                $.post("<?= base_url('110/diario_prova/frmProcessaNota') ?>", {
                                    prova: <?=$prova[0]['CD_PROVA']?>,
                                },
                                function(data) {
                                    swal("Lançamento Realizado!", data, "success");
                                });
                                // fim da função que verifica se a prova esta processada
                            }, 1000);
                            setTimeout(function() {
                                $('#frmModal').modal('hide');
                            }, 2000);
                        } else {                            
                            setTimeout(function() {
                                swal("Tudo bem!", "Você tem até o fim do bimestre ou até a prova ser bloqueada.", "error");
                                $('#frmModal').modal('hide');
                            }, 1000);
                        }
                    });
                });

            });
        });
    </script>

</div>
