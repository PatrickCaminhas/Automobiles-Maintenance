<?php
use PHPUnit\Framework\TestCase;

require_once '../../app/models/veiculo.php'; // Caminho real para a classe Veiculo
class VeiculoTest extends TestCase
{
    private $conn;


    protected function setUp(): void
    {
        parent::setUp();

        // Criação do mock da conexão com o banco de dados
        $this->conn = $this->createMock(DatabaseConnection::class);

        // Configurar o método getConnection para retornar a conexão simulada
        $this->conn->method('getConnection')->willReturn(new MockDbConnection());

        // Inserir dados de teste no banco de dados
        $this->seedTestData();
    }

    private function seedTestData()
    {
        // Inserir dados de teste no banco de dados de teste (usando a conexão simulada)
    }



    public function testInserirVeiculo()
    {
        // Configurar o objeto Veiculo para usar a conexão simulada ($this->conn)
        $veiculo = new Veiculo("", "", "", "", "", "");
        $veiculo->setMarca('Ford');
        $veiculo->setModelo('Focus');
        $veiculo->setAno('2022');
        $veiculo->setPlaca('XYZ123');
        $veiculo->setProprietarioId(1);
        $veiculo->setEstadoDoVeiculo('Com proprietário');

        // Aqui você pode testar o método inserirVeiculo() do objeto $veiculo
        $veiculo->inserirVeiculo();
        // Aqui você deve verificar se a inserção ocorreu corretamente, por exemplo, usando um mock da conexão com o banco de dados.

       // Configurar o mock da conexão para o método executeQuery
       $this->conn->expects($this->once())
       ->method('executeQuery')
       ->with($this->equalTo("INSERT INTO veiculos (...)"))
       ->willReturn(true);

   // Aqui você pode testar o método inserirVeiculo() do objeto $veiculo
   $veiculo->inserirVeiculo();
    }
    public function testGetMarca()
    {
        $veiculo = new Veiculo("", "", "", "", "", "");
        $veiculo->setMarca('Toyota');

        // Verificar se o método getMarca() retorna o valor esperado
        $this->assertEquals('Toyota', $veiculo->getMarca());
    }
}
?>