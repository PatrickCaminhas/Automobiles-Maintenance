<!DOCTYPE html>
<html>
<head>
    <title>Validador de CPF</title>
</head>
<body>
    <h2>Validador de CPF</h2>
    <form action="validaCPF.php" method="post">
        <label for="cpf">Digite o CPF (somente números):</label>
        <input type="text" id="cpf" name="cpf" maxlength="11" required>
        <input type="submit" value="Validar">
    </form>
</body>
</html>
