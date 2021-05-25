<?php

$arquivo = 'planilha.xls';

$html .= '<br>';

$html .= '<br>';
$html .= '<table class="table table-striped table-bordered table-responsive" >';

$html .= '<tr class="text-center">';
$html .= '<td>DATA</td>';
$html .= '<td>COLABORADOR</td>';
$html .= '<td>ALUNO</td>';                
$html .= '<td>VISITANTE</td>';
$html .= '<td>TOTAL</td>';
$html .= '</tr>';
    
         foreach ($registros as $registro)
            {
                $html .= '<tr class="text-center">';
                $html .= '<td>'.$registro['DATA'].'</td>';
                $html .= '<td>'.$registro['TOTAL_COLABORADOR'].'</td>';
                $html .= '<td>'.$registro['TOTAL_ALUNO'].'</td>';
                $html .= '<td>'.$registro['TOTAL_VISITANTES'].'</td>';
                $html .= '<td>'.$registro['TOTAL'].'</td>';
                $html .= '</tr>';
            }
    
         $html .= '</table>';

header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/x-msexcel");
header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
header ("Content-Description: PHP Generated Data" );
//Envia o conteúdo do arquivo
echo $html;
exit;

