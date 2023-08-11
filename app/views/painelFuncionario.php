<?php
session_start();

require_once '../../includes/headerFuncionario.php';
require_once '../../includes/headerView.php';


?>

<!DOCTYPE html>
<html>

<head>
    <title>Painel do Funcionário - Sistema de Acompanhamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

</head>

<body>
<div class="container-fluid d-flex justify-content-between align-items-center" style="margin-top: 1rem;">
    <?php headerVieW();?>
  
    <a href="../controllers/logout.php" class="btn btn-primary mb-1">Logout</a>

     
    </div>
    <div class="d-flex flex-column justify-content-center align-items-center">
        <div class="col-md-4 border p-4" style="width: 75vw;">
            <h1>Bem-vindo(a) ao Painel do Funcionário,
                <?php echo $user_nome; ?>!
            </h1>
            <!-- Aqui você pode implementar as funcionalidades do painel para o funcionário -->
            <div class="">
                <a href="listarVeiculos.php" class="fw-medium btn btn-primary mb-3">Alterar estado de veiculos</a> <br>
            </div>
        </div>
    </div>
    <!-- Exibir informações específicas para funcionários -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa"
        crossorigin="anonymous"></script>

</body>

</html>