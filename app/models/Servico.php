<?php
/**
 * Modelo Serviço
 * Sistema de Gestão de Bicicletaria
 */

//require_once 'BaseModel.php';

class Servico extends BaseModel {
    protected $table = 'servicos';
    
    /**
     * Criar novo serviço
     */
    public function create($data) {
        try {
            $sql = "INSERT INTO {$this->table} (
                cliente_nome, cliente_telefone, cliente_email,
                descricao_problema, descricao_servico, valor_servico,
                status, data_entrada, data_previsao, observacoes
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $data['cliente_nome'],
                $data['cliente_telefone'],
                $data['cliente_email'],
                $data['descricao_problema'],
                $data['descricao_servico'],
                $data['valor_servico'],
                $data['status'] ?? 'aguardando',
                $data['data_entrada'] ?? date('Y-m-d H:i:s'),
                $data['data_previsao'],
                $data['observacoes']
            ]);
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Atualizar serviço
     */
    public function update($id, $data) {
        try {
            $sql = "UPDATE {$this->table} SET 
                cliente_nome = ?, cliente_telefone = ?, cliente_email = ?,
                descricao_problema = ?, descricao_servico = ?, valor_servico = ?,
                status = ?, data_previsao = ?, observacoes = ?
                WHERE id = ?";
            
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $data['cliente_nome'],
                $data['cliente_telefone'],
                $data['cliente_email'],
                $data['descricao_problema'],
                $data['descricao_servico'],
                $data['valor_servico'],
                $data['status'],
                $data['data_previsao'],
                $data['observacoes'],
                $id
            ]);
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Buscar serviços por status
     */
    public function findByStatus($status) {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE status = ? ORDER BY data_entrada DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$status]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }
    
    /**
     * Estatísticas de serviços
     */
    public function getEstatisticas() {
        try {
            $stats = [];
            
            // Total de serviços
            $sql = "SELECT COUNT(*) as total FROM {$this->table}";
            $stmt = $this->db->query($sql);
            $stats['total'] = $stmt->fetch()['total'];
            
            // Serviços por status
            $sql = "SELECT status, COUNT(*) as quantidade FROM {$this->table} GROUP BY status";
            $stmt = $this->db->query($sql);
            $statusCount = $stmt->fetchAll();
            
            foreach ($statusCount as $item) {
                $stats['status_' . $item['status']] = $item['quantidade'];
            }
            
            // Valor total dos serviços do mês
            $sql = "SELECT SUM(valor_servico) as valor_total FROM {$this->table} 
                    WHERE MONTH(data_entrada) = MONTH(CURRENT_DATE()) 
                    AND YEAR(data_entrada) = YEAR(CURRENT_DATE())";
            $stmt = $this->db->query($sql);
            $stats['valor_mes'] = $stmt->fetch()['valor_total'] ?? 0;
            
            return $stats;
        } catch (Exception $e) {
            return [];
        }
    }
}

