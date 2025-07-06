<?php
/**
 * Produto Controller
 * Sistema de Gestão de Bicicletaria
 */

require_once 'BaseController.php';

class ProdutoController extends BaseController {
    private $produtoModel;
    private $estoqueModel;
    
    public function __construct() {
        parent::__construct();
        $this->produtoModel = new Produto();
        $this->estoqueModel = new Estoque();
    }
    
    /**
     * Lista todos os produtos
     */
    public function index() {
        $this->requireLogin();
        
        $search = $_GET['search'] ?? '';
        $categoria = $_GET['categoria'] ?? '';
        
        if (!empty($search)) {
            $produtos = $this->produtoModel->searchByNome($search);
        } elseif (!empty($categoria)) {
            $produtos = $this->produtoModel->findByCategoria($categoria);
        } else {
            $produtos = $this->produtoModel->findWithEstoque();
        }
        
        $categorias = $this->produtoModel->getCategorias();
        
        $data = [
            'title' => 'Produtos',
            'produtos' => $produtos,
            'categorias' => $categorias,
            'search' => $search,
            'categoria_selecionada' => $categoria
        ];
        
        $this->loadView('produtos/index', $data);
    }
    
    /**
     * Exibe formulário para novo produto
     */
    public function novo() {
        $this->requireLogin();
        
        $data = [
            'title' => 'Novo Produto',
            'produto' => null,
            'errors' => $_SESSION['errors'] ?? []
        ];
        
        unset($_SESSION['errors']);
        
        $this->loadView('produtos/form', $data);
    }
    
    /**
     * Salva um novo produto
     */
    public function salvar() {
        $this->requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/produto');
        }
        
        $data = [
            'nome' => $_POST['nome'] ?? '',
            'descricao' => $_POST['descricao'] ?? '',
            'preco_venda' => $_POST['preco_venda'] ?? '',
            'unidade_medida' => $_POST['unidade_medida'] ?? '',
            'marca' => $_POST['marca'] ?? '',
            'modelo' => $_POST['modelo'] ?? '',
            'aro' => $_POST['aro'] ?? '',
            'tipo' => $_POST['tipo'] ?? '',
            'categoria' => $_POST['categoria'] ?? ''
        ];
        
        $errors = $this->produtoModel->validate($data);
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $this->redirect('/produto/novo');
        }
        
        $idProduto = $this->produtoModel->insert($data);
        
        if ($idProduto) {
            // Criar registro de estoque inicial
            $this->estoqueModel->updateQuantidade($idProduto, 0);
            $this->redirect('/produto');
        } else {
            $_SESSION['errors'] = ['Erro ao salvar produto'];
            $this->redirect('/produto/novo');
        }
    }
    
    /**
     * Exibe formulário para editar produto
     */
    public function editar($id) {
        $this->requireLogin();
        
        $produto = $this->produtoModel->findById($id);
        
        if (!$produto) {
            $this->redirect('/produto');
        }
        
        $data = [
            'title' => 'Editar Produto',
            'produto' => $produto,
            'errors' => $_SESSION['errors'] ?? []
        ];
        
        unset($_SESSION['errors']);
        
        $this->loadView('produtos/form', $data);
    }
    
    /**
     * Atualiza um produto
     */
    public function atualizar($id) {
        $this->requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/produto');
        }
        
        $produto = $this->produtoModel->findById($id);
        
        if (!$produto) {
            $this->redirect('/produto');
        }
        
        $data = [
            'nome' => $_POST['nome'] ?? '',
            'descricao' => $_POST['descricao'] ?? '',
            'preco_venda' => $_POST['preco_venda'] ?? '',
            'unidade_medida' => $_POST['unidade_medida'] ?? '',
            'marca' => $_POST['marca'] ?? '',
            'modelo' => $_POST['modelo'] ?? '',
            'aro' => $_POST['aro'] ?? '',
            'tipo' => $_POST['tipo'] ?? '',
            'categoria' => $_POST['categoria'] ?? ''
        ];
        
        $errors = $this->produtoModel->validate($data);
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $this->redirect("/produto/editar/$id");
        }
        
        if ($this->produtoModel->update($id, $data)) {
            $this->redirect('/produto');
        } else {
            $_SESSION['errors'] = ['Erro ao atualizar produto'];
            $this->redirect("/produto/editar/$id");
        }
    }
    
    /**
     * Exclui um produto
     */
    public function excluir($id) {
        $this->requireLogin();
        
        $produto = $this->produtoModel->findById($id);
        
        if (!$produto) {
            $this->redirect('/produto');
        }
        
        if ($this->produtoModel->delete($id)) {
            $this->redirect('/produto');
        } else {
            $_SESSION['errors'] = ['Erro ao excluir produto'];
            $this->redirect('/produto');
        }
    }
    
    /**
     * API para buscar produtos (AJAX)
     */
    public function api() {
        $this->requireLogin();
        
        $search = $_GET['search'] ?? $_GET['termo'] ?? '';
        
        if (!empty($search)) {
            $produtos = $this->produtoModel->searchByNome($search);
        } else {
            $produtos = $this->produtoModel->findAll();
        }
        
        $this->json($produtos);
    }

    public function api2(){
        $this->requireLogin();

        $termo = $_GET['termo'] ?? '';
        $pagina = $_GET['page'] ?? 1;
        
        $produtos = $this->produtoModel->buscaProdutosPaginacao($termo,$pagina);
        $this->json($produtos);
    }
}

