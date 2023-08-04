<?php
require_once 'conexao.php';
class Manutencao
{
    private $conn = conectarBancoDados();
    private $id;
    private $placa;
    private $estado_do_veiculo;
    private $dataManutencao;
    private $dataTermino;
    private $tipo_servico;
    private $observacoes;
    private $custo;

    public function __construct($placa, $estado_do_veiculo, $dataManutencao, $dataTermino, $tipo_servico, $observacoes, $custo)
    {

        $this->placa = $placa;
        $this->estado_do_veiculo = $estado_do_veiculo;
        $this->dataManutencao = $dataManutencao;
        $this->dataTermino = $dataTermino;
        $this->tipo_servico = $tipo_servico;
        $this->observacoes = $observacoes;
        $this->custo = $custo;
    }


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getPlaca()
    {
        return $this->placa;
    }

    public function setPlaca($placa)
    {
        $this->placa = $placa;
    }

    public function getEstadoDoVeiculo()
    {
        return $this->estado_do_veiculo;
    }

    public function setEstadoDoVeiculo($estado_do_veiculo)
    {
        $this->estado_do_veiculo = $estado_do_veiculo;
    }

    public function getDataManutencao()
    {
        return $this->dataManutencao;
    }

    public function setDataManutencao($dataManutencao)
    {
        $this->dataManutencao = $dataManutencao;
    }

    public function getDataTermino()
    {
        return $this->dataTermino;
    }

    public function setDataTermino($dataTermino)
    {
        $this->dataTermino = $dataTermino;
    }

    public function getTipoServico()
    {
        return $this->tipo_servico;
    }

    public function setTipoServico($tipo_servico)
    {
        $this->tipo_servico = $tipo_servico;
    }

    public function getObservacoes()
    {
        return $this->observacoes;
    }

    public function setObservacoes($observacoes)
    {
        $this->observacoes = $observacoes;
    }

    public function getCusto()
    {
        return $this->custo;
    }

    public function setCusto($custo)
    {
        $this->custo = $custo;
    }
    public function agendarManutencao($placa, $data_manutencao)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $placa = $_POST["placa"];
            $data_manutencao = $_POST["data_manutencao"];
            $descricao = $_POST["descricao"];
            // Realize o agendamento da manutenção no banco de dados
            $conn = conectarBancoDados();

            // Aqui você pode inserir os dados do agendamento na tabela de manutenções (por exemplo, "manutencoes") 
            // e atualizar o campo "estado_do_veiculo" na tabela de veículos para refletir que o veículo está em manutenção.
            // Exemplo:
            // 1. Inserir o agendamento na tabela "manutencoes": 

            $sql_atualizar_estado = "UPDATE veiculos SET estado_do_veiculo = 'Entrega agendada para o dia: $data_manutencao' WHERE placa = '$placa'";
            $conn->query($sql_atualizar_estado);


            $sql_agendamento = "INSERT INTO manutencoes (placa, data_manutencao, estado_do_veiculo) VALUES ('$placa', '$data_manutencao', 'Entrega agendada para o dia: $data_manutencao')";
            $conn->query($sql_agendamento);

            // 2. Atualizar o campo "estado_do_veiculo" na tabela "veiculos" para refletir que o veículo está em manutenção.


            $conn->close();
            echo '<script>alert("Manutenção agendada com sucesso!"); window.location.href = "../cliente/painel.php";</script>';

        }
    }

    public function cancelarAgendamento($placa)
    {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $placa = $_POST["placa"];

            // Realize o agendamento da manutenção no banco de dados
            $conn = conectarBancoDados();

            // Atualizar o campo "estado_do_veiculo" na tabela "veiculos" para refletir que o veículo está com proprietário


            // Consultar a data de agendamento da manutenção
            $sql_consulta_data = "SELECT data_manutencao FROM manutencoes WHERE placa = '$placa' AND estado_do_veiculo LIKE 'Entrega agendada para o dia:%'";
            $resultado_datas = $conn->query($sql_consulta_data);

            // Verificar se encontrou uma data
            if ($resultado_datas->num_rows > 0) {
                // Extrair a data da primeira linha do resultado
                $row = $resultado_datas->fetch_assoc();
                $data_manutencao = $row['data_manutencao'];

                // Deletar o agendamento da manutenção
                $sql_agendamento = "DELETE FROM manutencoes WHERE placa = '$placa' AND data_manutencao = '$data_manutencao'";
                $conn->query($sql_agendamento);
                $sql_atualizar_estado = "UPDATE veiculos SET estado_do_veiculo = 'Com proprietário' WHERE placa = '$placa'";
                $conn->query($sql_atualizar_estado);
                echo '<script>alert("Agendamento de manutenção cancelada!"); window.location.href = "../cliente/painel.php";</script>';
            } else {
                echo '<script>alert("Não foi encontrado nenhum agendamento para o veículo."); window.location.href = "../cliente/painel.php";</script>';
            }

            // Fechar a conexão com o banco de dados
            $conn->close();
        }

    }


    public function finalizarManutencao($placa)
    {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $placa = $_POST["placa"];

            // Realize o agendamento da manutenção no banco de dados
            $conn = conectarBancoDados();

            // Atualizar o campo "estado_do_veiculo" na tabela "veiculos" para refletir que o veículo está com proprietário


            // Consultar a data de agendamento da manutenção
            $sql_consulta_data = "SELECT data_manutencao FROM manutencoes WHERE placa = '$placa' AND estado_do_veiculo = 'Manutenção concluída'";
            $resultado_datas = $conn->query($sql_consulta_data);

            // Verificar se encontrou uma data
            if ($resultado_datas->num_rows > 0) {
                // Extrair a data da primeira linha do resultado
                $row = $resultado_datas->fetch_assoc();
                $data_manutencao = $row['data_manutencao'];

                // Deletar o agendamento da manutenção
                $sql_agendamento = "UPDATE manutencoes SET estado_do_veiculo = 'Entregue ao proprietario' WHERE placa = '$placa' AND data_manutencao = '$data_manutencao'";
                $conn->query($sql_agendamento);
                $sql_atualizar_estado = "UPDATE veiculos SET estado_do_veiculo = 'Com proprietário' WHERE placa = '$placa'";
                $conn->query($sql_atualizar_estado);
                echo '<script>alert("Veiculo entregue ao cliente!"); window.location.href = "../funcionario/listarVeiculos.php";</script>';

            } else {
                echo '<script>alert("Não foi possivel entregar o veiculo ao cliente!\nContate o suporte"); window.location.href = "../funcionario/listarVeiculos.php";</script>';

            }

            // Fechar a conexão com o banco de dados
            $conn->close();
        }

    }
    function atualizarManutencao()
    {
        $sql = "UPDATE manutencoes SET estado_do_veiculo = '$this->estado_do_veiculo', data_manutencao = '$this->dataManutencao', observacoes = '$this->observacoes',  previsaoTermino = '$this->dataTermino', tipo_servico = '$this->tipo_servico', custo = '$this->custo' WHERE placa = '$this->placa' AND data_manutencao = (SELECT MAX(data_manutencao) FROM manutencoes WHERE placa = '$this->placa')";
        $sqlveiculo = "UPDATE veiculos SET estado_do_veiculo = '$this->estado_do_veiculo' WHERE placa = '$this->placa'";
        $this->conn->query($sql); // Executar a consulta de atualização
        $this->conn->query($sqlveiculo);

        $this->conn->close();
        header("Location: listarVeiculos.php");
    }


}


if (isset($_GET["funcao"])) {
    $funcao = $_GET["funcao"];
    $manutencao = new Manutencao($_POST["placa"], '', $_POST["dataManutencao"], '', '', '', '');
    switch ($funcao) {
        case "agendaManutencao":
            if($_SESSION['user_role'] !== 'proprietario'){
            $manutencao->agendarManutencao($_POST["placa"], $_POST["data_manutencao"]);
            }else{
                echo '<script>alert("Você não tem permissão para realizar essa ação!"); window.location.href = "../cliente/painel.php";</script>';
            }
            break;
        case "cancelarAgendamento":
            if($_SESSION['user_role'] !== 'proprietario'){
           // cancelarAgendamento($_POST["placa"]);
            }else{
                echo '<script>alert("Você não tem permissão para realizar essa ação!"); window.location.href = "../cliente/painel.php";</script>';
            }
            break;
        case "finalizarManutencao":
            if($_SESSION['user_role'] !== 'funcionario'){
            //finalizarManutencao($_POST["placa"]);
            }else{
                echo '<script>alert("Você não tem permissão para realizar essa ação!"); window.location.href = "../funcionario/listarVeiculos.php";</script>';
            }
            break;
        case "atualizarManutencao":
            if($_SESSION['user_role'] !== 'funcionario'){
            $dataManutencao = date("Y-m-d");
            $manutencao = new Manutencao($_POST["placa"], $_POST["estado"], $dataManutencao, $_POST["dataTermino"], $_POST["tipo_servico"], $_POST["observacoes"], $_POST["custo"]);
            $manutencao->atualizarManutencao();
            }else{
                echo '<script>alert("Você não tem permissão para realizar essa ação!"); window.location.href = "../funcionario/listarVeiculos.php";</script>';
            }
            break;

        // Adicione mais cases para outras funções
        default:
            // Função não encontrada
            echo "Função não encontrada.";
            header("Location: ../cliente/painel.php");
    }
}
?>