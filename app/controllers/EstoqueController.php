<?php
/**
 * Estoque Controller
 * Sistema de Gestão de Bicicletaria
 */

require_once 'BaseController.php';

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
     * Processa saída de estoque
     */
    public function processarSaida() {
        $this->requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/estoque/saida');
        }
        
        $idProduto = $_POST['id_produto'] ?? '';
        $quantidade = $_POST['quantidade'] ?? '';
        
        if (empty($idProduto) || empty($quantidade) || !is_numeric($quantidade) || $quantidade <= 0) {
            $_SESSION['errors'] = ['Produto e quantidade são obrigatórios'];
            $this->redirect('/estoque/saida');
        }
        
        $produto = $this->produtoModel->findById($idProduto);
        if (!$produto) {
            $_SESSION['errors'] = ['Produto não encontrado'];
            $this->redirect('/estoque/saida');
        }
        
        // Verificar se há quantidade suficiente
        if (!$this->estoqueModel->temQuantidadeSuficiente($idProduto, $quantidade)) {
            $_SESSION['errors'] = ['Quantidade insuficiente em estoque'];
            $this->redirect('/estoque/saida');
        }
        
        if ($this->estoqueModel->removerQuantidade($idProduto, $quantidade)) {
            $_SESSION['success'] = "Saída de {$quantidade} {$produto['unidade_medida']} do produto '{$produto['nome']}' realizada com sucesso";
        } else {
            $_SESSION['errors'] = ['Erro ao processar saída de estoque'];
        }
        
        $this->redirect('/estoque/saida');
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
     * Processa ajuste de estoque
     */
    public function processarAjuste() {
        $this->requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/estoque/ajuste');
        }
        
        $idProduto = $_POST['id_produto'] ?? '';
        $novaQuantidade = $_POST['nova_quantidade'] ?? '';
        
        if (empty($idProduto) || !is_numeric($novaQuantidade) || $novaQuantidade < 0) {
            $_SESSION['errors'] = ['Produto e nova quantidade são obrigatórios'];
            $this->redirect('/estoque/ajuste');
        }
        
        $produto = $this->produtoModel->findById($idProduto);
        if (!$produto) {
            $_SESSION['errors'] = ['Produto não encontrado'];
            $this->redirect('/estoque/ajuste');
        }
        
        if ($this->estoqueModel->updateQuantidade($idProduto, $novaQuantidade)) {
            $_SESSION['success'] = "Estoque do produto '{$produto['nome']}' ajustado para {$novaQuantidade} {$produto['unidade_medida']}";
        } else {
            $_SESSION['errors'] = ['Erro ao processar ajuste de estoque'];
        }
        
        $this->redirect('/estoque/ajuste');
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
}

