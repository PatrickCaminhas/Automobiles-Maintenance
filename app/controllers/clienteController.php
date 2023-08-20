<?php
use helpers\DatabaseConnection;
use helpers\Validador;
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
        // Futuramente função de exclusão de conta do cliente
        default:
            // Função não encontrada
            echo "Função não encontrada.";
    }
}
?>