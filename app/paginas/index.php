<?php
require_once 'conexao.php';
require_once 'validaCPF.php';
session_start();

// Verificar se o usuário está logado e redirecionar para o painel apropriado
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_role'] === 'proprietario') {
        header("Location: painel.php");
    } elseif ($_SESSION['user_role'] === 'funcionario') {
        header("Location: painelFuncionario.php");
    }
    exit;
}
// Caso não esteja logado, exibir o formulário de login
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Sistema de Acompanhamento</title>
</head>
<body>
    <h2>Login</h2>
    <form action="login.php" method="post">
        <label for="login">Email ou Telefone:</label>
        <input type="text" id="login" name="login" required><br>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required><br>

        <input type="submit" value="Entrar">
    </form>
</body>
</html>
