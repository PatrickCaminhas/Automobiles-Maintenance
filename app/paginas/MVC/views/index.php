<?php
require_once '../helpers/conexao.php';
require_once '../includes/headerView.php';

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <style>
</style>
    </head>
<body>

    <div class="container-fluid d-flex justify-content-center align-items-center vh-100">
        <div class="col-md-4 border p-4"> <!-- Adicione a classe border e a classe de espaçamento p-4 -->
        <?php headerVieW();?>
    
        <h2>Login</h2>
            <form action="../controllers/login.php" method="post">
                <div class="mb-3">
                    <label for="login">Login:</label>
                    <input type="text" id="login" name="login" required placeholder="Seu e-mail ou celular" class="form-control"><br> <!-- Adicione a classe form-control -->
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" required placeholder="Sua senha" class="form-control"><br> <!-- Adicione a classe form-control -->
                    <input type="submit" value="Entrar" class="fw-medium btn btn-primary"> <!-- Adicione a classe btn btn-primary para estilizar o botão -->
                    <a for="cadastrar">Não tem cadastro? então </label><a href="cadastro.php">clique aqui</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>
</body>
</html>


