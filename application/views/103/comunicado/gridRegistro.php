<table id="tblregistros" class="display table table-hover">
    <thead>
        <tr>            
            <th class="text-center">CÓDIGO</th>                        
            <th class="text-center">DESTINATÁRIO</th>            
            <th class="text-center">DATA</th>                  
            <th class="text-center">TÍTULO</th>            
            <th class="text-center">MENSAGEM</th>            
            <th class="text-center">COMUNICADO LIDO</th>            
            <th class="text-center">AÇÕES</th>                        
        </tr>
    </thead>

    <tbody>
        <?php foreach ($registros as $row) { ?>
            <tr> 
                <td class="text-center"><?= $row->CD_COMUNICADO ?></td>                
                <td class="text-center"><?= $row->NM_DESTINATARIO ?></td>                
                <td class="text-center"><?= date('d/m/Y', strtotime($row->DT_ENVIO)) ?></td>                
                <td class="text-center"><?= $row->DS_TITULO ?></td>                
                <td class="text-center"><?= mb_substr($row->DS_MENSAGEM, 0, 100) ?></td>                
                <td class="text-center"><?= $row->FLG_LIDO === "S" ? "SIM" : "NÃO" ?></td>
                <td class="text-center">  
                    <a href="<?= base_url($this->session->userdata('SGP_SISTEMA') . '/comunicado/modalRegistro/V-' . $row->CD_COMUNICADO) ?>" data-toggle="frmModalRegistro" class="btn btn-labeled btn-info btn-xs">
                        <i class="fa fa-search-plus"></i> Detalhes
                    </a>
                </td>
            </tr>                        
        <? } ?>
    </tbody>    
</table>