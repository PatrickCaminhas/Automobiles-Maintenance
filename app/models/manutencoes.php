<?php
require_once '../../helpers/conexao.php';
class Manutencao implements SplSubject
{

    private $placa;
    private $estado_do_veiculo;
    private $dataManutencao;
    private $dataTermino;
    private $tipo_servico;
    private $observacoes;
    private $custo;
    private $observers = [];
    private $notificacoes = [];

    private $acao;


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

    public function attach(SplObserver $observer): void
    {
        $this->observers[] = $observer;
    }

    public function detach(SplObserver $observer): void
    {
        $index = array_search($observer, $this->observers);
        if ($index !== false) {
            unset($this->observers[$index]);
        }
    }
    public function setAcao($acao)
    {
        $this->acao = $acao;
    }
    public function notify(): void
    {

        foreach ($this->observers as $observer) {

            $observer->setAcao($this->acao);

            $observer->update($this);

        }

    }


    public function addNotificacao($notificacao)
    {

        $this->notificacoes[] = $notificacao;
    }



    public function getPlaca()
    {
        return $this->placa;
    }

    public function setPlaca($placa)
    {
        $this->placa = $placa;
    }

    public function getEstadoDoVeiculo($placa)
    {
        $databaseConnection = DatabaseConnection::getInstance();
        $conn = $databaseConnection->getConnection();
        $sql = "SELECT estado_do_veiculo FROM veiculos WHERE placa = '$placa'";
        $result = $conn->query($sql);
        $estado = $result->fetch_assoc();
        $estado_do_veiculo = $estado['estado_do_veiculo'];
        return $estado_do_veiculo;
    }

    public function getEstadoUltimaManutencao($placa)
    {
        $databaseConnection = DatabaseConnection::getInstance();
        $conn = $databaseConnection->getConnection();
        $sql = "SELECT estado_do_veiculo FROM manutencoes WHERE placa = '$placa' AND id = (SELECT MAX(id) FROM manutencoes WHERE placa = '$placa')";
        $result = $conn->query($sql);
        $estado = $result->fetch_assoc();
        $estado_da_manutencao = $estado['estado_do_veiculo'];
        $conn->close();
        return $estado_da_manutencao;
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

    public function getObservacoes($placa)
    {
        $databaseConnection = DatabaseConnection::getInstance();
        $conn = $databaseConnection->getConnection();
        $sql = "SELECT observacao FROM manutencoes WHERE placa = '$placa' AND id = (SELECT MAX(id) FROM manutencoes WHERE placa = '$placa')";
        $result = $conn->query($sql);
        $estado = $result->fetch_assoc();
        $observacao_da_manutencao = $estado['observacao'];
        $conn->close();
        return $observacao_da_manutencao;
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

            // Realize o agendamento da manutenção no banco de dados
            $databaseConnection = DatabaseConnection::getInstance();
            $conn = $databaseConnection->getConnection();
    
            // Aqui você pode inserir os dados do agendamento na tabela de manutenções (por exemplo, "manutencoes") 
            // e atualizar o campo "estado_do_veiculo" na tabela de veículos para refletir que o veículo está em manutenção.
            // Exemplo:
            // 1. Inserir o agendamento na tabela "manutencoes": 

            $sql_id_cliente = "SELECT proprietario_id FROM veiculos WHERE placa = '$placa'";
            $result = $conn->query($sql_id_cliente);
            $id_c = $result->fetch_assoc();
            $id_cliente = $id_c['proprietario_id'];
            $_SESSION['id_cliente'] = $id_cliente;


            $sql_atualizar_estado = "UPDATE veiculos SET estado_do_veiculo = 'Entrega agendada para o dia: $data_manutencao' WHERE placa = '$placa'";
            $conn->query($sql_atualizar_estado);


            $sql_agendamento = "INSERT INTO manutencoes (placa, data_manutencao, estado_do_veiculo) VALUES ('$placa', '$data_manutencao', 'Entrega agendada para o dia: $data_manutencao')";
            $conn->query($sql_agendamento);

            // 2. Atualizar o campo "estado_do_veiculo" na tabela "veiculos" para refletir que o veículo está em manutenção.
            $mensagem = "Agendamento de manutenção para o veículo com placa $placa";
            $this->addNotificacao($mensagem);
            $this->setAcao("agendar");
            $this->notify();

            $conn->close();
            header("Location: ../views/painel.php");

        }
    }

    public function cancelarAgendamento($placa)
    {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $placa = $_POST["placa"];

            // Realize o agendamento da manutenção no banco de dados
            $databaseConnection = DatabaseConnection::getInstance();
            $conn = $databaseConnection->getConnection();
    
            // Atualizar o campo "estado_do_veiculo" na tabela "veiculos" para refletir que o veículo está com proprietário

            $sql_id_cliente = "SELECT proprietario_id FROM veiculos WHERE placa = '$placa'";
            $result = $conn->query($sql_id_cliente);
            $id_c = $result->fetch_assoc();
            $id_cliente = $id_c['proprietario_id'];
            $_SESSION['id_cliente'] = $id_cliente;
            // Consultar a data de agendamento da manutenção
            $sql_consulta_data = "SELECT data_manutencao FROM manutencoes WHERE placa = '$placa' AND estado_do_veiculo LIKE 'Entrega agendada para o dia:%'";
            $resultado_datas = $conn->query($sql_consulta_data);

            // Verificar se encontrou uma data
            if ($resultado_datas->num_rows > 0) {
                // Extrair a data da primeira linha do resultado
                $row = $resultado_datas->fetch_assoc();
                $data_manutencao = $row['data_manutencao'];

                // Deletar o agendamento da manutenção
                $sql_agendamento = "UPDATE manutencoes SET estado_do_veiculo = 'Cancelamento de agendamento de manutenção realizado para o veículo de placa: $placa' WHERE placa = '$placa' AND data_manutencao = '$data_manutencao'";
                $conn->query($sql_agendamento);
                $sql_atualizar_estado = "UPDATE veiculos SET estado_do_veiculo = 'Com proprietário' WHERE placa = '$placa'";
                $conn->query($sql_atualizar_estado);
                $mensagem = "Cancelado o agendamento de manutenção para o veículo com placa $placa";
                $this->addNotificacao($mensagem);
                $this->setAcao("cancelar");
                $this->notify();
                header("Location: ../views/painel.php");
            } else {
                echo '<script>alert("Não foi encontrado nenhum agendamento para o veículo."); window.location.href = "../views/painel.php";</script>';
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
            $databaseConnection = DatabaseConnection::getInstance();
            $conn = $databaseConnection->getConnection();
    
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
                $mensagem = "Finalizando o agendamento de manutenção para o veículo com placa $placa";

                $sql_id_cliente = "SELECT proprietario_id FROM veiculos WHERE placa = '$placa'";
                $result = $conn->query($sql_id_cliente);
                $id_c = $result->fetch_assoc();
                $id_cliente = $id_c['proprietario_id'];
                $_SESSION['id_cliente'] = $id_cliente;
                $this->addNotificacao($mensagem);
                $this->setAcao("entregue");
                $this->notify();
                header("Location: ../views/listarVeiculos.php");
            } else {
                echo '<script>alert("Não foi possivel entregar o veiculo ao cliente!\nContate o suporte"); window.location.href = "../views/listarVeiculos.php";</script>';

            }

            // Fechar a conexão com o banco de dados
            $conn->close();
        }

    }


public function atualizarManutencao($placa)
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $placa = $_POST["placa"];
        $databaseConnection = DatabaseConnection::getInstance();
        $conn = $databaseConnection->getConnection();
        $sql = "UPDATE manutencoes SET estado_do_veiculo = '$this->estado_do_veiculo', data_manutencao = '$this->dataManutencao', observacoes = '$this->observacoes', previsaoTermino = '$this->dataTermino', tipo_servico = '$this->tipo_servico', custo = '$this->custo' WHERE placa = '$this->placa' AND id = (SELECT MAX(id) FROM manutencoes WHERE placa = '$this->placa')";
        $conn->query($sql); // Executar a consulta de atualização
        $sqlveiculo = "UPDATE veiculos SET estado_do_veiculo = '$this->estado_do_veiculo' WHERE placa = '$this->placa'";
        $conn->query($sqlveiculo);
        $sql_consulta_data1 = "SELECT data_manutencao FROM manutencoes WHERE placa = '$placa' AND estado_do_veiculo = 'Em manutenção'";
        $resultado_datas1 = $conn->query($sql_consulta_data1);
        $sql_consulta_data2 = "SELECT data_manutencao FROM manutencoes WHERE placa = '$placa' AND estado_do_veiculo = 'Manutenção concluída'";
        $resultado_datas2 = $conn->query($sql_consulta_data2);

        // Verifica se a atualização foi bem-sucedida
        if ($resultado_datas1->num_rows > 0) {
            $mensagem = "Manutencao do veículo com placa $this->placa foi atualizado com sucesso.";

            $sql_id_cliente = "SELECT proprietario_id FROM veiculos WHERE placa = '$placa'";
            $result = $conn->query($sql_id_cliente);
            $id_c = $result->fetch_assoc();
            $id_cliente = $id_c['proprietario_id'];
            $_SESSION['id_cliente'] = $id_cliente;

            $this->setAcao("atualizar"); // Alterado para "atualizar"

            $this->addNotificacao($mensagem);

            $this->notify();
            header("Location: ../views/listarVeiculos.php");

        } else if($resultado_datas2->num_rows > 0){
            $mensagem = "Manutencao do veículo com placa $this->placa foi atualizado com sucesso.";

            $sql_id_cliente = "SELECT proprietario_id FROM veiculos WHERE placa = '$placa'";
            $result = $conn->query($sql_id_cliente);
            $id_c = $result->fetch_assoc();
            $id_cliente = $id_c['proprietario_id'];
            $_SESSION['id_cliente'] = $id_cliente;

            $this->setAcao("finalizar"); // Alterado para "atualizar"

            $this->addNotificacao($mensagem);

            $this->notify();
            header("Location: ../views/listarVeiculos.php");
        }
        else {
            // A atualização falhou
            echo '<script>alert("Falha ao atualizar o agendamento de manutenção!\nContate o suporte"); window.location.href = "../views/listarVeiculos.php";</script>';
        }

        $conn->close();
    }
}
}


?>