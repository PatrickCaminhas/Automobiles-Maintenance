<?php
session_start();

// Verifique se o usuário está autenticado, se não redirecione para a página de login
require_once '../includes/headerCliente.php';


// Obtém o nome do usuário autenticado
$user_nome = $_SESSION["user_nome"];

$conn = conectarBancoDados();
$sql_consulta_veiculos = "SELECT id, placa, marca, modelo, ano, estado_do_veiculo FROM veiculos WHERE proprietario_id = $user_id";
$resultado_veiculos = $conn->query($sql_consulta_veiculos);






?>

<!DOCTYPE html>
<html>

<head>
    <title>Painel - Sistema de Acompanhamento</title>
</head>

<body>
    <h2>Bem-vindo,
        <?php echo $user_nome; ?>!
    </h2>
    <p>Esta é a página do painel do usuário proprietário.</p>
    <?php
    // Verifique se o usuário possui veículos cadastrados
    if ($resultado_veiculos->num_rows == 0) {
        echo "<p>Você ainda não possui veículos cadastrados.</p>";
    } else {
        ?>
        <h3>Seus veículos</h3>

        <table>
            <tr>
                <th>Placa</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Ano</th>
                <th>Estado</th>
                <th>Ação</th>

            </tr>
            <?php
            // Loop para exibir os veículos na tabela
            while ($veiculo = $resultado_veiculos->fetch_assoc()) {
                $placa = $veiculo['placa'];
                $marca = $veiculo['marca'];
                $modelo = $veiculo['modelo'];
                $ano = $veiculo['ano'];
                $estado = $veiculo['estado_do_veiculo'];
                $sql_consulta_manutecao = "SELECT * FROM manutencoes WHERE placa = '$placa' AND estado_do_veiculo != 'Entregue ao proprietario' AND data_manutencao = (SELECT MAX(data_manutencao) FROM manutencoes WHERE placa = '$placa')";

                echo "<tr>";
                echo "<td>$placa</td>";
                echo "<td>$marca</td>";
                echo "<td>$modelo</td>";
                echo "<td>$ano</td>";
                echo "<td>$estado</td>";
                echo "<td>
                <form action='verificarManutencao.php' method='post'>
                <input type='hidden' name='placa' value='$placa'>
                 <input type='submit' value='Verificar' ";
                 ?>
                 <?php
                    $resultado_manutencao = $conn->query($sql_consulta_manutecao);
                    if ($resultado_manutencao->num_rows == 0) {
                        echo "disabled";
                    }
                 
                 
                 echo " ></form></td>";
                echo "</tr>";
            }
            ?>
        </table>

        <a href="agendamentoManutencao.php">Agendar entrega para manutenção</a> <br>
        <a href="cancelamentoDeAgendamento.php">Cancelar agendamento de entrega</a> <br>
        <?php
    }
    ?>
    <a href="cadastroVeiculo.php">Cadastrar veiculo</a> <br>
    <a href="alteracaoVeiculo.php">Alterar veiculo</a> <br>
    <a href="../controllers/logout.php">Logout</a>
</body>

</html>