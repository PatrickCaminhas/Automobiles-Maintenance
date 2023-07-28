<!DOCTYPE html>
<html>
<head>
    <title>Cadastro - Sistema de Acompanhamento</title>
</head>
<body>
    <h2>Cadastro</h2>
    <form action="cadastrar.php" method="post">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="telefone">Telefone:</label>
        <input type="tel" id="telefone" name="telefone" required><br>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required><br>

        <input type="submit" value="Cadastrar">
    </form>
</body>
</html>
