<?php
session_start();

// Verificar se o usuário está logado como funcionário
require_once '../includes/headerFuncionario.php';

require_once '../models/veiculo.php';

$conn = conectarBancoDados();
// Função para obter os dados do veículo pelo ID

// Obter os dados do veículo pelo ID passado na URL
if (isset($_POST["placa"])) {
    $placa_veiculo = $_POST["placa"];
    $dadosVeiculo = obterDadosVeiculo($placa_veiculo);
    $observacoes = obterObservacoes($placa_veiculo);
    $dataManutencao = obterDataManutencao($placa_veiculo);
    $tipoServico = obterTipoServico($placa_veiculo);
    $custo = obterCusto($placa_veiculo);
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
        <form action="../controllers/manutencoesController.php?funcao=finalizarManutencao" method="POST">
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