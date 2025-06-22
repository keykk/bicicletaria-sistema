<?php
/**
 * Modelo Item Tabela de Preço
 * Sistema de Gestão de Bicicletaria
 */

require_once 'BaseModel.php';

class ItemTabelaPreco extends BaseModel {
    protected $table = 'itens_tabela_preco';
    
    /**
     * Busca itens por tabela
     * @param int $idTabela
     * @return array
     */
    public function findByTabela($idTabela) {
        try {
            $sql = "
                SELECT 
                    itp.*,
                    p.nome as produto_nome,
                    p.categoria,
                    p.unidade_medida
                FROM {$this->table} itp
                INNER JOIN produtos p ON itp.id_produto = p.id
                WHERE itp.id_tabela = ?
                ORDER BY p.categoria, p.nome
            ";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$idTabela]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }
    
    /**
     * Atualiza ou insere preço de um produto na tabela
     * @param int $idTabela
     * @param int $idProduto
     * @param float $preco
     * @return bool
     */
    public function updateOrInsertPreco($idTabela, $idProduto, $preco) {
        try {
            // Verifica se já existe
            $stmt = $this->db->prepare("
                SELECT id FROM {$this->table} 
                WHERE id_tabela = ? AND id_produto = ?
            ");
            $stmt->execute([$idTabela, $idProduto]);
            $existing = $stmt->fetch();
            
            if ($existing) {
                // Atualiza
                return $this->update($existing['id'], ['preco' => $preco]);
            } else {
                // Insere
                return $this->insert([
                    'id_tabela' => $idTabela,
                    'id_produto' => $idProduto,
                    'preco' => $preco
                ]);
            }
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Remove um produto da tabela de preço
     * @param int $idTabela
     * @param int $idProduto
     * @return bool
     */
    public function removeProduto($idTabela, $idProduto) {
        try {
            $stmt = $this->db->prepare("
                DELETE FROM {$this->table} 
                WHERE id_tabela = ? AND id_produto = ?
            ");
            return $stmt->execute([$idTabela, $idProduto]);
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Valida os dados do item
     * @param array $data
     * @return array Erros de validação
     */
    public function validate($data) {
        $errors = [];
        
        if (empty($data['id_tabela']) || !is_numeric($data['id_tabela'])) {
            $errors[] = 'Tabela é obrigatória';
        }
        
        if (empty($data['id_produto']) || !is_numeric($data['id_produto'])) {
            $errors[] = 'Produto é obrigatório';
        }
        
        if (empty($data['preco']) || !is_numeric($data['preco']) || $data['preco'] <= 0) {
            $errors[] = 'Preço deve ser um valor positivo';
        }
        
        return $errors;
    }
}

