<?
$sistema = array();
foreach ($listar as $row) {
    $sistema[] = $row->DC_SISTEMA;
}
$sistema = array_keys(array_flip($sistema));
?>

<style>
    table{
        margin:5px; 
        width:98%;
    }
    table tr{
        height: 25px
    }
    table thead tr td{
        padding: 5px;
        background-color: #999999
    }
    table tbody tr td{
        padding: 2px;
        background-color:#C9DAE1
    }
</style>

<? foreach ($sistema as $sis) { ?>
    <table cellspacing="0" cellpadding="0">
        <caption>SISTEMA { <strong><?= $sis ?></strong> }</caption>
        <thead>
            <tr>
                <td>CÓDIGO</td>
                <td>PROGRAMA</td>
                <td>FORMULÁRIO</td>
            </tr>
        </thead>
        <tbody>
        <? foreach ($listar as $row) {
            if ($sis == $row->DC_SISTEMA) {
                ?>
                <tr>
                    <td><?= $row->CD_PROGRAMA ?></td>
                    <td width="70%"><?= $row->NM_PROGRAMA ?></td>
                    <td width="25%"><?= $row->FORMULARIO ?></td>
                </tr>
        <? } } ?>
        <tbody>
    </table>
<? } ?>