<?php
session_start();

// Verificar se o usuário está logado como funcionário
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'funcionario') {
    header("Location: ../index.php"); // Redirecionar para a página de login se não estiver logado como funcionário
    exit;
}

require_once '../conexao.php';

// Função para obter a lista de veículos com estados diferentes de "Com proprietário" e "Disponível para retirada"
function obterListaVeiculos()
{
    $conn = conectarBancoDados();
    $sql = "SELECT p.nome as proprietario_nome, p.telefone as proprietario_telefone,
    v.marca, v.modelo, v.ano, v.placa, v.estado_do_veiculo,
    m.data_manutencao, m.previsaoTermino, m.tipo_servico, m.custo
FROM veiculos v
INNER JOIN proprietarios p ON v.proprietario_id = p.id
LEFT JOIN manutencoes m ON v.placa = m.placa
WHERE v.estado_do_veiculo NOT IN ('Com proprietario', 'Disponivel para retirada');
";
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
    <title>Alteração de Estados de Manutenção - Sistema de Acompanhamento</title>
</head>
<body>
    <h2>Alteração de manuteções</h2>
    
    <table>
        <tr>
            <th>Proprietário</th>
            <th>Celular</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Ano</th>
            <th>Placa</th>
            <th>Data da ultima atualização</th>
            <th>Previsão de Término</th>
            <th>Tipo de Serviço</th>
            <th>Custo</th>
            <th>Estado</th>
            <th>Ação</th>
        </tr>
        <?php foreach ($listaVeiculos as $veiculo) { ?>
            <tr><form action="atualizarManutencao.php" method="post">
                <td><?php echo $veiculo['proprietario_nome']; ?></td>
                <td><?php echo $veiculo['proprietario_telefone']; ?></td>
                <td><?php echo $veiculo['marca']; ?></td>
                <td><?php echo $veiculo['modelo']; ?></td>
                <td><?php echo $veiculo['ano']; ?></td>
                <td><?php echo $veiculo['placa']; ?>
                <input type="hidden" name="placa" value="<?php echo $veiculo['placa']; ?>">
                </td>
                
                
                <td><?php echo $veiculo['data_manutencao']; ?></td>
                <td><?php echo $veiculo['previsaoTermino']; ?></td>
                <td><?php echo $veiculo['tipo_servico']; ?></td>
                <td>R$ <?php echo $veiculo['custo']; ?></td>
                <td><?php echo $veiculo['estado_do_veiculo']; ?></td>
                <td><input type="submit" value="Alterar"> </td>
                

            </form>    
            </tr>

        
        <?php } ?>
    </table>
<button onclick="window.location.href = 'painelFuncionario.php';">Voltar</button>
</body>
</html>
