<?php
/**
 * Modelo Orçamento
 * Sistema de Gestão de Bicicletaria
 */

//require_once 'BaseModel.php';

class Orcamento extends BaseModel {
    protected $table = 'orcamentos';
    
    /**
     * Cria um novo orçamento com itens
     * @param array $dadosOrcamento
     * @param array $itens
     * @return int|false ID do orçamento criado ou false em caso de erro
     */
    public function criarOrcamento($dadosOrcamento, $itens) {
        try {
            $this->db->beginTransaction();
            
            // Inserir o orçamento
            $idOrcamento = $this->insert($dadosOrcamento);
            
            if (!$idOrcamento) {
                $this->db->rollBack();
                return false;
            }
            // Inserir os itens do orçamento
            $itemOrcamentoModel = new ItemOrcamento();
            foreach ($itens as $item) {
                $item['id_orcamento'] = $idOrcamento;
                if (!$itemOrcamentoModel->insert($item)) {
                    $this->db->rollBack();
                    return false;
                }

            }
            
            $this->db->commit();
            return $idOrcamento;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
    
    /**
     * Busca orçamento com itens
     * @param int $id
     * @return array|null
     */
    public function findWithItens($id) {
        try {
            $orcamento = $this->findById($id);
            if (!$orcamento) {
                return null;
            }
            
            // Buscar itens do orçamento
            $sql = "
                SELECT 
                    io.*,
                    p.nome as produto_nome,
                    p.unidade_medida
                FROM itens_orcamento io
                INNER JOIN produtos p ON io.id_produto = p.id
                WHERE io.id_orcamento = ?
            ";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            $orcamento['itens'] = $stmt->fetchAll();
            
            return $orcamento;
        } catch (Exception $e) {
            return null;
        }
    }
    
    /**
     * Busca orçamentos por período
     * @param string $dataInicio
     * @param string $dataFim
     * @return array
     */
    public function findByPeriodo($dataInicio, $dataFim) {
        try {
            $stmt = $this->db->prepare("
                SELECT * FROM {$this->table} 
                WHERE DATE(data) BETWEEN ? AND ? 
                ORDER BY data DESC
            ");
            $stmt->execute([$dataInicio, $dataFim]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }
    
    /**
     * Busca orçamentos do mês atual
     * @return array
     */
    public function findMesAtual() {
        try {
            $stmt = $this->db->query("
                SELECT * FROM {$this->table} 
                WHERE MONTH(data) = MONTH(CURRENT_DATE()) 
                AND YEAR(data) = YEAR(CURRENT_DATE())
                ORDER BY data DESC
            ");
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }
    
    /**
     * Calcula estatísticas de orçamentos
     * @return array
     */
    public function getEstatisticas() {
        try {
            $sql = "
                SELECT 
                    COUNT(*) as total_orcamentos,
                    SUM(valor_total) as valor_total,
                    AVG(valor_total) as valor_medio,
                    MAX(valor_total) as maior_valor,
                    MIN(valor_total) as menor_valor
                FROM {$this->table}
                WHERE MONTH(data) = MONTH(CURRENT_DATE()) 
                AND YEAR(data) = YEAR(CURRENT_DATE())
            ";
            $stmt = $this->db->query($sql);
            return $stmt->fetch();
        } catch (Exception $e) {
            return [
                'total_orcamentos' => 0,
                'valor_total' => 0,
                'valor_medio' => 0,
                'maior_valor' => 0,
                'menor_valor' => 0
            ];
        }
    }
    
    /**
     * Valida os dados do orçamento
     * @param array $data
     * @return array Erros de validação
     */
    public function validate($data) {
        $errors = [];
        
        if (empty($data['cliente'])) {
            $errors[] = 'Nome do cliente é obrigatório';
        }
        
        if (empty($data['valor_total']) || !is_numeric($data['valor_total']) || $data['valor_total'] <= 0) {
            $errors[] = 'Valor total deve ser um valor positivo';
        }
        
        if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email inválido';
        }
        
        return $errors;
    }
}

