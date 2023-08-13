<?php
session_start();
require_once '../../includes/headerCliente.php';
require_once '../../includes/headerView.php';

?>
<!DOCTYPE html>
<html>

<head>
    <title>Alterar Informações do Veículo - Sistema de Acompanhamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <?php headerHead(); ?>

</head>

<body>


<div class="container-fluid d-flex justify-content-center align-items-center vh-100">
        <div class="col-md-4 border p-4"> <!-- Adicione a classe border e a classe de espaçamento p-4 -->
        <?php headerVieW();?>
    <h2>Alterar Informações do Veículo</h2>

    <!-- Select para escolher a placa do veículo -->
    <label for="placa">Selecione o veiculo:</label>
    <select id="placa" name="placa" class="form-control" required>
        <option value="" data-default disabled selected></option>
        <?php
        // Consulta para obter as placas dos veículos do usuário logado
        $sql_consulta_placas = "SELECT id, placa, marca, modelo, ano FROM veiculos WHERE proprietario_id = $user_id";
        $resultado_placas = $conn->query($sql_consulta_placas);

        // Mostra as opções do select com as placas dos veículos
        while ($veiculo = $resultado_placas->fetch_assoc()) {
            $id_veiculo = $veiculo['id'];
            $placa_veiculo = $veiculo['placa'];
            $marca = $veiculo['marca'];
            $modelo = $veiculo['modelo'];
            $ano = $veiculo['ano'];
            $selected = ($veiculo_id == $id_veiculo) ? 'selected' : '';

            echo "<option value='$placa_veiculo' $selected>$placa_veiculo | $marca | $modelo | $ano</option>";
        }   
        ?>
    </select>

    <!-- Campo oculto para armazenar as informações do veículo selecionado -->
    <input type="hidden" id="marca-veiculo" value="<?php echo $marca; ?>">
    <input type="hidden" id="modelo-veiculo" value="<?php echo $modelo; ?>">
    <input type="hidden" id="ano-veiculo" value="<?php echo $ano; ?>">

    <!-- Div para exibir as informações do veículo selecionado -->
    <div id="informacoes-veiculo">
        <?php if (isset($marca) && isset($modelo) && isset($ano)) { ?>
            Informações do Veículo: 
                
        <?php } ?>
    </div>

    <!-- Formulário para alterar as informações do veículo -->
    <form action="../controllers/veiculosController.php?funcao=alterarVeiculo" method="post">
        <!-- Os campos "marca", "modelo" e "ano" serão preenchidos automaticamente pelo JavaScript -->
        <label for="marca">Marca:</label>
        <input type="text" id="marca" name="marca" required class="form-control" placeholder="Marca do veiculo"><br>

        <label for="modelo">Modelo:</label>
        <input type="text" id="modelo" name="modelo" required class="form-control" placeholder="Modelo do veiculo"><br>

        <label for="ano">Ano:</label>
        <input type="number" id="ano" name="ano" required class="form-control" placeholder="Ano do veiculo"><br>

        <!-- Campo oculto para enviar a placa selecionada -->
        <input type="hidden" name="placa" id="placa-selecionada" value="">
        <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id ?>">

        <input type="submit" value="Atualizar" class="btn btn-primary">
        <input type="reset" value="Limpar" class="btn btn-primary">
        <input type="button" value="Voltar" onclick="window.location.href='painel.php'" class="btn btn-primary">
    </form>

    <!-- Script JavaScript para atualizar as informações do veículo -->
    <script>
        // Obtém referência ao elemento select
        const selectPlaca = document.getElementById('placa');
        // Obtém referências aos elementos de exibição das informações do veículo
        const divInformacoesVeiculo = document.getElementById('informacoes-veiculo');
        const inputMarcaVeiculo = document.getElementById('marca-veiculo');
        const inputModeloVeiculo = document.getElementById('modelo-veiculo');
        const inputAnoVeiculo = document.getElementById('ano-veiculo');
        // Obtém referência ao campo oculto para enviar a placa selecionada
        const inputPlacaSelecionada = document.getElementById('placa-selecionada');

        // Adiciona o evento de mudança ao select
        selectPlaca.addEventListener('change', function () {
            // Obtém o índice da opção selecionada no select
            const indexSelecionado = selectPlaca.selectedIndex;
            // Obtém o texto da opção selecionada
            const textoSelecionado = selectPlaca.options[indexSelecionado].text;
            // Divide o texto para obter as informações separadas por pipe '|'
            const informacoes = textoSelecionado.split(' | ');

            // Atualiza os elementos de exibição com as informações do veículo selecionado
            divInformacoesVeiculo.textContent = "Informações do Veículo: " + informacoes[0] + " | " + informacoes[1] + " | " + informacoes[2] + " | " + informacoes[3] ;

            // Atualiza os campos do formulário de alteração com as informações do veículo selecionado


            // Atualiza o valor do campo oculto com a placa selecionada
            inputPlacaSelecionada.value = informacoes[0];
        });
    </script>
</div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>

</body>

</html>