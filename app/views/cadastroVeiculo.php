<?php
session_start();
require_once '../../includes/headerCliente.php';
require_once '../../includes/headerView.php';

?>
<!DOCTYPE html>
<html>

<head>
    <title>Cadastro de Veículo - Sistema de Acompanhamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <?php headerHead(); ?>

</head>

<body>


    <div class="container-fluid d-flex justify-content-center align-items-center vh-100">
        <div class="col-md-4 border p-4">
            <?php headerVieW(); ?>
            <h2>Cadastro de Veículo</h2>
            <form action="../controllers/veiculosController.php?funcao=cadastrarVeiculo" method="post">

                <label for="marca" class="form-label">Marca:</label>
                <input type="text" list="datalistOptions" class="form-control" id="marca" name="marca" required
                    placeholder="Marca do veiculo"><br>
                <datalist id="datalistOptions">
                    <option value="Chevrolet">
                    <option value="Fiat">
                    <option value="Honda">
                    <option value="Hyundai">
                    <option value="Jeep">
                    <option value="Nissan">
                    <option value="Peugeot">
                    <option value="Renault">
                    <option value="Tesla">
                    <option value="Toyota">
                    <option value="Volkswagen">

                </datalist>


                <label for="modelo" class="form-label">Modelo:</label>
                <input type="text" class="form-control" id="modelo" name="modelo" required
                    placeholder="Modelo do veiculo"><br>



                <label for="ano" class="form-label">Ano:</label>
                <!--<input type="number" class="form-control" id="ano" name="ano" required placeholder="Ano do veiculo"><br>*-->
                <?php

                // Loop para criar os selects dos números do ano
                
                echo '<select type="number" class="form-control" name="ano" placeholder="Ano do veiculo" required>';
                
                for ($ano = 2023; $ano >= 1990; $ano--) {
                    
                    echo "<option value='$ano'>$ano</option>";
                }
                echo '</select>';


                ?>  
                <br>


                <label for="placa" class="form-label">Placa:</label>
                <input type="text" class="form-control" id="placa" name="placa" required required placeholder="LLLNLNN"
                    minlength="7" maxlength="7"><br>


                <br>

                <!-- Campo oculto para enviar o ID do proprietário -->
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">

                <input type="submit" value="Cadastrar" class="btn btn-primary">
                <input type="button" value="Voltar" class="btn btn-primary" onclick="window.location.href='painel.php'">

            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa"
        crossorigin="anonymous"></script>

</body>

</html>