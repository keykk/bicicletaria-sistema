<?php
/**
 * Modelo Estoque
 * Sistema de Gestão de Bicicletaria
 */

require_once 'BaseModel.php';

class Estoque extends BaseModel {
    protected $table = 'estoque';
    
    /**
     * Busca estoque por produto
     * @param int $idProduto
     * @return array|null
     */
    public function findByProduto($idProduto) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id_produto = ?");
            $stmt->execute([$idProduto]);
            return $stmt->fetch();
        } catch (Exception $e) {
            return null;
        }
    }
    
    /**
     * Atualiza a quantidade em estoque
     * @param int $idProduto
     * @param int $quantidade
     * @return bool
     */
    public function updateQuantidade($idProduto, $quantidade) {
        try {
            // Verifica se já existe registro para o produto
            $estoque = $this->findByProduto($idProduto);
            
            if ($estoque) {
                // Atualiza o registro existente
                $stmt = $this->db->prepare("UPDATE {$this->table} SET quantidade = ? WHERE id_produto = ?");
                return $stmt->execute([$quantidade, $idProduto]);
            } else {
                // Cria um novo registro
                return $this->insert([
                    'id_produto' => $idProduto,
                    'quantidade' => $quantidade
                ]);
            }
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Adiciona quantidade ao estoque
     * @param int $idProduto
     * @param int $quantidade
     * @return bool
     */
    public function adicionarQuantidade($idProduto, $quantidade) {
        try {
            $estoque = $this->findByProduto($idProduto);
            
            if ($estoque) {
                $novaQuantidade = $estoque['quantidade'] + $quantidade;
                return $this->updateQuantidade($idProduto, $novaQuantidade);
            } else {
                return $this->updateQuantidade($idProduto, $quantidade);
            }
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Remove quantidade do estoque
     * @param int $idProduto
     * @param int $quantidade
     * @return bool
     */
    public function removerQuantidade($idProduto, $quantidade) {
        try {
            $estoque = $this->findByProduto($idProduto);
            
            if ($estoque) {
                $novaQuantidade = max(0, $estoque['quantidade'] - $quantidade);
                return $this->updateQuantidade($idProduto, $novaQuantidade);
            }
            
            return false;
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Verifica se há quantidade suficiente em estoque
     * @param int $idProduto
     * @param int $quantidadeNecessaria
     * @return bool
     */
    public function temQuantidadeSuficiente($idProduto, $quantidadeNecessaria) {
        $estoque = $this->findByProduto($idProduto);
        return $estoque && $estoque['quantidade'] >= $quantidadeNecessaria;
    }
    
    /**
     * Busca produtos com estoque baixo
     * @param int $limite
     * @return array
     */
    public function findEstoqueBaixo($limite = 5) {
        try {
            $sql = "
                SELECT e.*, p.nome, p.categoria 
                FROM {$this->table} e 
                INNER JOIN produtos p ON e.id_produto = p.id 
                WHERE e.quantidade <= ?
                ORDER BY e.quantidade ASC
            ";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$limite]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }
    
    /**
     * Relatório de estoque atual
     * @return array
     */
    public function relatorioEstoque() {
        try {
            $sql = "
                SELECT 
                    p.id,
                    p.nome,
                    p.categoria,
                    p.preco_venda,
                    COALESCE(e.quantidade, 0) as quantidade,
                    (COALESCE(e.quantidade, 0) * p.preco_venda) as valor_total_estoque
                FROM produtos p 
                LEFT JOIN {$this->table} e ON p.id = e.id_produto
                ORDER BY p.categoria, p.nome
            ";
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }
}

