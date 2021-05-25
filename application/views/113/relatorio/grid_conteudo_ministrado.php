<div class="col-lg-12 animated-panel zoomIn no-padding" style="animation-delay: 0.5s;">
    <div class="hpanel hviolet">
        <div class="panel-body">
            <table class='table table-hover'>
                <thead>                    
                    <tr>                        
                        <th class='border-right text-center' valign='center'>COD. AULA</th>
                        <th class='border-right text-center' valign='center'>DATA AULA</th>
                        <th class='border-right text-center' valign='center'>TURMA</th>
                        <th class='border-right text-center' valign='center'>DISCIPLINA</th>
                        <th class='border-right text-center' valign='center'>PROFESSOR</th>
                        <th class='border-right text-center' valign='center'>CONTEÚDO</th>                        
                        <th class='border-right text-center' valign='center'>CONTEÚDO LIVRO</th>                                                
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($conteudos as $conteudo): ?>
                        <tr>                            
                            <td class='text-center'><?= $conteudo['CD_CL_AULA']; ?></td>
                            <td class='text-center'><?= date("d/m/Y", strtotime($conteudo['DT_AULA'])); ?></td>
                            <td class='text-center'><?= $conteudo['CD_TURMA'] ?></td>
                            <td class='text-center'><?= $conteudo['NM_DISCIPLINA'] ?></td>
                            <td class='text-center'><?= $conteudo['NM_PROFESSOR'] ?></td>                            
                            <td><?= $conteudo['CONTEUDO'] ?></td>
                            <td>
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
</div>