<?php
/**
 * PDV Controller
 * Sistema de Gestão de Bicicletaria - Módulo PDV
 */

class PdvController extends BaseController {
    
    public function __construct() {
        parent::__construct();
        $this->requireLogin();
        //$this->requirePermission('vendas');
    }
    
    /**
     * Página principal do PDV
     */
    public function index() {
        $tabela = new TabelaPreco();
        $tabela_preco = $tabela->findAll($_SESSION['empresa_id']);
        $data = [
            'title' => 'Ponto de Venda (PDV)',
            'active_menu' => 'pdv',
            'tabela_preco' => $tabela_preco
        ];
        
        $this->loadView('pdv/index', $data);
    }
    
    /**
     * Buscar produtos para o PDV (AJAX)
     */
    public function buscarProdutos() {
        $termo = $_GET['termo'] ?? '';
        $idtab = (int)$_GET['tab'] ?? '';
        
        if (strlen($termo) < 1 || $idtab <= 0) {
            $this->json(['produtos' => []]);
            return;
        }
        
        $produto = new Produto();
        $produtos = $produto->buscarParaPDV($termo, $idtab);
        
        $this->json(['produtos' => $produtos]);
    }
    
    /**
     * Buscar produto por código de barras (AJAX)
     */
    public function buscarPorCodigo() {
        $codigo = $_GET['codigo'] ?? '';
        $idtab = (int)$_GET['tab'] ?? '';
        
        if (empty($codigo) || $idtab <= 0) {
            $this->json(['success' => false, 'message' => 'Código não informado']);
            return;
        }
        
        $produto = new Produto();
        $item1 = $produto->buscarParaPDVById($codigo, $idtab);
        $produtoData = $item1[0];
        
        if ($produtoData) {
            // Verificar estoque
            
            $this->json(['success' => true, 'produto' => $produtoData]);
        } else {
            $this->json(['success' => false, 'message' => 'Produto não encontrado']);
        }
    }
    
    /**
     * Processar venda (AJAX)
     */
    public function processarVenda() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'message' => 'Método não permitido']);
            return;
        }
        
        
        $input = json_decode(file_get_contents('php://input'), true);
      
        // Validar dados
        if (empty($input['itens']) || !is_array($input['itens'])) {
            $this->json(['success' => false, 'message' => 'Nenhum item informado']);
            return;
        }
        
        if (empty($input['forma_pagamento'])) {
            $this->json(['success' => false, 'message' => 'Forma de pagamento não informada']);
            return;
        }
        
        try {
            $this->db->beginTransaction();
            
            // Calcular totais
            $subtotal = 0;
            foreach ($input['itens'] as $item) {
                $subtotal += $item['quantidade'] * $item['preco_unitario'];
            }
            
            $desconto = $input['desconto'] ?? 0;
            $total = $subtotal - $desconto;
            
            // Calcular troco se for dinheiro
            $troco = 0;
            $valor_pago = null;
            
            if ($input['forma_pagamento'] === 'dinheiro') {
                $valor_pago = $input['valor_pago'] ?? 0;
                if ($valor_pago < $total) {
                    throw new Exception('Valor pago é menor que o total da venda');
                }
                $troco = $valor_pago - $total;
            }
            
            // Criar venda
            $venda = new Venda();
            $usr = $this->getLoggedUser();
            $emp = $this->getSelectedEmpresa();
            $dados_venda = [
                'cliente_nome' => $input['cliente_nome'] ?? null,
                'cliente_telefone' => $input['cliente_telefone'] ?? null,
                'cliente_email' => $input['cliente_email'] ?? null,
                'subtotal' => $subtotal,
                'desconto' => $desconto,
                'total' => $total,
                'forma_pagamento' => $input['forma_pagamento'],
                'valor_pago' => $valor_pago,
                'troco' => $troco,
                'observacoes' => $input['observacoes'] ?? null,
                'usuario_id' => $usr['id'],
                'empresa_id' => $emp['id']
            ];
            
            $venda_id = $venda->insert($dados_venda);
            
            // Adicionar itens
            $itens_venda = new ItemVenda();
            foreach ($input['itens'] as $item) {
                $item_data = [
                    'venda_id' => $venda_id,
                    'produto_id' => $item['id'],
                    'quantidade' => $item['quantidade'],
                    'preco_unitario' => $item['preco_unitario'],
                    'subtotal' => $item['quantidade'] * $item['preco_unitario'],
                    'desconto_item' => $item['desconto_item'] ?? 0,
                    'tabela_preco_id' => $item['tabela_preco_id']
                ];
                
                $itens_venda->insert($item_data);
            }
            
            // Atualizar estoque
            $venda->atualizarEstoque($venda_id);
            
            $this->db->commit();
            
            return $this->json([
                'success' => true,
                'message' => 'Venda processada com sucesso',
                'venda_id' => $venda_id,
                'total' => $total,
                'troco' => $troco
            ]);
            exit;
            
        } catch (Exception $e) {
            $this->db->rollBack();
            gravarLog("Erro: ".$e->getMessage());
            return $this->json(['success' => false, 'message' => $e->getMessage()]);
            exit;
        }
    }
    
    /**
     * Calcular troco (AJAX)
     */
    public function calcularTroco() {
        $total = $_GET['total'] ?? 0;
        $valor_pago = $_GET['valor_pago'] ?? 0;
        
        $total = floatval($total);
        $valor_pago = floatval($valor_pago);
        
        if ($valor_pago < $total) {
            $this->json([
                'success' => false,
                'message' => 'Valor pago é menor que o total',
                'falta' => $total - $valor_pago
            ]);
        } else {
            $this->json([
                'success' => true,
                'troco' => $valor_pago - $total
            ]);
        }
    }
    
    /**
     * Listar vendas
     */
    public function vendas() {
        $filtros = [
            'data_inicio' => $_GET['data_inicio'] ?? date('Y-m-01'),
            'data_fim' => $_GET['data_fim'] ?? date('Y-m-t'),
            'forma_pagamento' => $_GET['forma_pagamento'] ?? '',
            'cliente' => $_GET['cliente'] ?? ''
        ];
        
        $venda = new Venda();
        $vendas = $venda->buscar($filtros);
        $estatisticas = $venda->estatisticas($filtros);
        
        $data = [
            'title' => 'Vendas Realizadas',
            'active_menu' => 'pdv',
            'vendas' => $vendas,
            'estatisticas' => $estatisticas,
            'filtros' => $filtros
        ];
        
        $this->loadView('pdv/vendas', $data);
    }
    
    /**
     * Visualizar venda específica
     */
    public function visualizar($id = null) {
        if (!$id) {
            $_SESSION['errors'] = ['Venda não encontrada'];
            $this->redirect('/pdv/vendas');
            exit;
        }
        
        $venda = new Venda();
        $vendaData = $venda->buscarComItens($id);
        
        if (!$vendaData) {
            $_SESSION['errors'] = ['Venda não encontrada'];
            $this->redirect('/pdv/vendas');
            exit;
        }
        
        $data = [
            'title' => 'Detalhes da Venda #' . $id,
            'active_menu' => 'pdv',
            'venda' => $vendaData
        ];
        
        $this->loadView('pdv/visualizar', $data);
    }
    
    /**
     * Imprimir cupom da venda
     */
    public function cupom($id = null) {
        $this->requireLogin();
        if (!$id) {
            die('Venda não encontrada');
        }
        
        $venda = new Venda();
        $vendaData = $venda->buscarComItens($id);
        
        if (!$vendaData) {
            die('Venda não encontrada');
        }
        
        $data = [
            'venda' => $vendaData
        ];
        
        $this->loadView('pdv/cupom', $data);
    }

    public function imprimir($id) {
        $this->requireLogin();
        
        $venda = new Venda();
        $vendaData = $venda->buscarComItens($id);
        
        if (!$vendaData) {
            die('Venda não encontrada');
        }
        
        $data = [
            'title' => 'Imprimir Orçamento',
            'venda' => $vendaData,
            'empresa' => $this->getSelectedEmpresa() ?? Config::getEmpresaInfo()
        ];
        
        $this->loadView('pdv/imprimir', $data);
    }
    
    /**
     * Cancelar venda
     */
    public function cancelar() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'message' => 'Método não permitido']);
            return;
        }
        
        $input = json_decode(file_get_contents('php://input'), true);
        $venda_id = $input['venda_id'] ?? null;
        $motivo = $input['motivo'] ?? '';
        
        if (!$venda_id) {
            $this->json(['success' => false, 'message' => 'ID da venda não informado']);
            return;
        }
        
        try {
            $venda = new Venda();
            $success = $venda->cancelar($venda_id, $motivo);
            
            if ($success) {
                $this->json(['success' => true, 'message' => 'Venda cancelada com sucesso']);
            } else {
                $this->json(['success' => false, 'message' => 'Erro ao cancelar venda']);
            }
        } catch (Exception $e) {
            $this->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    
    /**
     * Relatório de vendas
     */
    public function relatorio() {
        $periodo = $_GET['periodo'] ?? 'hoje';
        $data_inicio = $_GET['data_inicio'] ?? date('Y-m-d');
        $data_fim = $_GET['data_fim'] ?? date('Y-m-d');
        
        $venda = new Venda();
        
        if ($periodo !== 'personalizado') {
            $estatisticas = $venda->resumoPorPeriodo($periodo);
        } else {
            $filtros = ['data_inicio' => $data_inicio, 'data_fim' => $data_fim];
            $estatisticas = $venda->estatisticas($filtros);
        }
        
        $produtos_mais_vendidos = $venda->produtosMaisVendidos([
            'data_inicio' => $data_inicio,
            'data_fim' => $data_fim
        ]);
        
        $data = [
            'title' => 'Relatório de Vendas',
            'active_menu' => 'pdv',
            'estatisticas' => $estatisticas,
            'produtos_mais_vendidos' => $produtos_mais_vendidos,
            'periodo' => $periodo,
            'data_inicio' => $data_inicio,
            'data_fim' => $data_fim
        ];
        
        $this->loadView('pdv/relatorio', $data);
    }
    
    /**
     * Dashboard do PDV
     */
    public function dashboard() {
        $venda = new Venda();
        
        $vendas_hoje = $venda->resumoPorPeriodo('hoje');
        $vendas_semana = $venda->resumoPorPeriodo('semana');
        $vendas_mes = $venda->resumoPorPeriodo('mes');
        $vendas_do_dia = $venda->vendasDoDia();
        
        $data = [
            'title' => 'Dashboard PDV',
            'active_menu' => 'pdv',
            'vendas_hoje' => $vendas_hoje,
            'vendas_semana' => $vendas_semana,
            'vendas_mes' => $vendas_mes,
            'vendas_do_dia' => $vendas_do_dia
        ];
        
        $this->loadView('pdv/dashboard', $data);
    }

    public function excluir($id){
        $this->requireLogin();

        $venda = new Venda();

        $ver = $venda->findById($id);

        if (!$ver) {
            $_SESSION['errors'] = ['Erro ao excluir Pedido'];
            $this->redirect('/pdv/vendas');
        }
        $venda->cancelar($id, 'Pedido Excluido');
        if ($venda->delete($id)) {
            $this->redirect('/pdv/vendas');
        } else {
            $_SESSION['errors'] = ['Erro ao excluir Pedido'];
            $this->redirect('/pdv/vendas');
        }

    }
}
?>

