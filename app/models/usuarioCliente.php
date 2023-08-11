<?php
require_once '../../helpers/conexao.php';
require 'usuario.php';



class Proprietario extends usuario 
{

    private $id;
    private $nome;
    private $email;
    private $telefone;
    private $senha;
    private $conn;



    public function __construct($nome, $email, $telefone, $senha)
    {
        parent::__construct($nome, $senha);
        $this->nome = $nome;
        $this->email = $email;
        $this->telefone = $telefone;
        $this->senha = $senha;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getTelefone()
    {
        return $this->telefone;
    }

    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function setSenha($senha)
    {
        $this->senha = $senha;
    }

    public function login($login, $password)
    {
        $databaseConnection = DatabaseConnection::getInstance();
        $conn = $databaseConnection->getConnection();
        $sql = "SELECT id, nome, email, telefone  FROM proprietarios WHERE (email = '$login' OR telefone = '$login') AND senha = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $this->setNome($row["nome"]);
            $this->setEmail($row["email"]);
            $this->setTelefone($row["telefone"]);
            $this->setId($row["id"]);


            $_SESSION["user_id"] = $row["id"];
            $_SESSION["user_nome"] = $row["nome"];
            $_SESSION["user_role"] = "proprietario";
            header("Location: ../views/painel.php");
            exit;
        } else {
            echo '<script>alert("Login ou senha inválidos. Tente novamente.");window.location.href = "../index.php";</script>';
        }

    }



    public function cadastrar()
    {
        // Realize o cadastro do novo proprietário no banco de dados
        $databaseConnection = DatabaseConnection::getInstance();
        $conn = $databaseConnection->getConnection();

        $sqlVerificaEmail = "SELECT * FROM proprietarios WHERE email = '$this->email'";
        $sqlVerificaTelefone = "SELECT * FROM proprietarios WHERE telefone = '$this->telefone'";

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
            $sql = "INSERT INTO proprietarios (nome, email,telefone, senha) VALUES ('$this->nome', '$this->email','$this->telefone', '$this->senha')";
            if ($conn->query($sql) === TRUE) {
                // Notificar os observadores sobre o cadastro concluído


                header("Location: ../views/index.php");
            } else {
                echo '<script>alert("Erro ao cadastrar.");</script>';
                $erro = true;
                exit;
            }
        }

    }


}

?>