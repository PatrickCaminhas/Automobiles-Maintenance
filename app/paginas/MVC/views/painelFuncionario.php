<?php
session_start();

require_once '../includes/headerFuncionario.php';

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
    <a href="../controllers/logout.php">Logout</a> <br>

    <!-- Exibir informações específicas para funcionários -->
</body>
</html>
