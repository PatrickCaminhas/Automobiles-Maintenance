<?php
session_start();

// Verificar se o usuário está logado como funcionário
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'funcionario') {
    header("Location: index.php"); // Redirecionar para a página de login se não estiver logado como funcionário
    exit;
}

require_once 'conexao.php';

// Função para obter os dados do veículo pelo ID
function obterDadosVeiculo($id)
{
    $conn = conectarBancoDados();
    $id_veiculo = mysqli_real_escape_string($conn, $id);
    $sql = "SELECT v.id as veiculo_id, p.nome as proprietario_nome, p.telefone as proprietario_telefone,
            v.marca, v.modelo, v.ano, v.placa, v.estado_do_veiculo
            FROM veiculos v
            INNER JOIN proprietarios p ON v.proprietario_id = p.id
            WHERE v.id = $id_veiculo";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows == 1) {
        $dadosVeiculo = $resultado->fetch_assoc();
    } else {
        $dadosVeiculo = null;
    }

    $conn->close();
    return $dadosVeiculo;
}

// Função para atualizar os dados do veículo
function atualizarDadosVeiculo($id, $estado, $tipo_servico, $pecas_utilizadas, $observacoes, $custo)
{
    $conn = conectarBancoDados();
    $id_veiculo = mysqli_real_escape_string($conn, $id);
    $estado_veiculo = mysqli_real_escape_string($conn, $estado);
    $tipo_servico = mysqli_real_escape_string($conn, $tipo_servico);
    $pecas_utilizadas = mysqli_real_escape_string($conn, $pecas_utilizadas);
    $observacoes = mysqli_real_escape_string($conn, $observacoes);
    $custo = mysqli_real_escape_string($conn, $custo);

    $sql = "UPDATE veiculos SET estado_do_veiculo = '$estado_veiculo', tipo_servico = '$tipo_servico',
            pecas_utilizadas = '$pecas_utilizadas', observacoes = '$observacoes', custo = '$custo'
            WHERE id = $id_veiculo";

    if ($conn->query($sql) === TRUE) {
        header("Location: listarVeiculos.php");
        exit;
    } else {
        echo "Erro ao atualizar os dados do veículo: " . $conn->error;
    }

    $conn->close();
}

// Obter os dados do veículo pelo ID passado na URL
if (isset($_GET["id"])) {
    $id_veiculo = $_GET["id"];
    $dadosVeiculo = obterDadosVeiculo($id_veiculo);
} else {
    header("Location: listarVeiculos.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Alterar Veículo - Sistema de Acompanhamento</title>
</head>
<body>
    <h2>Alterar Veículo</h2>
    <?php if ($dadosVeiculo) { ?>
        <form action="alterarVeiculo.php" method="post">
            <input type="hidden" name="veiculo_id" value="<?php echo $dadosVeiculo['veiculo_id']; ?>">
            <label for="marca">Marca:</label>
            <input type="text" id="marca" name="marca" value="<?php echo $dadosVeiculo['marca']; ?>" readonly><br>

            <label for="modelo">Modelo:</label>
            <input type="text" id="modelo" name="modelo" value="<?php echo $dadosVeiculo['modelo']; ?>" readonly><br>

            <label for="ano">Ano:</label>
            <input type="number" id="ano" name="ano" value="<?php echo $dadosVeiculo['ano']; ?>" readonly><br>

            <label for="placa">Placa:</label>
            <input type="text" id="placa" name="placa" value="<?php echo $dadosVeiculo['placa']; ?>" readonly><br>

            <label for="estado">Estado:</label>
            <input type="text" id="estado" name="estado" value="<?php echo $dadosVeiculo['estado_do_veiculo']; ?>" required><br>

            <label for="tipo_servico">Tipo de Serviço:</label>
            <input type="text" id="tipo_servico" name="tipo_servico" required><br>

            <label for="pecas_utilizadas">Peças Utilizadas:</label>
            <input type="text" id="pecas_utilizadas" name="pecas_utilizadas" required><br>

            <label for="observacoes">Observações:</label>
            <textarea id="observacoes" name="observacoes" rows="4" cols="50" required></textarea><br>

            <label for="custo">Custo:</label>
            <input type="number" id="custo" name="custo" required><br>

            <input type="submit" value="Atualizar">
        </form>
    <?php } else { ?>
        <p>Veículo não encontrado.</p>
    <?php } ?>
</body>
</html>
