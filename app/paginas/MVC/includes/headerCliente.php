<?php

require_once '../helpers/conexao.php';
$conn = conectarBancoDados();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'proprietario') {
    header("Location: ../views/index.php");
    exit;
}
$user_id = $_SESSION['user_id'];
?>