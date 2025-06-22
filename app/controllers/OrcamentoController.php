<?php
/**
 * Orçamento Controller
 * Sistema de Gestão de Bicicletaria
 */

require_once 'BaseController.php';

class OrcamentoController extends BaseController {
    private $orcamentoModel;
    private $produtoModel;
    private $itemOrcamentoModel;
    
    public function __construct() {
        parent::__construct();
        $this->orcamentoModel = new Orcamento();
        $this->produtoModel = new Produto();
        $this->itemOrcamentoModel = new ItemOrcamento();
    }
    
    /**
     * Lista todos os orçamentos
     */
    public function index() {
        $this->requireLogin();
        
        $periodo = $_GET['periodo'] ?? 'mes_atual';
        
        switch ($periodo) {
            case 'mes_atual':
                $orcamentos = $this->orcamentoModel->findMesAtual();
                break;
            case 'todos':
                $orcamentos = $this->orcamentoModel->findAll();
                break;
            default:
                $orcamentos = $this->orcamentoModel->findMesAtual();
        }
        
        $estatisticas = $this->orcamentoModel->getEstatisticas();
        
        $data = [
            'title' => 'Orçamentos',
            'orcamentos' => $orcamentos,
            'estatisticas' => $estatisticas,
            'periodo_selecionado' => $periodo
        ];
        
        $this->loadView('orcamentos/index', $data);
    }
    
    /**
     * Exibe formulário para novo orçamento
     */
    public function novo() {
        $this->requireLogin();
        
        $produtos = $this->produtoModel->findAll();
        
        $data = [
            'title' => 'Novo Orçamento',
            'produtos' => $produtos,
            'errors' => $_SESSION['errors'] ?? []
        ];
        
        unset($_SESSION['errors']);
        
        $this->loadView('orcamentos/form', $data);
    }
    
    /**
     * Salva um novo orçamento
     */
    public function salvar() {
        $this->requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/orcamento');
        }
        
        $dadosOrcamento = [
            'cliente' => $_POST['cliente'] ?? '',
            'telefone' => $_POST['telefone'] ?? '',
            'email' => $_POST['email'] ?? '',
            'valor_total' => 0 // Será calculado
        ];
        
        $itens = [];
        $valorTotal = 0;
        
        // Processar itens do orçamento
        if (isset($_POST['produtos']) && is_array($_POST['produtos'])) {
            foreach ($_POST['produtos'] as $index => $idProduto) {
                $quantidade = $_POST['quantidades'][$index] ?? 0;
                $preco = $_POST['precos'][$index] ?? 0;
                
                if ($idProduto && $quantidade > 0 && $preco > 0) {
                    $subtotal = $quantidade * $preco;
                    $valorTotal += $subtotal;
                    
                    $itens[] = [
                        'id_produto' => $idProduto,
                        'quantidade' => $quantidade,
                        'preco' => $preco,
                        'subtotal' => $subtotal
                    ];
                }
            }
        }
        
        if (empty($itens)) {
            $_SESSION['errors'] = ['Adicione pelo menos um item ao orçamento'];
            $this->redirect('/orcamento/novo');
        }
        
        $dadosOrcamento['valor_total'] = $valorTotal;
        
        $errors = $this->orcamentoModel->validate($dadosOrcamento);
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $this->redirect('/orcamento/novo');
        }
        
        $idOrcamento = $this->orcamentoModel->criarOrcamento($dadosOrcamento, $itens);
        
        if ($idOrcamento) {
            $this->redirect("/orcamento/visualizar/$idOrcamento");
        } else {
            $_SESSION['errors'] = ['Erro ao salvar orçamento'];
            $this->redirect('/orcamento/novo');
        }
    }
    
    /**
     * Visualiza um orçamento
     */
    public function visualizar($id) {
        $this->requireLogin();
        
        $orcamento = $this->orcamentoModel->findWithItens($id);
        
        if (!$orcamento) {
            $this->redirect('/orcamento');
        }
        
        $data = [
            'title' => 'Visualizar Orçamento',
            'orcamento' => $orcamento
        ];
        
        $this->loadView('orcamentos/visualizar', $data);
    }
    
    /**
     * Imprime um orçamento
     */
    public function imprimir($id) {
        $this->requireLogin();
        
        $orcamento = $this->orcamentoModel->findWithItens($id);
        
        if (!$orcamento) {
            $this->redirect('/orcamento');
        }
        
        $data = [
            'title' => 'Imprimir Orçamento',
            'orcamento' => $orcamento
        ];
        
        $this->loadView('orcamentos/imprimir', $data);
    }
    
    /**
     * Exclui um orçamento
     */
    public function excluir($id) {
        $this->requireLogin();
        
        $orcamento = $this->orcamentoModel->findById($id);
        
        if (!$orcamento) {
            $this->redirect('/orcamento');
        }
        
        if ($this->orcamentoModel->delete($id)) {
            $this->redirect('/orcamento');
        } else {
            $_SESSION['errors'] = ['Erro ao excluir orçamento'];
            $this->redirect('/orcamento');
        }
    }
    
    /**
     * API para obter preço do produto
     */
    public function apiPrecoProduto($idProduto) {
        $this->requireLogin();
        
        $produto = $this->produtoModel->findById($idProduto);
        
        if ($produto) {
            $this->json([
                'preco' => $produto['preco_venda'],
                'unidade_medida' => $produto['unidade_medida']
            ]);
        } else {
            $this->json(['error' => 'Produto não encontrado']);
        }
    }
    
    /**
     * Envia orçamento por email
     */
    public function enviarEmail($id) {
        $this->requireLogin();
        
        $orcamento = $this->orcamentoModel->findWithItens($id);
        
        if (!$orcamento || empty($orcamento['email'])) {
            $_SESSION['errors'] = ['Orçamento não encontrado ou email não informado'];
            $this->redirect("/orcamento/visualizar/$id");
        }
        
        // Aqui seria implementada a lógica de envio de email
        // Por enquanto, apenas simular o envio
        $_SESSION['success'] = 'Orçamento enviado por email com sucesso';
        $this->redirect("/orcamento/visualizar/$id");
    }
}

