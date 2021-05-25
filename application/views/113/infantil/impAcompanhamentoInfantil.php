
            <h4 class="center">Relatório Pedagógico Infantil</h4>

            <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="10%" height="50" align="left">
                        <img src="<?= base_url('usuarios/foto/' . $aluno[0]['CD_ALUNO'] . '') ?>" class="img-rounded" style="height:120px" /></td>
                    <td width="64%" align="left">
                        <table width="100%" border="0" cellspacing="4" cellpadding="4">
                            <tr>
                                <td width="9%" align="right" style="font-size:11px">Matrícula:</td>
                                <td width="91%" style="font-size:12px"><strong>
                                        <?= $aluno[0]['CD_ALUNO'] ?>
                                    </strong></td>
                            </tr>
                            <tr>
                                <td width="9%" align="right" style="font-size:11px">Nome:</td>
                                <td width="91%" style="font-size:12px"><strong>
                                        <?= $aluno[0]['NM_ALUNO'] ?>
                                    </strong></td>
                            </tr>
                            <tr>
                                <td align="right" style="font-size:11px">Turma:</td>
                                <td style="font-size:12px"><strong>
                                        <?= $aluno[0]['CD_TURMA'] ?>
                                    </strong></td>
                            </tr>
                            <tr>
                                <td align="right" style="font-size:11px">Curso:</td>
                                <td style="font-size:12px"><strong>
                                        <?= $aluno[0]['NM_CURSO'] ?>
                                    </strong></td>
                            </tr>
                            <tr>
                                <td align="right" style="font-size:11px">Série:</td>
                                <td style="font-size:12px"><strong>
                                        <?= $aluno[0]['NM_SERIE'] ?>
                                    </strong></td>
                            </tr>
                        </table></td>
                    <td width="26%" align="right" valign="middle">&nbsp;</td>
                </tr>
            </table>
            <br/>
            <?
            $div = array();
            foreach ($listar as $row) {
            $div[] = $row['DC_DIVISAO'];
            }
            $divisao = array_keys(array_flip($div));            
            foreach ($divisao as $d) { 
            ?>
            <h4><?= $d ?></h4>
            <table width="100%" cellpadding="2">
                    <tr>
                        <td bgcolor="#939393"><strong>Pergunta</strong></td>
                        <td bgcolor="#939393" width="15%" align="center"><strong>1 Bimestre</strong></td>
                    </tr>
                    <?
                    foreach ($listar as $r) {
                    if (str_replace(' ', '', $d) == str_replace(' ', '', $r['DC_DIVISAO'])) {
                    ?>
                    <tr>
                        <td bgcolor="#F7F7F7" style="font-size:13px"><?= $r['DC_PERGUNTA'] ?></td>
                        <td align="center" bgcolor="#F7F7F7" style="font-size:10px">
                            <? echo $r['DC_RESPOSTA_PADRAO'];?>
                        </td>
                    </tr>
                    <?
                    }
                    }
                    ?>
                </tbody>
            </table>
            <? } ?>