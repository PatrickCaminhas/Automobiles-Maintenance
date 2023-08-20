<?php


use PHPUnit\Framework\TestCase;
use app\models\Veiculo;

class VeiculoTest extends TestCase
{


    public function testInserirVeiculo()
    {
        //Teste para  cadastro de um veiculo
        $veiculo = new Veiculo();
        $veiculo->setMarca('Honda');
        $veiculo->setModelo('Civic');
        $veiculo->setAno('2022');
        $veiculo->setPlaca('ZZZ9Z01');
        $veiculo->setProprietarioId(23);
        $veiculo->setEstadoDoVeiculo('Com proprietário');
        //Função de inserção de veiculos, retorna a SQL com os dados caso não tenha nenhum problema.
        $resultado = $veiculo->inserirVeiculo();
        //SQL teste
        $teste = "INSERT INTO veiculos (marca, modelo, ano, placa, proprietario_id, estado_do_veiculo) VALUES ('Ford', 'Focus', '2022', 'ZZZ9Z01', '23', 'Com proprietário')";
        //Verifica se SQL teste é igual a SQL que foi retornada da função de Inserção de veiculos.
        $this->assertEquals($teste, $resultado);

    }

    public function testUpdateVeiculo()
    {
        //Teste para atualização de dados de um veiculo
        $veiculo = new Veiculo();
        $veiculo->setMarca('Ford');
        $veiculo->setModelo('Focus');
        $veiculo->setAno('2022');
        $veiculo->setProprietarioId(23);
        $veiculo->setEstadoDoVeiculo('Com proprietário');
        //Função de alteração de veiculos, retorna a SQL com os dados caso não tenha nenhum problema.
        $resultado = $veiculo->updateVeiculo();
        //SQL teste
        $teste = "UPDATE veiculos SET marca = 'Ford', modelo = 'Focus', ano = '2022' WHERE placa = 'ZZZ9Z99' AND proprietario_id = '23'";
        //Verifica se SQL teste é igual a SQL que foi retornada da função de alteração de veiculos.

        $this->assertEquals($teste, $resultado);

    }


}