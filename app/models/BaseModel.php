<?php
/**
 * Classe Base Model
 * Sistema de Gestão de Bicicletaria
 */

class BaseModel {
    protected $db;
    protected $table;
    
    public function __construct() {
        //$database = new Database();
        //$this->db = $database->connect();
        $this->db = Database::connect(); // Usando o singleton para obter a conexão
    }
    
    /**
     * Busca todos os registros
     * @return array
     */
    public function findAll() {
        try {
            $stmt = $this->db->query("SELECT * FROM {$this->table}");
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }
    
    /**
     * Busca um registro por ID
     * @param int $id
     * @return array|null
     */
    public function findById($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (Exception $e) {
            return null;
        }
    }
    
    /**
     * Insere um novo registro
     * @param array $data
     * @return int|false ID do registro inserido ou false em caso de erro
     */
    public function insert($data) {
        try {
            $fields = array_keys($data);
            $placeholders = array_fill(0, count($fields), '?');
            
            $sql = "INSERT INTO {$this->table} (" . implode(', ', $fields) . ") VALUES (" . implode(', ', $placeholders) . ")";
            $stmt = $this->db->prepare($sql);

            if ($stmt->execute(array_values($data))) {
                return $data['id_pessoa'] ?? $data['id'] ?? $this->db->lastInsertId() ?? null;
            }
            return false;
        } catch (Exception $e) {
            
            gravarLog("Erro ao inserir registro: " . $e->getMessage());
            gravarLog("Consulta: " . $sql);
            gravarLog("Campos: " . json_encode($data));
            return false;
        }
    }
    
    /**
     * Atualiza um registro
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update($id, $data) {
        try {
            $fields = array_keys($data);
            $setClause = implode(' = ?, ', $fields) . ' = ?';
            
            $sql = "UPDATE {$this->table} SET {$setClause} WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            
            $values = array_values($data);
            $values[] = $id;
            
            return $stmt->execute($values);
        } catch (Exception $e) {
            gravarLog("Erro ao atualizar registro: " . $e->getMessage());
            gravarLog("Consulta: " . $sql);
            gravarLog("Campos: " . json_encode($data));
            return false;
        }
    }
    
    /**
     * Deleta um registro
     * @param int $id
     * @return bool
     */
    public function delete($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Conta o total de registros
     * @return int
     */
    public function count() {
        try {
            $stmt = $this->db->query("SELECT COUNT(*) as total FROM {$this->table}");
            $result = $stmt->fetch();
            return $result['total'];
        } catch (Exception $e) {
            return 0;
        }
    }
    
    /**
     * Busca registros com condições
     * @param array $conditions
     * @return array
     */
    public function findWhere($conditions) {
        try {
            $whereClause = [];
            $values = [];
            
            foreach ($conditions as $field => $value) {
                $whereClause[] = "$field = ?";
                $values[] = $value;
            }
            
            $sql = "SELECT * FROM {$this->table} WHERE " . implode(' AND ', $whereClause);
            $stmt = $this->db->prepare($sql);
            $stmt->execute($values);
            
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }
}

