<?php
session_start();

// Verificar se o usuário está logado como funcionário
require_once '../includes/headerFuncionario.php';
require_once '../models/veiculo.php';

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
    <h2>Atualizar Manutenção</h2>
    <?php if ($dadosVeiculo) { ?>
        <form action="../controllers/manutencoesController.php?funcao=atualizarManutencao" method="POST">
            <label for="placa">Placa do Veículo:
                <?php echo $_POST["placa"]; ?>
            </label> <br>
            <input type="hidden" name="placa" value="<?php echo $_POST["placa"]; ?>">
            <input type="hidden" name="data_manutencao" value="<?php echo date("Y-m-d"); ?>">
            <label for="estado">Estado:</label>
            <select id="estado" name="estado" required>
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
            <input type="date" id="data_final" name="data_final" required required
                value="<?php echo $dataManutencao ?>"><br>
            <label for="tipo_servico">Tipo de Serviço:</label>
            <select id="tipo_servico" name="tipo_servico" required>
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
            <textarea id="observacoes" name="observacoes"
                placeholder="Observações sobre a manutenção"><?php echo $observacoes['observacoes']; ?></textarea><br>

            <label for="custo">Custo:</label>
            <input type="number" step="0.01" id="custo" name="custo" required value="<?php echo $custo; ?>"><br>

            <input type="submit" value="Atualizar">
            <input type="button" value="Voltar" onclick="window.location.href='listarVeiculos.php'">

        </form>
    <?php } else { ?>
        <p>Veículo não encontrado.</p>
    <?php } ?>


    <script>
        // Obtém a referência ao elemento de data da manutenção
        const dataManutencaoInput = document.getElementById('data_manutencao');
        const dataFinalInput = document.getElementById('data_final');

        // Obtém a data de $dataManutencao (formato AAAA-MM-DD) e cria um objeto Date
        const dataManutencao = new Date('<?php echo $dataManutencao ?>');

        // Adiciona um dia à data de $dataManutencao para obter a data mínima permitida
        dataManutencao.setDate(dataManutencao.getDate() + 1);

        // Converte a data mínima para o formato aceito pelo campo de data (AAAA-MM-DD)
        const dataMinima = dataManutencao.toISOString().split('T')[0];

        // Define a data mínima no campo de data
        dataFinalInput.setAttribute('min', dataMinima);
    </script>

</body>

</html>