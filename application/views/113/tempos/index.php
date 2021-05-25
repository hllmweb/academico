<? $this->load->view('home/header'); ?>
<div class="hpanel hgreen">
    <div class="row text-center">
        <div class="btn-group">
            <div class="btn-group" role="group">
                <button 
                    type="button" 
                    class="btn btn-primary2"
                    data-toggle="frmModal"
                    data-remote="<?= base_url($this->session->userdata('SGP_SISTEMA') . '/tempos/mdlHorarioTurma') ?>"
                    >
                    <i class="fa fa-users fa-4x" aria-hidden="true"></i>
                    <br/><br/>
                    <span class="text-uppercase hidden-xs">
                        HORÁRIO TURMA
                    </span>
                </button>
            </div>
            <div class="btn-group" role="group">
                <button 
                    type="button" 
                    class="btn btn-info"
                    data-toggle="frmModal"
                    data-remote="<?= base_url($this->session->userdata('SGP_SISTEMA') . '/tempos/mdlHorarioProfessor') ?>"
                    >
                    <i class="fa fa-user fa-4x" aria-hidden="true"></i>
                    <br/><br/>
                    <span class="text-uppercase hidden-xs">
                        HORÁRIO PROFESSOR
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

<? $this->load->view('home/footer'); ?>