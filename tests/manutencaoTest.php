<?php


use PHPUnit\Framework\TestCase;
use app\models\Manutencao;

class manutencaoTest extends TestCase
{

    public function testeAgendarManutencao()
    {
        //Função de agendar manutenção
        //Primeiramente verificar se o veiculo escolhido existe ou se caso ele exista ele não já esteja em manutenção

        $manutencao = new Manutencao();
        $manutencao->setPlaca('ABB8Z76');
        $manutencao->setDataManutencao('2023-08-19');
        //Função de inserção de agendamento, retorna a consulta SQL de inserção.
        $resultado = $manutencao->agendarManutencao('ABB8Z76', '2023-08-19');
        //Consulta SQL teste
        $teste = "INSERT INTO manutencoes (placa, data_manutencao, estado_do_veiculo) VALUES ('ABB8Z76', '2023-08-19', 'Entrega agendada para o dia: 2023-08-19')";
        //Verifica se a consulta SQL teste é igual ao resultado da função de inserção
        $this->assertEquals($teste, $resultado);

    }

    public function testeCancelarManutencao()
    {
        //Verificar se o veiculo escolhido está realmente em agendamento, caso não esteja retornará NULL na comparação das SQL
        $manutencao = new Manutencao();
        $manutencao->setPlaca('ZZZ9Z99');
        //Função de cancelamento de agendamento, retorna a consulta SQL de alteração.
        $resultado = $manutencao->cancelarAgendamento('ZZZ9Z99');
        //Consulta SQL teste
        $teste = "UPDATE veiculos SET estado_do_veiculo = 'Com proprietário' WHERE placa = 'ZZZ9Z99'";
        //Verifica se a consulta SQL teste é igual ao resultado da função de cancelamento
        $this->assertEquals($teste, $resultado);

    }

}