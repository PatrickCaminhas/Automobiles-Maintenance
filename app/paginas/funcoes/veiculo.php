<?php
require_once 'conexao.php';
require_once 'validadores.php';
require_once 'usuarioCliente.php';



#function inserirVeiculo($conn, $id, $proprietario_id, $marca, $modelo, $ano, $placa, $estado_do_veiculo)
#{
#    $sql = "INSERT INTO veiculos (id, proprietario_id, marca, modelo, ano, placa, estado_do_veiculo) VALUES ('$id', '$proprietario_id', '$marca', '$modelo', '$ano', '$placa', '$estado_do_veiculo')";
#    $conn->query($sql);
#}
function inserirVeiculo($proprietario_id, $marca, $modelo, $ano)
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $placa = $_POST["placa_letra1"] . $_POST["placa_letra2"] . $_POST["placa_letra3"] . $_POST["placa_numero1"] . $_POST["placa_letra4"] . $_POST["placa_numero2"] . $_POST["placa_numero3"];


        // Realize a consulta para verificar se a placa já foi cadastrada
        $conn = conectarBancoDados();
        $sql_consulta = "SELECT * FROM veiculos WHERE placa = '$placa'";
        $resultado_consulta = $conn->query($sql_consulta);

        if ($resultado_consulta->num_rows > 0) {
            $conn->close();
            echo '<script>alert("Erro: Carro com a placa informada já está cadastrado!"); window.location.href = "../cliente/cadastroVeiculo.php";</script>';
            echo "Erro ao cadastrar o veículo: " . $conn->error;


        } else {
            // Realize o cadastro do novo veículo no banco de dados
            $sql_cadastro = "INSERT INTO veiculos (marca, modelo, ano, placa, proprietario_id, estado_do_veiculo) VALUES ('$marca', '$modelo', '$ano', '$placa', '$proprietario_id', 'Com proprietário')";
            if ($conn->query($sql_cadastro) === TRUE) {
                $conn->close();
                echo '<script>alert("Cadastro concluído com sucesso!"); window.location.href = "../cliente/painel.php";</script>';
                exit;
            } else {
                echo "Erro ao cadastrar o veículo: " . $conn->error;
            }

            $conn->close();
        }
    }
}


#function updateVeiculo($conn, $id, $proprietario_id, $marca, $modelo, $ano, $placa, $estado_do_veiculo)
#{
#    $sql = "UPDATE veiculos SET id = '$id', proprietario_id = '$proprietario_id', marca = '$marca', modelo = '$modelo', ano = '$ano', placa = '$placa', estado_do_veiculo = '$estado_do_veiculo' WHERE id = '$id'";
#    $conn->query($sql);
#}
function updateVeiculo($marca, $modelo, $ano, $placa)
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $marca = $_POST["marca"];
        $modelo = $_POST["modelo"];
        $ano = $_POST["ano"];
        $placa = $_POST["placa"];

        // Realiza a consulta para verificar se já existe algum veículo cadastrado com a nova placa
        $conn = conectarBancoDados();
        $user_id = $_SESSION['user_id'];
        $sql_consulta_placa = "SELECT id FROM veiculos WHERE placa = '$placa' AND proprietario_id = $user_id";
        $resultado_consulta = $conn->query($sql_consulta_placa);

        if ($resultado_consulta->num_rows > 0) {
            // Caso encontre outro veículo com a mesma placa e ID diferente, exibe um aviso
            $veiculo_existente = $resultado_consulta->fetch_assoc();


            // Caso encontre outro veículo com a mesma placa, mas mesmo ID (o mesmo veículo), permite atualizar as informações
            $sql_atualizar = "UPDATE veiculos SET marca = '$marca', modelo = '$modelo', ano = '$ano' WHERE placa = '$placa' AND proprietario_id = $user_id";
            if ($conn->query($sql_atualizar) === TRUE) {
                echo '<script>alert("Atualização do veiculo concluída com sucesso!"); window.location.href = "../cliente/painel.php";</script>';

            } else {
                echo "Erro ao atualizar as informações do veículo: " . $conn->error;
            }

        } else {
            // Caso a placa não esteja duplicada, realiza a atualização das informações do veículo no banco de dados
            $sql_atualizar = "UPDATE veiculos SET marca = '$marca', modelo = '$modelo', ano = '$ano' WHERE placa = '$placa' AND proprietario_id = $user_id";
            if ($conn->query($sql_atualizar) === TRUE) {
                echo '<script>alert("Atualização do veiculo concluída com sucesso!"); window.location.href = "../cliente/painel.php";</script>';
            } else {
                echo "Erro ao atualizar as informações do veículo: " . $conn->error;
            }
        }

        // Feche a conexão com o banco de dados
        $conn->close();
    }
}


function deleteVeiculo($placa)
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {


        // Realize o agendamento da manutenção no banco de dados
        $conn = conectarBancoDados();

        // Atualizar o campo "estado_do_veiculo" na tabela "veiculos" para refletir que o veículo está com proprietário

        $sql_veiculo = "DELETE FROM veiculos WHERE placa = '$placa'";
        $conn->query($sql_veiculo);
        // Consultar a data de agendamento da manutenção

        echo '<script>alert("Exclusão do veiculo concluída com sucesso!"); window.location.href = "../cliente/painel.php";</script>';

        // Fechar a conexão com o banco de dados
        $conn->close();
    } else {
        echo "Não foi possível excluir o veículo";
    }
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

    $conn->close();
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

    $conn->close();
    return $listaVeiculos;
}


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
    $conn->close();
    return $listaVeiculos;
}

function obterListaVeiculos()
{
    $conn = conectarBancoDados();
    $sql = "SELECT p.nome as proprietario_nome, p.telefone as proprietario_telefone,
    v.marca, v.modelo, v.ano, v.placa, v.estado_do_veiculo, m.estado_do_veiculo as estado_manutencao,
    m.data_manutencao, m.previsaoTermino, m.tipo_servico, m.custo, v.proprietario_id
FROM manutencoes m
INNER JOIN veiculos v ON m.placa = v.placa
LEFT JOIN proprietarios p ON v.proprietario_id = p.id
WHERE v.estado_do_veiculo NOT IN ('Com proprietario') AND m.estado_do_veiculo NOT IN ('Entregue ao proprietario');";
    $resultado = $conn->query($sql);
    $listaVeiculos = array();

    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $listaVeiculos[] = $row;
        }
    }

    $conn->close();
    return $listaVeiculos;
}
function obterDadosVeiculo($placa, $conn)
{
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

function obterObservacoes($placa, $conn)
{
    $placa_veiculo = mysqli_real_escape_string($conn, $placa);
    $sql = "SELECT observacoes FROM manutencoes WHERE placa = '$placa_veiculo' AND data_manutencao = (SELECT MAX(data_manutencao) FROM manutencoes WHERE placa = '$placa_veiculo')";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows == 1) {
        $observacoes = $resultado->fetch_assoc();
    } else {
        $observacoes = '';
    }

    return $observacoes;
}

function obterDataManutencao($placa, $conn)
{
    $placa_veiculo = mysqli_real_escape_string($conn, $placa);
    $sql = "SELECT data_manutencao FROM manutencoes WHERE placa = '$placa_veiculo' AND data_manutencao = (SELECT MAX(data_manutencao) FROM manutencoes WHERE placa = '$placa_veiculo')";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows == 1) {
        $dataManutencaoArray = $resultado->fetch_assoc();
        $dataManutencao = $dataManutencaoArray['data_manutencao'];
    } else {
        $dataManutencao = '';
    }

    return $dataManutencao;

}

function obterTipoServico($placa, $conn)
{
    $placa_veiculo = mysqli_real_escape_string($conn, $placa);
    $sql = "SELECT tipo_servico FROM manutencoes WHERE placa = '$placa_veiculo' AND data_manutencao = (SELECT MAX(data_manutencao) FROM manutencoes WHERE placa = '$placa_veiculo')";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows == 1) {
        $tipoServicoArray = $resultado->fetch_assoc();
        $tipoServico = $tipoServicoArray['tipo_servico'];

    } else {
        $tipoServico = '';
    }

    return $tipoServico;
}

function obterCusto($placa, $conn)
{
    $placa_veiculo = mysqli_real_escape_string($conn, $placa);
    $sql = "SELECT custo FROM manutencoes WHERE placa = '$placa_veiculo' AND data_manutencao = (SELECT MAX(data_manutencao) FROM manutencoes WHERE placa = '$placa_veiculo')";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows == 1) {
        $custoArray = $resultado->fetch_assoc();
        $custo = $custoArray['custo'];

    } else {
        $custo = '';
    }

    return $custo;
}


if (isset($_GET["funcao"])) {
    $funcao = $_GET["funcao"];

    switch ($funcao) {
        case "cadastrarVeiculo":
            inserirVeiculo($_POST["proprietario_id"], $_POST["marca"], $_POST["modelo"], $_POST["ano"]);
            break;
        case "alterarVeiculo":
            updateVeiculo($_POST["marca"], $_POST["modelo"], $_POST["ano"], $_POST["placa"]);
            break;
        case "excluirVeiculo":
            deleteVeiculo($_POST["placa"]);
            break;

        // Adicione mais cases para outras funções
        default:
            // Função não encontrada
            echo "Função não encontrada.";
    }
}



?>