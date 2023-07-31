<?php
// Função para realizar a conexão com o banco de dados
function conectarBancoDados() {
    $hostname = 'localhost'; // Endereço do servidor do banco de dados
    $username = 'root'; // Nome de usuário do banco de dados
    $password = ''; // Senha do banco de dados
    $database = 'mecanica'; // Nome do banco de dados

    $conn = new mysqli($hostname, $username, $password, $database);

    // Verifica se houve erro na conexão
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    return $conn;
}

// Função para desconectar do banco de dados
function desconectarBancoDados($conn) {
    $conn->close();
}
?>
