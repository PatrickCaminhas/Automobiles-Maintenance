<?php
require_once 'conexao.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $placa = $_POST["placa"];

    // Realize o agendamento da manutenção no banco de dados
    $conn = conectarBancoDados();

    // Atualizar o campo "estado_do_veiculo" na tabela "veiculos" para refletir que o veículo está com proprietário
   
    $sql_veiculo = "DELETE FROM veiculos WHERE placa = '$placa'";
    $conn->query($sql_veiculo);
    // Consultar a data de agendamento da manutenção


    // Fechar a conexão com o banco de dados
    $conn->close();
}
?>
