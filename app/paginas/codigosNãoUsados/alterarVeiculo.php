<?php
require_once 'conexao.php';
session_start();


// Verifica se o formulário foi enviado (após a alteração)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $marca = $_POST["marca"];
    $modelo = $_POST["modelo"];
    $ano = $_POST["ano"];
    $placa = $_POST["placa"];

    // Realiza a consulta para verificar se já existe algum veículo cadastrado com a nova placa
    $conn = conectarBancoDados();
    $user_id = $_SESSION['user_id'];
    $sql_consulta_placa = "SELECT id FROM veiculos WHERE placa = '$placa' AND proprietario_id = $user_id";
    $resultado_consulta = $conn->query($sql_consulta_placa);

    if ($resultado_consulta->num_rows > 0) {
        // Caso encontre outro veículo com a mesma placa e ID diferente, exibe um aviso
        $veiculo_existente = $resultado_consulta->fetch_assoc();
       
            // Caso encontre outro veículo com a mesma placa, mas mesmo ID (o mesmo veículo), permite atualizar as informações
            $sql_atualizar = "UPDATE veiculos SET marca = '$marca', modelo = '$modelo', ano = '$ano' WHERE placa = '$placa' AND proprietario_id = $user_id";
            if ($conn->query($sql_atualizar) === TRUE) {
                echo "Informações do veículo atualizadas com sucesso!";
            } else {
                echo "Erro ao atualizar as informações do veículo: " . $conn->error;
            }
        
    } else {
        // Caso a placa não esteja duplicada, realiza a atualização das informações do veículo no banco de dados
        $sql_atualizar = "UPDATE veiculos SET marca = '$marca', modelo = '$modelo', ano = '$ano' WHERE placa = '$placa' AND proprietario_id = $user_id";
        if ($conn->query($sql_atualizar) === TRUE) {
            echo "Informações do veículo atualizadas com sucesso!";
        } else {
            echo "Erro ao atualizar as informações do veículo: " . $conn->error;
        }
    }

    // Feche a conexão com o banco de dados
    $conn->close();
}
?>
