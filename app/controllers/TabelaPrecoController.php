<?php
/**
 * Tabela de Preço Controller
 * Sistema de Gestão de Bicicletaria
 */

require_once 'BaseController.php';

class TabelaPrecoController extends BaseController {
    private $tabelaPrecoModel;
    private $itemTabelaPrecoModel;
    private $produtoModel;
    
    public function __construct() {
        parent::__construct();
        $this->tabelaPrecoModel = new TabelaPreco();
        $this->itemTabelaPrecoModel = new ItemTabelaPreco();
        $this->produtoModel = new Produto();
    }
    
    /**
     * Lista todas as tabelas de preço
     */
    public function index() {
        $this->requireLogin();
        
        $tabelas = $this->tabelaPrecoModel->findAll();
        
        $data = [
            'title' => 'Tabelas de Preço',
            'tabelas' => $tabelas
        ];
        
        $this->loadView('tabelas_preco/index', $data);
    }
    
    /**
     * Exibe formulário para nova tabela de preço
     */
    public function nova() {
        $this->requireLogin();
        
        $data = [
            'title' => 'Nova Tabela de Preço',
            'errors' => $_SESSION['errors'] ?? []
        ];
        
        unset($_SESSION['errors']);
        
        $this->loadView('tabelas_preco/form', $data);
    }
    
    /**
     * Salva uma nova tabela de preço
     */
    public function salvar() {
        $this->requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/tabelapreco');
        }
        
        $data = [
            'nome' => $_POST['nome'] ?? ''
        ];
        
        $errors = $this->tabelaPrecoModel->validate($data);
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $this->redirect('/tabelapreco/nova');
        }
        
        $idTabela = $this->tabelaPrecoModel->insert($data);
        
        if ($idTabela) {
            $this->redirect("/tabelapreco/editar/$idTabela");
        } else {
            $_SESSION['errors'] = ['Erro ao salvar tabela de preço'];
            $this->redirect('/tabelapreco/nova');
        }
    }
    
    /**
     * Exibe formulário para editar tabela de preço
     */
    public function editar($id) {
        $this->requireLogin();
        
        $tabela = $this->tabelaPrecoModel->findWithItens($id);
        
        if (!$tabela) {
            $this->redirect('/tabelapreco');
        }
        
        $produtos = $this->produtoModel->findAll();

        $modelo_lucratividade = [ 
            [
                'id' => 0,
                'descricao' => 'Markup (%)'
            ],
            [
                'id' => 1,
                'descricao' => 'Margem Bruta (%)'
            ]
        ];
        
        $data = [
            'title' => 'Editar Tabela de Preço',
            'tabela' => $tabela,
            'produtos' => $produtos,
            'modelo_lucratividade' => $modelo_lucratividade,
            'errors' => $_SESSION['errors'] ?? [],
            'success' => $_SESSION['success'] ?? null
        ];
        
        unset($_SESSION['errors'], $_SESSION['success']);
        
        $this->loadView('tabelas_preco/editar', $data);
    }
    
    /**
     * Adiciona produto à tabela de preço
     */
    public function adicionarProduto($idTabela) {
        $this->requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect("/tabelapreco/editar/$idTabela");
        }
        
        $idProduto = $_POST['id_produto'] ?? '';
        $preco = $_POST['preco'] ?? '';
        $modelo_lucratividade = $_POST['modelo_lucratividade'] ?? '1';
        $porcentual_lucratividade = $_POST['porc'] ?? '';
        $valor_revenda = $_POST['valor_revenda'] ?? '';

        $valida_modelo = in_array($modelo_lucratividade, [0, 1]);
        
        if (empty($idProduto) || empty($preco) || !is_numeric($preco) || $preco <= 0 ||
            !is_numeric($porcentual_lucratividade) || $porcentual_lucratividade < 0 ||
            empty($valor_revenda) || !is_numeric($valor_revenda) || $valor_revenda < 0 ||
            !$valida_modelo) {
            $_SESSION['errors'] = ['Produto e preço são obrigatórios'];
            $this->redirect("/tabelapreco/editar/$idTabela");
        }
        
        if ($this->itemTabelaPrecoModel->updateOrInsertPreco($idTabela, $idProduto, $preco, $modelo_lucratividade, $porcentual_lucratividade, $valor_revenda)) {
            $_SESSION['success'] = 'Produto adicionado à tabela com sucesso';
        } else {
            $_SESSION['errors'] = ['Erro ao adicionar produto à tabela'];
        }
        
        $this->redirect("/tabelapreco/editar/$idTabela");
    }
    
    /**
     * Remove produto da tabela de preço
     */
    public function removerProduto($idTabela, $idProduto) {
        $this->requireLogin();
        
        if ($this->itemTabelaPrecoModel->removeProduto($idTabela, $idProduto)) {
            $_SESSION['success'] = 'Produto removido da tabela com sucesso';
        } else {
            $_SESSION['errors'] = ['Registro em uso.','Erro ao remover produto da tabela'];
        }
        
        $this->redirect("/tabelapreco/editar/$idTabela");
    }
    
    /**
     * Copia uma tabela de preço
     */
    public function copiar($id) {
        $this->requireLogin();
        
        $tabela = $this->tabelaPrecoModel->findById($id);
        
        if (!$tabela) {
            $this->redirect('/tabelapreco');
        }
        
        $novoNome = $tabela['nome'] . ' - Cópia';
        $novaTabela = $this->tabelaPrecoModel->copiarTabela($id, $novoNome);
        
        if ($novaTabela) {
            $this->redirect("/tabelapreco/editar/$novaTabela");
        } else {
            $_SESSION['errors'] = ['Erro ao copiar tabela de preço'];
            $this->redirect('/tabelapreco');
        }
    }
    
    /**
     * Atualiza preços em massa
     */
    public function atualizarPrecosEmMassa($id) {
        $this->requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect("/tabelapreco/editar/$id");
        }
        
        $percentual = $_POST['percentual'] ?? '';
        (int)$modelo_lucratividade = $_POST['modelo_lucratividade1'] ?? '1';

        $valida_modelo = in_array($modelo_lucratividade, [0, 1]);
        
        if (empty($percentual) || !is_numeric($percentual) || !$valida_modelo) {
            $_SESSION['errors'] = ['Percentual é obrigatório: '. $percentual. ' Modelo: '.$modelo_lucratividade];
            $this->redirect("/tabelapreco/editar/$id");
        }
        
        if ($this->tabelaPrecoModel->atualizarPrecosEmMassa($id, $percentual, $modelo_lucratividade)) {
            $_SESSION['success'] = "Preços atualizados com {$percentual}% de ajuste";
        } else {
            $_SESSION['errors'] = ['Erro ao atualizar preços'];
        }
        
        $this->redirect("/tabelapreco/editar/$id");
    }
    
    /**
     * Exclui uma tabela de preço
     */
    public function excluir($id) {
        $this->requireLogin();
        
        $tabela = $this->tabelaPrecoModel->findById($id);
        
        if (!$tabela) {
            $this->redirect('/tabelapreco');
        }
        
        if ($this->tabelaPrecoModel->delete($id)) {
            $this->redirect('/tabelapreco');
        } else {
            $_SESSION['errors'] = ['Erro ao excluir tabela de preço'];
            $this->redirect('/tabelapreco');
        }
    }
    
    /**
     * API para obter preço de produto em tabela específica
     */
    public function apiPreco($idTabela, $idProduto) {
        $this->requireLogin();
        
        $preco = $this->tabelaPrecoModel->getPrecoProduto($idTabela, $idProduto);
        
        if ($preco !== null) {
            $this->json(['preco' => $preco]);
        } else {
            // Se não tem preço na tabela, usar preço padrão do produto
            $produto = $this->produtoModel->findById($idProduto);
            $precoDefault = $produto ? $produto['preco_venda'] : 0;
            $this->json(['preco' => $precoDefault]);
        }
    }
}

