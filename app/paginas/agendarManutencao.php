<?php
require_once 'conexao.php';
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $placa = $_POST["placa"];
    $data_manutencao = $_POST["data_manutencao"];
    $descricao = $_POST["descricao"];
    $usuario_id = $_SESSION["user_id"];

    // Realize o agendamento da manutenção no banco de dados
    $conn = conectarBancoDados();

    // Aqui você pode inserir os dados do agendamento na tabela de manutenções (por exemplo, "manutencoes") 
    // e atualizar o campo "estado_do_veiculo" na tabela de veículos para refletir que o veículo está em manutenção.
    // Exemplo:
    // 1. Inserir o agendamento na tabela "manutencoes": 
    
    $sql_atualizar_estado = "UPDATE veiculos SET estado_do_veiculo = 'Entrega agendada para o dia: $data_manutencao' WHERE placa = '$placa'";
    $conn->query($sql_atualizar_estado);

    
    $sql_agendamento = "INSERT INTO manutencoes (placa, data_manutencao, observacoes) 
                        VALUES ('$placa', '$data_manutencao', '$descricao')";
    $conn->query($sql_agendamento);

    // 2. Atualizar o campo "estado_do_veiculo" na tabela "veiculos" para refletir que o veículo está em manutenção.
   

    $conn->close();

    echo "Manutenção agendada com sucesso!";

}
?>
