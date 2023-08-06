<?php
session_start();
require_once '../includes/headerCliente.php';
require_once '../includes/headerView.php';

?>
<!DOCTYPE html>
<html>

<head>
    <title>Cadastro de Veículo - Sistema de Acompanhamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

</head>

<body>


    <div class="container-fluid d-flex justify-content-center align-items-center vh-100">
        <div class="col-md-4 border p-4">
            <?php headerVieW(); ?>
            <h2>Cadastro de Veículo</h2>
            <form action="../controllers/veiculosController.php?funcao=cadastrarVeiculo" method="post">

                <label for="marca" class="form-label">Marca:</label>
                <input type="text" list="datalistOptions" class="form-control" id="marca" name="marca" required><br>
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
                <input type="text" class="form-control" id="modelo" name="modelo" required><br>



                <label for="ano" class="form-label">Ano:</label>
                <input type="number" class="form-control" id="ano" name="ano" required><br>



                <label for="placa" class="form-label">Placa:</label>
                <input type="text" class="form-control" id="placa" name="placa" required><br>

                <?php

                /*
                        // Loop para criar os selects das letras da placa
                        echo '<select name="placa_letra1" required>';
                        for ($i = 65; $i <= 90; $i++) {
                            $letra = chr($i);
                            echo "<option value='$letra'>$letra</option>";
                        }
                        echo '</select>';

                        // Loop para criar os selects dos números da placa
                        
                        echo '<select name="placa_letra2" required>';
                        for ($i = 65; $i <= 90; $i++) {
                            $letra = chr($i);
                            echo "<option value='$letra'>$letra</option>";
                        }
                        echo '</select>';

                        echo '<select name="placa_letra3" required>';
                        for ($i = 65; $i <= 90; $i++) {
                            $letra = chr($i);
                            echo "<option value='$letra'>$letra</option>";
                        }
                        echo '</select>';

                        echo '<select name="placa_numero1" required>';
                        for ($i = 0; $i <= 9; $i++) {
                            echo "<option value='$i'>$i</option>";
                        }
                        echo '</select>';

                        echo '<select name="placa_letra4" required>';
                        for ($i = 65; $i <= 90; $i++) {
                            $letra = chr($i);
                            echo "<option value='$letra'>$letra</option>";
                        }
                        echo '</select>';

                        echo '<select name="placa_numero2" required>';
                        for ($i = 0; $i <= 9; $i++) {
                            echo "<option value='$i'>$i</option>";
                        }
                        echo '</select>';

                        echo '<select name="placa_numero3" required>';
                        for ($i = 0; $i <= 9; $i++) {
                            echo "<option value='$i'>$i</option>";
                        }
                        echo '</select>';
                        */
                ?>
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