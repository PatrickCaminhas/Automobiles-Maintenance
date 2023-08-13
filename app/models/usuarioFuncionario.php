<?php
require_once '../../helpers/conexao.php';
require_once 'usuario.php';
class Funcionario extends Usuario
{
    // Restante do código da classe Funcionario
    private $id;
    private $nome;
    private $cpf;
    private $senha;

    public function __construct()
    {
    }

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = trim($id);
    }
    public function getNome()
    {
        return $this->nome;
    }
    public function setNome($nome)
    {
        $this->nome = trim($nome);
    }
    public function getCpf()
    {
        return $this->cpf;
    }
    public function setCpf($cpf)
    {
        $this->cpf = trim($cpf);
    }
    public function getSenha()
    {
        return $this->senha;
    }
    public function setSenha($senha)
    {
        $this->senha = trim($senha);
    }

    

    public function login($login, $password)
    {
        // Realize a autenticação verificando o CPF e senha no banco de dados
        // Substitua 'seu_usuario', 'sua_senha', 'seu_banco_de_dados' pelas suas credenciais
        $databaseConnection = DatabaseConnection::getInstance();
        $conn = $databaseConnection->getConnection();
        $sqlSenhaCriptografada = "SELECT senha FROM usuarios WHERE cpf = '$login'";
        $resultadoSenhaCriptografada = $conn->query($sqlSenhaCriptografada);
        $rowSenhaCriptografada = $resultadoSenhaCriptografada->fetch_assoc();
        $senhaCriptografada = $rowSenhaCriptografada["senha"];
        $senhaRecebida = sha1($password);

       
        $sql = "SELECT id, nome FROM usuarios WHERE cpf = '$login' AND senha = '$senhaRecebida'";
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
            echo '<script>alert("Login ou senha inválidos. Tente novamente.");window.location.href = "../views/index.php";</script>';
        }

    }
}

?>