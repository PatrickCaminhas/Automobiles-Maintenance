<?php
require_once 'conexao.php';



class Proprietario extends Usuario
{

    private $id;
    private $nome;
    private $email;
    private $telefone;
    private $senha;
    private $conn = conectarBancoDados();



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
        $sql = "SELECT id, nome, email, telefone  FROM proprietarios WHERE (email = '$login' OR telefone = '$login') AND senha = '$password'";
        $result = $this->conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $this->setNome($row["nome"]);
            $this->setEmail($row["email"]);
            $this->setTelefone($row["telefone"]);
            $this->setId($row["id"]);


            $_SESSION["user_id"] = $row["id"];
            $_SESSION["user_nome"] = $row["nome"];
            $_SESSION["user_role"] = "proprietario";
            header("Location: ../cliente/painel.php");
            exit;
        } else {
            echo '<script>alert("Login ou senha inválidos. Tente novamente.");window.location.href = "../index.php";</script>';
        }

        $this->conn->close();
    }



    public function cadastrar()
    {
        // Realize o cadastro do novo proprietário no banco de dados

        $sqlVerificaEmail = "SELECT * FROM proprietarios WHERE email = '$this->email'";
        $sqlVerificaTelefone = "SELECT * FROM proprietarios WHERE telefone = '$this->telefone'";

        $resultadoEmail = $this->conn->query($sqlVerificaEmail);
        $resultadoTelefone = $this->conn->query($sqlVerificaTelefone);
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
            if ($this->conn->query($sql) === TRUE) {
                // Notificar os observadores sobre o cadastro concluído


                header("Location: ../index.php");
            } else {
                echo '<script>alert("Erro ao cadastrar.");</script>';
                $erro = true;
                exit;
            }
        }

        $this->conn->close();
    }


}


if (isset($_GET["funcao"])) {
    $funcao = $_GET["funcao"];

    switch ($funcao) {
        case "cadastrar":
            $proprietario = new Proprietario($_POST["nome"], $_POST["email"], $_POST["telefone"], $_POST["senha"]);
            $proprietario->cadastrar();
            break;
        case "cancelarAgendamento":
            //cancelarAgendamento($_POST["placa"]);
            break;
        // Adicione mais cases para outras funções
        default:
            // Função não encontrada
            echo "Função não encontrada.";
    }
}

?>