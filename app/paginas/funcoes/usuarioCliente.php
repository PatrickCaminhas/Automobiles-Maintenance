<?php
require_once 'conexao.php';
session_start();

function idClienteEmail($email)
{
    $conn = conectarBancoDados();
    $sql = "SELECT id FROM proprietarios WHERE email = '$email'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $id = $row["id"];
    return $id;
}

function idClienteCelular($telefone)
{
    $conn = conectarBancoDados();
    $sql = "SELECT id FROM proprietarios WHERE telefone = '$telefone'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $id = $row["id"];
    return $id;
}

function cadastrar($nome, $email, $telefone, $senha)
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Realize o cadastro do novo proprietário no banco de dados
        // Substitua 'seu_usuario', 'sua_senha', 'seu_banco_de_dados' pelas suas credenciais
        $conn = conectarBancoDados();

        $sqlVerificaEmail = "SELECT * FROM proprietarios WHERE email = '$email'";
        $sqlVerificaTelefone = "SELECT * FROM proprietarios WHERE telefone = '$telefone'";

        $resultadoEmail = $conn->query($sqlVerificaEmail);
        $resultadoTelefone = $conn->query($sqlVerificaTelefone);
        $erro = false;
        if ($resultadoEmail->num_rows > 0) {
            echo '<script>alert("Este email já está cadastrado. Por favor, escolha outro email");window.location.href = "../cadastro.php";</script>';
            $erro = true;
            exit;
        }

        if ($resultadoTelefone->num_rows > 0) {
            echo '<script>alert("Este telefone já está cadastrado. Por favor, escolha outro telefone.");window.location.href = "../cadastro.php";</script>';
            $erro = true;
            exit;
        }
        if ($erro == false) {
            $sql = "INSERT INTO proprietarios (nome, email,telefone, senha) VALUES ('$nome', '$email','$telefone', '$senha')";
            if ($conn->query($sql) === TRUE) {
                echo "Cadastro realizado com sucesso!";
                header("Location: ../index.php");

            } else {
                echo '<script>alert("Erro ao cadastrar.");</script>';
                $erro = true;
                exit;
            }
        }
     
        $conn->close();
    }
}


if (isset($_GET["funcao"])) {
    $funcao = $_GET["funcao"];

    switch ($funcao) {
        case "cadastrar":
            cadastrar($_POST["nome"], $_POST["email"], $_POST["telefone"], $_POST["senha"]);
            break;
        case "cancelarAgendamento":
            cancelarAgendamento($_POST["placa"]);
            break;
        // Adicione mais cases para outras funções
        default:
            // Função não encontrada
            echo "Função não encontrada.";
    }
}
?>