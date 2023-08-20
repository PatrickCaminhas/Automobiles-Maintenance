<?php
session_start();
use app\models\Manutencao;
use app\models\Notificacoes;
use helpers\DatabaseConnection;

require_once '../models/Manutencao.php';
require_once '../models/Notificacoes.php';

$userRole = $_SESSION['user_role'];

$notificacoes = new Notificacoes();
$manutencao = new Manutencao();
$manutencao->setPlaca($_POST["placa"]);
$manutencao->setDataManutencao($_POST["data_manutencao"]);
$manutencao->attach($notificacoes);


if (isset($_GET["funcao"])) {
    $funcao = $_GET["funcao"];

    switch ($funcao) {
        case "agendaManutencao":
            if ($userRole == 'proprietario') {
                $sql = $manutencao->agendarManutencao($_POST["placa"], $_POST["data_manutencao"]);
                if ($sql != false) {
                    $manutencao->insertInDataBase($sql);
                } else {
                    echo '<script>alert("Não foi possivel realizar a ação.");window.location.href = "../views/painel.php"; </script>';

                }
            } else {
                echo '<script>alert("Você não tem permissão para realizar essa ação!!"); window.location.href = "../views/painel.php";</script>';
            }
            break;
        case "cancelarAgendamento":
            if ($userRole == 'proprietario') {
                $sql = $manutencao->cancelarAgendamento($_POST["placa"]);
                if ($sql != false) {
                    $manutencao->updateInDataBase($sql);
                } else {
                    echo '<script>alert("Não foi possivel realizar a ação.");window.location.href = "../views/painel.php"; </script>';

                }
            } else {
                echo '<script>alert("Você não tem permissão para realizar essa ação!"); window.location.href = "../views/painel.php";</script>';
            }
            break;
        case "finalizarManutencao":
            if ($userRole == 'funcionario') {
                $manutencao->finalizarManutencao($_POST["placa"]);
            } else {
                echo '<script>alert("Você não tem permissão para realizar essa ação!"); window.location.href = "../views/listarVeiculos.php";</script>';
            }
            break;
        case "atualizarManutencao":
            if ($userRole == "funcionario") {
                date_default_timezone_set('America/Sao_Paulo');
                $dataManutencao = date("Y-m-d");
                $manutencao = new Manutencao();
                $manutencao->setPlaca($_POST["placa"]);
                $manutencao->setEstadoDoVeiculo($_POST["estado"]);
                $manutencao->setTipoServico($_POST["tipo_servico"]);
                $manutencao->setDataManutencao($dataManutencao);
                $manutencao->setDataTermino($_POST["data_final"]);
                $manutencao->setObservacoes($_POST["observacoes"]);
                $manutencao->setCusto($_POST["custo"]);
                $manutencao->attach($notificacoes);
                $manutencao->atualizarManutencao($_POST["placa"]);

            } else {
                echo '<script>alert("Você não tem permissão para realizar essa ação!"); window.location.href = "../views/listarVeiculos.php";</script>';
            }
            break;

        default:
            // Função não encontrada
            echo "Função não encontrada.";
            header("Location: ../views/index.php");
    }
}
$notificacoesArray = $notificacoes->getNotificacoes();

?>