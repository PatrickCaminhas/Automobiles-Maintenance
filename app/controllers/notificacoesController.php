<?php

session_start();
require_once '../models/notificacoes.php';


if (isset($_GET["funcao"])) {
    $funcao = $_GET["funcao"];
    switch ($funcao) {
        case "limparNotificacoes":
            $notificacoes = new Notificacoes();
            $notificacoes->limparNotificacoes($_SESSION["user_id"]);
            break;
        // Adicione mais cases para outras funções
        default:
            // Função não encontrada
            echo "Função não encontrada.";
    }
}


?>