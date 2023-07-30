<?php
require_once 'conexao.php';
require_once 'validadores.php';
require_once 'usuarioCliente.php';
session_start();


#function inserirVeiculo($conn, $id, $proprietario_id, $marca, $modelo, $ano, $placa, $estado_do_veiculo)
#{
#    $sql = "INSERT INTO veiculos (id, proprietario_id, marca, modelo, ano, placa, estado_do_veiculo) VALUES ('$id', '$proprietario_id', '$marca', '$modelo', '$ano', '$placa', '$estado_do_veiculo')";
#    $conn->query($sql);
#}
function inserirVeiculo($conn, $proprietario_id, $marca, $modelo, $ano, $placa, $estado_do_veiculo)
{
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $marca = $_POST["marca"];
    $modelo = $_POST["modelo"];
    $ano = $_POST["ano"];
    $placa_letras = $_POST["placa_letra"]; // Array com as letras da placa
    $placa_numeros = $_POST["placa_numero"]; // Array com os números da placa
    $placa = implode('', $placa_letras) . implode('', $placa_numeros); // Concatena as letras e os números
    $proprietario_id = $_SESSION["user_id"]; // Obtém o ID do proprietário da sessão

    // Realize a consulta para verificar se a placa já foi cadastrada
    $conn = conectarBancoDados();
    $sql_consulta = "SELECT * FROM veiculos WHERE placa = '$placa'";
    $resultado_consulta = $conn->query($sql_consulta);

    if ($resultado_consulta->num_rows > 0) {
        $conn->close();
        echo '<script>alert("Erro: Carro com a placa informada já está cadastrado!");</script>';
        header("Location: cadastroVeiculo.php");
    } else {
        // Realize o cadastro do novo veículo no banco de dados
        $sql_cadastro = "INSERT INTO veiculos (marca, modelo, ano, placa, proprietario_id, estado_do_veiculo) VALUES ('$marca', '$modelo', '$ano', '$placa', '$proprietario_id', 'Com proprietário')";
        if ($conn->query($sql_cadastro) === TRUE) {
            $conn->close();
            echo '<script>alert("Cadastro concluído com sucesso!");</script>';
            header("Location: painel.php");
            exit;
        } else {
            echo "Erro ao cadastrar o veículo: " . $conn->error;
            header("Location: cadastroVeiculo.php");
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
function updateVeiculo($conn, $marca, $modelo, $ano, $placa)
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
                echo "Informações do veículo atualizadas com sucesso!";
            } else {
                echo "Erro ao atualizar as informações do veículo: " . $conn->error;
            }
        
    } else {
        // Caso a placa não esteja duplicada, realiza a atualização das informações do veículo no banco de dados
        $sql_atualizar = "UPDATE veiculos SET marca = '$marca', modelo = '$modelo', ano = '$ano' WHERE placa = '$placa' AND proprietario_id = $user_id";
        if ($conn->query($sql_atualizar) === TRUE) {
            echo "Informações do veículo atualizadas com sucesso!";
        } else {
            echo "Erro ao atualizar as informações do veículo: " . $conn->error;
        }
    }

    // Feche a conexão com o banco de dados
    $conn->close();
}
}


function deleteVeiculo($conn, $placa)
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
    
        // Realize o agendamento da manutenção no banco de dados
        $conn = conectarBancoDados();
    
        // Atualizar o campo "estado_do_veiculo" na tabela "veiculos" para refletir que o veículo está com proprietário
       
        $sql_veiculo = "DELETE FROM veiculos WHERE placa = '$placa'";
        $conn->query($sql_veiculo);
        // Consultar a data de agendamento da manutenção
    
    
        // Fechar a conexão com o banco de dados
        $conn->close();
    }
    else{
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


function selectVeiculoPorLogin($conn, $login)
{
    if(validarCelular($login)){
    $login = idClienteCelular( $login);
    $sql = "SELECT * FROM veiculos WHERE proprietario_id = '$login'";
    $resultado = $conn->query($sql);
    $listaVeiculos = array();

    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $listaVeiculos[] = $row;
        }
    }
    }
    else if(validarEmail($login)){
        $login = idClienteEmail($login);
        $sql = "SELECT * FROM veiculos WHERE proprietario_id = '$login'";
        $resultado = $conn->query($sql);
        $listaVeiculos = array();
    
        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $listaVeiculos[] = $row;
            }
        }
    }
    else{
        echo "Login inválido";
    }
    $conn->close();
    return $listaVeiculos;
}





?>