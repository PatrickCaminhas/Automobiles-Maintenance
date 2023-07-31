<?php
session_start();

// Verificar se o usuário está logado como funcionário
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'funcionario') {
    header("Location: ../index.php"); // Redirecionar para a página de login se não estiver logado como funcionário
    exit;
}

require_once '../funcoes/conexao.php';
require_once '../funcoes/veiculo.php';
// Função para obter a lista de veículos com estados diferentes de "Com proprietário" e "Disponível para retirada"


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
            <th>Finalizar</th>
        </tr>
        <?php foreach ($listaVeiculos as $veiculo) { ?>
            <tr>


                <td>
                    <?php echo $veiculo['proprietario_nome']; ?>
                </td>
                <td>
                    <?php echo $veiculo['proprietario_telefone']; ?>
                </td>
                <td>
                    <?php echo $veiculo['marca']; ?>
                </td>
                <td>
                    <?php echo $veiculo['modelo']; ?>
                </td>
                <td>
                    <?php echo $veiculo['ano']; ?>
                </td>
                <td>
                    <?php echo $veiculo['placa']; ?>

                </td>
                <td>
                    <?php echo $veiculo['data_manutencao']; ?>
                </td>
                <td>
                    <?php echo $veiculo['previsaoTermino']; ?>
                </td>
                <td>
                    <?php echo $veiculo['tipo_servico']; ?>
                </td>
                <td>R$
                    <?php echo $veiculo['custo']; ?>
                </td>
                <td>
                    <?php echo $veiculo['estado_manutencao']; ?>
                </td>
                <td>
                    <form action="atualizarManutencao.php" method="post">
                        <input type="hidden" name="placa" value="<?php echo $veiculo['placa']; ?>">
                        <input type="submit" value="Alterar"<?php
                           if ($veiculo['estado_manutencao'] == "Manutenção concluída") {
                               echo "disabled";
                           }
                           ?>>
                    </form>
                </td>
                <td>
                    <form action="finalizarManutencao.php" method="post">
                        <input type="hidden" name="placa" value="<?php echo $veiculo['placa']; ?>">
                        <input type="submit" value="Finalizar" <?php
                           if ($veiculo['estado_manutencao'] != "Manutenção concluída") {
                               echo "disabled";
                           }
                           ?>>
                    </form>
                </td>



            </tr>


        <?php } ?>
    </table>
    <button onclick="window.location.href = 'painelFuncionario.php';">Voltar</button>
</body>

</html>