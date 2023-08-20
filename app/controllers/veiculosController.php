<?php

session_start();
use app\models\Veiculo;

require_once '../models/veiculo.php';


if (isset($_GET["funcao"])) {
    $funcao = $_GET["funcao"];
    $veiculo = new Veiculo();
    $veiculo->setMarca($_POST["marca"]);
    $veiculo->setModelo($_POST["modelo"]);
    $veiculo->setAno($_POST["ano"]);
    $veiculo->setPlaca($_POST["placa"]);
    $veiculo->setProprietarioId($_POST["user_id"]);
    $veiculo->setEstadoDoVeiculo("Com proprietario");
    switch ($funcao) {
        case "cadastrarVeiculo":

            $sql = $veiculo->inserirVeiculo();
            if ($sql != false) {
                $veiculo->insertInDataBase($sql);
            } else {
                echo '<script>alert("Não foi possivel realizar a ação.");window.location.href = "../views/painel.php"; </script>';
            }
            break;
        case "alterarVeiculo":

            $sql = $veiculo->updateVeiculo();
            if ($sql != false) {
                $veiculo->updateInDataBase($sql);
            } else {
                echo '<script>alert("Não foi possivel realizar a ação.");window.location.href = "../views/painel.php"; </script>';
            }
            break;
        //Futuramente função de exclusão de veiculo do banco de dados
        default:
            // Função não encontrada
            echo "Função não encontrada.";
    }
}


?>