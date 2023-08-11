<?php
require_once '../../helpers/conexao.php';
require_once 'usuario.php';
class Funcionario
{
    // Restante do código da classe Funcionario

    public function login($login, $password)
    {
        // Realize a autenticação verificando o CPF e senha no banco de dados
        // Substitua 'seu_usuario', 'sua_senha', 'seu_banco_de_dados' pelas suas credenciais
        $databaseConnection = DatabaseConnection::getInstance();
        $conn = $databaseConnection->getConnection();

        $sql = "SELECT id, nome FROM usuarios WHERE cpf = '$login' AND senha = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["user_nome"] = $row["nome"];
            $_SESSION["user_cpf"] = $login;
            $_SESSION["user_role"] = "funcionario";
            header("Location: ../views/painelFuncionario.php");
            exit;
        } else {
            echo '<script>alert("Login ou senha inválidos. Tente novamente.");window.location.href = "../index.php";</script>';
        }

    }
}

?>