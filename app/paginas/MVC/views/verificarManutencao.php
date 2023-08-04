<?php
session_start();

require_once '../includes/headerCliente.php';
require_once '../models/veiculo.php';



if (isset($_POST["placa"])) {
    $placa_veiculo = $_POST["placa"];
    $dadosVeiculo = obterDadosVeiculo($placa_veiculo);
    $observacoes = obterObservacoes($placa_veiculo);
    $dataManutencao = obterDataManutencao($placa_veiculo);
    $dataFinal = obterDataFinal($placa_veiculo);
    $tipoServico = obterTipoServico($placa_veiculo);
    $custo = obterCusto($placa_veiculo);
    $sqlEstado = "SELECT estado_do_veiculo FROM veiculos WHERE placa = '$placa_veiculo'";
    $resultadoEstado = $conn->query($sqlEstado);
    $estado = $resultadoEstado->fetch_assoc();
    $estado_do_veiculo = $estado['estado_do_veiculo'];

    $conn->close();
} else {

    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <label for="placa">Placa do Veículo:
        <?php echo $_POST["placa"]; ?>
    </label> <br>
    <input type="hidden" name="placa" value="<?php echo $_POST["placa"]; ?>">
    <label for="estado">Estado:
        <?php echo $estado_do_veiculo; ?>
    </label><br>
    <label for="data_final">No dia:
        <?php echo $dataManutencao; ?>
    </label><br>
    <label for="data_final">Previsão de termino:
        <?php echo $dataFinal; ?>
    </label><br>
    <label for="tipo_servico">Serviço:
        <?php echo $tipoServico ?>
    </label><br>
    <label for="observacoes">Observações:
        <?php echo $observacoes['observacoes']; ?>
    </label><br>
    <label for="custo">Custo:
        <?php echo $custo; ?>
    </label><br>
    <input type="submit" value="Finalizar">
    <input type="button" value="Voltar" onclick="window.location.href='painel.php'">
</body>

</html>