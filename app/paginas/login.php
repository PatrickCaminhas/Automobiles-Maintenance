<?php
require_once 'conexao.php';
require_once 'validaCPF.php';
session_start();
$userLogin = $_POST["login"];
    $senha = $_POST["senha"];


function loginProprietario($login, $password){
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userLogin = $login;
    $senha = $password;

    // Realize a autenticação verificando o email e senha no banco de dados
    // Substitua 'seu_usuario', 'sua_senha', 'seu_banco_de_dados' pelas suas credenciais
    $conn = conectarBancoDados();

    $sql = "SELECT id, nome FROM proprietarios WHERE (email = '$userLogin' OR telefone = '$userLogin') AND senha = '$senha'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION["user_id"] = $row["id"];
        $_SESSION["user_nome"] = $row["nome"];
        $_SESSION["user_role"] = "proprietario";
        header("Location: painel.php");
        exit;
    } else {
        $mensagem_erro = "Credenciais inválidas. Tente novamente.";
        echo $mensagem_erro;
        header("Location: index.php");
    }
}
}

function loginFuncionario($login, $password){
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userLogin = $login;
    $senha = $password;

    // Realize a autenticação verificando o email e senha no banco de dados
    // Substitua 'seu_usuario', 'sua_senha', 'seu_banco_de_dados' pelas suas credenciais
    $conn = conectarBancoDados();

    $sql = "SELECT id, nome FROM usuarios WHERE cpf = '$userLogin' AND senha = '$senha'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION["user_id"] = $row["id"];
        $_SESSION["user_nome"] = $row["nome"];
        $_SESSION["user_cpf"] = $userLogin;
        $_SESSION["user_role"] = "funcionario";
        header("Location: painelFuncionario.php");
        exit;
    } else {
        $mensagem_erro = "Credenciais inválidas. Tente novamente.";
        header("Location: index.php");
    }
}
}

if (validarCPF($userLogin)) {
    loginFuncionario($userLogin, $senha);
} else {
    loginProprietario($userLogin, $senha);
}
?>

