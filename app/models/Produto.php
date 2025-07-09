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
                  AND e.empresa_id = ?
            ";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$_SESSION['empresa_id']]);
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
                LEFT JOIN estoque e ON p.id = e.id_produto 
                  AND e.empresa_id = ?
                WHERE e.quantidade <= ?
            ";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$_SESSION['empresa_id'], $limite]);
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

    /**
     * Buscar produtos para PDV (por código ou descrição)
     * @param string $termo
     * @param int $tabela
     * @return array
     */
    public function buscarParaPDV($termo, $tabela) {
        $sql = "SELECT p.id, p.nome, pr.valor_revenda as preco_venda,
                CASE 
                    when p.categoria = 'Serviços' then 999
                    else e.quantidade
                end as estoque_disponivel
                FROM produtos p
                INNER JOIN itens_tabela_preco pr on pr.id_produto = p.id
                LEFT JOIN estoque e ON p.id = e.id_produto
                    and e.empresa_id = ?
                WHERE ((p.categoria = ?) OR (p.nome LIKE ?)) 
                AND     id_tabela = ?

                ORDER BY p.nome
                LIMIT 20";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$_SESSION['empresa_id'], '%'.$termo.'%','%'.$termo.'%', $tabela]);
            
            return $stmt->fetchAll();
        } catch (Exception $e) {
            gravarLog("Erro: " . $e->getMessage());
        }
    }

        /**
     * Buscar produtos para PDV (por código)
     * @param int $termo
     * @param int $tabela
     * @return array
     */
    public function buscarParaPDVById($termo, $tabela) {
        $sql = "SELECT p.id, p.nome, pr.valor_revenda as preco_venda, 
            CASE 
             when p.categoria = 'Serviços' then 999
             else e.quantidade
            end as estoque_disponivel
                FROM produtos p
                INNER JOIN itens_tabela_preco pr on pr.id_produto = p.id
                LEFT JOIN estoque e ON p.id = e.id_produto
                  AND e.empresa_id = ?
                WHERE p.id = ? 
                AND     id_tabela = ?
                ";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$_SESSION['empresa_id'], (int)$termo, $tabela]);
            
            return $stmt->fetchAll();
        } catch (Exception $e) {
            gravarLog("Erro: " . $e->getMessage());
        }
    }

    /**
     * Buscar produtos para PDV (por código ou descrição)
     * @param string $termo
     * @param string $pagina
     * @return json
     */
    public function buscaProdutosPaginacao($termo, $pagina = 1, $ocultaSrvico=0){
        try{
        $limite = 20;
        $pagina = max(1, (int)$pagina);
        $offset = ($pagina- 1) * $limite;
        

        $sql = "SELECT id, nome, categoria, preco_venda 
        FROM produtos 
        WHERE (nome LIKE :termo OR categoria LIKE :termo2)
         AND ((categoria <> 'Serviços' AND :cat1 = 1) OR (:cat2 = 0))
        ORDER BY nome
        LIMIT $limite OFFSET $offset";

        
        $stmt = $this->db->prepare($sql);

        $termoBusca = '%' . $termo . '%';
        $stmt->bindParam(':termo', $termoBusca);
        $stmt->bindParam(':termo2', $termoBusca);
        $stmt->bindParam(':cat1', $ocultaSrvico);
        $stmt->bindParam(':cat2', $ocultaSrvico);
        $stmt->execute();

        $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Conta o total
        $sqlCount = "SELECT COUNT(*) as total FROM produtos WHERE nome LIKE :termo OR categoria LIKE :termo2";
        $stmtCount = $this->db->prepare($sqlCount);
        $stmtCount->bindParam(':termo', $termoBusca);
        $stmtCount->bindParam(':termo2', $termoBusca);
        $stmtCount->execute();
        $total = $stmtCount->fetchColumn();

        // Formata a resposta
        $response = [
            'produtos' => [],
            'total_count' => $total
        ];

        foreach ($produtos as $produto) {
            $response['produtos'][] = [
                'id' => $produto['id'] ?? '',
                'text' => $produto['nome'] . ' (' . $produto['categoria'] . ')' ?? '',
                'data-preco' => $produto['preco_venda'] ?? 0,
                'data_preco' => $produto['preco_venda'] ?? 0
            ];
        }

        return $response;
    } catch (Exception $e) {
            
            gravarLog("Erro: " . $e->getMessage());
            return false;
        }
    }
}

