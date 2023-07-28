<?php
session_start();
        require_once 'conexao.php';
        $conn = conectarBancoDados();
        if (!isset($_SESSION["user_id"]) || $_SESSION['user_role'] !== 'proprietario') {
            header("Location: index.php");
            exit;
        }
        $user_id = $_SESSION['user_id'];
        
        ?>
<!DOCTYPE html>
<html>
<head>
    <title>Agendar Manutenção - Sistema de Acompanhamento</title>
</head>
<body>
    <h2>Agendar entrega para manutenção</h2>
    <form action="agendarManutencao.php" method="post">
        <label for="placa">Placa do Veículo:</label>
        <select id="placa" name="placa" required>
            <option value="" data-default disabled selected></option>
            <?php
            
            // Aqui você pode realizar uma consulta para obter as placas dos veículos disponíveis para agendamento
            // e preencher as opções do select com essas placas.
            // Exemplo: SELECT placa FROM veiculos WHERE estado_do_veiculo = 'livre para busca';
            $sql_consulta_placas = "SELECT id, placa, marca, modelo, ano FROM veiculos WHERE proprietario_id = $user_id";
            $resultado_placas = $conn->query($sql_consulta_placas);

        // Mostra as opções do select com as placas dos veículos
        while ($veiculo = $resultado_placas->fetch_assoc()) {
            $id_veiculo = $veiculo['id'];
            $placa_veiculo = $veiculo['placa'];
            $marca = $veiculo['marca'];
            $modelo = $veiculo['modelo'];
            $ano = $veiculo['ano'];
            $selected = ($veiculo_id == $id_veiculo) ? 'selected' : '';

            echo "<option value='$placa_veiculo' $selected>$placa_veiculo | $marca | $modelo | $ano</option>";
        }
        $conn->close();
        ?>
            ?>
        </select><br>

        <label for="data_manutencao">Data da Manutenção:</label>
        <input type="date" id="data_manutencao" name="data_manutencao" required ><br>

        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao" rows="4" cols="50" required></textarea><br>
        <input type="hidden" name="placa" id="placa-selecionada" value="">
        <input type="submit" value="Agendar">
        <input type="reset" value="Limpar">
        <input type="button" value="Voltar" onclick="window.location.href='painel.php'">
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
</body>
</html>
