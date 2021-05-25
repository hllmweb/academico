<div class="col-lg-12">
    <div class="panel panel-primary">
        <table class='table table-hover table-striped table-bordered'>
            <thead>                
                <tr class="panel-heading">
                    <th class="text-center" colspan="3">LISTA DE CONTEÚDOS</th>
                </tr>

                <tr class="panel-heading">                                        
                    <th class='border-right text-center' valign='center'>DATA AULA</th>                                
                    <th class='border-right text-center' valign='center'>CONTEÚDO</th>                        
                    <th class='border-right text-center' valign='center'>CONTEÚDO LIVRO</th>                                                
                </tr>
            </thead>

            <tbody>
                <?php foreach ($conteudos as $conteudo): ?>
                    <tr>                           
                        <td class="col-sm-2 text-center"><?= date("d/m/Y", strtotime($conteudo['DT_AULA'])); ?></td>
                        <td class="col-sm-5" style="padding: 5px"><?= $conteudo['CONTEUDO'] ?></td>
                        <td class="col-sm-5">
                            <ul>
                                <?php foreach ($conteudo['AULA_ASSUNTO_LIVRO'] as $row): ?>                                            
                                    <?php if (!empty($row)) : ?>
                                        <li><?= $row['DC_ASSUNTO'] ?></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </td>                            
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>