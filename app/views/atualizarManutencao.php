<?php
session_start();

// Verificar se o usuário está logado como funcionário


require_once '../../includes/headerFuncionario.php';
require_once '../../includes/headerView.php';
use app\models\Veiculo;

require_once '../models/Veiculo.php';


// Função para obter os dados do veículo pelo ID

// Obter os dados do veículo pelo ID passado na URL
if (isset($_POST["placa"])) {

    $veiculo = new veiculo("", "", "", "", "", "");
    $placa_veiculo = $_POST["placa"];
    $dadosVeiculo = $veiculo->obterDadosVeiculo($placa_veiculo);
    $observacoes = $veiculo->obterObservacoes($placa_veiculo);
    $dataManutencao = $veiculo->obterDataManutencao($placa_veiculo);
    $tipoServico = $veiculo->obterTipoServico($placa_veiculo);
    $custo = $veiculo->obterCusto($placa_veiculo);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <?php headerHead(); ?>

</head>

<body>


    <div class="container-fluid d-flex justify-content-center align-items-center vh-100">
        <div class="col-md-4 border p-4"> <!-- Adicione a classe border e a classe de espaçamento p-4 -->
            <?php headerVieW(); ?>
            <h2>Atualizar Manutenção</h2>
            <?php if ($dadosVeiculo) { ?>
                <form action="../controllers/manutencoesController.php?funcao=atualizarManutencao" method="POST">
                    <label for="placa">Placa do Veículo:
                        <?php echo $_POST["placa"]; ?>
                    </label> <br>
                    <input type="hidden" name="placa" value="<?php echo $_POST["placa"]; ?>">
                    <input type="hidden" name="data_manutencao" value="<?php echo date("Y-m-d"); ?>">
                    <label for="estado">Estado:</label>
                    <select id="estado" name="estado" class="form-control" required>
                        <option value="" data-default disabled selected>Estado atual:
                            <?php echo $estado_do_veiculo; ?>
                        </option>
                        <?php
                        if ($estado_do_veiculo != "Manutenção concluída") {
                            ?>
                            <option valeu="Em manutenção">Em manutenção</option>
                            <?php
                        }
                        ?>
                        <option value="Manutenção concluída">Manutenção concluída.</option>
                    </select><br>
                    <label for="data_final">Previsão de finalização:</label>
                    <input type="date" id="data_final" name="data_final" class="form-control" required
                        value="<?php echo $dataManutencao ?>"><br>
                    <label for="tipo_servico">Tipo de Serviço:</label>
                    <select id="tipo_servico" name="tipo_servico" class="form-control" required>
                        <option value="" data-default disabled selected>
                            <?php echo $tipoServico ?>
                        </option>
                        <option value="Troca de óleo">Troca de óleo</option>
                        <option value="Troca de pneus">Troca de pneus</option>
                        <option value="Troca de bateria">Troca de bateria</option>
                        <option value="Troca de freios">Troca de freios</option>
                        <option value="Troca de amortecedores">Troca de amortecedores</option>
                        <option value="Troca de correia dentada">Troca de correia dentada</option>
                        <option value="Troca de velas">Troca de velas</option>
                        <option value="Troca de filtros">Troca de filtros</option>
                        <option value="Troca de pastilhas de freio">Troca de pastilhas de freio</option>
                        <option value="Troca de palhetas">Troca de palhetas</option>
                        <option value="Troca de lâmpadas">Troca de lâmpadas</option>
                        <option value="Troca de escapamento">Troca de escapamento</option>
                        <option value="Troca de embreagem">Troca de embreagem</option>
                    </select><br>
                    <label for="observacoes">Observações:</label>
                    <textarea id="observacoes" name="observacoes" placeholder="Observações sobre a manutenção"
                        class="form-control"><?php echo $observacoes['observacoes']; ?></textarea><br>

                    <label for="custo">Custo:</label>
                    <input type="number" step="0.01" id="custo" name="custo" class="form-control" required
                        value="<?php echo $custo; ?>"><br>

                    <input type="submit" value="Atualizar" class="fw-medium btn btn-primary">
                    <input type="button" value="Voltar" class="fw-medium btn btn-primary"
                        onclick="window.location.href='listarVeiculos.php'">

                </form>
            <?php } else { ?>
                <p>Veículo não encontrado.</p>
            <?php } ?>
        </div>
    </div>

    <script>
        // Obtém a referência ao elemento de data da manutenção
        const dataManutencaoInput = document.getElementById('data_manutencao');
        const dataFinalInput = document.getElementById('data_final');

        // Obtém a data de $dataManutencao (formato AAAA-MM-DD) e cria um objeto Date
        const dataManutencao = new Date('<?php echo !empty($dataManutencao) ? $dataManutencao : "" ?>');

        // Adiciona um dia à data de $dataManutencao para obter a data mínima permitida
        dataManutencao.setDate(dataManutencao.getDate());

        // Converte a data mínima para o formato aceito pelo campo de data (AAAA-MM-DD)
        const dataMinima = dataManutencao.toISOString().split('T')[0];

        // Define a data mínima no campo de data
        dataFinalInput.setAttribute('min', dataMinima);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa"
        crossorigin="anonymous"></script>

</body>

</html>