<?php
require_once 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $telefone = $_POST["telefone"];
    $senha = $_POST["senha"];


    // Realize o cadastro do novo proprietário no banco de dados
    // Substitua 'seu_usuario', 'sua_senha', 'seu_banco_de_dados' pelas suas credenciais
    $conn = conectarBancoDados();

    $sql = "INSERT INTO proprietarios (nome, email,telefone, senha) VALUES ('$nome', '$email','$telefone', '$senha')";
    if ($conn->query($sql) === TRUE) {
        echo "Cadastro realizado com sucesso!";
        header("Location: index.php");

    } else {
        echo "Erro ao cadastrar: " . $conn->error;
        header("Location: cadastro.php");

    }

    $conn->close();
}
?>
