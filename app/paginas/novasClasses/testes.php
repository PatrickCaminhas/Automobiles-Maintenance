<?php
/*
interface Subject
{
    public function attach(Observer $observer): void;
    public function detach(Observer $observer): void;
    public function notify(): void;
}

interface Observer
{
    public function update(Subject $subject): void;
}
*/
    //    private $observers = [];

    //private $veiculosRelacionados = [];

    /*public function attach(SplObserver $observer): void
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

    public function notify(): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    public function addVeiculoRelacionado($placa)
    {
        $conn = conectarBancoDados();

        $sql = "SELECT placa FROM veiculos WHERE proprietario_id = '{$this->id}' AND placa != '$placa'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->veiculosRelacionados[] = $row["placa"];
            }
        }

        $conn->close();
    }
    */

    
/*class CadastroProprietarioObserver implements SplObserver
{
    public function update(SplSubject $subject): void
    {
        if ($subject instanceof Proprietario) {
            $nomeProprietario = $subject->getNome();
            echo "Cadastro do proprietário $nomeProprietario realizado com sucesso!";
        }
    }
}*/

?>