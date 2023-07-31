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
    <h2>Cancelamento de entrega</h2>
    <?php
     $sql_consulta_placas = "SELECT id, placa, marca, modelo, ano FROM veiculos WHERE proprietario_id = $user_id AND estado_do_veiculo LIKE 'Entrega agendada para o dia:%'";
     $resultado_placas = $conn->query($sql_consulta_placas);
     if($resultado_placas->num_rows == 0){
         echo "Não há agendamentos para cancelar";
     }
        else{
        
    ?>
    <form action="manutencoes.php?funcao=cancelarAgendamento" method="post">
        <label for="placa">Placa do Veículo:</label>
        <select id="placa" name="placa" required>
            <option value="" data-default disabled selected></option>
            <?php
        
            // Aqui você pode realizar uma consulta para obter as placas dos veículos disponíveis para agendamento
            // e preencher as opções do select com essas placas.
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
            
        </select><br>
    
        

        
        <input type="submit" value="Cancelar">
        <input type="reset" value="Limpar">
        <?php
        }
        ?>
        <br>
        <input type="button" value="Voltar" onclick="window.location.href='painel.php'">
    </form>

    
</body>
</html>
