<?php
session_start();

// Verificar se o usuário está logado como funcionário
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'funcionario') {
    header("Location: index.php"); // Redirecionar para a página de login se não estiver logado como funcionário
    exit;
}

require_once 'conexao.php';

// Função para obter a lista de veículos com estados diferentes de "Com proprietário" e "Disponível para retirada"
function obterListaVeiculos()
{
    $conn = conectarBancoDados();
    $sql = "SELECT v.id as veiculo_id, p.nome as proprietario_nome, p.telefone as proprietario_telefone,
            v.marca, v.modelo, v.ano, v.placa, v.estado_do_veiculo
            FROM veiculos v
            INNER JOIN proprietarios p ON v.proprietario_id = p.id
            WHERE v.estado_do_veiculo NOT IN ('Com proprietario', 'Disponivel para retirada')";
    $resultado = $conn->query($sql);
    $listaVeiculos = array();

    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $listaVeiculos[] = $row;
        }
    }

    $conn->close();
    return $listaVeiculos;
}

$listaVeiculos = obterListaVeiculos();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Alteração de Estados dos Veículos - Sistema de Acompanhamento</title>
</head>
<body>
    <h2>Veículos</h2>
    <table>
        <tr>
            <th>Proprietário</th>
            <th>Celular</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Ano</th>
            <th>Placa</th>
            <th>Estado</th>
            <th>Ação</th>
        </tr>
        <?php foreach ($listaVeiculos as $veiculo) { ?>
            <tr>
                <td><?php echo $veiculo['proprietario_nome']; ?></td>
                <td><?php echo $veiculo['proprietario_telefone']; ?></td>
                <td><?php echo $veiculo['marca']; ?></td>
                <td><?php echo $veiculo['modelo']; ?></td>
                <td><?php echo $veiculo['ano']; ?></td>
                <td><?php echo $veiculo['placa']; ?></td>
                <td><?php echo $veiculo['estado_do_veiculo']; ?></td>
                <td><a href="alterarEstadoVeiculo.php?id=<?php echo $veiculo['veiculo_id']; ?>">Alterar</a></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
