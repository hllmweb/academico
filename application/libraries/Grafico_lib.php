<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* Library Grafico de Prova
 * Autor: Silvio de Souza
 * Data: 25/06/2015
 * 
 * Retorna: 
 * ----------------------------------------
 * # Lista de Alunos envolvidos na Prova
 * 
 */

class Grafico_lib {

    public $prova;
    public $titulo;
    
    function CalculaPercentual($t,$n) {
        
        $res = number_format((($n*100)/$t),1,'.','');
        return($res);        
     }
    //
    function DadosProva() {
        $obj = & get_instance();
        $obj->load->model('banco/bancoprova_model', 'banco', TRUE);
        $provat = $obj->banco->prova(array('operacao' => 'FC', 'codigo' => $this->prova));
        $this->titulo = $provat[0]['TITULO'];
        
     }
    //
    function GPAlunos() {
        $obj = & get_instance();
        $obj->load->model('grafico_model', 'grafico', TRUE);
        
        $grafico = '';
        $alunos = $obj->grafico->ProvaGrafico(array('operacao' => 'LT', 'prova' => $this->prova));
        foreach($alunos as $row){
            $grafico .= "['".$row['NM_ALUNO']."', ".$row['TOTAL_ACERTOS'].",".$al['QT']."],";
        }
        return($grafico);
     }

    // exibe o resultado por aluno
    function LTAlunos() {
        $obj = & get_instance();
        $obj->load->model('banco/bancoprova_model', 'banco', TRUE);
        $obj->load->model('grafico_model', 'grafico', TRUE);
        
        $versao = $obj->banco->prova(array('operacao' => 'FPV', 'codigo' => $this->prova));

        foreach($versao as $v){
        $alunos = $obj->grafico->ProvaGrafico(array('operacao' => 'LA', 'prova' => $v['CD_PROVA']));
        
        $string .= '<table id="tbl" width="100%" border="0" cellpadding="4" cellspacing="0" class="">
                        <thead>
                        <tr>';
                $string .= '<td colspan="2"><h4 class="panel-title">Acertos dos Alunos :: Questões Objetivas</h4></td>';
                $string .= '<td colspan="'.$v['QTDE_QUESTOES'].'" align="center"><label> QUESTÃO </label></td>
                       </tr>
                       <tr>
                            <td height="25" colspan="2"><label> </label></td>';
             for($i=1; $i <= $v['QTDE_QUESTOES']; $i++){
                 $string .= '<td width="20px" align="center"><label> '.$i.'</label></td>';
             }
        $string .= '</tr>
                       
                       <tr>
                           <td align="right" height="25">#</td> 
                           <td rowspan="3"> GABARITO DA VERSÃO :: '.$v['NUM_PROVA'].'</td>';
             for($i=0; $i < $v['QTDE_QUESTOES']; $i++){
                 $string .= '<td align="center" >'.substr($alunos[0]['GABARITO'],$i,1).'</td>';
             }
        $string .= '   <td align="center" rowspan="3">ACERTOS</td>
                       </tr>
                       
                        </thead>
                        <tbody>';
        $j = 1;
                        foreach($alunos as $al){
               $string .= '<tr>
                                <td>'.$j.'</td>
                                <td><img height="25px" class="img-rounded" src="'.base_url('login/foto/'.$al['CD_ALUNO'].'').'" /> <a href="'.base_url('grafico/aluno/frmGabaritos?token='.$al['CD_ALUNO'].'').'" target="_blank">'.substr($al['NM_ALUNO'],0,50).'</a></td>';
              for($i=0; $i < $v['QTDE_QUESTOES']; $i++){
                 $string .= '<td align="center" style="background:'.((substr($al['GABARITO'],$i,1) == substr($al['RESPOSTAS'],$i,1)? '#E8F3FF': '#FBE3E6')).'">'.((substr($al['RESPOSTAS'],$i,1) != 'Z')? substr($al['RESPOSTAS'],$i,1) : '-').'</td>';
             } 
               $string .= '     <td width="50" align="center">'.$al['TOTAL_ACERTOS'].' / '.$al['QT'].'</td>
                            </tr>';
                            $j = $j+1; }
               $string .= '</tbody>
                    </table><br/>';
               
        }
        return($string);
    }    
    // exibe resultados sobre as questões
    function LTQuestoes() {
        $obj = & get_instance();
        $obj->load->model('grafico_model', 'grafico', TRUE);
        
        // RELAÇÃO DAS QUESTÕES DA PROVA
        $questoes = $obj->grafico->ProvaGrafico(array('operacao' => 'PQR', 'prova' => $this->prova));
        
        
        $string = '<h4 class="panel-title"></h4>
                    <hr/>';
        foreach($questoes as $r){
            
         // RELAÇÃO DAS QUESTÕES DA PROVA
        $dados = $obj->grafico->ProvaGrafico(array('operacao' => 'VTC', 'questao' => $r['CD_QUESTAO']));   
            
            
        $string .= '<table id="tbl_erro" width="100%" border="0" cellpadding="5" cellspacing="1">
                      <thead>
                        <tr style="background:#B6B6B6">
                         <td align="left" colspan="6">                              
                             <table width="100%" id="tbl_erro" border="0" cellpadding="5" cellspacing="1">
                                  <thead>
                                   <tr>
                                       <td>DISCIPLINA:</td>
                                       <td>'.$dados[0]['NM_DISCIPLINA'].'</td>
                                  </tr>
                                  <tr>
                                       <td>TEMA:</td>
                                       <td>'.strip_tags($dados[0]['DC_TEMA']).'</td>
                                  </tr>
                                  <tr>
                                       <td>CONTEÚDO:</td>
                                       <td>'.strip_tags($dados[0]['DC_CONTEUDO']).'</td>
                                  </tr>
                                  </thead>
                             </table>
                         </td>
                      </tr>
                        <tr style="background:#D3D3D3">
                            <td align="left" height="25"><label> QUESTÃO</label></td>                            
                            <td align="center"> OPÇÃO 1 </td>
                            <td align="center"> OPÇÃO 2 </td>
                            <td align="center"> OPÇÃO 3 </td>
                            <td align="center"> OPÇÃO 4 </td>
                            <td align="center"> OPÇÃO 5 </td>';
                $string .= '
                       </tr>
                     </thead>';
                $total = ($r['R_1']+$r['R_2']+$r['R_3']+$r['R_4']+$r['R_5']);
          $string .= '<tbody>
                        <tr style="background:#EFEFEF">
                          <td width="100" height="25">Nº '.$r['CD_QUESTAO'].'</td>
                          <td width="80" align="center" style="background:'.(($dados[0]['CORRETA'] == 1)? '#E8F3FF': '').'"> '.$this->CalculaPercentual($total,$r['R_1']).'% ('.$r['R_1'].') '.(($dados[0]['CORRETA'] == 1)? '<img height="16" src="'.base_url('assets/images/check.png').'">': '').'</td>
                          <td width="80" align="center" style="background:'.(($dados[0]['CORRETA'] == 2)? '#E8F3FF': '').'"> '.$this->CalculaPercentual($total,$r['R_2']).'% ('.$r['R_2'].') '.(($dados[0]['CORRETA'] == 2)? '<img height="16" src="'.base_url('assets/images/check.png').'">': '').'</td>
                          <td width="80" align="center" style="background:'.(($dados[0]['CORRETA'] == 3)? '#E8F3FF': '').'"> '.$this->CalculaPercentual($total,$r['R_3']).'% ('.$r['R_3'].') '.(($dados[0]['CORRETA'] == 3)? '<img height="16" src="'.base_url('assets/images/check.png').'">': '').'</td>
                          <td width="80" align="center" style="background:'.(($dados[0]['CORRETA'] == 4)? '#E8F3FF': '').'"> '.$this->CalculaPercentual($total,$r['R_4']).'% ('.$r['R_4'].') '.(($dados[0]['CORRETA'] == 4)? '<img height="16" src="'.base_url('assets/images/check.png').'">': '').'</td>
                          <td width="80" align="center" style="background:'.(($dados[0]['CORRETA'] == 5)? '#E8F3FF': '').'"> '.$this->CalculaPercentual($total,$r['R_5']).'% ('.$r['R_5'].') '.(($dados[0]['CORRETA'] == 5)? '<img height="16" src="'.base_url('assets/images/check.png').'">': '').'</td>
                     </tr>
                     </tbody>
                     </table>
                     <hr/>';
                             }
        return($string);
    }

 function LTAlunosPrint() {
        $obj = & get_instance();
        $obj->load->model('banco/bancoprova_model', 'banco', TRUE);
        $obj->load->model('grafico_model', 'grafico', TRUE);
        
        $versao = $obj->banco->prova(array('operacao' => 'FPV', 'codigo' => $this->prova));
        
        foreach($versao as $v){
        $alunos = $obj->grafico->ProvaGrafico(array('operacao' => 'LA', 'prova' => $v['CD_PROVA']));
        
        $string .= '<table width="96%" border="0" cellpadding="4" cellspacing="0" align="center">';
        $string .= '<tr style="background:#CCC">
                           <td align="right" height="25">#</td> 
                           <td> GABARITO DA VERSÃO :: '.$v['NUM_PROVA'].'</td>';
             for($i=0; $i < $alunos[0]['QT']; $i++){
                 $string .= '<td align="center" > '.substr($alunos[0]['GABARITO'],$i,1).'</td>';
             }
        $string .= '   <td align="center">ACERTOS</td>
                       </tr>';
        $j = 1;
                        foreach($alunos as $al){
               $string .= '<tr style="background:#E5E5E5">
                                <td>'.$j.'</td>
                                <td>'.substr($al['NM_ALUNO'],0,50).'</td>';
              for($i=0; $i < $al['QT']; $i++){
                 $string .= '<td align="center" style="background:'.((substr($al['GABARITO'],$i,1) == substr($al['RESPOSTAS'],$i,1)? '#E8F3FF': '#FBE3E6')).'">'.substr($al['RESPOSTAS'],$i,1).'</td>';
             } 
               $string .= '     <td width="50" align="center">'.$al['TOTAL_ACERTOS'].' / '.$al['QT'].'</td>
                            </tr>';
                            $j = $j+1; }
               $string .= '</table><br/>';
        }
        return($string);
    }
    
     
     function LTQuestao() {
        $obj = & get_instance();
        $obj->load->model('grafico_model', 'grafico', TRUE);
        $alunos = $obj->grafico->ProvaGrafico(array('operacao' => 'LA', 'prova' => $this->prova));
        
        $vet = array();
        $res = array();
        
        foreach($alunos as $est){
            for($i=0; $i < $est['QT']; $i++){
                switch(substr($est['RESPOSTAS'],$i,1)){
                    case 'A': 
                        $vet[$i]['QUESTAO']['A'] = $vet[$i]['QUESTAO']['A'] +1;
                    break;
                    case 'B': 
                        $vet[$i]['QUESTAO']['B'] = $vet[$i]['QUESTAO']['B'] +1;
                    break;
                    case 'C': 
                        $vet[$i]['QUESTAO']['C'] = $vet[$i]['QUESTAO']['C'] +1;
                    break;
                    case 'D': 
                        $vet[$i]['QUESTAO']['D'] = $vet[$i]['QUESTAO']['D'] +1;
                    break;
                    case 'E': 
                        $vet[$i]['QUESTAO']['E'] = $vet[$i]['QUESTAO']['E'] +1;
                    break;
                    case 'Z': 
                        $vet[$i]['QUESTAO']['BRANCOS'] = $vet[$i]['QUESTAO']['BRANCOS'] +1;
                    break;
                    case 'W': 
                        $vet[$i]['QUESTAO']['NULOS'] = $vet[$i]['QUESTAO']['NULOS'] +1;
                    break;
                }
              $vet[$i]['GABARITO'] = substr($est['GABARITO'],$i,1);
              $vet[$i]['PROVA'] = $est['CD_PROVA'];
              
              $vet[$i]['ACERTO'] = ((substr($est['GABARITO'],$i,1) == substr($est['RESPOSTAS'],$i,1)? $vet[$i]['ACERTO'] +1: $vet[$i]['ACERTO']+0));
              $vet[$i]['ERROS'] = ((substr($est['GABARITO'],$i,1) != substr($est['RESPOSTAS'],$i,1)? $vet[$i]['ERROS'] +1: $vet[$i]['ERROS']+0));
            }
        }
       // print_r($vet);EXIT();
        
        $string = '<h4 class="panel-title">Desempenho da TURMA por assunto</h4>
                    <hr/>';
        for($i=0; $i < $alunos[0]['QT']; $i++){
        $string .= '<table id="tbl_erro" width="100%" border="0" cellpadding="5" cellspacing="1">
                      <thead>
                        <tr>
                            <td align="left" height="25"><label> #</label></td>
                            
                            <td align="center"> A </td>
                            <td align="center"> B </td>
                            <td align="center"> C </td>
                            <td align="center"> D </td>
                            <td align="center"> E </td>
                            <td align="center"> NULOS </td>
                            <td align="center"> BRANCOS </td>';
                $string .= '
                       </tr>
                     </thead>';
                $total = ($vet[$i]['QUESTAO']['A']+$vet[$i]['QUESTAO']['B']+$vet[$i]['QUESTAO']['C']+$vet[$i]['QUESTAO']['D']+$vet[$i]['QUESTAO']['E']);
          $string .= '<tbody>
                        <tr>
                          <td width="100" height="25">Questão '.($i+1).' </td>
                          <td width="80" align="center" style="background:'.(($vet[$i]['GABARITO'] == 'A')? '#E8F3FF': '').'"><label> '.$this->CalculaPercentual($total,$vet[$i]['QUESTAO']['A']).'% </label></td>
                          <td width="80" align="center" style="background:'.(($vet[$i]['GABARITO'] == 'B')? '#E8F3FF': '').'"><label> '.$this->CalculaPercentual($total,$vet[$i]['QUESTAO']['B']).'% </label></td>
                          <td width="80" align="center" style="background:'.(($vet[$i]['GABARITO'] == 'C')? '#E8F3FF': '').'"><label> '.$this->CalculaPercentual($total,$vet[$i]['QUESTAO']['C']).'% </label></td>
                          <td width="80" align="center" style="background:'.(($vet[$i]['GABARITO'] == 'D')? '#E8F3FF': '').'"><label> '.$this->CalculaPercentual($total,$vet[$i]['QUESTAO']['D']).'% </label></td>
                          <td width="80" align="center" style="background:'.(($vet[$i]['GABARITO'] == 'E')? '#E8F3FF': '').'"><label> '.$this->CalculaPercentual($total,$vet[$i]['QUESTAO']['E']).'% </label></td>
                          <td width="80" align="center"><label> '.$this->CalculaPercentual($total,$vet[$i]['QUESTAO']['NULOS']).'%</label></td>
                          <td width="80" align="center"><label> '.$this->CalculaPercentual($total,$vet[$i]['QUESTAO']['BRANCOS']).'%</label></td>
                     </tr>
                     <!--tr>
                         <td align="center" colspan="8">CONTEUDO</td>
                     </tr-->
                     </tbody>
                     </table>
                     <hr/>';
                             }
        return($string);
    }
}
?>