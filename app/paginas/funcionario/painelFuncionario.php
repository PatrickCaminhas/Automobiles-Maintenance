<?php
session_start();
require_once '../funcoes/conexao.php';

// Verificar se o usuário está logado e se é um funcionário
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'funcionario') {
    header("Location: ../index.php");
    exit;
}

// Dados do usuário logado
$user_id = $_SESSION['user_id'];
$user_nome = $_SESSION['user_nome'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Painel do Funcionário - Sistema de Acompanhamento</title>
</head>
<body>
    <h1>Bem-vindo(a) ao Painel do Funcionário, <?php echo $user_nome; ?>!</h1>
    <!-- Aqui você pode implementar as funcionalidades do painel para o funcionário -->
    <a href="listarVeiculos.php">Alterar estado de veiculos</a> <br>
    <a href="../logout.php">Logout</a> <br>

    <!-- Exibir informações específicas para funcionários -->
</body>
</html>
