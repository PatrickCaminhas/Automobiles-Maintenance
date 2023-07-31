<?php
session_start();
require_once '../funcoes/conexao.php';

// Verifique se o usuário está autenticado, se não redirecione para a página de login
if (!isset($_SESSION["user_id"]) || $_SESSION['user_role'] !== 'proprietario') {
    header("Location: ../index.php");
    exit;
}

// Obtém o nome do usuário autenticado
$user_nome = $_SESSION["user_nome"];
$user_id = $_SESSION['user_id'];
$conn = conectarBancoDados();
$sql_consulta_veiculos = "SELECT id, placa, marca, modelo, ano, estado_do_veiculo FROM veiculos WHERE proprietario_id = $user_id";
$resultado_veiculos = $conn->query($sql_consulta_veiculos);
$conn->close();

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

            </tr>
            <?php
            // Loop para exibir os veículos na tabela
            while ($veiculo = $resultado_veiculos->fetch_assoc()) {
                $placa = $veiculo['placa'];
                $marca = $veiculo['marca'];
                $modelo = $veiculo['modelo'];
                $ano = $veiculo['ano'];
                $estado = $veiculo['estado_do_veiculo'];

                echo "<tr>";
                echo "<td>$placa</td>";
                echo "<td>$marca</td>";
                echo "<td>$modelo</td>";
                echo "<td>$ano</td>";
                echo "<td>$estado</td>";
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
    <a href="excluirVeiculo.php">Excluir veiculo</a> <br>
    <a href="../logout.php">Logout</a>
</body>

</html>