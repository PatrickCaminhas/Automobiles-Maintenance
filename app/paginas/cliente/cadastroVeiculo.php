<?php
session_start();
require_once '../funcoes/conexao.php';
if (!isset($_SESSION["user_id"]) || $_SESSION['user_role'] !== 'proprietario') {
    header("Location: ../index.php");
    exit;
}
$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>Cadastro de Veículo - Sistema de Acompanhamento</title>
</head>

<body>
    <h2>Cadastro de Veículo</h2>
    <form action="../funcoes/veiculo.php?funcao=cadastrarVeiculo" method="post">
        <label for="marca">Marca:</label>
        <input type="text" id="marca" name="marca" required><br>

        <label for="modelo">Modelo:</label>
        <input type="text" id="modelo" name="modelo" required><br>

        <label for="ano">Ano:</label>
        <input type="number" id="ano" name="ano" required><br>

        <label for="placa">Placa:</label>
        <?php


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
        ?>
        <br>

        <!-- Campo oculto para enviar o ID do proprietário -->
        <input type="hidden" name="proprietario_id" value="<?php echo $_SESSION['user_id']; ?>">

        <input type="submit" value="Cadastrar">
        <input type="button" value="Voltar" onclick="window.location.href='painel.php'">

    </form>
</body>

</html>