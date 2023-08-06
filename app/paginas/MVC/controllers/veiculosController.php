<?php

session_start();
require_once '../models/veiculo.php';


if (isset($_GET["funcao"])) {
    $funcao = $_GET["funcao"];
    switch ($funcao) {
        case "cadastrarVeiculo":
           
            $veiculo = new Veiculo($_POST["marca"], $_POST["modelo"], $_POST["ano"], $_POST["placa"], $_POST["user_id"], "Com proprietario");
            
            $veiculo->inserirVeiculo();
        
            break;
        case "alterarVeiculo":
            $veiculo = new Veiculo($_POST["marca"], $_POST["modelo"], $_POST["ano"], $_POST["placa"],  $_POST["user_id"], "Com proprietario");
            $veiculo->updateVeiculo();
            break;

        // Adicione mais cases para outras funções
        default:
            // Função não encontrada
            echo "Função não encontrada.";
    }
}


?>