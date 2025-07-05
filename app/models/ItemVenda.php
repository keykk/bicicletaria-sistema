<?php
/**
 * Modelo Item Venda
 * Sistema de Gestão de Bicicletaria - Módulo PDV
 */

class ItemVenda extends BaseModel {
    protected $table = 'itens_venda';
    
    /**
     * Buscar itens por venda
     * @param int $venda_id
     * @return array
     */
    public function buscarPorVenda($venda_id) {
        $sql = "SELECT iv.*, p.nome as produto_nome, p.codigo as produto_codigo,
                       p.unidade as produto_unidade
                FROM {$this->table} iv
                JOIN produtos p ON iv.produto_id = p.id
                WHERE iv.venda_id = :venda_id
                ORDER BY iv.id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':venda_id' => $venda_id]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Remover item da venda
     * @param int $id
     * @return bool
     */
    public function remover($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
    
    /**
     * Atualizar quantidade do item
     * @param int $id
     * @param float $quantidade
     * @param float $preco_unitario
     * @return bool
     */
    public function atualizarQuantidade($id, $quantidade, $preco_unitario) {
        $subtotal = $quantidade * $preco_unitario;
        
        $sql = "UPDATE {$this->table} 
                SET quantidade = :quantidade,
                    preco_unitario = :preco_unitario,
                    subtotal = :subtotal
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':quantidade' => $quantidade,
            ':preco_unitario' => $preco_unitario,
            ':subtotal' => $subtotal
        ]);
    }
    
    /**
     * Aplicar desconto no item
     * @param int $id
     * @param float $desconto
     * @return bool
     */
    public function aplicarDesconto($id, $desconto) {
        $sql = "UPDATE {$this->table} 
                SET desconto_item = :desconto,
                    subtotal = (quantidade * preco_unitario) - :desconto
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':desconto' => $desconto
        ]);
    }
}
?>

