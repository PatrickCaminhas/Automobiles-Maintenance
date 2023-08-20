<?php   
use helpers\DatabaseConnection;
require_once __DIR__ . '/../vendor/autoload.php'; // Caminho para o autoload do Composer

$databaseConnection = DatabaseConnection::getInstance();
$conn = $databaseConnection->getConnection();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'funcionario') {
    header("Location: ../views/index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$user_nome = $_SESSION['user_nome'];
?>