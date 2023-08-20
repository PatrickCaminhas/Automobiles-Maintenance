<?php
session_start();

require_once '../../includes/headerCliente.php';
require_once '../../includes/headerView.php';
use app\models\Veiculo;
use app\models\Manutencao;
require_once '../models/Manutencao.php';
require_once '../models/veiculo.php';




if (isset($_POST["placa"])) {
    $placa_veiculo = $_POST["placa"];
    $veiculo = new Veiculo("", "", "", "", "", "");
    $dadosVeiculo = $veiculo->obterDadosVeiculo($placa_veiculo);

    $observacoes = $veiculo->obterObservacoes($placa_veiculo);
    $dataManutencao = $veiculo->obterDataManutencao($placa_veiculo);
    $dataFinal = $veiculo->obterDataFinal($placa_veiculo);
    $tipoServico = $veiculo->obterTipoServico($placa_veiculo);
    $custo = $veiculo->obterCusto($placa_veiculo);
    $sqlEstado = "SELECT estado_do_veiculo FROM veiculos WHERE placa = '$placa_veiculo'";
    $resultadoEstado = $conn->query($sqlEstado);
    $estado = $resultadoEstado->fetch_assoc();
    $estado_do_veiculo = $estado['estado_do_veiculo'];

} else {

    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <?php headerHead(); ?>

    <title>Verificar manutenção</title>
</head>

<body>


    <div class="container-fluid d-flex justify-content-center align-items-center vh-100">
        <div class="col-md-4 border p-4"> <!-- Adicione a classe border e a classe de espaçamento p-4 -->
            <?php headerVieW(); ?>
            <label for="placa">Placa do Veículo:
                <?php echo $_POST["placa"]; ?>
            </label> <br>
            <label for="estado">Estado:
                <?php echo $estado_do_veiculo; ?>
            </label><br>
            <label for="data_final">No dia:
                <?php
                $dataFormatada = date_format(date_create($dataManutencao), 'd/m/Y');
                echo $dataFormatada; ?>
            </label><br>
            <label for="data_final">Previsão de termino:

                <?php
                if ($dataFinal == "0000-00-00") {
                    $dataFormatada = "Ainda não definida";
                } else {
                    $dataFormatada = date_format(date_create($dataFinal), 'd/m/Y');
                }
                echo $dataFormatada; ?>
            </label><br>
            <label for="tipo_servico">Serviço:
                <?php echo $tipoServico ?>
            </label><br>
            <label for="observacoes">Observações:
                <?php echo $observacoes['observacoes']; ?>
            </label><br>
            <label for="custo">Custo:
                <?php echo "R$" . $custo; ?>
            </label><br>
            <input type="button" value="Voltar" class="btn btn-primary" onclick="window.location.href='painel.php'">
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa"
        crossorigin="anonymous"></script>

</body>

</html>