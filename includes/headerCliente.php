<?php

require_once '../../helpers/conexao.php';
$databaseConnection = DatabaseConnection::getInstance();
$conn = $databaseConnection->getConnection();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'proprietario') {
    header("Location: ../views/index.php");
    exit;
}
$user_id = $_SESSION['user_id'];
?>