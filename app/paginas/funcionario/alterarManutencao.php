<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'funcionario') {
    header("Location: ../index.php");
    exit;
}

require_once '../conexao.php';

$conn = conectarBancoDados();

function atualizarManutencao($conn, $placa, $estado, $previsaoTermino, $tipo_servico, $custo)
{
    $dataManutencao = date("Y-m-d");

    $sql = "UPDATE manutencoes SET estado_do_veiculo = '$estado', data_manutencao = '$dataManutencao', previsaoTermino = '$previsaoTermino', tipo_servico = '$tipo_servico', custo = '$custo' WHERE placa = '$placa'";
    $sqlveiculo = "UPDATE veiculos SET estado_do_veiculo = '$estado' WHERE placa = '$placa'";
    $conn->query($sql); // Executar a consulta de atualização
    $conn->query($sqlveiculo);

    $conn->close();
    header("Location: listarVeiculos.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['placa'], $_POST['estado'], $_POST['data_final'], $_POST['tipo_servico'], $_POST['custo'])) {
        $placa = $_POST['placa'];
        $estado = $_POST['estado'];
        $previsaoTermino = $_POST['data_final'];
        $tipo_servico = $_POST['tipo_servico'];
        $custo = $_POST['custo'];

        atualizarManutencao($conn, $placa, $estado, $previsaoTermino, $tipo_servico, $custo);
    }
}
?>
