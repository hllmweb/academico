<br>
<h1 class="text-center">Lista de pessoas por período</h1>
<br>
<table class="table table-striped table-bordered table-responsive">

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
<table class="table">
<tr>
    <td>
        <a class="btn btn-primary" href="<?= base_url("/118/main")?>">Nova Consulta</a>
        <br>    
        </td>
        <td align='right'>
        <form action="<?=base_url('118/main/consulta')?>" method="post">
            <input type="hidden" name="dataInicial" value ="<?= $dataInicial?>">
            <input type="hidden" name="dataFinal" value ="<?= $dataFinal?>">
            <input type="hidden" name="tipo" value ="1">
            <button class="btn btn-primary" type="submit">Exportar</button>
        </form>
    </td>
</tr>
</table>