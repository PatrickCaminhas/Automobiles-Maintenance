<?php
namespace helpers;
use mysqli;
class DatabaseConnection {
    private static $instance = null;
    private $conn;

    private function __construct() {
        $hostname = 'localhost'; // Endereço do servidor do banco de dados
        $username = 'root'; // Nome de usuário do banco de dados
        $password = ''; // Senha do banco de dados
        $database = 'mecanica'; // Nome do banco de dados

        $this->conn = new mysqli($hostname, $username, $password, $database);

        // Verifica se houve erro na conexão
        if ($this->conn->connect_error) {
            die("Falha na conexão: " . $this->conn->connect_error);
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }

    // Evita que a instância seja clonada
    private function __clone() {}

    // Evita que a instância seja desserializada
    public function __wakeup() {}
}
?>
