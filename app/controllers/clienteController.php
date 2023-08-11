<?php
require_once '../../helpers/conexao.php';
require_once '../../helpers/validadores.php';
require_once '../models/usuarioCliente.php';

if (isset($_GET["funcao"])) {
    $funcao = $_GET["funcao"];
    switch ($funcao) {
        case "cadastrarCliente":
            $user = new Proprietario($_POST["nome"], $_POST["email"], $_POST["telefone"], $_POST["senha"]);

            $user->cadastrar();
            break;
        // Adicione mais cases para outras funções
        default:
            // Função não encontrada
            echo "Função não encontrada.";
    }
}
?>