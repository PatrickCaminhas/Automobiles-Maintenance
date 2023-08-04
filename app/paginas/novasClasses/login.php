<?php
require_once 'conexao.php';
require_once 'validadores.php';
require_once 'proprietario.php';
require_once 'funcionario.php';


session_start();
$userLogin = $_POST["login"];
$senha = $_POST["senha"];


if (validarCPF($userLogin)) {
    $funcionario = new Funcionario();
    $funcionario->login($userLogin, $senha);
} else {
    if (validarCelular($userLogin)) {
        $proprietario = new Proprietario('', '', $userLogin, $senha);
        $proprietario->login($userLogin, $senha);
    }
    if (validarEmail($userLogin)) {
        $proprietario = new Proprietario('', $userLogin, '', $senha);
        $proprietario->login($userLogin, $senha);
    }
}
?>