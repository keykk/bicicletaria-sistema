<?php
/**
 * Estoque Controller
 * Sistema de Gestão de Bicicletaria
 */

//require_once 'BaseController.php';

class EstoqueController extends BaseController {
    private $estoqueModel;
    private $produtoModel;
    
    public function __construct() {
        parent::__construct();
        $this->estoqueModel = new Estoque();
        $this->produtoModel = new Produto();
    }
    
    /**
     * Exibe relatório de estoque
     */
    public function index() {
        $this->requireLogin();
        
        $relatorio = $this->estoqueModel->relatorioEstoque();
        $estoqueBaixo = $this->estoqueModel->findEstoqueBaixo();
        
        $data = [
            'title' => 'Controle de Estoque',
            'relatorio' => $relatorio,
            'estoque_baixo' => $estoqueBaixo
        ];
        
        $this->loadView('estoque/index', $data);
    }
    
    /**
     * Exibe formulário para entrada de estoque
     */
    public function entrada() {
        $this->requireLogin();
        
        $produtos = $this->produtoModel->findAll();
        
        $data = [
            'title' => 'Entrada de Estoque',
            'produtos' => $produtos,
            'errors' => $_SESSION['errors'] ?? [],
            'success' => $_SESSION['success'] ?? null
        ];
        
        unset($_SESSION['errors'], $_SESSION['success']);
        
        $this->loadView('estoque/entrada', $data);
    }
    
    /**
     * Processa entrada de estoque
     */
    public function processarEntrada() {
        $this->requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/estoque/entrada');
        }
        
        $idProduto = $_POST['id_produto'] ?? '';
        $quantidade = $_POST['quantidade'] ?? '';
        
        if (empty($idProduto) || empty($quantidade) || !is_numeric($quantidade) || $quantidade <= 0) {
            $_SESSION['errors'] = ['Produto e quantidade são obrigatórios'];
            $this->redirect('/estoque/entrada');
        }
        
        $produto = $this->produtoModel->findById($idProduto);
        if (!$produto) {
            $_SESSION['errors'] = ['Produto não encontrado'];
            $this->redirect('/estoque/entrada');
        }
        
        if ($this->estoqueModel->adicionarQuantidade($idProduto, $quantidade)) {
            $_SESSION['success'] = "Entrada de {$quantidade} {$produto['unidade_medida']} do produto '{$produto['nome']}' realizada com sucesso";
        } else {
            $_SESSION['errors'] = ['Erro ao processar entrada de estoque'];
        }
        
        $this->redirect('/estoque/entrada');
    }
    
    /**
     * Exibe formulário para saída de estoque
     */
    public function saida() {
        $this->requireLogin();
        
        $produtos = $this->produtoModel->findWithEstoque();
        
        $data = [
            'title' => 'Saída de Estoque',
            'produtos' => $produtos,
            'errors' => $_SESSION['errors'] ?? [],
            'success' => $_SESSION['success'] ?? null
        ];
        
        unset($_SESSION['errors'], $_SESSION['success']);
        
        $this->loadView('estoque/saida', $data);
    }
    
    /**
     * Exibe formulário para ajuste de estoque
     */
    public function ajuste() {
        $this->requireLogin();
        
        $produtos = $this->produtoModel->findWithEstoque();
        
        $data = [
            'title' => 'Ajuste de Estoque',
            'produtos' => $produtos,
            'errors' => $_SESSION['errors'] ?? [],
            'success' => $_SESSION['success'] ?? null
        ];
        
        unset($_SESSION['errors'], $_SESSION['success']);
        
        $this->loadView('estoque/ajuste', $data);
    }
    
    
    /**
     * API para obter quantidade em estoque
     */
    public function api($idProduto) {
        $this->requireLogin();
        
        $estoque = $this->estoqueModel->findByProduto($idProduto);
        $quantidade = $estoque ? $estoque['quantidade'] : 0;
        
        $this->json(['quantidade' => $quantidade]);
    }

    /**
     * Processar ajuste de estoque (AJAX)
     */
    public function ajustar() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'message' => 'Método não permitido']);
            return;
        }
        
        $input = json_decode(file_get_contents('php://input'), true);
        
        // Validar dados
        if (empty($input['produto_id']) || empty($input['tipo_ajuste']) || 
            !isset($input['quantidade']) ) {
            $this->json(['success' => false, 'message' => 'Dados incompletos']);
            return;
        }
        
        $produto_id = $input['produto_id'];
        $tipo_ajuste = $input['tipo_ajuste'];
        $quantidade = floatval($input['quantidade']);
        
        
        if ($quantidade <= 0) {
            $this->json(['success' => false, 'message' => 'Quantidade deve ser maior que zero']);
            return;
        }
        
        try {
            $this->db->beginTransaction();
            
            // Buscar produto e estoque atual
            $produto = new Produto();
            $produtoData = $produto->findById($produto_id);
            
            if (!$produtoData) {
                throw new Exception('Produto não encontrado');
            }
            
            $estoque = new Estoque();
            $estoqueData = $estoque->findById($produto_id, $_SESSION['empresa_id']);
            $estoque_anterior = $estoqueData['quantidade'] ?? 0;
            
            // Calcular novo estoque
            $novo_estoque = $estoque_anterior;
            
            switch ($tipo_ajuste) {
                case 'entrada':
                    $novo_estoque = $estoque_anterior + $quantidade;
                    break;
                case 'saida':
                    $novo_estoque = $estoque_anterior - $quantidade;
                    break;
                case 'correcao':
                    $novo_estoque = $quantidade;
                    break;
                default:
                    throw new Exception('Tipo de ajuste inválido');
            }
            
            if ($novo_estoque < 0) {
                throw new Exception('Estoque não pode ficar negativo');
            }
            
            // Atualizar estoque
            $success = $estoque->updateQuantidade($produto_id, $novo_estoque);
            
            if (!$success) {
                throw new Exception('Erro ao atualizar estoque');
            }
            
            $this->db->commit();
            
            $this->json([
                'success' => true,
                'message' => 'Ajuste realizado com sucesso',
                'estoque_anterior' => $estoque_anterior,
                'estoque_atual' => $novo_estoque
            ]);
            
        } catch (Exception $e) {
            $this->db->rollBack();
            $this->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}

