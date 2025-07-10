<?php
/**
 * Relatório Controller
 * Sistema de Gestão de Bicicletaria
 */

//require_once 'BaseController.php';

class RelatorioController extends BaseController {
    private $produtoModel;
    private $estoqueModel;
    private $orcamentoModel;
    
    public function __construct() {
        parent::__construct();
        $this->produtoModel = new Produto();
        $this->estoqueModel = new Estoque();
        $this->orcamentoModel = new Orcamento();
    }
    
    /**
     * Página principal de relatórios
     */
    public function index() {
        $this->requireLogin();
        
        $data = [
            'title' => 'Relatórios',
        ];
        
        $this->loadView('relatorios/index', $data);
    }
    
    /**
     * Relatório de vendas por período
     */
    public function vendas() {
        $this->requireLogin();
        
        $dataInicio = $_GET['data_inicio'] ?? date('Y-m-01');
        $dataFim = $_GET['data_fim'] ?? date('Y-m-t');
        
        $orcamentos = $this->orcamentoModel->findByPeriodo($dataInicio, $dataFim);
        
        // Calcular estatísticas
        $totalOrcamentos = count($orcamentos);
        $valorTotal = array_sum(array_column($orcamentos, 'valor_total'));
        $valorMedio = $totalOrcamentos > 0 ? $valorTotal / $totalOrcamentos : 0;
        
        // Agrupar por dia
        $vendasPorDia = [];
        foreach ($orcamentos as $orcamento) {
            $dia = date('Y-m-d', strtotime($orcamento['data']));
            if (!isset($vendasPorDia[$dia])) {
                $vendasPorDia[$dia] = ['quantidade' => 0, 'valor' => 0];
            }
            $vendasPorDia[$dia]['quantidade']++;
            $vendasPorDia[$dia]['valor'] += $orcamento['valor_total'];
        }
        
        $data = [
            'title' => 'Relatório de Vendas',
            'data_inicio' => $dataInicio,
            'data_fim' => $dataFim,
            'orcamentos' => $orcamentos,
            'total_orcamentos' => $totalOrcamentos,
            'valor_total' => $valorTotal,
            'valor_medio' => $valorMedio,
            'vendas_por_dia' => $vendasPorDia
        ];
        
        $this->loadView('relatorios/vendas', $data);
    }
    
    /**
     * Relatório de produtos mais vendidos
     */
    public function produtosMaisVendidos() {
        $this->requireLogin();
        
        $dataInicio = $_GET['data_inicio'] ?? date('Y-m-01');
        $dataFim = $_GET['data_fim'] ?? date('Y-m-t');
        
        try {
            $sql = "
                SELECT 
                    p.id,
                    p.nome,
                    p.categoria,
                    p.preco_venda,
                    SUM(io.quantidade) as total_vendido,
                    SUM(io.subtotal) as valor_total_vendido,
                    COUNT(DISTINCT io.id_orcamento) as num_orcamentos
                FROM produtos p
                INNER JOIN itens_orcamento io ON p.id = io.id_produto
                INNER JOIN orcamentos o ON io.id_orcamento = o.id
                WHERE DATE(o.data) BETWEEN ? AND ?
                GROUP BY p.id, p.nome, p.categoria, p.preco_venda
                ORDER BY total_vendido DESC
                LIMIT 20
            ";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$dataInicio, $dataFim]);
            $produtosMaisVendidos = $stmt->fetchAll();
        } catch (Exception $e) {
            $produtosMaisVendidos = [];
        }
        
        $data = [
            'title' => 'Produtos Mais Vendidos',
            'data_inicio' => $dataInicio,
            'data_fim' => $dataFim,
            'produtos' => $produtosMaisVendidos
        ];
        
        $this->loadView('relatorios/produtos_mais_vendidos', $data);
    }
    
    /**
     * Relatório de estoque crítico
     */
    public function estoqueCritico() {
        $this->requireLogin();
        
        $limite = $_GET['limite'] ?? Config::ESTOQUE_LIMITE_BAIXO;
        
        $produtosEstoqueBaixo = $this->estoqueModel->findEstoqueBaixo($limite);
        
        $data = [
            'title' => 'Relatório de Estoque Crítico',
            'limite' => $limite,
            'produtos' => $produtosEstoqueBaixo
        ];
        
        $this->loadView('relatorios/estoque_critico', $data);
    }
    
    /**
     * Dashboard executivo
     */
    public function dashboardExecutivo() {
        $this->requireLogin();
        
        // Estatísticas gerais
        $totalProdutos = $this->produtoModel->count();
        $totalOrcamentosMes = count($this->orcamentoModel->findMesAtual());
        $valorTotalMes = array_sum(array_column($this->orcamentoModel->findMesAtual(), 'valor_total'));
        $produtosEstoqueBaixo = count($this->estoqueModel->findEstoqueBaixo());
        
        // Vendas dos últimos 7 dias
        $vendasUltimos7Dias = [];
        for ($i = 6; $i >= 0; $i--) {
            $data = date('Y-m-d', strtotime("-$i days"));
            $orcamentos = $this->orcamentoModel->findByPeriodo($data, $data);
            $vendasUltimos7Dias[] = [
                'data' => $data,
                'quantidade' => count($orcamentos),
                'valor' => array_sum(array_column($orcamentos, 'valor_total'))
            ];
        }
        
        // Top 5 produtos mais vendidos no mês
        try {
            $sql = "
                SELECT 
                    p.nome,
                    SUM(io.quantidade) as total_vendido
                FROM produtos p
                INNER JOIN itens_orcamento io ON p.id = io.id_produto
                INNER JOIN orcamentos o ON io.id_orcamento = o.id
                WHERE MONTH(o.data) = MONTH(CURRENT_DATE()) 
                AND YEAR(o.data) = YEAR(CURRENT_DATE())
                GROUP BY p.id, p.nome
                ORDER BY total_vendido DESC
                LIMIT 5
            ";
            $stmt = $this->db->query($sql);
            $topProdutos = $stmt->fetchAll();
        } catch (Exception $e) {
            $topProdutos = [];
        }
        
        $data = [
            'title' => 'Dashboard Executivo',
            'total_produtos' => $totalProdutos,
            'total_orcamentos_mes' => $totalOrcamentosMes,
            'valor_total_mes' => $valorTotalMes,
            'produtos_estoque_baixo' => $produtosEstoqueBaixo,
            'vendas_ultimos_7_dias' => $vendasUltimos7Dias,
            'top_produtos' => $topProdutos
        ];
        
        $this->loadView('relatorios/dashboard_executivo', $data);
    }
    
    /**
     * Exportar relatório para CSV
     */
    public function exportarCSV() {
        $this->requireLogin();
        
        $tipo = $_GET['tipo'] ?? 'vendas';
        $dataInicio = $_GET['data_inicio'] ?? date('Y-m-01');
        $dataFim = $_GET['data_fim'] ?? date('Y-m-t');
        
        switch ($tipo) {
            case 'vendas':
                $this->exportarVendasCSV($dataInicio, $dataFim);
                break;
            case 'estoque':
                $this->exportarEstoqueCSV();
                break;
            case 'produtos':
                $this->exportarProdutosCSV();
                break;
            default:
                $this->redirect('/relatorio');
        }
    }
    
    private function exportarVendasCSV($dataInicio, $dataFim) {
        $orcamentos = $this->orcamentoModel->findByPeriodo($dataInicio, $dataFim);
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="vendas_' . $dataInicio . '_' . $dataFim . '.csv"');
        
        $output = fopen('php://output', 'w');
        
        // BOM para UTF-8
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // Cabeçalho
        fputcsv($output, ['ID', 'Data', 'Cliente', 'Telefone', 'Email', 'Valor Total'], ';');
        
        // Dados
        foreach ($orcamentos as $orcamento) {
            fputcsv($output, [
                $orcamento['id'],
                date('d/m/Y H:i', strtotime($orcamento['data'])),
                $orcamento['cliente'],
                $orcamento['telefone'],
                $orcamento['email'],
                number_format($orcamento['valor_total'], 2, ',', '.')
            ], ';');
        }
        
        fclose($output);
        exit;
    }
    
    private function exportarEstoqueCSV() {
        $relatorio = $this->estoqueModel->relatorioEstoque();
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="estoque_' . date('Y-m-d') . '.csv"');
        
        $output = fopen('php://output', 'w');
        
        // BOM para UTF-8
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // Cabeçalho
        fputcsv($output, ['ID', 'Produto', 'Categoria', 'Preço', 'Quantidade', 'Valor Total'], ';');
        
        // Dados
        foreach ($relatorio as $item) {
            fputcsv($output, [
                $item['id'],
                $item['nome'],
                $item['categoria'],
                number_format($item['preco_venda'], 2, ',', '.'),
                $item['quantidade'],
                number_format($item['valor_total_estoque'], 2, ',', '.')
            ], ';');
        }
        
        fclose($output);
        exit;
    }

    /**
     * Exportar lista de produtos para CSV
     */
    private function exportarProdutosCSV() {
        $produtos = $this->produtoModel->findAll();

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="produtos_' . date('Y-m-d') . '.csv"');

        $output = fopen('php://output', 'w');

        // BOM para UTF-8
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

        // Cabeçalho
        fputcsv($output, ['ID', 'Nome', 'Categoria', 'Preço de Venda', 'Descrição'], ';');

        // Dados
        foreach ($produtos as $produto) {
            fputcsv($output, [
                $produto['id'],
                $produto['nome'],
                $produto['categoria'],
                number_format($produto['preco_venda'], 2, ',', '.'),
                $produto['descricao'] ?? ''
            ], ';');
        }

        fclose($output);
        exit;
    }
}

