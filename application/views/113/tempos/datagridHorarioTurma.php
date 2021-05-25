<div class="table-responsive" style="padding:5px">
    <style type="text/css" media="all">
        .cell{
            height: 50px;
        }
        .cell td{
            vertical-align: middle;
            text-align: center;
            cursor: pointer;
            font-size: 10px
        }
    </style>
    <? $id = date('dmYhis');?>
    <strong>HORÁRIOS DA MANHÃ</strong>
    <table class="text-center table-bordered" style="width: 100%" id="dtGridManha">
        <thead>
            <tr class="panel-footer" style="height: 30px">
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
            <? for ($i = 1; $i <= 7; $i++) { ?>
                <tr class="cell">
                    <td width="4%"><?= $i ?>º</td>
                    <? for ($j = 1; $j <= 7; $j++) { ?>
                        <td class="<?=$manhacor['A'][$j][$i]?> horario"
                        width="16%"
                        data-item-horario="<?=$disciplina['A'][$j][$i]?>"
                        data-toggle="popover"
                        data-content="
                        <div class='btn-group'role='group'>
                            <? 
                                // Converte (") para ('), para não fechar o atributo data-content
                                $texto =  str_replace('"',"'",$manha['A'][$j][$i]); 
                                echo $texto;
                            ?>
                            <? if($texto == ''){ ?>
                                <button 
                                    type='button' class='btn btn-outline btn-info btnCadastrar<?=$id?>'
                                    data-remote='<?= base_url($this->session->userdata('SGP_SISTEMA') . "/tempos/mdlTurmaHorarioTempo/A:".$i.":".$j."") ?>'
                                >
                                    <i class='fa fa-plus'></i> Novo
                                </button>
                            <? }else{ ?>
                                <hr />
                                <button type='button' 
                                    class='btn btn-info btnCadastrar<?=$id?>'
                                    data-remote='<?= base_url($this->session->userdata('SGP_SISTEMA') . "/tempos/mdlHorarioEditar/".$idmanha['A'][$j][$i]."") ?>' 
                                >
                                    <i class='fa fa-edit'></i> Editar
                                </button>
                                <button type='button' data-item-id='<?=$idmanha['A'][$j][$i]?>' 
                                    class='btn btn-danger btnFinalizar<?=$id?>'
                                >
                                    <i class='fa fa-times-circle'></i>  Finalizar
                                </button>
                            <? } ?>
                                </div>"
                    >
                        <?=$manha['A'][$j][$i]?>
                    </td>
                    <? } ?>
                </tr>
            <? } ?>
        </tbody>
    </table>
</div>
<br/>
<div class="table-responsive" style="padding:5px">
    <strong>HORÁRIOS DA TARDE</strong>
    <table class="text-center table-bordered" style="width: 100%" id="dtGridTarde">
        <thead>
            <tr class="panel-footer" style="height: 30px">
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
            <? for ($i = 1; $i <= 6; $i++) { ?>
                <tr class="cell">
                    <td width="4%"><?= $i ?>º</td>
                    <? for ($j = 1; $j <= 6; $j++) { ?>
                        <td class="<?=$tardecor['B'][$j][$i]?> horario"
                        width="16%"
                        data-item-horario="<?=$disciplina['B'][$j][$i]?>"
                        data-toggle="popover"
                        data-content="
                        <div class='btn-group'role='group'>
                            <? 
                                // Converte (") para ('), para não fechar o atributo data-content
                                $texto =  str_replace('"',"'",$tarde['B'][$j][$i]); 
                                echo $texto;
                            ?>
                            <? if($texto == ''){ ?>
                                <button 
                                    type='button' class='btn btn-outline btn-info btnCadastrar<?=$id?>'
                                    data-remote='<?= base_url($this->session->userdata('SGP_SISTEMA') . "/tempos/mdlTurmaHorarioTempo/B:".$i.":".$j."") ?>'
                                >
                                    <i class='fa fa-plus'></i> Novo
                                </button>
                            <? }else{ ?>
                                <hr />
                                <button type='button' 
                                    class='btn btn-info btnCadastrar<?=$id?>'
                                    data-remote='<?= base_url($this->session->userdata('SGP_SISTEMA') . "/tempos/mdlHorarioEditar/".$idtarde['B'][$j][$i]."") ?>' 
                                >
                                    <i class='fa fa-edit'></i> Editar
                                </button>
                                <button type='button' data-item-id='<?=$idtarde['B'][$j][$i]?>' 
                                    class='btn btn-danger btnFinalizar<?=$id?>'
                                >
                                    <i class='fa fa-times-circle'></i>  Finalizar
                                </button>
                            <? } ?>
                                </div>"
                    >
                        <?=$tarde['B'][$j][$i]?>
                    </td>
                    <? } ?>
                </tr>
            <? } ?>
        </tbody>
    </table>
</div>

<script>
    
    $(document).ready(function(){
        
        $("[data-toggle=popover]").popover({
            html: 'true',
            placement: 'top',
            container: 'body',
            title: 'Ações <a href="#" class="close" data-dismiss="alert">×</a>',
        });

        $(document).on("click", ".popover .close" , function(){
            $(this).parents(".popover").popover('hide');
        });

        $(document).on("click", ".popover .desmiss" , function(){
            $(this).parents(".popover").popover('hide');
        });
    
        $(document).on("click", ".popover .btnFinalizar<?=$id?>" , function(e){
            $(this).parents(".popover").popover('hide');
            // Prevent os atributos do item clicado
            e.preventDefault();
            // Pega o Código do Horário
            var codigo = $(this).data('item-id');

            swal({
                title: "Encerrar Horário",
                text: "Você tem certeza que deseja finalizar esse horário?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Sim, Encerrar!",
                cancelButtonText: "Não, Cancelar!",
                closeOnConfirm: false,
                closeOnCancel: true,
            },
            function(isConfirm) {
                if (isConfirm) {
                    // função que verifica no banco se a prova esta processada 
                    $.post("<?= base_url($this->session->userdata('SGP_SISTEMA') . '/turma_horario/frmManter') ?>", {
                        Horario: codigo,
                        Operacao: 'D',
                    },
                    function(data) {
                        swal("Sucesso!", "Horário finalizado com sucesso!", "success");
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

        $(document).on("click", ".popover .btnCadastrar<?=$id?>", function(e){
            $(this).parents(".popover").popover('hide');
            $('#frmModalDataGridView').remove();
            e.preventDefault();
            var $this = $(this)
                    , $remote = $this.data('remote') || $this.attr('href')
                    , $modal = $('<div class="modal fade modal-info"  id="frmModalDataGridView"  tabindex="-1" role="dialog" ><div class="modal-dialog" ><div class="modal-content"></div></div></div>');
            $('body').append($modal);
            $modal.modal({backdrop: 'static', keyboard: false});
            $modal.load($remote);
        });
    }); 
</script>