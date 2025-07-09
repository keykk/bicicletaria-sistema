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
            'total_vendas_mes' => $this->getTotalVendasMes(),
            'valor_total_vendas_mes' => $this->getValorTotalVendasMes()
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
            $stmt = $this->db->prepare("
                SELECT COUNT(*) as total 
                FROM estoque 
                WHERE quantidade <= 5
                AND empresa_id = ?
            ");
            $stmt->execute([$_SESSION['empresa_id']]);
            $result = $stmt->fetch();
            return $result['total'];
        } catch (Exception $e) {
            return 0;
        }
    }
    
    private function getTotalVendasMes() {
        try {
            $stmt = $this->db->prepare("
                SELECT COUNT(*) as total 
                FROM vendas 
                WHERE MONTH(data_venda) = MONTH(CURRENT_DATE()) 
                AND YEAR(data_venda) = YEAR(CURRENT_DATE())
                AND empresa_id = ?
            ");
            $stmt->execute([$_SESSION['empresa_id']]);
            $result = $stmt->fetch();
            return $result['total'];
        } catch (Exception $e) {
            return 0;
        }
    }
    
    private function getValorTotalVendasMes() {
        try {
            $stmt = $this->db->prepare("
                SELECT SUM(total) as total 
                FROM vendas 
                WHERE MONTH(data_venda) = MONTH(CURRENT_DATE()) 
                AND YEAR(data_venda) = YEAR(CURRENT_DATE())
                AND empresa_id = ?
            ");
            $stmt->execute([$_SESSION['empresa_id']]);
            $result = $stmt->fetch();
            return $result['total'] ?? 0;
        } catch (Exception $e) {
            return 0;
        }
    }
}

