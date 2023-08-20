<?php
use helpers\DatabaseConnection;
use helpers\Validador;
require_once '../../helpers/DatabaseConnection.php';
require_once '../../helpers/Validador.php';
require_once '../models/usuarioCliente.php';
require_once '../models/usuarioFuncionario.php';


session_start();
if (isset($_POST["login"]) && isset($_POST["senha"])) {
    $userLogin = $_POST["login"];
    $senha = $_POST["senha"];
    $validador = new Validador();
    if ($validador->validarCPF($userLogin)) {

        $funcionario = new Funcionario();
        $funcionario->setCpf($userLogin);
        $funcionario->setSenha($senha);
        $funcionario->login($userLogin, $senha);
    } else if ($validador->validarCelular($userLogin)) {
        $proprietario = new Proprietario();
        $proprietario->setTelefone($userLogin);
        $proprietario->setSenha($senha);
        $proprietario->login($userLogin, $senha);
    } else if ($validador->validarEmail($userLogin)) {

        $proprietario = new Proprietario();
        $proprietario->setEmail($userLogin);
        $proprietario->setSenha($senha);
        $proprietario->login($userLogin, $senha);
    } else {
        echo '<script>alert("Login inválido. Tente novamente.");window.location.href = "../views/index.php";</script>';

    }
}

?>