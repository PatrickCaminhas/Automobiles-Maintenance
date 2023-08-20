<?php
session_start();

// Verificar se o usuário está logado como funcionário
require_once '../../includes/headerFuncionario.php';
require_once '../../includes/headerView.php';
use app\models\Veiculo;

// Função para obter a lista de veículos com estados diferentes de "Com proprietário" e "Disponível para retirada"

$veiculo = new Veiculo("","","","","","");
$listaVeiculos = $veiculo->obterListaVeiculos();




?>

<!DOCTYPE html>
<html>

<head>
    <title>Alteração de Estados de Manutenção - Sistema de Acompanhamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <?php headerHead(); ?>

</head>

<body>
<div class="container-fluid d-flex justify-content-between align-items-center" style="margin-top: 1rem;">
        <?php headerVieW(); ?>
        <a href="../controllers/logout.php" class="btn btn-primary mb-1">Logout</a>
    </div>


<div class="d-flex flex-column justify-content-center align-items-center">
    <div class="col-md-4 border p-4" style="width: 75vw;">
    <h2>Alteração de manuteções</h2>
    <?php
    if (empty($listaVeiculos)) {
        echo "Não há veiculos para serem alterados.";
    } else {
      
    ?>
    <h3>Veiculos em manutenção</h3>
    <table class="table table-striped text-body-white table-hover">
        <tr>
            <th>Proprietário</th>
            <th>Celular</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Ano</th>
            <th>Placa</th>
            <th>Data da ultima atualização</th>
            <th>Previsão de Término</th>
            <th>Tipo de Serviço</th>
            <th>Custo</th>
            <th>Estado</th>
            <th>Ação</th>
            <th>Finalizar</th>
        </tr>

        <?php
        } 
        foreach ($listaVeiculos as $veiculo) { ?>
            <tr>


                <td>
                    <?php echo $veiculo['proprietario_nome']; ?>
                </td>
                <td>
                    <?php echo $veiculo['proprietario_telefone']; ?>
                </td>
                <td>
                    <?php echo $veiculo['marca']; ?>
                </td>
                <td>
                    <?php echo $veiculo['modelo']; ?>
                </td>
                <td>
                    <?php echo $veiculo['ano']; ?>
                </td>
                <td>
                    <?php echo $veiculo['placa']; ?>

                </td>
                <td>
                    <?php
                     $dataFormatada  = date_format(date_create($veiculo['data_manutencao']), 'd/m/Y');
                     echo $dataFormatada;  ?>
                </td>
                <td>
                    <?php
                    if($veiculo['previsaoTermino'] == "0000-00-00"){
                        $dataFormatada = "Ainda não definida";
                    }
                    else{
                    $dataFormatada  = date_format(date_create($veiculo['previsaoTermino']), 'd/m/Y');
                    }
                    echo $dataFormatada;  ?>
                </td>
                <td>
                    <?php echo $veiculo['tipo_servico']; ?>
                </td>
                <td><?php echo "R$".$veiculo['custo']; ?>
                </td>
                <td>
                    <?php echo $veiculo['estado_manutencao']; ?>
                </td>
                <td>
                    <form action="atualizarManutencao.php" method="post">
                        <input type="hidden" name="placa" value="<?php echo $veiculo['placa']; ?>">
                        <input type="submit" value="Alterar" class=<?php
                        $dataHoje = date("Y-m-d");
                           if ($veiculo['estado_manutencao'] == "Manutenção concluída") {
                               echo "'fw-medium btn btn-secondary' disabled";
                           } else if($veiculo['data_manutencao'] > $dataHoje) {
                               echo "'fw-medium btn btn-secondary' disabled";
                           }else if($veiculo['estado_manutencao'] == "Entregue ao proprietario"){
                               echo "'fw-medium btn btn-secondary' disabled";
                           }else{
                                 echo "'fw-medium btn btn-primary'";
                        }
                           ?>>
                    </form>
                </td>
                <td>
                    <form action="finalizarManutencao.php" method="post">
                        <input type="hidden" name="placa" value="<?php echo $veiculo['placa']; ?>">
                        <input type="submit" value="Finalizar" class=<?php
                           if ($veiculo['estado_manutencao'] != "Manutenção concluída") {
                            echo "'fw-medium btn btn-secondary' disabled";
                           } else{
                                 echo "'fw-medium btn btn-primary'";
                        }
                           ?>>
                    </form>
                </td>



            </tr>


        <?php } ?>
    </table>
    <div class="d-flex flex-column justify-content-center align-items-center">
    <button onclick="window.location.href = 'painelFuncionario.php';" class="fw-medium btn btn-primary">Voltar</button>
    </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>

</body>

</html>