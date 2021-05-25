<?
$this->load->view('home/header');
foreach ($lista as $t) {
    $pag[] = $t['PAGINA'];
}
$paginas = array_keys(array_flip($pag));
//print_r($paginas);
?>

<div class="panel-footer no-margins">
    <a href="<?= base_url('' . $this->session->userdata('SGP_SISTEMA') . '/main') ?>" class="btn btn-xs btn-primary2 "><i class="fa fa-refresh fa-2x"></i> <br/>Outra Turma</a>
    | 
    <span style="font-size:15px">TURMA: <?= $this->session->userdata('SGP_TURMA') ?> | DISCIPLINA: <?= $this->session->userdata('SGP_DISICPLINA') ?></span>
</div>
<div class="content animate-panel">    
    <div class="row">
        <div class="col-lg-12 animated-panel zoomIn" style="animation-delay: 0.5s;">
            <div class="hpanel hviolet">
                <div class="panel-footer text-right">
                    <h4>FREQUÊNCIA DA TURMA</h4>
                </div>
                <div class="panel-body no-padding">

                    <ul class="nav nav-tabs panel-footer">
                        <? foreach ($paginas as $p) { ?>
                            <li class="">
                                <a data-toggle="tab" href="#tab-<?= $p ?>">
                                    <?= $p ?>ª Página
                                </a> 
                            </li>
                        <? } ?>
                    </ul>
                    <br/><br/>
                    <div class="tab-content">
                        <? foreach ($paginas as $p) { ?>
                            <div id="tab-<?= $p ?>" class="tab-pane">
                                <div class="table-responsive">
                                    <table class='table table-hover'>
                                        <tbody>
                                            <?
                                            foreach ($lista as $l) {
                                                if ($l['PAGINA'] == $p) {
                                                    ?>
                                                    <tr style="font-size:10px">
                                                        <td><?= $l['CD_ALUNO'] ?></td>
                                                        <td  style="font-size:11px" class='border-right'><?= $l['NM_ALUNO'] ?></td>
                                                        <td class='border-right' align='center'><?= (($l['COL1'] == 'P') ? '<label class="badge badge-gray">' . $l['COL1'] . '<label>' : (($l['COL1'] == 'F') ? '<label class="badge badge-danger">' . $l['COL1'] . '<label>' : $l['COL1'])) ?></td>
                                                        <td class='border-right' align='center'><?= (($l['COL2'] == 'P') ? '<label class="badge badge-gray">' . $l['COL2'] . '<label>' : (($l['COL2'] == 'F') ? '<label class="badge badge-danger">' . $l['COL2'] . '<label>' : $l['COL2'])) ?></td>
                                                        <td class='border-right' align='center'><?= (($l['COL3'] == 'P') ? '<label class="badge badge-gray">' . $l['COL3'] . '<label>' : (($l['COL3'] == 'F') ? '<label class="badge badge-danger">' . $l['COL3'] . '<label>' : $l['COL3'])) ?></td>
                                                        <td class='border-right' align='center'><?= (($l['COL4'] == 'P') ? '<label class="badge badge-gray">' . $l['COL4'] . '<label>' : (($l['COL4'] == 'F') ? '<label class="badge badge-danger">' . $l['COL4'] . '<label>' : $l['COL4'])) ?></td>
                                                        <td class='border-right' align='center'><?= (($l['COL5'] == 'P') ? '<label class="badge badge-gray">' . $l['COL5'] . '<label>' : (($l['COL5'] == 'F') ? '<label class="badge badge-danger">' . $l['COL5'] . '<label>' : $l['COL5'])) ?></td>
                                                        <td class='border-right' align='center'><?= (($l['COL6'] == 'P') ? '<label class="badge badge-gray">' . $l['COL6'] . '<label>' : (($l['COL6'] == 'F') ? '<label class="badge badge-danger">' . $l['COL6'] . '<label>' : $l['COL6'])) ?></td>
                                                        <td class='border-right' align='center'><?= (($l['COL7'] == 'P') ? '<label class="badge badge-gray">' . $l['COL7'] . '<label>' : (($l['COL7'] == 'F') ? '<label class="badge badge-danger">' . $l['COL7'] . '<label>' : $l['COL7'])) ?></td>
                                                        <td class='border-right' align='center'><?= (($l['COL8'] == 'P') ? '<label class="badge badge-gray">' . $l['COL8'] . '<label>' : (($l['COL8'] == 'F') ? '<label class="badge badge-danger">' . $l['COL8'] . '<label>' : $l['COL8'])) ?></td>
                                                        <td class='border-right' align='center'><?= (($l['COL9'] == 'P') ? '<label class="badge badge-gray">' . $l['COL9'] . '<label>' : (($l['COL9'] == 'F') ? '<label class="badge badge-danger">' . $l['COL9'] . '<label>' : $l['COL9'])) ?></td>
                                                        <td class='border-right' align='center'><?= (($l['COL10'] == 'P') ? '<label class="badge badge-gray">' . $l['COL10'] . '<label>' : (($l['COL10'] == 'F') ? '<label class="badge badge-danger">' . $l['COL10'] . '<label>' : $l['COL10'])) ?></td>
                                                        <td class='border-right' align='center'><?= (($l['COL11'] == 'P') ? '<label class="badge badge-gray">' . $l['COL11'] . '<label>' : (($l['COL11'] == 'F') ? '<label class="badge badge-danger">' . $l['COL11'] . '<label>' : $l['COL11'])) ?></td>
                                                        <td class='border-right' align='center'><?= (($l['COL12'] == 'P') ? '<label class="badge badge-gray">' . $l['COL12'] . '<label>' : (($l['COL12'] == 'F') ? '<label class="badge badge-danger">' . $l['COL12'] . '<label>' : $l['COL12'])) ?></td>
                                                        <td class='border-right' align='center'><?= (($l['COL13'] == 'P') ? '<label class="badge badge-gray">' . $l['COL13'] . '<label>' : (($l['COL13'] == 'F') ? '<label class="badge badge-danger">' . $l['COL13'] . '<label>' : $l['COL13'])) ?></td>
                                                        <td class='border-right' align='center'><?= (($l['COL14'] == 'P') ? '<label class="badge badge-gray">' . $l['COL14'] . '<label>' : (($l['COL14'] == 'F') ? '<label class="badge badge-danger">' . $l['COL14'] . '<label>' : $l['COL14'])) ?></td>
                                                        <td class='border-right' align='center'><?= (($l['COL15'] == 'P') ? '<label class="badge badge-gray">' . $l['COL15'] . '<label>' : (($l['COL15'] == 'F') ? '<label class="badge badge-danger">' . $l['COL15'] . '<label>' : $l['COL15'])) ?></td>
                                                        <td class='border-right' align='center'><?= (($l['COL16'] == 'P') ? '<label class="badge badge-gray">' . $l['COL16'] . '<label>' : (($l['COL16'] == 'F') ? '<label class="badge badge-danger">' . $l['COL16'] . '<label>' : $l['COL16'])) ?></td>
                                                        <td class='border-right' align='center'><?= (($l['COL17'] == 'P') ? '<label class="badge badge-gray">' . $l['COL17'] . '<label>' : (($l['COL17'] == 'F') ? '<label class="badge badge-danger">' . $l['COL17'] . '<label>' : $l['COL17'])) ?></td>
                                                        <td class='border-right' align='center'><?= (($l['COL18'] == 'P') ? '<label class="badge badge-gray">' . $l['COL18'] . '<label>' : (($l['COL18'] == 'F') ? '<label class="badge badge-danger">' . $l['COL18'] . '<label>' : $l['COL18'])) ?></td>
                                                        <td class='border-right' align='center'><?= (($l['COL19'] == 'P') ? '<label class="badge badge-gray">' . $l['COL19'] . '<label>' : (($l['COL19'] == 'F') ? '<label class="badge badge-danger">' . $l['COL19'] . '<label>' : $l['COL19'])) ?></td>
                                                        <td class='border-right' align='center'><?= (($l['COL20'] == 'P') ? '<label class="badge badge-gray">' . $l['COL20'] . '<label>' : (($l['COL20'] == 'F') ? '<label class="badge badge-danger">' . $l['COL20'] . '<label>' : $l['COL20'])) ?></td>
                                                    </tr>
        <? }
    } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
<? } ?>
                    </div>


















                </div>
            </div>
        </div>
    </div>
</div>
<? $this->load->view('home/footer'); ?>