<? $this->load->view('home/header'); ?>
<script src='<?= base_url('assets/js/fullcalendar.min.js') ?>'></script>
<script src='<?= base_url('assets/js/locale-all.js') ?>'></script>
<script>
    $(document).ready(function () {
        var initialLocaleCode = 'pt-br';
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            defaultDate: '<?= date('Y-m-d') ?>',
            minTime: "07:00:00",
            maxTime: "18:00:00",
            navLinks: true, // can click day/week names to navigate views
            selectable: true,
            selectHelper: true,
            //select: function (start, end) {
                /*var title = prompt('Event Title:');
                var eventData;
                if (title) {
                    eventData = {
                        title: title,
                        start: start,
                        end: end
                    };
                    $('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
                }
                $('#calendar').fullCalendar('unselect');*/
            //},
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            locale: "pt-br",
            events: {
                url: "<?= base_url('' . $this->session->userdata('SGP_SISTEMA') . '/reserva/listview/') ?>",
                type: "POST",
                startParam: "inicio",
                endParam: "fim",
                data: function () {},
            },
            eventClick: function (calEvent, jsEvent, view) {
                $('[data-item="professor"]').html(calEvent.professor);
                $('[data-item="espaco"]').html(calEvent.title);
                //$('[data-item="espaco"]').html(calEvent.title);
                $('[data-item="dt_inicio"]').html(calEvent.inicio);
                $('[data-item="dt_final"]').html(calEvent.final);
                
                $('[data-item="hr_inicio"]').html(calEvent.hr_inicio);
                $('[data-item="hr_final"]').html(calEvent.hr_final);
            }
        });
    });

</script>



<div class="col-lg-9">
    <div class="hpanel hblue">
        <div class="panel-heading">
            <button type="button" 
                    id="" 
                    class="btn btn-sm btn-info" 
                    data-toggle="frmModal" 
                    href="<?= base_url('' . $this->session->userdata('SGP_SISTEMA') . '/reserva/mdlfrmSolicitacao/A') ?>">
                <span class="btn-label">
                    <i class="fa fa-plus"></i>
                </span>
                Nova Solicitação
            </button>
        </div>
        <div class="panel-body">
            <div id='calendar'></div>

        </div>
        <div class="panel-footer">

        </div>
    </div>
</div>

<div class="col-lg-3">
    
    <div class="hpanel hgreen" style="position: fixed; ">
        <div class="panel-body">
            <h5 data-item="professor"></h5>
            <div data-item="espaco" class="text-muted font-bold m-b-xs"></div>
        </div>
        <div class="panel-footer">
            <div class="row">
                <div class="col-sm-12">
                    <p>
                        <span data-item="dt_inicio"></span> - 
                        <span data-item="dt_final"></span>
                    </p>
                    <p>
                        <span data-item="hr_inicio"></span><br>
                        <span data-item="hr_final"></span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="hpanel hgreen" style="display:none">
    <div class="panel-footer">
        <div class="row">
            <form id="frmNovaPesquisa" class="col-xs-11 pull-right">

                <div class="col-xs-4 pull-right">
                    <label>Local:</label>
                    <div class="input-group btn-group">
                        <select required name="Local" id="Local" class="form-control input-sm">
                            <option></option>
                            <option value="L">LABORATÓRIO</option>
                            <option value="E">ESPAÇO</option>
                        </select>
                        <span class="input-group-btn">
                            <button onclick="txtFiltrar()" type="button" id="" class="btn btn-xs btn-warning input-sm">
                                <span class="btn-label"><i class="fa fa-search"></i></span>
                                Filtrar
                            </button>
                        </span>
                    </div>
                </div>
                <div class="col-xs-2 pull-right no-padding">
                    <label>Data:</label>
                    <div class="input-group m-b">
                        <input size="16" type="text" class="form-control input-sm"   name="Data" id="Data" >
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span> 
                    </div>
                </div>
                <div class="col-xs-2  pull-right">
                    <label>Período:</label>
                    <select required name="Periodo" id="Periodo" class="form-control input-sm">
                        <option></option>
                        <option value="2017/1">2017/1</option>
                        <option value="2016/1">2016/1</option>
                        <option value="2015/1">2015/1</option>
                        <option value="2014/1">2014/1</option>
                    </select>
                </div>

            </form>
        </div>
    </div>
    <div class="panel-body no-padding" id="tblFiltro">
    </div>
</div>


<? $this->load->view('home/footer'); ?>