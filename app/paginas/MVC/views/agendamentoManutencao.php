<?php
session_start();
require_once '../includes/headerCliente.php';
require_once '../includes/headerView.php';

?>
<!DOCTYPE html>
<html>

<head>
    <title>Agendar Manutenção - Sistema de Acompanhamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

</head>

<body>



<div class="container-fluid d-flex justify-content-center align-items-center vh-100">
   
        <div class="col-md-4 border p-4">
             <?php headerVieW();?> <!-- Adicione a classe border e a classe de espaçamento p-4 -->
    <h2>Agendar entrega para manutenção</h2>
    <?php
    // Aqui você pode realizar uma consulta para obter as placas dos veículos disponíveis para agendamento
    $sql_consulta_placas = "SELECT id, placa, marca, modelo, ano FROM veiculos WHERE proprietario_id = $user_id AND estado_do_veiculo = 'Com proprietário'";
    $resultado_placas = $conn->query($sql_consulta_placas);
    if ($resultado_placas->num_rows == 0) {
        echo "Não há veiculos disponiveis";
        ?>
        <br>
        <input type="button" value="Voltar" class="fw-medium btn btn-primary mb-3" onclick="window.location.href='painel.php'">
        <?php
    } else {
    ?>
    <form action="../controllers/manutencoesController.php?funcao=agendaManutencao" method="post" >
        <label for="placa">Placa do Veículo:</label>
        <select id="placa" name="placa" class="form-control" required>
            <option value="" data-default disabled selected></option>
            <?php

            // Exemplo: SELECT placa FROM veiculos WHERE estado_do_veiculo = 'livre para busca';
           

            // Mostra as opções do select com as placas dos veículos
            while ($veiculo = $resultado_placas->fetch_assoc()) {
                $id_veiculo = $veiculo['id'];
                $placa = $veiculo['placa'];
                $marca = $veiculo['marca'];
                $modelo = $veiculo['modelo'];
                $ano = $veiculo['ano'];
                $selected = ($veiculo_id == $id_veiculo) ? 'selected' : '';

                echo "<option value='$placa' $selected>$placa | $marca | $modelo | $ano</option>";
            }
            $conn->close();
            ?>
            ?>
        </select><br>

        <label for="data_manutencao">Data da Manutenção:</label>
        <input type="date" id="data_manutencao" name="data_manutencao" class="form-control" required><br>


        <input type="submit" value="Agendar" class="btn btn-primary">
        <input type="reset" value="Limpar" class="btn btn-primary">
        <input type="button" value="Voltar" class="btn btn-primary" onclick="window.location.href='painel.php'">
        <?php
            }
            ?>
    </form>

    <script>
        // Obtém a referência ao elemento de data da manutenção
        const dataManutencaoInput = document.getElementById('data_manutencao');

        // Obtém a data atual
        const dataAtual = new Date();

        // Adiciona um dia à data atual para obter a data mínima permitida
        dataAtual.setDate(dataAtual.getDate() + 1);

        // Converte a data mínima para o formato aceito pelo campo de data (AAAA-MM-DD)
        const dataMinima = dataAtual.toISOString().split('T')[0];

        // Define a data mínima no campo de data
        dataManutencaoInput.setAttribute('min', dataMinima);
    </script>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>

</body>

</html>