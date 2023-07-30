<?php
require_once 'conexao.php';

session_start();

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
?>
