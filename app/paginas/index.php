<?php
require_once './funcoes/conexao.php';
require_once './funcoes/validadores.php';
session_start();

// Verificar se o usuário está logado e redirecionar para o painel apropriado
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_role'] === 'proprietario') {
        header("Location: cliente/painel.php");
    } elseif ($_SESSION['user_role'] === 'funcionario') {
        header("Location: funcionario/painelFuncionario.php");
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
    <form action="./funcoes/login.php" method="post">
        <label for="login">Login:</label>
        <input type="text" id="login" name="login" required placeholder="Seu e-mail ou celular"><br>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required placeholder="Sua senha"><br>
        <input type="submit" value="Entrar">
        <a for="cadastrar">Não tem cadastro? então </label><a href="cadastro.php">clique aqui</a>
    </form>
    
</body>
</html>
