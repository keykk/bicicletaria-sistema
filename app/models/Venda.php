<?php
/**
 * Modelo Venda
 * Sistema de Gestão de Bicicletaria - Módulo PDV
 */

class Venda extends BaseModel {
    protected $table = 'vendas';
    
    /**
     * Buscar vendas com filtros
     * @param array $filtros
     * @return array
     */
    public function buscar($filtros = []) {
        $sql = "SELECT v.*, u.nome as vendedor_nome 
                FROM {$this->table} v
                LEFT JOIN usuarios u ON v.usuario_id = u.id
                WHERE 1=1";
        
        $params = [];
        
        if (!empty($filtros['data_inicio'])) {
            $sql .= " AND DATE(v.data_venda) >= :data_inicio";
            $params[':data_inicio'] = $filtros['data_inicio'];
        }
        
        if (!empty($filtros['data_fim'])) {
            $sql .= " AND DATE(v.data_venda) <= :data_fim";
            $params[':data_fim'] = $filtros['data_fim'];
        }
        
        if (!empty($filtros['forma_pagamento'])) {
            $sql .= " AND v.forma_pagamento = :forma_pagamento";
            $params[':forma_pagamento'] = $filtros['forma_pagamento'];
        }
        
        if (!empty($filtros['cliente'])) {
            $sql .= " AND v.cliente_nome LIKE :cliente";
            $params[':cliente'] = '%' . $filtros['cliente'] . '%';
        }
        $sql .= " AND empresa_id = :empresaid";
        $params[':empresaid'] = $_SESSION['empresa_id'];
        
        $sql .= " ORDER BY v.data_venda DESC";
        
        if (!empty($filtros['limit'])) {
            $sql .= " LIMIT " . (int)$filtros['limit'];
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Buscar venda por ID com itens
     * @param int $id
     * @return array|null
     */
    public function buscarComItens($id) {
        // Buscar dados da venda
        $sql = "SELECT v.*, u.nome as vendedor_nome 
                FROM {$this->table} v
                LEFT JOIN usuarios u ON v.usuario_id = u.id
                WHERE v.id = :id
                AND empresa_id = :empresaid";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id, ':empresaid' => $_SESSION['empresa_id']]);
        $venda = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$venda) {
            return null;
        }
        
        // Buscar itens da venda
        $sql = "SELECT iv.*, p.nome as produto_nome, p.id as produto_codigo, p.unidade_medida
                FROM itens_venda iv
                JOIN produtos p ON iv.produto_id = p.id
                WHERE iv.venda_id = :venda_id
                ORDER BY iv.id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':venda_id' => $id]);
        $venda['itens'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $venda;
    }
    
    /**
     * Calcular estatísticas de vendas
     * @param array $filtros
     * @return array
     */
    public function estatisticas($filtros = []) {
        $where = "WHERE 1=1";
        $params = [];
        
        if (!empty($filtros['data_inicio'])) {
            $where .= " AND DATE(data_venda) >= :data_inicio";
            $params[':data_inicio'] = $filtros['data_inicio'];
        }
        
        if (!empty($filtros['data_fim'])) {
            $where .= " AND DATE(data_venda) <= :data_fim";
            $params[':data_fim'] = $filtros['data_fim'];
        }

        $where .= " AND empresa_id = :empresaid";
        $params[':empresaid'] = $_SESSION['empresa_id'];
        
        $sql = "SELECT 
                    COUNT(*) as total_vendas,
                    SUM(total) as valor_total,
                    AVG(total) as ticket_medio,
                    SUM(CASE WHEN forma_pagamento = 'dinheiro' THEN 1 ELSE 0 END) as vendas_dinheiro,
                    SUM(CASE WHEN forma_pagamento = 'cartao_credito' THEN 1 ELSE 0 END) as vendas_cartao_credito,
                    SUM(CASE WHEN forma_pagamento = 'cartao_debito' THEN 1 ELSE 0 END) as vendas_cartao_debito,
                    SUM(CASE WHEN forma_pagamento = 'pix' THEN 1 ELSE 0 END) as vendas_pix
                FROM {$this->table} {$where}";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Produtos mais vendidos
     * @param array $filtros
     * @return array
     */
    public function produtosMaisVendidos($filtros = []) {
        $where = "WHERE 1=1";
        $params = [];
        
        if (!empty($filtros['data_inicio'])) {
            $where .= " AND DATE(v.data_venda) >= :data_inicio";
            $params[':data_inicio'] = $filtros['data_inicio'];
        }
        
        if (!empty($filtros['data_fim'])) {
            $where .= " AND DATE(v.data_venda) <= :data_fim";
            $params[':data_fim'] = $filtros['data_fim'];
        }
        $where .= " AND empresa_id = :empresaid";
        $params[':empresaid'] = $_SESSION['empresa_id'];
        $sql = "SELECT 
                    p.id, p.nome, p.codigo,
                    SUM(iv.quantidade) as quantidade_vendida,
                    SUM(iv.subtotal) as valor_total,
                    COUNT(DISTINCT v.id) as numero_vendas
                FROM itens_venda iv
                JOIN produtos p ON iv.produto_id = p.id
                JOIN vendas v ON iv.venda_id = v.id
                {$where}
                GROUP BY p.id, p.nome, p.codigo
                ORDER BY quantidade_vendida DESC
                LIMIT 10";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Cancelar venda
     * @param int $id
     * @param string $motivo
     * @return bool
     */
    public function cancelar($id, $motivo = '') {
        $vendas = $this->findById($id, $_SESSION['empresa_id']);

        $sql = "UPDATE {$this->table} 
                SET status = 'cancelada', 
                    motivo_cancelamento = :motivo,
                    data_cancelamento = NOW()
                WHERE id = :id
                AND empresa_id = :empresaid";
        
        $stmt = $this->db->prepare($sql);
        $retorno = $stmt->execute([
            ':id' => $id,
            ':motivo' => $motivo,
            ':empresaid' => $_SESSION['empresa_id']
        ]);

        if ($vendas['status'] !== 'cancelada'){
            $this->atualizarEstoque($id);
        }
        
        return $retorno;

    }
    
    /**
     * Atualizar estoque após venda
     * @param int $venda_id
     * @return bool
     */
    public function atualizarEstoque($venda_id) {
        // Buscar itens da venda
        $sql = "SELECT produto_id, quantidade FROM itens_venda WHERE venda_id = :venda_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':venda_id' => $venda_id]);
        $itens = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $venda = $this->findById($venda_id, $_SESSION['empresa_id']);
        
        $operador = $venda['status'] == 'cancelada' ? '+' : '-';
        // Atualizar estoque de cada produto
        foreach ($itens as $item) {
            $sql = "UPDATE estoque 
                    SET quantidade = quantidade $operador :quantidade,
                        data_atualizacao = NOW()
                    WHERE id_produto = :produto_id
                    AND empresa_id = :empresaid";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':quantidade' => $item['quantidade'],
                ':produto_id' => $item['produto_id'],
                ':empresaid' => $_SESSION['empresa_id']
            ]);
        }
        
        return true;
    }
    
    /**
     * Buscar vendas do dia
     * @return array
     */
    public function vendasDoDia() {
        $sql = "SELECT v.*, u.nome as vendedor_nome 
                FROM {$this->table} v
                LEFT JOIN usuarios u ON v.usuario_id = u.id
                WHERE DATE(v.data_venda) = CURDATE()
                AND v.status != 'cancelada'
                AND v.empresa_id = ?
                ORDER BY v.data_venda DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$_SESSION['empresa_id']]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Resumo de vendas por período
     * @param string $periodo (hoje, semana, mes, ano)
     * @return array
     */
    public function resumoPorPeriodo($periodo = 'hoje') {
        $where_conditions = [
            'hoje' => "DATE(data_venda) = CURDATE()",
            'semana' => "YEARWEEK(data_venda) = YEARWEEK(NOW())",
            'mes' => "YEAR(data_venda) = YEAR(NOW()) AND MONTH(data_venda) = MONTH(NOW())",
            'ano' => "YEAR(data_venda) = YEAR(NOW())"
        ];
        
        $where = $where_conditions[$periodo] ?? $where_conditions['hoje'];
        
        $sql = "SELECT 
                    COUNT(*) as total_vendas,
                    SUM(total) as valor_total,
                    AVG(total) as ticket_medio
                FROM {$this->table} 
                WHERE {$where} AND status != 'cancelada'
                AND empresa_id = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$_SESSION['empresa_id']]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>

