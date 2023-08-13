<?php
session_start();

// Verifique se o usuário está autenticado, se não redirecione para a página de login
require_once '../../includes/headerCliente.php';
require_once '../../includes/headerView.php';
require_once '../models/notificacoes.php';
require_once '../models/manutencoes.php';
require_once 'notificacoesView.php';


// Obtém o nome do usuário autenticado
$user_nome = $_SESSION["user_nome"];

$databaseConnection = DatabaseConnection::getInstance();
$conn = $databaseConnection->getConnection();
$sql_consulta_veiculos = "SELECT id, placa, marca, modelo, ano, estado_do_veiculo FROM veiculos WHERE proprietario_id = $user_id";
$resultado_veiculos = $conn->query($sql_consulta_veiculos);






?>

<!DOCTYPE html>
<html>

<head>
    <title>Painel - Sistema de Acompanhamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <?php headerHead(); ?>
 

</head>

<body>

    <div class="container-fluid d-flex justify-content-between align-items-center" style="margin-top: 1rem;">
    <?php headerVieW();?>

  
    <a href="../controllers/logout.php" class="btn btn-primary mb-1">Logout</a>

     
    </div>
    <div class="container d-flex align-items-start justify-content-center">
<h2><a>Bem-vindo,</a>
        <?php echo $user_nome; ?>!
       
    </h2>
    
    </div>

    <?php
   
    // Criar instância do objeto Notificacoes
    $notificacoes = new Notificacoes();
    // Adicionar a instância do objeto Notificacoes como observador na classe Manutencao
    $notificacoesArray = $notificacoes->getNotificacoesFromDB($user_id); // Busque as notificações do banco de dados
    
    


    // Exibir as notificações na página usando a classe NotificacoesView
    
    $notificacoesView = new NotificacoesView();
    $notificacoesView->mostrarNotificacoes($notificacoesArray);

    // Verifique se o usuário possui veículos cadastrados
    if ($resultado_veiculos->num_rows == 0) {?>
        <div class="container-fluid d-flex justify-content-center border p-2"style="width: 75vw;">
        <?php
        echo "<p>Você ainda não possui veículos cadastrados.</p>";
        ?>
        </div>
        <?php
    } else {
        ?>
        <div class="d-flex flex-column justify-content-center align-items-center">
    <div class="col-md-4 border p-4" style="width: 75vw;">
        <h3>Seus veículos</h3>
        <table class="table table-striped text-body-white table-hover">
            <tr class="table-light ">
                <th>Placa</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Ano</th>
                <th>Estado</th>
                <th>Manutenção</th>

            </tr>
            <?php
            // Loop para exibir os veículos na tabela
            while ($veiculo = $resultado_veiculos->fetch_assoc()) {
                $placa = $veiculo['placa'];
                $marca = $veiculo['marca'];
                $modelo = $veiculo['modelo'];
                $ano = $veiculo['ano'];
                $estado = $veiculo['estado_do_veiculo'];
                $sql_consulta_manutecao = "SELECT * FROM manutencoes WHERE placa = '$placa' AND estado_do_veiculo != 'Entregue ao proprietario' AND data_manutencao = (SELECT MAX(data_manutencao) FROM manutencoes WHERE placa = '$placa')";
                if($estado == "Com proprietário")

                echo "<tr >";
                echo "<td class=' fw-medium '>$placa</td>";
                echo "<td>$marca</td>";
                echo "<td>$modelo</td>";
                echo "<td>$ano</td>";
                echo "<td class=' fw-medium ";
                if($estado == "Com proprietário"){
                    echo "text-primary'";
                }
                else if($estado == "Manutenção concluída"){
                    echo " text-success'";
                }
                else{
                    echo "text-warning'";
                }
                echo ">$estado</td>";
                echo "<td>
                <form action='verificarManutencao.php' method='post'>
                <input type='hidden' name='placa' value='$placa'>
                 <input type='submit' value='Verificar' class='fw-medium ";
                ?>
                <?php
                $resultado_manutencao = $conn->query($sql_consulta_manutecao);
                if ($resultado_manutencao->num_rows == 0) {
                    echo "btn btn-secondary' disabled ";
                } else if($estado == "Com proprietário"){
                    echo "btn btn-secondary' disabled ";
                }
                else{
                    echo "btn btn-primary'";
                }


                echo " ></form></td>";
                echo "</tr>";
            }
            ?>
        </table>
        
        <div class="d-flex flex-column justify-content-center align-items-center">
                        <a href="agendamentoManutencao.php" class="btn btn-primary my-1">Agendar entrega para manutenção</a>
                       
                        <a href="cancelamentoDeAgendamento.php" class="btn btn-primary my-1" >Cancelar
                            agendamento de entrega</a>
                    </div>

                        <?php
    }
    ?>                      <div class="d-flex flex-column justify-content-center align-items-center">

                    <a href="cadastroVeiculo.php" class="btn btn-primary my-1" >Cadastrar veiculo</a> 
                    <?php
                    if ($resultado_veiculos->num_rows !== 0) {?>
                    <a href="alteracaoVeiculo.php" class="btn btn-primary my-1" >Alterar veiculo</a> 
                    <?php
                    }
                    ?>
                </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>
</body>

</html>