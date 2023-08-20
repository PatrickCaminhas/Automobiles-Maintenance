<?php
use helpers\DatabaseConnection;

require_once "../../helpers/DatabaseConnection.php";
use helpers\Validador;

require_once "../../helpers/Validador.php";

require 'usuario.php';



class Proprietario extends usuario
{

    private $id;
    private $nome;
    private $email;
    private $telefone;
    private $senha;





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
    public function paraPascalCase($nome)
    {
        $palavras = explode(" ", strtolower($nome));
        $palavrasEmPascalCase = array_map('ucfirst', $palavras);
        return implode(" ", $palavrasEmPascalCase);
    }

    public function login($login, $password)
    {
        $databaseConnection = DatabaseConnection::getInstance();
        $conn = $databaseConnection->getConnection();
        $sqlSenhaCriptografada = "SELECT senha FROM proprietarios WHERE email = '$login' OR telefone = '$login'";
        $resultadoSenhaCriptografada = $conn->query($sqlSenhaCriptografada);
        $rowSenhaCriptografada = $resultadoSenhaCriptografada->fetch_assoc();
        $senhaCriptografada = $rowSenhaCriptografada["senha"];
        $senhaRecebida = sha1($this->senha);



        $sql = "SELECT id, nome, email, telefone  FROM proprietarios WHERE (email = '$login' OR telefone = '$login') AND senha = '$senhaRecebida'";
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
            echo '<script>alert("Login ou senha inválidos. Tente novamente.");window.location.href = "../views/index.php";</script>';
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
        $validador = new Validador;
        if ($resultadoEmail->num_rows > 0) {
            echo '<script>alert("Este email já está cadastrado. Por favor, escolha outro email");window.location.href = "../views/cadastro.php";</script>';
            $erro = true;
            exit;
        }

        if ($resultadoTelefone->num_rows > 0) {
            echo '<script>alert("Este telefone já está cadastrado. Por favor, escolha outro telefone.");window.location.href = "../views/cadastro.php";</script>';
            $erro = true;
            exit;
        }
        if ($erro == false) {

            $senhaCriptografada = sha1($this->senha);
            $nomePascalCase = $this->paraPascalCase($this->nome);

            $sql = "INSERT INTO proprietarios (nome, email,telefone, senha) VALUES ('$nomePascalCase', '$this->email','$this->telefone', '$senhaCriptografada')";
            if ($validador->validarCelular($this->telefone) && $validador->validarEmail($this->email)) {
                if ($conn->query($sql) === TRUE) {
                    // Notificar os observadores sobre o cadastro concluído


                    header("Location: ../views/index.php");
                } else {
                    echo '<script>alert("Erro ao cadastrar.");window.location.href = "../views/cadastro.php";</script>';
                    $erro = true;
                    exit;
                }
            } else {
                echo '<script>alert("Email ou telefone em formato invalido, favor verificar! .");window.location.href = "../views/cadastro.php";</script>';
                $erro = true;
                exit;
            }
        }

    }


}

?>