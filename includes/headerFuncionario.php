<?php   

require_once '../../helpers/conexao.php';
$conn = conectarBancoDados();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'funcionario') {
    header("Location: ../app/views/index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$user_nome = $_SESSION['user_nome'];
?>