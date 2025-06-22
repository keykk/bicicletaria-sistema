<?php
/**
 * Dashboard Controller
 * Sistema de Gestão de Bicicletaria
 */

require_once 'BaseController.php';

class DashboardController extends BaseController {
    
    public function index() {
        // Verificar se o usuário está logado
        $this->requireLogin();
        
        // Buscar dados para o dashboard
        $data = [
            'title' => 'Dashboard - Sistema de Gestão',
            'total_produtos' => $this->getTotalProdutos(),
            'produtos_estoque_baixo' => $this->getProdutosEstoqueBaixo(),
            'total_orcamentos_mes' => $this->getTotalOrcamentosMes(),
            'valor_total_orcamentos_mes' => $this->getValorTotalOrcamentosMes()
        ];
        
        $this->loadView('dashboard/index', $data);
    }
    
    private function getTotalProdutos() {
        try {
            $stmt = $this->db->query("SELECT COUNT(*) as total FROM produtos");
            $result = $stmt->fetch();
            return $result['total'];
        } catch (Exception $e) {
            return 0;
        }
    }
    
    private function getProdutosEstoqueBaixo() {
        try {
            $stmt = $this->db->query("
                SELECT COUNT(*) as total 
                FROM estoque 
                WHERE quantidade <= 5
            ");
            $result = $stmt->fetch();
            return $result['total'];
        } catch (Exception $e) {
            return 0;
        }
    }
    
    private function getTotalOrcamentosMes() {
        try {
            $stmt = $this->db->query("
                SELECT COUNT(*) as total 
                FROM orcamentos 
                WHERE MONTH(data) = MONTH(CURRENT_DATE()) 
                AND YEAR(data) = YEAR(CURRENT_DATE())
            ");
            $result = $stmt->fetch();
            return $result['total'];
        } catch (Exception $e) {
            return 0;
        }
    }
    
    private function getValorTotalOrcamentosMes() {
        try {
            $stmt = $this->db->query("
                SELECT SUM(valor_total) as total 
                FROM orcamentos 
                WHERE MONTH(data) = MONTH(CURRENT_DATE()) 
                AND YEAR(data) = YEAR(CURRENT_DATE())
            ");
            $result = $stmt->fetch();
            return $result['total'] ?? 0;
        } catch (Exception $e) {
            return 0;
        }
    }
}

