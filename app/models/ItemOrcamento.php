<?php
/**
 * Modelo Item Orçamento
 * Sistema de Gestão de Bicicletaria
 */

require_once 'BaseModel.php';

class ItemOrcamento extends BaseModel {
    protected $table = 'itens_orcamento';
    
    /**
     * Busca itens por orçamento
     * @param int $idOrcamento
     * @return array
     */
    public function findByOrcamento($idOrcamento) {
        try {
            $sql = "
                SELECT 
                    io.*,
                    p.nome as produto_nome,
                    p.unidade_medida
                FROM {$this->table} io
                INNER JOIN produtos p ON io.id_produto = p.id
                WHERE io.id_orcamento = ?
            ";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$idOrcamento]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }
    
    /**
     * Calcula o subtotal de um item
     * @param int $quantidade
     * @param float $preco
     * @return float
     */
    public function calcularSubtotal($quantidade, $preco) {
        return $quantidade * $preco;
    }
    
    /**
     * Valida os dados do item
     * @param array $data
     * @return array Erros de validação
     */
    public function validate($data) {
        $errors = [];
        
        if (empty($data['id_produto']) || !is_numeric($data['id_produto'])) {
            $errors[] = 'Produto é obrigatório';
        }
        
        if (empty($data['quantidade']) || !is_numeric($data['quantidade']) || $data['quantidade'] <= 0) {
            $errors[] = 'Quantidade deve ser um valor positivo';
        }
        
        if (empty($data['preco']) || !is_numeric($data['preco']) || $data['preco'] <= 0) {
            $errors[] = 'Preço deve ser um valor positivo';
        }
        
        return $errors;
    }
}

