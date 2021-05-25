<? $this->load->view('home/header'); ?>
<div class="content animate-panel">

    <div class="row">
        <div class="col-lg-3">
            <div class="hpanel hgreen">
                <div class="panel-body text-center">
                    <img alt="<?= $professor->NM_PROFESSOR ?>" class="img-rounded m-b m-t-md" src="https://www.seculomanaus.com.br/portal/restrito/foto?codigo=<?= $professor->CD_PESSOA ?>">
                    <h3><a><?= $professor->NM_PROFESSOR ?></a></h3>
                    <div class="text-muted font-bold m-b-xs">
                        <?= $professor->NM_FUNCAO ?>
                    </div>
                    <div class="progress m-t-xs full progress-small">
                        <div style="width: 100%" 
                             aria-valuemax="100" 
                             aria-valuemin="0" 
                             aria-valuenow="100" 
                             role="progressbar" 
                             class="progress-bar progress-bar-success">
                            <span class="sr-only">100% Complete (success)</span>
                        </div>
                    </div>
                </div>
                <div class="panel-body" style="display:none">
                    <dl>
                        <dt>Description lists</dt>
                        <dd>A description list is perfect for defining terms.</dd>
                        <dt>Euismod</dt>
                        <dd>Vestibulum id ligula porta felis euismod semper eget lacinia odio sem nec elit.</dd>
                        <dd>Donec id elit non mi porta gravida at eget metus.</dd>
                        <dt>Malesuada porta</dt>
                        <dd>Etiam porta sem malesuada magna mollis euismod.</dd>
                    </dl>
                </div>
                <div class="panel-footer contact-footer">
                    <div class="row">
                        <div class="col-md-4 border-right">
                            <div class="contact-stat"><span>Projects: </span> <strong>200</strong></div>
                        </div>
                        <div class="col-md-4 border-right">
                            <div class="contact-stat"><span>Messages: </span> <strong>300</strong></div>
                        </div>
                        <div class="col-md-4">
                            <div class="contact-stat"><span>Views: </span> <strong>400</strong></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-lg-9">
            <div class="hpanel">
                <div class="hpanel">

                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a data-toggle="tab" href="#tab-1">
                                <i class="fa fa-clock-o"></i> Horários
                            </a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#tab-2">
                                <i class="fa fa-list-ol"></i> Histórico de Alteração
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane active">
                            <div class="panel-body">
                                <strong>Lorem ipsum dolor sit amet, consectetuer adipiscing</strong>

                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart. I am alone, and feel the charm of
                                    existence in this spot, which was created for the bliss of souls like mine.</p>

                                <div class="table-responsive">
                                    <table class="table table-striped text-center">
                                        <thead>
                                            <tr>

                                                <td>#</td>
                                                <td>Segunda</td>
                                                <td>Terça</td>
                                                <td>Quarta</td>
                                                <td>Quinta</td>
                                                <td>Sexta</td>
                                                <td>Sábado</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Jul 14, 2013</td>
                                                <td>Jul 14, 2013</td>
                                                <td>Jul 14, 2013</td>
                                                <td>Jul 14, 2013</td>
                                                <td>Jul 14, 2013</td>
                                                <td>Jul 14, 2013</td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Jul 14, 2013</td>
                                                <td>Jul 14, 2013</td>
                                                <td>Jul 14, 2013</td>
                                                <td>Jul 14, 2013</td>
                                                <td>Jul 14, 2013</td>
                                                <td>Jul 14, 2013</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="tab-2" class="tab-pane">
                            <div class="panel-body no-padding">
                                <div class="panel-footer no-margins text-right">
                                    <button class="btn btn-primary2">
                                        <i class="fa fa-print"></i>
                                        Imprimir
                                    </button>
                                </div>
                                <br/>
                                <div class="table-responsive" style="padding:5px">
                                    <table class="table" id="dataview" style="font-size: 11px">
                                        <thead>
                                            <tr class="panel-footer">
                                                <th>#</th>
                                                <th>Disciplina / Turma</th>
                                                <th>Turma</th>
                                                <th>início / Fim</th>
                                                <th>Data</th>
                                                <th>Log Usuário</th>
                                                <th>Programa</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?

                                            $tipo_i = '<i class="fa fa-plus text-success"></i>';
                                            $tipo_u = '<i class="fa fa-edit text-info"></i>';
                                            $tipo_d = '<i class="fa fa-times text-danger"></i>';

                                            foreach($horario_log as $log){

                                            ?>
                                            <tr>
                                                <td class="text-center" width="1%">
                                                    <?
                                                    echo (($log->TIPO_OPERACAO == 'I')? $tipo_i : (($log->TIPO_OPERACAO == 'U')? $tipo_u : $tipo_d))
                                                    ?>
                                                </td>
                                                <td>
                                                    <small>
                                                        <?=$log->NM_DISCIPLINA.'<br/>'.
                                                           $log->CD_TURMA?>
                                                    </small>
                                                </td>
                                                <td width="5%">
                                                    <small>
                                                        <?=$log->CD_TURMA?>
                                                    </small>
                                                </td>
                                                <td width="20%">
                                                    <small>
                                                        Início: <?=date('d/m/Y', strtotime(implode("-", array_reverse(explode("/", $log->DT_INICIO)))))?><br/>
                                                        Fim: <?=(($log->DT_FIM != '')? date('d/m/Y', strtotime(implode("-", array_reverse(explode("/", $log->DT_FIM))))) : '<span class="text-danger">Não informado</span>')?>
                                                    </small>
                                                </td>
                                                <td width="10%">
                                                    <?=(($log->TIPO_OPERACAO == 'I')? 'Inserido' : (($log->TIPO_OPERACAO == 'U')? 'Editado' : 'Deletado'))?>
                                                    <?=date('d/m/Y', strtotime(implode("-", array_reverse(explode("/", $log->DATA_LOG)))))?>
                                                </td>
                                                <td width="15%">
                                                    <small>
                                                        <?='<i class="fa fa-desktop"></i> '.$log->USUARIO_SO.'<br/>'.
                                                           '<i class="fa fa-database"></i> '.$log->USUARIO_BANCO.'<br/>'
                                                        ?>
                                                    </small>
                                                </td>
                                                <td width="10%">
                                                    <small>
                                                        <?=$log->PROGRAMA.'<br/>'.
                                                           $log->TERMINAL.'<br/>'
                                                        ?>
                                                    </small>
                                                </td>
                                            </tr>
                                            <? } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    
    $(document).ready(function() {
    var table = $('#dataview').DataTable({
        "columnDefs": [
            { "visible": false, "targets": 2 }
        ],
        "order": [[ 2, 'asc' ]],
        "displayLength": 25,
        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
 
            api.column(2, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group panel-footer"><td colspan="7" style="font-size: 13px; font-weight: bold">'+group+'</td></tr>'
                    );
 
                    last = group;
                }
            } );
        }
    } );
 
    // Order by the grouping
    $('#dataview tbody').on( 'click', 'tr.group', function () {
        var currentOrder = table.order()[0];
        if ( currentOrder[0] === 2 && currentOrder[1] === 'asc' ) {
            table.order( [ 2, 'desc' ] ).draw();
        }
        else {
            table.order( [ 2, 'asc' ] ).draw();
        }
    } );
} );
</script>
<? $this->load->view('home/footer'); ?>