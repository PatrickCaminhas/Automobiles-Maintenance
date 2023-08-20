<?php

session_start();
use app\models\Notificacoes;

require_once '../models/Notificacoes.php';


if (isset($_GET["funcao"])) {
    $funcao = $_GET["funcao"];
    switch ($funcao) {
        case "limparNotificacoes":
            $notificacoes = new Notificacoes();
            $notificacoes->limparNotificacoes($_SESSION["user_id"]);
            break;
        default:
            // Função não encontrada
            echo "Função não encontrada.";
    }
}


?>