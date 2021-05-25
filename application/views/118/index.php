

<h3>Página Inicial</h3>
<br>
        <h1>Consulta por período</h1>
        <br>        
        <form action="<?=base_url('118/main/consulta')?>" method="post">
            <table class="table">
                <tr>
                    <td>Data Inicial</td>
                    <td>
                        <input class="form-control" type="date" name="dataInicial" required>
                    </td>
                </tr>
                <tr>
                    <td>Data Final</td>
                    <td>
                        <input class="form-control" type="date" name="dataFinal" required>
                    </td>
                </tr>                                                   
            </table>
            <button class="btn btn-primary" type="submit">Consultar</button>
        </form>
