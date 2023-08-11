<?php
require_once '../../helpers/conexao.php';
require_once '../../helpers/validadores.php';
require_once 'usuarioCliente.php';

class Veiculo
{

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

    public function __construct($marca, $modelo, $ano, $placa, $proprietario_id, $estado_do_veiculo)
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
        $databaseConnection = DatabaseConnection::getInstance();
        $conn = $databaseConnection->getConnection();
        // Realize a consulta para verificar se a placa já foi cadastrada
        $sql_consulta = "SELECT * FROM veiculos WHERE placa = '$this->placa'";
        $resultado_consulta = $conn->query($sql_consulta);

        if ($resultado_consulta->num_rows > 0) {
            echo '<script>alert("Erro: Carro com a placa informada já está cadastrado!"); window.location.href = "../views/cadastroVeiculo.php";</script>';
            echo "Erro ao cadastrar o veículo: " . $conn->error;
        } else if(validarPlaca($this->placa) == false){
            echo '<script>alert("Erro: Placa em modelo incorreto! Favor inserir novamente!"); window.location.href = "../views/cadastroVeiculo.php";</script>';
            echo "Erro ao cadastrar o veículo: " . $conn->error;
        }else {
            // Realize o cadastro do novo veículo no banco de dados
            $sql_cadastro = "INSERT INTO veiculos (marca, modelo, ano, placa, proprietario_id, estado_do_veiculo) VALUES ('$this->marca', '$this->modelo', '$this->ano', '$this->placa', '$this->proprietario_id', 'Com proprietário')";
            if ($conn->query($sql_cadastro) === TRUE) {
                echo '<script>alert("Cadastro concluído com sucesso!"); window.location.href = "../views/painel.php";</script>';
                exit;
            } else {
                echo "Erro ao cadastrar o veículo: " . $conn->error;
            }
        }
    }

    public function updateVeiculo()
    {
        // Realiza a consulta para verificar se já existe algum veículo cadastrado com a nova placa
        $databaseConnection = DatabaseConnection::getInstance();
        $conn = $databaseConnection->getConnection();

        
        $sql_consulta_placa = "SELECT id FROM veiculos WHERE placa = '$this->placa' AND proprietario_id = '$this->proprietario_id'";
        $resultado_consulta = $conn->query($sql_consulta_placa);

        if ($resultado_consulta->num_rows > 1) {
            // Caso encontre outro veículo com a mesma placa e ID diferente, exibe um aviso
            $veiculo_existente = $resultado_consulta->fetch_assoc();

            if ($veiculo_existente["id"] != $_GET["id"]) {
                echo '<script>alert("Erro: Carro com a placa informada já está cadastrado!"); window.location.href = "../views/cadastroVeiculo.php";</script>';
                exit;
            }

            // Caso encontre outro veículo com a mesma placa, mas mesmo ID (o mesmo veículo), permite atualizar as informações
            $sql_atualizar = "UPDATE veiculos SET marca = '$this->marca', modelo = '$this->modelo', ano = '$this->ano' WHERE placa = '$this->placa' AND proprietario_id = '$this->proprietario_id'";
            if ($conn->query($sql_atualizar) === TRUE) {
                echo '<script>alert("Atualização do veículo concluída com sucesso!"); window.location.href = "../views/painel.php";</script>';
            } else {
                echo "Erro ao atualizar as informações do veículo: " . $conn->error;
            }

        } else {
            // Caso a placa não esteja duplicada, realiza a atualização das informações do veículo no banco de dados
            $sql_atualizar = "UPDATE veiculos SET marca = '$this->marca', modelo = '$this->modelo', ano = '$this->ano' WHERE placa = '$this->placa' AND proprietario_id = '$this->proprietario_id'";
            if ($conn->query($sql_atualizar) === TRUE) {
                echo '<script>alert("Atualização do veículo concluída com sucesso!"); window.location.href = "../views/painel.php";</script>';
            } else {
                echo "Erro ao atualizar as informações do veículo: " . $conn->error;
            }
        }
    }



    // Restante dos métodos e atributos da classe Veiculo
    // ...


}


function selectTodosVeiculos($conn)
{
    $sql = "SELECT * FROM veiculos";
    $resultado = $conn->query($sql);
    $listaVeiculos = array();

    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $listaVeiculos[] = $row;
        }
    }

    return $listaVeiculos;
}

function selectVeiculoPorPlaca($conn, $placa)
{
    $sql = "SELECT * FROM veiculos WHERE placa = '$placa'";
    $resultado = $conn->query($sql);
    $listaVeiculos = array();

    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $listaVeiculos[] = $row;
        }
    }

    return $listaVeiculos;
}

/*
function selectVeiculosPorLogin($conn, $login)
{
    if (validarCelular($login)) {
        $login = idClienteCelular($login);
        $sql = "SELECT * FROM veiculos WHERE proprietario_id = '$login'";
        $resultado = $conn->query($sql);
        $listaVeiculos = array();

        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $listaVeiculos[] = $row;
            }
        }
    } else if (validarEmail($login)) {
        $login = idClienteEmail($login);
        $sql = "SELECT * FROM veiculos WHERE proprietario_id = '$login'";
        $resultado = $conn->query($sql);
        $listaVeiculos = array();

        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $listaVeiculos[] = $row;
            }
        }
    } else {
        echo "Login inválido";
    }
    return $listaVeiculos;
}*/

function obterListaVeiculos()
{
    $databaseConnection = DatabaseConnection::getInstance();
    $conn = $databaseConnection->getConnection();
$sql = "SELECT p.nome as proprietario_nome, p.telefone as proprietario_telefone,
    v.marca, v.modelo, v.ano, v.placa, v.estado_do_veiculo, m.estado_do_veiculo as estado_manutencao,
    m.data_manutencao, m.previsaoTermino, m.tipo_servico, m.custo, v.proprietario_id
FROM manutencoes m
INNER JOIN veiculos v ON m.placa = v.placa
LEFT JOIN proprietarios p ON v.proprietario_id = p.id
WHERE v.estado_do_veiculo NOT IN ('Com proprietario') AND m.estado_do_veiculo NOT IN ('Entregue ao proprietario') AND m.estado_do_veiculo NOT LIKE 'Cancelamento de agendamento de manutenção realizado para o veículo de placa:%' ;";
    $resultado = $conn->query($sql);
    $listaVeiculos = array();

    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $listaVeiculos[] = $row;
        }
    }

    return $listaVeiculos;
}
function obterDadosVeiculo($placa)
{
    $databaseConnection = DatabaseConnection::getInstance();
    $conn = $databaseConnection->getConnection();

    $placa_veiculo = mysqli_real_escape_string($conn, $placa);
    $sql = "SELECT v.id as veiculo_id, p.nome as proprietario_nome, p.telefone as proprietario_telefone,
            v.marca, v.modelo, v.ano, v.placa, v.estado_do_veiculo
            FROM veiculos v
            INNER JOIN proprietarios p ON v.proprietario_id = p.id
            WHERE v.placa = '$placa_veiculo'";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows == 1) {
        $dadosVeiculo = $resultado->fetch_assoc();
    } else {
        $dadosVeiculo = null;
    }

    return $dadosVeiculo;
}

function obterObservacoes($placa)
{
    $databaseConnection = DatabaseConnection::getInstance();
    $conn = $databaseConnection->getConnection();
$sql = "SELECT observacoes FROM manutencoes WHERE placa = '$placa' AND id = (SELECT MAX(id) FROM manutencoes WHERE placa = '$placa')";
    $result = $conn->query($sql);
    
    // Verifica se há resultados na consulta
    if ($result->num_rows > 0) {
        // Retorna o array associativo com as observações
        $observacoes = $result->fetch_assoc();
    } else {
        // Caso não haja resultados, retorna um array vazio
        $observacoes = array();
    }

    return $observacoes;
}

function obterDataManutencao($placa)
{
    $databaseConnection = DatabaseConnection::getInstance();
    $conn = $databaseConnection->getConnection();

    $placa_veiculo = mysqli_real_escape_string($conn, $placa);
    $sql = "SELECT data_manutencao FROM manutencoes WHERE placa = '$placa_veiculo' AND id = (SELECT MAX(id) FROM manutencoes WHERE placa = '$placa_veiculo')";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows == 1) {
        $data_manutencaoArray = $resultado->fetch_assoc();
        $data_manutencao = $data_manutencaoArray['data_manutencao'];
    } else {
        $data_manutencao = '';
    }

    return $data_manutencao;

}

function obterDataFinal($placa){

    $databaseConnection = DatabaseConnection::getInstance();
    $conn = $databaseConnection->getConnection();

    $placa_veiculo = mysqli_real_escape_string($conn, $placa);
    $sql = "SELECT previsaoTermino FROM manutencoes WHERE placa = '$placa_veiculo' AND id = (SELECT MAX(id) FROM manutencoes WHERE placa = '$placa_veiculo')";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows == 1) {
        $previsaoTerminoArray = $resultado->fetch_assoc();
        $previsaoTermino = $previsaoTerminoArray['previsaoTermino'];
    } else {
        $previsaoTermino = '';
    }

    return $previsaoTermino;

}

function obterTipoServico($placa)
{
    $databaseConnection = DatabaseConnection::getInstance();
    $conn = $databaseConnection->getConnection();

    $placa_veiculo = mysqli_real_escape_string($conn, $placa);
    $sql = "SELECT tipo_servico FROM manutencoes WHERE placa = '$placa_veiculo' AND id = (SELECT MAX(id) FROM manutencoes WHERE placa = '$placa_veiculo')";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows == 1) {
        $tipoServicoArray = $resultado->fetch_assoc();
        $tipoServico = $tipoServicoArray['tipo_servico'];

    } else {
        $tipoServico = '';
    }

    return $tipoServico;
}

function obterCusto($placa)
{
    $databaseConnection = DatabaseConnection::getInstance();
    $conn = $databaseConnection->getConnection();
$placa_veiculo = mysqli_real_escape_string($conn, $placa);
    $sql = "SELECT custo FROM manutencoes WHERE placa = '$placa_veiculo' AND id = (SELECT MAX(id) FROM manutencoes WHERE placa = '$placa_veiculo')";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows == 1) {
        $custoArray = $resultado->fetch_assoc();
        $custo = $custoArray['custo'];

    } else {
        $custo = '';
    }

    return $custo;
}



?>