<div class="container" style="font-family: Arial, Helvetica, sans-serif">    
    <div class="text-center" style="padding: 20px">
        <table class="table table-bordered" >
            <thead>
                <tr>
                    <th class="text-center">DATA PENDÊNCIA</th>
                    <th class="text-center">DATA SOLICITAÇÃO</th>                    
                    <th class="text-center">PROFESSOR</th>
                    <th class="text-center">MOTIVO</th>
                    <th class="text-center">DESCRIÇÃO</th>
                    <th class="text-center">SITUAÇÃO</th>                    
                </tr>
            </thead>

            <tbody>
                <?php foreach ($registros as $row) : ?>
                    <tr>                        
                        <td style="padding: 0 15px" class="text-center"><?= date('d/m/Y', strtotime($row->DT_PENDENCIA)) ?></td>
                        <td style="padding: 0 15px" class="text-center"><?= date('d/m/Y', strtotime($row->DT_SOLICITACAO)) ?></td>
                        <td style="padding: 0 15px; width: 25%" class="text-center"><?= $row->NM_PROFESSOR ?></td>
                        <td style="padding: 0 15px" class="text-center"><?= $row->NM_MOTIVO ?></td>
                        <td style="padding: 0 15px; width: 35%" class="text-justify"><?= $row->DS_SOLICITACAO ?></td>
                        <td style="padding: 0 15px" class="text-center"><?= $row->DS_FL_STATUS ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>