<?php
require_once 'conexao.php';
require_once 'validadores.php';

class Veiculo
{
    private $conn = conectarBancoDados();

    private $marca;
    private $modelo;
    private $ano;
    private $placa;
    private $proprietario_id;
    private $estado_do_veiculo;

    public function getMarca()
    {
        return $this->marca;
    }

    public function setMarca($marca)
    {
        $this->marca = $marca;
    }
    
    public function getModelo()
    {
        return $this->modelo;
    }

    public function setModelo($modelo)
    {
        $this->modelo = $modelo;
    }

    public function getAno()
    {
        return $this->ano;
    }

    public function setAno($ano)
    {
        $this->ano = $ano;
    }

    public function getPlaca()
    {
        return $this->placa;
    }

    public function setPlaca($placa)
    {
        $this->placa = $placa;
    }

    public function getProprietarioId()
    {
        return $this->proprietario_id;
    }

    public function setProprietarioId($proprietario_id)
    {
        $this->proprietario_id = $proprietario_id;
    }

    public function getEstadoDoVeiculo()
    {
        return $this->estado_do_veiculo;
    }  

    public function setEstadoDoVeiculo($estado_do_veiculo)
    {
        $this->estado_do_veiculo = $estado_do_veiculo;
    }

    public function __construct( $marca, $modelo, $ano, $placa, $proprietario_id, $estado_do_veiculo)
    {
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->ano = $ano;
        $this->placa = $placa;
        $this->proprietario_id = $proprietario_id;
        $this->estado_do_veiculo = $estado_do_veiculo;
    }

    public function inserirVeiculo()
    {
        // Realize a consulta para verificar se a placa já foi cadastrada
        $sql_consulta = "SELECT * FROM veiculos WHERE placa = '$this->placa'";
        $resultado_consulta = $this->conn->query($sql_consulta);

        if ($resultado_consulta->num_rows > 0) {
            echo '<script>alert("Erro: Carro com a placa informada já está cadastrado!"); window.location.href = "../cliente/cadastroVeiculo.php";</script>';
            echo "Erro ao cadastrar o veículo: " . $this->conn->error;
        } else {
            // Realize o cadastro do novo veículo no banco de dados
            $sql_cadastro = "INSERT INTO veiculos (marca, modelo, ano, placa, proprietario_id, estado_do_veiculo) VALUES ('$this->marca', '$this->modelo', '$this->ano', '$this->placa', '$this->proprietario_id', 'Com proprietario')";
            if ($this->conn->query($sql_cadastro) === TRUE) {
                echo '<script>alert("Cadastro concluído com sucesso!"); window.location.href = "../cliente/painel.php";</script>';
                exit;
            } else {
                echo "Erro ao cadastrar o veículo: " . $this->conn->error;
            }
        }
    }

    public function updateVeiculo()
    {
        // Realiza a consulta para verificar se já existe algum veículo cadastrado com a nova placa
        $user_id = $_SESSION['user_id'];
        $sql_consulta_placa = "SELECT id FROM veiculos WHERE placa = '$this->placa' AND proprietario_id = $user_id";
        $resultado_consulta = $this->conn->query($sql_consulta_placa);

        if ($resultado_consulta->num_rows > 0) {
            // Caso encontre outro veículo com a mesma placa e ID diferente, exibe um aviso
            $veiculo_existente = $resultado_consulta->fetch_assoc();

            if ($veiculo_existente["id"] != $_GET["id"]) {
                echo '<script>alert("Erro: Carro com a placa informada já está cadastrado!"); window.location.href = "../cliente/cadastroVeiculo.php";</script>';
                exit;
            }

            // Caso encontre outro veículo com a mesma placa, mas mesmo ID (o mesmo veículo), permite atualizar as informações
            $sql_atualizar = "UPDATE veiculos SET marca = '$this->marca', modelo = '$this->modelo', ano = '$this->ano' WHERE placa = '$this->placa' AND proprietario_id = $user_id";
            if ($this->conn->query($sql_atualizar) === TRUE) {
                echo '<script>alert("Atualização do veículo concluída com sucesso!"); window.location.href = "../cliente/painel.php";</script>';
            } else {
                echo "Erro ao atualizar as informações do veículo: " . $this->conn->error;
            }

        } else {
            // Caso a placa não esteja duplicada, realiza a atualização das informações do veículo no banco de dados
            $sql_atualizar = "UPDATE veiculos SET marca = '$this->marca', modelo = '$this->modelo', ano = '$this->ano' WHERE placa = '$this->placa' AND proprietario_id = $user_id";
            if ($this->conn->query($sql_atualizar) === TRUE) {
                echo '<script>alert("Atualização do veículo concluída com sucesso!"); window.location.href = "../cliente/painel.php";</script>';
            } else {
                echo "Erro ao atualizar as informações do veículo: " . $this->conn->error;
            }
        }
    }

  

    // Restante dos métodos e atributos da classe Veiculo
    // ...


}




