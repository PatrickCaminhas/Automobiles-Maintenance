<?php
require_once '../../helpers/conexao.php';
require_once '../../helpers/validadores.php';
require_once '../models/usuarioCliente.php';
require_once '../models/usuarioFuncionario.php';


session_start();
if (isset($_POST["login"]) && isset($_POST["senha"])) {
    $userLogin = $_POST["login"];
    $senha = $_POST["senha"];
    if (validarCPF($userLogin)) {

        $funcionario = new Funcionario();
        $funcionario->setCpf($userLogin);
        $funcionario->setSenha($senha);
        $funcionario->login($userLogin, $senha);
    } else if (validarCelular($userLogin)) {
        $proprietario = new Proprietario();
        $proprietario->setTelefone($userLogin);
        $proprietario->setSenha($senha);
        $proprietario->login($userLogin, $senha);
    } else if (validarEmail($userLogin)) {

        $proprietario = new Proprietario();
        $proprietario->setEmail($userLogin);
        $proprietario->setSenha($senha);
        $proprietario->login($userLogin, $senha);
    } else {
        echo '<script>alert("Login inválido. Tente novamente.");window.location.href = "../views/index.php";</script>';

    }
}

?>