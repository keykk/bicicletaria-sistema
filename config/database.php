<?php
/**
 * Configuração do Banco de Dados
 * Sistema de Gestão de Bicicletaria
 */

class Database {
    private $host = 'localhost';
    private $db_name = 'bikesystem';
    private $username = 'root';
    private $password = '';
    private $charset = 'utf8mb4';
    private $pdo;

    /**
     * Conecta ao banco de dados
     * @return PDO
     */
    public function connect() {
        if ($this->pdo === null) {
            try {
                $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset={$this->charset}";
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ];
                
                $this->pdo = new PDO($dsn, $this->username, $this->password, $options);
            } catch (PDOException $e) {
                throw new PDOException("Erro na conexão com o banco de dados: " . $e->getMessage());
            }
        }
        
        return $this->pdo;
    }

    /**
     * Fecha a conexão com o banco de dados
     */
    public function disconnect() {
        $this->pdo = null;
    }
}

