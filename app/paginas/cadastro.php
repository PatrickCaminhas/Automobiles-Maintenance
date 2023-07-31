<!DOCTYPE html>
<html>
<head>
    <title>Cadastro - Sistema de Acompanhamento</title>
</head>
<body>
    <h2>Cadastro</h2>
    <form action="./funcoes/usuarioCliente.php?funcao=cadastrar" method="post">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required placeholder="Seu nome"><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required placeholder="Seu email"><br>

        <label for="telefone">Telefone:</label>
        <input type="tel" id="telefone" name="telefone" required placeholder="Seu telefone celular"><br>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required placeholder="Sua senha"><br>

        <input type="submit" value="Cadastrar">
        <input type="button" value="Voltar" onclick="window.location.href='index.php'">
    </form>
</body>
</html>
