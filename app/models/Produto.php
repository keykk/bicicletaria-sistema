<?php
/**
 * Modelo Produto
 * Sistema de Gestão de Bicicletaria
 */

require_once 'BaseModel.php';

class Produto extends BaseModel {
    protected $table = 'produtos';
    
    /**
     * Busca produtos por categoria
     * @param string $categoria
     * @return array
     */
    public function findByCategoria($categoria) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE categoria = ?");
            $stmt->execute([$categoria]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }
    
    /**
     * Busca produtos com estoque
     * @return array
     */
    public function findWithEstoque() {
        try {
            $sql = "
                SELECT p.*, e.quantidade 
                FROM {$this->table} p 
                LEFT JOIN estoque e ON p.id = e.id_produto
            ";
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }
    
    /**
     * Busca produtos com estoque baixo
     * @param int $limite
     * @return array
     */
    public function findEstoqueBaixo($limite = 5) {
        try {
            $sql = "
                SELECT p.*, e.quantidade 
                FROM {$this->table} p 
                INNER JOIN estoque e ON p.id = e.id_produto 
                WHERE e.quantidade <= ?
            ";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$limite]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }
    
    /**
     * Busca produtos por nome (busca parcial)
     * @param string $nome
     * @return array
     */
    public function searchByNome($nome) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE nome LIKE ?");
            $stmt->execute(["%$nome%"]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }
    
    /**
     * Obtém todas as categorias disponíveis
     * @return array
     */
    public function getCategorias() {
        try {
            $stmt = $this->db->query("SELECT DISTINCT categoria FROM {$this->table} ORDER BY categoria");
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (Exception $e) {
            return [];
        }
    }
    
    /**
     * Valida os dados do produto
     * @param array $data
     * @return array Erros de validação
     */
    public function validate($data) {
        $errors = [];
        
        if (empty($data['nome'])) {
            $errors[] = 'Nome é obrigatório';
        }
        
        if (empty($data['preco_venda']) || !is_numeric($data['preco_venda']) || $data['preco_venda'] <= 0) {
            $errors[] = 'Preço de venda deve ser um valor positivo';
        }
        
        if (empty($data['unidade_medida'])) {
            $errors[] = 'Unidade de medida é obrigatória';
        }
        
        if (empty($data['categoria'])) {
            $errors[] = 'Categoria é obrigatória';
        }
        
        return $errors;
    }
}

