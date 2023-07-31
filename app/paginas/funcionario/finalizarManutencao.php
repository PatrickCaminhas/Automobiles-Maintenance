<?php
session_start();

// Verificar se o usuário está logado como funcionário
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'funcionario') {
    header("Location: ../index.php"); // Redirecionar para a página de login se não estiver logado como funcionário
    exit;
}

require_once '../funcoes/conexao.php';
require_once '../funcoes/veiculo.php';

$conn = conectarBancoDados();
// Função para obter os dados do veículo pelo ID

// Obter os dados do veículo pelo ID passado na URL
if (isset($_POST["placa"])) {
    $placa_veiculo = $_POST["placa"];
    $dadosVeiculo = obterDadosVeiculo($placa_veiculo, $conn);
    $observacoes = obterObservacoes($placa_veiculo, $conn);
    $dataManutencao = obterDataManutencao($placa_veiculo, $conn);
    $tipoServico = obterTipoServico($placa_veiculo, $conn);
    $custo = obterCusto($placa_veiculo, $conn);
    $sqlEstado = "SELECT estado_do_veiculo FROM veiculos WHERE placa = '$placa_veiculo'";
    $resultadoEstado = $conn->query($sqlEstado);
    $estado = $resultadoEstado->fetch_assoc();
    $estado_do_veiculo = $estado['estado_do_veiculo'];
    
    $conn->close();
} else {
    header("Location: listarVeiculos.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Atualizar Manutenção - Sistema de Acompanhamento</title>
</head>

<body>
    <h2>Entrega de veiculo</h2>
    <?php if ($dadosVeiculo) { ?>
        <form action="../funcoes/manutencoes.php?funcao=finalizarManutencao" method="POST">
            <h3>Você tem certeza que quer entregar o veiculo:</h3>
            <label for="placa">Placa do Veículo: <?php echo $_POST["placa"]; ?></label> <br>
            <input type="hidden" name="placa" value="<?php echo $_POST["placa"]; ?>">
            <label for="estado">Estado: <?php echo $estado_do_veiculo; ?> </label><br>
            <label for="data_final">No dia: <?php echo date("d-m-Y"); ?></label><br>
            <label for="tipo_servico">Serviço: <?php echo $tipoServico ?></label><br>
            <label for="observacoes">Observações: <?php echo $observacoes['observacoes']; ?></label><br>
            <label for="custo">Custo: <?php echo $custo; ?></label><br>
            <input type="submit" value="Finalizar">
            <input type="button" value="Voltar" onclick="window.location.href='listarVeiculos.php'">

        </form>
    <?php } else { ?>
        <p>Veículo não encontrado.</p>
    <?php } ?>




</body>

</html>