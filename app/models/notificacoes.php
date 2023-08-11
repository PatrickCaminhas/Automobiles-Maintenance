<?php
require_once 'manutencoes.php';
class Notificacoes implements SplObserver
{
    private $acao;
    private $notificacoes = [];

    public function setAcao($acao)
    {
        $this->acao = $acao;
    }
    public function update(SplSubject $subject): void
    {
        if ($subject instanceof Manutencao) {
            if ($this->acao == "agendar"){
            $mensagem = "Agendamento de manutenção realizado para o veículo de placa: " . $subject->getPlaca();
            echo '<script>alert("Agendamento de manutenção concluida!"); </script>';
        }
            else if ($this->acao == "cancelar") {
                $mensagem = "Cancelamento de agendamento de manutenção realizado para o veículo de placa: " . $subject->getPlaca();
                echo '<script>alert("Agendamento de manutenção cancelada!"); </script>';

            } else if ($this->acao == "finalizar") {
                $mensagem = "Manutenção finalizada referente ao veículo de placa: " . $subject->getPlaca();
                echo '<script>alert("Manutenção Finalizada!"); </script>';

            } else if ($this->acao == "atualizar") {
                $mensagem = "Manutenção atualizada referente ao veículo de placa: " . $subject->getPlaca();
                echo '<script>alert("Manutenção atualizada!"); </script>';

            } else if ($this->acao == "entregue") {
                $mensagem = "Entrega de veículo ao proprietário. Veículo de placa: " . $subject->getPlaca();
                echo '<script>alert("Carro entregue!"); </script>';

            }


            $this->notificacoes[] = $mensagem;
            // Obtenha o ID do usuário autenticado para associá-lo à notificação
            $usuario_id = $_SESSION["user_id"];
            // Chame a função para cadastrar a notificação no banco de dados

            $this->cadastrarNotificacaoAgendamento($mensagem, $usuario_id);
        }
    }
    private function cadastrarNotificacaoAgendamento($mensagem, $usuario_id)
    {
        $databaseConnection = DatabaseConnection::getInstance();
        $conn = $databaseConnection->getConnection();
        // Preparar a declaração SQL para inserção dos dados
        $dataAtual = date("Y-m-d H:i:s");

        $id_proprietario = $_SESSION['id_cliente'];

        $sql = "INSERT INTO notificacoes (mensagem, data_notificacao, lida, usuario_id) VALUES ('$mensagem', '$dataAtual', 0, '$id_proprietario')";

        $conn->query($sql);

        $conn->close();

    }

    public function getNotificacoes(): array
    {
        return $this->notificacoes;
    }

    public function getNotificacoesFromDB($user_id)
    {
        $databaseConnection = DatabaseConnection::getInstance();
        $conn = $databaseConnection->getConnection();
        // Consulta SQL para buscar as notificações associadas ao usuário
        $sql = "SELECT mensagem, data_notificacao FROM notificacoes WHERE usuario_id = $user_id AND lida='0' ORDER BY data_notificacao DESC";
        $result = $conn->query($sql);

        $notificacoes = array();
        while ($row = $result->fetch_assoc()) {
            $notificacao = $row["mensagem"] . " - " . $row["data_notificacao"];
            $notificacoes[] = $notificacao;
        }


        return $notificacoes;
    }

    public function limparNotificacoes($user_id)
    {
        $sql_consulta = "UPDATE notificacoes SET lida = 1 WHERE usuario_id = $user_id AND lida = '0'";
        $databaseConnection = DatabaseConnection::getInstance();
        $conn = $databaseConnection->getConnection();
        $conn->query($sql_consulta);
        header("Location: ../views/painel.php");
    }
}
?>