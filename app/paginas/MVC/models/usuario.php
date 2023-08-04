<?php   
class Usuario
{
    private $nome;
    private $senha;

    public function __construct($nome, $senha)
    {
        $this->nome = $nome;
        $this->senha = $senha;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function setSenha($senha)
    {
        $this->senha = $senha;
    }
}
?>