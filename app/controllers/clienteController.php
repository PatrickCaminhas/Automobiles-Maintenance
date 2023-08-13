<?php
require_once '../../helpers/conexao.php';
require_once '../../helpers/validadores.php';
require_once '../models/usuarioCliente.php';

if (isset($_GET["funcao"])) {
    $funcao = $_GET["funcao"];
    switch ($funcao) {
        case "cadastrarCliente":
            $user = new Proprietario();
            $user->setNome($_POST["nome"]);
            $user->setEmail($_POST["email"]);
            $user->setTelefone($_POST["telefone"]);
            $user->setSenha($_POST["senha"]);
            $user->cadastrar();
            break;
        // Adicione mais cases para outras funções
        default:
            // Função não encontrada
            echo "Função não encontrada.";
    }
}
?>