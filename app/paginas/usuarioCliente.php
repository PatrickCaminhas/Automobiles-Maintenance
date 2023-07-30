<?php
require_once 'conexao.php';
session_start();

function idClienteEmail($email){
    $conn = conectarBancoDados();
    $sql = "SELECT id FROM clientes WHERE email = '$email'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $id = $row["id"];
    return $id;
}

function idClienteCelular($celular){
    $conn = conectarBancoDados();
    $sql = "SELECT id FROM clientes WHERE celular = '$celular'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $id = $row["id"];
    return $id;
}
?>