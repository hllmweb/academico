<br>
<h1 class="text-center">Lista de pessoas por período</h1>
<br>
<table class="table table-striped table-bordered table-responsive" >

    <tr class="text-center">
        <td>DATA</td>
        <td>COLABORADOR</td>  
        <td>ALUNO</td>                
        <td>VISITANTE</td>  
        <td>TOTAL</td>  
    </tr>
    
    <?php 
    
         foreach ($registros as $registro):
    ?>
        <tr class="text-center">
            <td><?= $registro['DATA'] ?></td>
            <td><?= $registro['TOTAL_COLABORADOR'] ?></td>
            <td><?= $registro['TOTAL_ALUNO'] ?></td>
            <td><?= $registro['TOTAL_VISITANTES'] ?></td>
            <td><?= $registro['TOTAL'] ?></td>            
        </tr>
    <?php
         endforeach
    ?>
</table>

<a class="btn btn-primary" href="<?= base_url("/118/main")?>">Nova Consulta</a>
