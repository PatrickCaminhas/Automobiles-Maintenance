<?php
require_once 'conexao.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $placa = $_POST["placa"];

    // Realize o agendamento da manutenção no banco de dados
    $conn = conectarBancoDados();

    // Atualizar o campo "estado_do_veiculo" na tabela "veiculos" para refletir que o veículo está com proprietário
   

    // Consultar a data de agendamento da manutenção
    $sql_consulta_data = "SELECT data_manutencao FROM manutencoes WHERE placa = '$placa' AND estado_do_veiculo LIKE 'Entrega agendada para o dia:%'";
    $resultado_datas = $conn->query($sql_consulta_data);
    
    // Verificar se encontrou uma data
    if ($resultado_datas->num_rows > 0) {
        // Extrair a data da primeira linha do resultado
        $row = $resultado_datas->fetch_assoc();
        $data_manutencao = $row['data_manutencao'];

        // Deletar o agendamento da manutenção
        $sql_agendamento = "DELETE FROM manutencoes WHERE placa = '$placa' AND data_manutencao = '$data_manutencao'";
        $conn->query($sql_agendamento);
        $sql_atualizar_estado = "UPDATE veiculos SET estado_do_veiculo = 'Com proprietário' WHERE placa = '$placa'";
        $conn->query($sql_atualizar_estado);
        echo "Agendamento cancelado com sucesso!";
    } else {
        echo "Não foi encontrado nenhum agendamento para o veículo.";
    }

    // Fechar a conexão com o banco de dados
    $conn->close();
}
?>
