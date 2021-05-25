<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Combobox extends CI_Controller {

    function __construct() {
        parent::__construct();

        /* NOVAS ANOTAÇÕES */
        $this->load->model("academico/tema_model", "tema", true);
        $this->load->model('sica/aluno_model', 'aluno', TRUE);
        $this->load->model("sica/estrutura_notas_model", "estrutura_notas", true);
        $this->load->model("sica/serie_model", "serie", true);
        $this->load->model("sica/turma_model", "turma", true);
        $this->load->model("sica/turma_professor_model", "turma_professor", true);

        $this->load->model('geral/secretaria_model', 'secretaria', TRUE);
        $this->load->model('geral/colegio_model', 'colegio', TRUE);
        $this->load->model('academico_model', 'academico', TRUE);
        $this->load->model('108/questao_model', 'questao', TRUE);
        $this->load->model('sica/responsavel_model', 'responsavel', TRUE);
        $this->load->model('academico/reserva_local_model', 'local', TRUE);
        $this->load->model('sica/aes_prova_model', 'prova', TRUE);

        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'session'));
    }

    function alunos() {
        $p = array(
            'curso' => $this->input->post('curso'),
            'serie' => $this->input->post('serie'),
        );
        $registro = $this->aluno->listar_serie($p);
        $combo = '';
        foreach ($registro as $r) {
            $combo .= '<option value="' . $r['CD_ALUNO'] . '">' . $r['CD_ALUNO'] . ' - ' . $r['NM_ALUNO'] . '</option>';
        }
        echo $combo;
    }

    /**
     * Retorna todos os alunos por turma, serie e curso que possuem
     * 
     * @param string $curso
     * @param string $serie
     * @param string $turma
     * @param string $multiplo
     * @param string $selecionado
     * @return string
     */
    function turma_alunos() {
        $params = array(
            'curso' => $this->input->post('curso'),
            'serie' => $this->input->post('serie'),
            'turma' => $this->input->post('turma'),
            'periodo' => $this->session->userdata("SGP_PERIODO")
        );

        //verificar se deve retornar a combo com algum registro selecionado
        $selecionado = $this->input->post('selecionado');

        //verificar se a combo permite selecionar vários registros e evitar um registro em branco
        $multiplo = $this->input->post("multiplo");
        $combo = !empty($multiplo) ? "" : "<option value=''></option>";

        $registros = $this->aluno->listaPorTurma($params);
        foreach ($registros as $row) {
            $combo .= "<option value='" . $row->CD_ALUNO . "' "
                    . ($row->CD_ALUNO == $selecionado ? "selected" : "") . ">"
                    . $row->NM_ALUNO . "</option>";
        }

        echo $combo;
    }

    /**
     * Retorna todos os responsaveis por turma, serie e curso sendo apenas
     * o CPF do responsavel
     * 
     * @param string $curso
     * @param string $serie
     * @param string $turma
     * @param string $tipo
     * @param string $multiplo
     * @param string $selecionado
     * @return string
     */
    function turma_responsaveis() {
        $tipo = $this->input->post('tipo');

        $params = array(
            'curso' => $this->input->post('curso'),
            'serie' => $this->input->post('serie'),
            'turma' => $this->input->post('turma'),
            'tipo' => empty($tipo) ? null : $tipo,
            'periodo' => $this->session->userdata("SGP_PERIODO")
        );

        //verificar se deve retornar a combo com algum registro selecionado
        $selecionado = $this->input->post('selecionado');

        //verificar se a combo permite selecionar vários registros e evitar um registro em branco
        $multiplo = $this->input->post("multiplo");
        $combo = !empty($multiplo) ? "" : "<option value=''></option>";

        $registros = $this->responsavel->listaPorTurma($params);
        foreach ($registros as $row) {
            $combo .= "<option value='" . $row->CPF_RESPONSAVEL . "' "
                    . ($row->CPF_RESPONSAVEL == $selecionado ? "selected" : "") . ">"
                    . $row->NM_RESPONSAVEL . " | " . $row->NM_ALUNO . "</option>";
        }

        echo $combo;
    }

    /**
     * Retorna todos os responsaveis por turma, serie e curso contendo o codigo
     * do responsavel e codigo do aluno.
     * 
     * @param string $curso
     * @param string $serie
     * @param string $turma
     * @param string $tipo
     * @param string $multiplo
     * @param string $selecionado
     * @return string
     */
    function turma_responsavel_aluno() {
        $tipo = $this->input->post('tipo');

        $params = array(
            'curso' => $this->input->post('curso'),
            'serie' => $this->input->post('serie'),
            'turma' => $this->input->post('turma'),
            'tipo' => empty($tipo) ? null : $tipo,
            'periodo' => $this->session->userdata("SGP_PERIODO")
        );

        //verificar se deve retornar a combo com algum registro selecionado
        $selecionado = $this->input->post('selecionado');

        //verificar se a combo permite selecionar vários registros e evitar um registro em branco
        $multiplo = $this->input->post("multiplo");
        $combo = !empty($multiplo) ? "" : "<option value=''></option>";

        $registros = $this->responsavel->listaPorTurma($params);
        foreach ($registros as $row) {
            $combo .= "<option value='" . $row->ID_RESPONSAVEL . "-" . $row->CD_ALUNO . "' "
                    . ($row->CPF_RESPONSAVEL == $selecionado ? "selected" : "") . ">"
                    . $row->NM_RESPONSAVEL . " | " . $row->NM_ALUNO . "</option>";
        }

        echo $combo;
    }

    function responsavel() {
        $p = array(
            'aluno' => $this->input->post('aluno'),
        );
        $registro = $this->responsavel->listar_aluno($p);
        $combo = '<option value=""></option>';
        foreach ($registro as $r) {
            $combo .= '<option value="' . $r['ID_RESPONSAVEL'] . '">' . $r['NM_RESPONSAVEL'] . '</option>';
        }
        echo $combo;
    }

    function dvSerie() {

        $serie = $this->secretaria->aluno_turma(array('operacao' => 'S', 'curso' => $this->input->post('curso')));
        $combo = '';
        foreach ($serie as $s) {
            if (($s['NM_SERIE'] != 'ATIVIDADE DIRIGIDA') && ($s['NM_SERIE'] != 'ESTUDO DIRIGIDO') && ($s['ORDEM_SERIE'] != 10)) {
                $combo .= '<li class="list-group-item">
                                <label class="radio-inline c-radio">
                                    <input required id="avalSerie" type="radio" name="avalSerie" value="' . $s['ORDEM_SERIE'] . '">
                                    <strong style="font-size:14px">' . $s['ORDEM_SERIE'] . 'º ANO</strong>
                                </label>
                            </li>';
            }
        }
        echo $combo;
    }

    /**
     * Retorna todas as séries de um determinado curso ou conjunto de cursos.
     * 
     * @param string|array $curso
     * @param boolean multiplo TRUE quando a combo for selectpicker.
     * @return string 
     */
    function serie() {
        $check = $this->input->post('selecionado');
        $multiplo = $this->input->post("multiplo");

        //verificar se foi enviado string ou vetor
        $aux = $this->input->post("curso");
        $cursos = is_string($aux) ? array($aux) : $aux;

        //evitar que o componente selectpicker gere uma opção vazia
        $combo = empty($multiplo) ? '<option value=""></option>' : "";

        $series = $this->serie->series($cursos);
        foreach ($series as $s) {
            $combo .= '<option ' . (($check == $s->ORDEM_SERIE) ? 'selected="selected"' : '' ) . ' value="' . $s->ORDEM_SERIE . '">' . ($s->CD_CURSO == 3 ? $s->ORDEM_SERIE . 'º ANO' : $s->ORDEM_SERIE . 'ª SÉRIE') . '</option>';
        }

        echo $combo;
    }

    function turma() {

        $check = $this->input->post('selecionado');
        $turma = $this->secretaria->aluno_turma($a = array('operacao' => 'T', 'curso' => $this->input->post('curso'), 'ordem' => $this->input->post('serie')));
        $combo = '<option value=""></option>';
        foreach ($turma as $t) {
            $combo .= '<option ' . (($check == $t['CD_TURMA']) ? 'selected="selected"' : '' ) . ' value="' . $t['CD_TURMA'] . '">' . $t['CD_TURMA'] . '</option>';
        }
        echo $combo;
    }

    /**
     * Retorna todas as turmas normais e mista de um determinado curso e série 
     * ou conjunto de cursos e séries.
     * 
     * @param string|array $curso
     * @param string|array $serie
     * @param boolean multiplo TRUE quando a combo for selectpicker.
     * @return string 
     */
    function turma_regular() {
        $multiplo = $this->input->post("multiplo");
        $check = $this->input->post('selecionado');
        $aux1 = $this->input->post("curso");
        $aux2 = $this->input->post("serie");

        //verificar se dados foram enviado como string ou vetor
        $cursos = is_string($aux1) ? array($aux1) : $aux1;
        $series = is_string($aux2) ? array($aux2) : $aux2;

        //evitar que o componente selectpicker gere uma opção vazia
        $combo = empty($multiplo) ? '<option value=""></option>' : "";

        $turmas = $this->turma->turmas($cursos, $series);
        foreach ($turmas as $t) {
            $combo .= '<option ' . (($check == $t->CD_TURMA) ? 'selected="selected"' : '' ) . ' value="' . $t->CD_TURMA . '">' . $t->CD_TURMA . '</option>';
        }

        echo $combo;
    }
    
    function disciplina() {

        $turma = $this->secretaria->aluno_turma(array('operacao' => 'DE', 'curso' => $this->input->post('curso'), 'ordem' => $this->input->post('serie')));
        $check = $this->input->post('selecionado');

        $combo = '<option value=""></option>';
        foreach ($turma as $t) {
            $combo .= '<option ' . (($check == $t['CD_DISCIPLINA']) ? 'selected="selected"' : '' ) . ' value="' . $t['CD_DISCIPLINA'] . '">' . str_pad($t['CD_DISCIPLINA'], 3, "0", STR_PAD_LEFT) . ' - ' . $t['NM_DISCIPLINA'] . '</option>';
        }
        echo $combo;
    }

    function disciplina_turma() {

        $turma = $this->secretaria->aluno_turma(array('operacao' => 'DET', 'turma' => $this->input->post('turma')));
        $check = $this->input->post('selecionado');

        $combo = '<option value=""></option>';
        foreach ($turma as $t) {
            $combo .= '<option ' . (($check == $t['CD_DISCIPLINA']) ? 'selected="selected"' : '' ) . ' value="' . $t['CD_DISCIPLINA'] . '">' . str_pad($t['CD_DISCIPLINA'], 3, "0", STR_PAD_LEFT) . ' - ' . $t['NM_DISCIPLINA'] . '</option>';
        }
        echo $combo;
    }

    function disciplinaTable() {

        $disc = $this->secretaria->aluno_turma(array('operacao' => 'DEC', 'curso' => $this->input->post('curso'), 'ordem' => $this->input->post('serie')));

        $table = '<table width="100%">
                        <thead>
                        <tr style="background: #CCC;">
                            <td width="70%" style="padding:2px;"><label><strong>DISCIPLINA</strong></label></td>
                            <td align="center" width="10%" style="padding:2px;"><label><strong>INICIO</strong></label></td>
                            <td align="center" width="10%" style="padding:2px;"><label><strong>FIM</strong></label></td>
                            <td align="center" width="10%" style="padding:2px;"></td>
                        </tr>                           
                        </thead>';

        foreach ($disc as $t) {
            $table .= '<tr>';
            $table .= '<td><input style="width:100%" disabled  value="' . $t['NM_DISCIPLINA'] . '"></td>';
            $table .= '<td><input onchange="calculador()" onblur="calculador()" style="width:100px" min="1" type="number" name="txtQTDDInicial[]" > </td>';
            $table .= '<td><input onchange="calculador()" onblur="calculador()" style="width:100px" min="1" type="number" name="txtQTDDFinal[]" > </td>';
            $table .= '<td align="center"><button class="btn btn-xs btn-danger" onclick="RemoveTableRow(this)" type="button"><i class="fa fa-trash-o"></i></button></td>';
            $table .= '</tr>';
        }
        $table .= '<tbody >
                        </tbody>
                    </table>';
        echo $table;
    }

    function professor() {

        $res = $this->secretaria->aluno_turma(array('operacao' => 'PD', 'disciplina' => $this->input->post('disciplina'), 'curso' => $this->input->post('curso')));
        $check = $this->input->post('selecionado');

        $combo = '<option value="">ESCOLHA O PROFESSOR</option>';
        foreach ($res as $r) {
            $combo .= '<option ' . (($check == $r['CD_PROFESSOR']) ? 'selected="selected"' : '' ) . ' value="' . $r['CD_PROFESSOR'] . '">' . $r['NM_PROFESSOR'] . '</option>';
        }
        echo $combo;
    }

    function professores() {
        $res = $this->secretaria->aluno_turma(array('operacao' => 'PS'));
        $combo = '<option value="">ESCOLHA O PROFESSOR</option>';
        foreach ($res as $r) {
            $combo .= '<option value="' . $r['CD_PROFESSOR'] . '">' . $r['NM_PROFESSOR'] . '</option>';
        }
        echo $combo;
    }

    /**
     * Exibe todos os professores conforme um curso e série selecionado.
     * 
     * @param string $curso Via POST
     * @param string $serie Via POST
     * @return string String com o html para geração dos dados da combo
     */
    public function curso_serie_professor() {
        $curso = $this->input->post("curso");
        $serie = $this->input->post("serie");

        $professores = $this->turma_professor->professoresCursoSerie($curso, $serie);
        $combo = "<option value=''>ESCOLHA O PROFESSOR</option>";
        foreach ($professores as $row) {
            $combo .= "<option value='" . $row->CD_PROFESSOR . "'>" . $row->NM_PROFESSOR . "</option>";
        }

        echo $combo;
    }

    function notas() {

        $res = $this->colegio->aes_colegio($a = array('operacao' => 'NF', 'curso' => $this->input->post('curso'), 'bimestre' => $this->input->post('bimestre')));
        $combo = '<option value="">ESCOLHA A NOTA</option>';
        if($this->input->post('bimestre') == 4 || $this->input->post('bimestre') == 5)
            $combo .= '<option value="42">RP2</option>';
         

        
        foreach ($res as $t) {
            $combo .= '<option value="' . $t['CD_TIPO_NOTA'] . '">' . strtoupper('(' . $t['NM_MINI'] . ')') . '</option>';
        }
        echo $combo;
    }

    function maic() {

        $res = $this->colegio->colegio($a = array('operacao' => 'NFM', 'curso' => $this->input->post('curso'), 'bimestre' => $this->input->post('bimestre')));
        $combo = '';
        foreach ($res as $t) {
            $combo .= '<option value="' . $t['NUM_NOTA'] . '">' . strtoupper($t['DC_TIPO_NOTA']) . ' - (' . $t['NM_MINI'] . ') ' . '</option>';
        }
        echo $combo;
    }

    function estrutura() {
        $turma = $this->colegio->aes_colegio(array('operacao' => 'ESTR', 'curso' => $this->input->post('curso')));
        foreach ($turma as $t) {
            $combo = $t['CD_ESTRUTURA'];
        }
        echo $combo;
    }

     function estrutura_notas() {
        $turma = $this->input->post("turma");
        $bimestre = $this->input->post("bimestre");

        $turmaDetalhe = $this->turma->filtro_id(array(
            array("campo" => "CD_TURMA", "valor" => $turma),
            array("campo" => "PERIODO", "valor" => $this->session->userdata('SGP_PERIODO'))
        ));

        $estruturaNotas = $this->estrutura_notas->filtrar(array(
            array("campo" => "CD_ESTRUTURA", "valor" => $turmaDetalhe->CD_ESTRUTURA),
            array("campo" => "BIMESTRE", "valor" => $bimestre)//,
            //array("campo" => "NM_MINI IN ('P1', 'P2', 'RS')")
            //array("campo" => "NM_MINI IN ('P1', 'P2', 'RS','MAIC')")
        ));

        $combo = "<option></option>";
        foreach ($estruturaNotas as $row) {
            $combo .= "<option value='" . $row->NUM_NOTA . "-" . $row->CD_TIPO_NOTA . "'>" . $row->DC_TIPO_NOTA . " (" . $row->NM_MINI . ")" . "</option>";
        }

        echo $combo;
    }

    function turma_professor() {

        $turma = $this->academico->consultas(array('operacao' => 'TP', 'professor' => $this->input->post('professor')));
        $combo = '<option value=""></option>';
        foreach ($turma as $t) {
            $combo .= '<option value="' . $t['CD_TURMA'] . '">' . $t['CD_TURMA'] . '</option>';
        }
        echo $combo;
    }

    function turma_disciplina() {

        $disciplina = $this->academico->consultas(array('operacao' => 'TPD', 'professor' => $this->input->post('professor'), 'turma' => $this->input->post('turma')));
        $combo = '<option value=""></option>';
        foreach ($disciplina as $d) {
            $combo .= '<option value="' . $d['CD_DISCIPLINA'] . '">' . $d['NM_DISCIPLINA'] . '</option>';
        }
        echo $combo;
    }

    function tema() {
        $tema = $this->tema->filtrar(array(
            array('campo' => 'CD_CURSO', 'valor' => $this->input->post('curso')),
            array('campo' => 'ORDEM_SERIE', 'valor' => $this->input->post('serie')),
            array('campo' => 'CD_DISCIPLINA', 'valor' => $this->input->post('disciplina')),
            array('campo' => 'FLG_ATIVO', 'valor' => 'S'),
        ));

        $check = $this->input->post('selecionado');
        $combo = '<option value="">ESCOLHA O TEMA </option>';
        foreach ($tema as $t) {
            $combo .= '<option ' . (($check == $t->CD_TEMA) ? 'selected="selected"' : '' ) . ' value="' . $t->CD_TEMA . '">' . $t->CD_TEMA . ' - ' . $t->DC_TEMA . '</option>';
        }
        echo $combo;
    }

    function tema_conteudo() {
        $check = $this->input->post('selecionado');
        $conteudo = $this->questao->conteudo(array('operacao' => 'F', 'tema' => $this->input->post('tema')));
        $combo = '<option value="">ESCOLHA O CONTEÚDO</option>';
        foreach ($conteudo as $c) {
            $combo .= '<option ' . (($check == $c['CD_CONTEUDO']) ? 'selected="selected"' : '' ) . ' value="' . $c['CD_CONTEUDO'] . '">' . $c['DC_CONTEUDO'] . '</option>';
        }
        echo $combo;
    }

    function reserva_local() {
        $check = $this->input->post('selecionado');
        $conteudo = $this->local->listar_tipo($this->input->post('tipo'));

        $combo = '<option value="">ESCOLHA O ' . (($this->input->post('tipo') == 'L') ? 'LABORATÓRIO' : 'ESPAÇO') . '</option>';
        foreach ($conteudo as $c) {
            $combo .= '<option ' . (($check == $c['CD_LOCAL']) ? 'selected="selected"' : '' ) . ' value="' . $c['CD_LOCAL'] . '">' . $c['NM_LOCAL'] . '</option>';
        }
        echo $combo;
    }

    //Lista as datas de avaliação de uma turma, utilizada no filtro DATA DE REALIZAÇÃO(combo) na tela de acompanhamento da prova online By: Mônica
    function data() {

        $curso = $this->input->post('curso');
        $serie = $this->input->post('serie');

        $datas = $this->prova->provasPorCurso(array('curso' => $curso, 'serie' => $serie));

        $combo .= '<option value="">Selecione</option>';

        $data = '';
        foreach ($datas as $d) {
            $data = date('d/m/Y', strtotime($d['DT_PROVA']));
            $combo .= '<option  value="' . $data . '">' . $data . '</option>';
        }
        echo $combo;
    }

    //Lista as provas(nº das provas) da data e turma previamente selecionados, utilizada no filtro NºPROVA(combo) na tela de acompanhamento da prova online By: Mônica
    function prova() {

        $data = $this->input->post('data');
        $curso = $this->input->post('curso');
        $serie = $this->input->post('serie');
        $prova = $this->prova->provaPorData(array('curso' => $curso, 'serie' => $serie, 'data' => $data));

        $combo = '<option value="">Selecione</option>';

        foreach ($prova as $p) {
            $combo .= '<option  value="' . $p['CD_PROVA'] . '">' . $p['NUM_PROVA'] . '</option>';
        }
        echo $combo;
    }

}
