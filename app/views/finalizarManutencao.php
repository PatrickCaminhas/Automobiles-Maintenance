<?php
session_start();

// Verificar se o usuário está logado como funcionário
require_once '../../includes/headerFuncionario.php';
require_once '../../includes/headerView.php';
require_once '../models/veiculo.php';

$databaseConnection = DatabaseConnection::getInstance();
$conn = $databaseConnection->getConnection();
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
    
} else {
    header("Location: listarVeiculos.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Atualizar Manutenção - Sistema de Acompanhamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

</head>

<body>

<div class="container-fluid d-flex justify-content-center align-items-center vh-100">
        <div class="col-md-4 border p-4"><?php headerVieW();?>
    <h2>Entrega de veiculo</h2>
    <?php if ($dadosVeiculo) { ?>
        <form action="../controllers/manutencoesController.php?funcao=finalizarManutencao" method="POST">
            <h3>Você tem certeza que quer entregar o veiculo:</h3>
            <label for="placa">Placa do Veículo: <?php echo $_POST["placa"]; ?></label> <br>
            <input type="hidden" name="placa" value="<?php echo $_POST["placa"]; ?>">
            <label for="estado">Estado: <?php echo $estado_do_veiculo; ?> </label><br>
            <input type="hidden" name="data_manutencao" value="<?php echo date("Y-m-d"); ?>">
            <label for="data_final">No dia: <?php echo date("d-m-Y"); ?></label><br>
            <label for="tipo_servico">Serviço: <?php echo $tipoServico ?></label><br>
            <label for="observacoes">Observações: <?php echo $observacoes['observacoes']; ?></label><br>
            <label for="custo">Custo: <?php echo $custo; ?></label><br>
            <input type="submit" value="Finalizar"class="fw-medium btn btn-primary">
            <input type="button" value="Voltar" class="fw-medium btn btn-primary" onclick="window.location.href='listarVeiculos.php'">

        </form>
    <?php } else { ?>
        <p>Veículo não encontrado.</p>
    <?php } ?>

</div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>

</body>

</html>