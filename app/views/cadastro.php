<?php 


session_start();
require_once '../../includes/headerView.php';
require_once '../../helpers/conexao.php';
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_role'] === 'proprietario') {
        header("Location: painel.php");
    } elseif ($_SESSION['user_role'] === 'funcionario') {
        header("Location: painelFuncionario.php");
    }
    exit;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Cadastro - Sistema de Acompanhamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <?php headerHead(); ?>

</head>
<body>
<div class="container-fluid d-flex justify-content-center align-items-center vh-100">
        <div class="col-md-4 border p-4">
    <?php headerVieW();?>
    <h2>Cadastro</h2>
    <form action="../controllers/clienteController.php?funcao=cadastrarCliente" method="post">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required placeholder="Seu nome" class="form-control"><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required placeholder="Seu email" class="form-control"><br>

        <label for="telefone">Telefone:</label>
        <input type="tel" id="telefone" name="telefone" required placeholder="Seu telefone celular" class="form-control" minlength="11" maxlength="11"><br>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required placeholder="Mínimo 6 e máximo 15 caracteres" class="form-control" minlength="6" maxlength="15"><br>

        <input type="submit" value="Cadastrar" class="fw-medium btn btn-primary mb-3">
        <input type="button" value="Voltar" class="fw-medium btn btn-primary mb-3" onclick="window.location.href='index.php'">
    </form>
</div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>

</body>
</html>
