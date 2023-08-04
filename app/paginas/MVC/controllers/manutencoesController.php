<?php
session_start();
include_once '../models/manutencoes.php';
$userRole = $_SESSION['user_role'];
if (isset($_GET["funcao"])) {
    $funcao = $_GET["funcao"];
    
    switch ($funcao) {
        case "agendaManutencao":
            if($userRole == 'proprietario'){
            $manutencao = new Manutencao($_POST["placa"], '', $_POST["dataManutencao"], '', '', '', '');
            $manutencao->agendarManutencao($_POST["placa"], $_POST["data_manutencao"]);
            }else{
                echo '<script>alert("Você não tem permissão para realizar essa ação!!"); window.location.href = "../views/painel.php";</script>';
            }
            break;
        case "cancelarAgendamento":
            if($userRole == 'proprietario'){
            $manutencao = new Manutencao($_POST["placa"], '', '', '', '', '', '');
            $manutencao->cancelarAgendamento($_POST["placa"]);
            }else{
                echo '<script>alert("Você não tem permissão para realizar essa ação!"); window.location.href = "../views/painel.php";</script>';
            }
            break;
        case "finalizarManutencao":
            if($userRole == 'funcionario'){
            $manutencao = new Manutencao($_POST["placa"], '', '', '', '', '', '');
            $manutencao->finalizarManutencao($_POST["placa"]);
            }else{
                echo '<script>alert("Você não tem permissão para realizar essa ação!"); window.location.href = "../views/listarVeiculos.php";</script>';
            }
            break;
        case "atualizarManutencao":
            if($userRole == "funcionario"){
            $dataManutencao = date("Y-m-d");
            $manutencao = new Manutencao($_POST["placa"], $_POST["estado"], $dataManutencao, $_POST["dataTermino"], $_POST["tipo_servico"], $_POST["observacoes"], $_POST["custo"]);
            $manutencao->atualizarManutencao();
            }else{
                echo '<script>alert("Você não tem permissão para realizar essa ação!"); window.location.href = "../views/listarVeiculos.php";</script>';
            }
            break;

        // Adicione mais cases para outras funções
        default:
            // Função não encontrada
            echo "Função não encontrada.";
            header("Location: ../views/index.php");
    }
}
?>