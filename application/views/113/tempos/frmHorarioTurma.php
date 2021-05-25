<? $this->load->view('home/header'); ?>
<div class="hpanel hgreen">
    <div class="panel-footer text-right">
        <div class="pull-left">
            <a class="btn btn-primary btn-outline"
                href="<?= base_url($this->session->userdata('SGP_SISTEMA') . '/tempos/') ?>" >
                <i class="fa fa-angle-double-left"></i> VOLTAR
            </a>
            <button 
                    type="button" 
                    class="btn btn-info"
                    data-toggle="frmModal"
                    data-remote="<?= base_url($this->session->userdata('SGP_SISTEMA') . '/tempos/mdlHorarioProfessor') ?>"
                    >
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <span class="text-uppercase hidden-xs">
                        HORÁRIO PROFESSOR
                    </span>
                </button>
            <!--button 
                type="button" 
                class="btn btn-primary2"
                data-toggle="frmModal"
                data-remote="<?= base_url($this->session->userdata('SGP_SISTEMA') . '/tempos/mdlHorarioTurma') ?>"
                >
                <i class="fa fa-users fa-2x" aria-hidden="true"></i>
                <span class="text-uppercase hidden-xs">
                    HORÁRIO TURMA
                </span>
            </button-->
        </div>
        <h4>Controle de Tempos de Aula da Turma :: <?=$codigo?></h4>
    </div>
</div>
<div class="content animate-panel" style="padding:10px">
    <div class="row">
        <div class="col-lg-3">
            <div class="hpanel hgreen">
                <div class="panel-heading">
                    Professores Relacionados à Turma
                </div>
                <div class="panel-footer" id="MnuItemDisciplina">
                    <? foreach($lista as $p){ ?>
                    <div style="cursor: pointer"
                         class="social-talk border-bottom bg-light" 
                         data-item="<?=$p->CD_DISCIPLINA.$p->CD_PROFESSOR?>"
                        >
                        <div class="media social-profile clearfix">
                            <a class="pull-left">
                                <img class="img-rounded" src="<?=base_url('usuarios/foto?codigo='.$p->CD_PESSOA.'')?>" alt="profile-picture" />
                            </a>
                            <div class="media-body">
                                <span class="font-bold"><?=$p->CD_DISCIPLINA.' - '.$p->NM_DISCIPLINA?></span>
                                <div class="social-content">
                                    <small><?=$p->NM_PROFESSOR?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <? } ?>
                    <button class="btn btn-warning form-control clear">
                        Limpar
                    </button>
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
                            <div class="panel-body no-padding">
                                <div class="panel-footer no-margins text-right">
                                    <a class="btn btn-primary"
                                       href="<?=base_url($this->session->userdata('SGP_SISTEMA').'/turma_horario/prtHorarioTurma/?token='.base64_encode(json_encode(array('turma'=>$codigo))))?>"
                                       target="_blank"
                                        >
                                        <i class="fa fa-print"></i>
                                        Imprimir
                                    </a>
                                    <button 
                                        type="button" 
                                        id="btnEncerrarTodos"
                                        class="btn btn-danger2"
                                    >
                                        <i class="fa fa-times-circle-o"></i>
                                        Finalizar Todos
                                    </button>
                                </div>
                                <div id="datagridview"></div>
                            </div>
                        </div>
                        <div id="tab-2" class="tab-pane">
                            <div class="panel-body no-padding">
                                <div class="panel-footer no-margins text-right">
                                    <button style='display:none' class="btn btn-primary2">
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

                                            foreach ($horario_log as $log) {
                                                ?>
                                                <tr>
                                                    <td class="text-center" width="1%">
                                                        <?
                                                        echo (($log->TIPO_OPERACAO == 'I') ? $tipo_i : (($log->TIPO_OPERACAO == 'U') ? $tipo_u : $tipo_d))
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <small>
                                                            <?=
                                                            $log->NM_DISCIPLINA . '<br/>' .
                                                            $log->CD_TURMA
                                                            ?>
                                                        </small>
                                                    </td>
                                                    <td width="5%">
                                                        <small>
                                                            <?= $log->CD_TURMA ?>
                                                        </small>
                                                    </td>
                                                    <td width="20%">
                                                        <small>
                                                            Início: <?= date('d/m/Y', strtotime(implode("-", array_reverse(explode("/", $log->DT_INICIO))))) ?><br/>
                                                            Fim: <?= (($log->DT_FIM != '') ? date('d/m/Y', strtotime(implode("-", array_reverse(explode("/", $log->DT_FIM))))) : '<span class="text-danger">Não informado</span>') ?>
                                                        </small>
                                                    </td>
                                                    <td width="10%">
                                                        <?= (($log->TIPO_OPERACAO == 'I') ? 'Inserido' : (($log->TIPO_OPERACAO == 'U') ? 'Editado' : 'Deletado')) ?>
                                                        <?= date('d/m/Y', strtotime(implode("-", array_reverse(explode("/", $log->DATA_LOG))))) ?>
                                                    </td>
                                                    <td width="15%">
                                                        <small>
                                                            <?=
                                                            '<i class="fa fa-desktop"></i> ' . $log->USUARIO_SO . '<br/>' .
                                                            '<i class="fa fa-database"></i> ' . $log->USUARIO_BANCO . '<br/>'
                                                            ?>
                                                        </small>
                                                    </td>
                                                    <td width="10%">
                                                        <small>
                                                            <?=
                                                            $log->PROGRAMA . '<br/>' .
                                                            $log->TERMINAL . '<br/>'
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
    $(document).ready(function () {

        $("#datagridview").html('<small><i>Atualizando datagrid</i></small>');
        $.post("<?= base_url($this->session->userdata('SGP_SISTEMA') . '/tempos/datagridHorarioTurma') ?>", {
            p: '<?= $this->input->get('p') ?>',
        },
        function (data) {
            $("#datagridview").html(data);
        });

        var table = $('#dataview').DataTable({
            "columnDefs": [
                {"visible": false, "targets": 1}
            ],
            "order": [[1, 'asc']],
            "displayLength": 25,
            "drawCallback": function (settings) {
                var api = this.api();
                var rows = api.rows({page: 'current'}).nodes();
                var last = null;
                api.column(1, {page: 'current'}).data().each(function (group, i) {
                    if (last !== group) {
                        $(rows).eq(i).before(
                            '<tr class="group panel-footer"><td colspan="7" style="font-size: 13px; font-weight: bold">' + group + '</td></tr>'
                        );
                        last = group;
                    }
                });
            }
        });

        $('#dataview tbody').on('click', 'tr.group', function () {
            var currentOrder = table.order()[0];
            if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                table.order([2, 'desc']).draw();
            } else {
                table.order([2, 'asc']).draw();
            }
        });
        
        function dtGridTarde(item){
            $('td[data-item-horario]').removeAttr("style");
            $('#dtGridTarde tbody tr').each(function(){
                $('td[data-item-horario="'+item+'"]').css('background','#ffb606').css('color','#FFFFFF');
            });
        };
        
        function dtGridManha(item){
            // REMOVE AS SELEÇÕES ANTERIORES
            $('td[data-item-horario]').removeAttr("style");
            // DESTACA AS CELULAS DA TABELA COM O ID ENVIANDO DENTRO DE "ITEM"
            $('#dtGridManha tbody tr').each(function(){
                $('td[data-item-horario="'+item+'"]').css('background','#ffb606').css('color','#FFFFFF');
            });
        };

        $("#MnuItemDisciplina .social-talk").click(function(){
            var item = $(this).data('item');
            $('[data-item]').removeAttr("style").css('cursor','pointer');
            $('[data-item="'+item+'"]').css('color','#ffb606');
            dtGridManha(item);
            dtGridTarde(item);
        });
        
        $("#MnuItemDisciplina .clear").click(function(){
            $('[data-item]').removeAttr("style").css('cursor','pointer');
            $('td[data-item-horario]').removeAttr("style");
        });

    });
    $(document).on("click", "button[id=btnEncerrarTodos]" , function(e){
        // Prevent os atributos do item clicado
        e.preventDefault();
        swal({
                title: "Encerrar todos os Horários",
                text: "Você tem certeza que deseja finalizar todos os horário desta turma?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Sim, Encerrar Todos!",
                cancelButtonText: "Não, Cancelar!",
                closeOnConfirm: false,
                closeOnCancel: true,
        },
        function(isConfirm) {
            if (isConfirm) {
                // função que verifica no banco se a prova esta processada 
                $.post("<?= base_url($this->session->userdata('SGP_SISTEMA') . '/turma_horario/frmManter') ?>", {
                    Turma: "<?=$this->session->userdata('SGP_SEL_TURMA')?>",
                    Operacao: 'ET', // ENCERRAR TODOS
                },
                function(data) {
                    swal("Sucesso!", "Horários finalizados com sucesso!", "success");
                    // ATUALIZA O GRID COM A ALTERAÇÃO RELIZADA
                    $("#datagridview").html('<small><i>Atualizando datagrid</i></small>');
                    $.post("<?= base_url($this->session->userdata('SGP_SISTEMA') . '/tempos/datagridHorarioTurma') ?>", {
                        p: '<?= $this->input->get('p') ?>',
                    },
                    function (data) {
                        $("#datagridview").html(data);
                    });
                });
            }
        });
    });
</script>
<? $this->load->view('home/footer'); ?>