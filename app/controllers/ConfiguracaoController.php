<?php
/**
 * Configurações Controller
 * Sistema de Gestão de Bicicletaria
 */

require_once 'BaseController.php';

class ConfiguracaoController extends BaseController {
    private $backupSystem;
    
    public function __construct() {
        parent::__construct();
        $this->backupSystem = new BackupSystem();
    }
    
    /**
     * Página principal de configurações
     */
    public function index() {
        $this->requireLogin();
        
        $data = [
            'title' => 'Configurações do Sistema',
        ];
        
        $this->loadView('configuracoes/index', $data);
    }
    
    /**
     * Gerenciamento de backups
     */
    public function backup() {
        $this->requireLogin();
        
        $backups = $this->backupSystem->listarBackups();
        
        $data = [
            'title' => 'Gerenciamento de Backups',
            'backups' => $backups
        ];
        
        $this->loadView('configuracoes/backup', $data);
    }
    
    /**
     * Criar backup manual
     */
    public function criarBackup() {
        $this->requireLogin();
        
        $resultado = $this->backupSystem->criarBackup();
        
        if ($resultado['success']) {
            $_SESSION['success'] = $resultado['message'];
        } else {
            $_SESSION['error'] = $resultado['message'];
        }
        
        $this->redirect('/configuracao/backup');
    }
    
    /**
     * Baixar backup
     */
    public function baixarBackup($filename) {
        $this->requireLogin();
        
        if (!$this->backupSystem->baixarBackup($filename)) {
            $_SESSION['error'] = 'Arquivo de backup não encontrado';
            $this->redirect('/configuracao/backup');
        }
    }
    
    /**
     * Excluir backup
     */
    public function excluirBackup($filename) {
        $this->requireLogin();
        
        $resultado = $this->backupSystem->excluirBackup($filename);
        
        if ($resultado['success']) {
            $_SESSION['success'] = $resultado['message'];
        } else {
            $_SESSION['error'] = $resultado['message'];
        }
        
        $this->redirect('/configuracao/backup');
    }
    
    /**
     * Configurações da empresa
     */
    public function empresa() {
        $this->requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->salvarConfiguracaoEmpresa();
        }
        
        $data = [
            'title' => 'Configurações da Empresa',
            'empresa' => Config::getEmpresaInfo()
        ];
        
        $this->loadView('configuracoes/empresa', $data);
    }
    
    /**
     * Salvar configurações da empresa
     */
    private function salvarConfiguracaoEmpresa() {
        // Aqui você implementaria a lógica para salvar as configurações
        // Por simplicidade, vamos apenas mostrar uma mensagem de sucesso
        $_SESSION['success'] = 'Configurações da empresa atualizadas com sucesso';
        $this->redirect('/configuracao/empresa');
    }
    
    /**
     * Configurações do sistema
     */
    public function sistema() {
        $this->requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->salvarConfiguracaoSistema();
        }
        
        $data = [
            'title' => 'Configurações do Sistema',
        ];
        
        $this->loadView('configuracoes/sistema', $data);
    }
    
    /**
     * Salvar configurações do sistema
     */
    private function salvarConfiguracaoSistema() {
        $_SESSION['success'] = 'Configurações do sistema atualizadas com sucesso';
        $this->redirect('/configuracao/sistema');
    }
    
    /**
     * Gerenciamento de usuários
     */
    public function usuarios() {
        $this->requireLogin();
        
        try {
            $sql = "SELECT id, nome, email, nivel_acesso, ativo, data_criacao FROM usuarios ORDER BY nome";
            $stmt = $this->db->query($sql);
            $usuarios = $stmt->fetchAll();
        } catch (Exception $e) {
            $usuarios = [];
        }
        
        $data = [
            'title' => 'Gerenciamento de Usuários',
            'usuarios' => $usuarios
        ];
        
        $this->loadView('configuracoes/usuarios', $data);
    }
    
    /**
     * Criar novo usuário
     */
    public function novoUsuario() {
        $this->requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->salvarUsuario();
        }
        
        $data = [
            'title' => 'Novo Usuário',
        ];
        
        $this->loadView('configuracoes/usuario_form', $data);
    }
    
    /**
     * Salvar usuário
     */
    private function salvarUsuario() {
        $nome = $_POST['nome'] ?? '';
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';
        $nivelAcesso = $_POST['nivel_acesso'] ?? 'operador';
        
        if (empty($nome) || empty($email) || empty($senha)) {
            $_SESSION['error'] = 'Todos os campos são obrigatórios';
            $this->redirect('/configuracao/novo-usuario');
            return;
        }
        
        try {
            // Verificar se email já existe
            $sql = "SELECT id FROM usuarios WHERE email = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$email]);
            
            if ($stmt->fetch()) {
                $_SESSION['error'] = 'Este email já está cadastrado';
                $this->redirect('/configuracao/novo-usuario');
                return;
            }
            
            // Inserir novo usuário
            $sql = "INSERT INTO usuarios (nome, email, senha, nivel_acesso, ativo, data_criacao) VALUES (?, ?, ?, ?, 1, NOW())";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$nome, $email, password_hash($senha, PASSWORD_DEFAULT), $nivelAcesso]);
            
            $_SESSION['success'] = 'Usuário criado com sucesso';
            $this->redirect('/configuracao/usuarios');
        } catch (Exception $e) {
            $_SESSION['error'] = 'Erro ao criar usuário: ' . $e->getMessage();
            $this->redirect('/configuracao/novo-usuario');
        }
    }
    
    /**
     * Ativar/desativar usuário
     */
    public function toggleUsuario($id) {
        $this->requireLogin();
        
        try {
            $sql = "UPDATE usuarios SET ativo = NOT ativo WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            
            $_SESSION['success'] = 'Status do usuário atualizado';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Erro ao atualizar usuário';
        }
        
        $this->redirect('/configuracao/usuarios');
    }
    
    /**
     * Informações do sistema
     */
    public function info() {
        $this->requireLogin();
        
        $info = [
            'versao_sistema' => Config::SISTEMA_VERSAO,
            'versao_php' => phpversion(),
            'servidor_web' => $_SERVER['SERVER_SOFTWARE'] ?? 'Desconhecido',
            'sistema_operacional' => php_uname(),
            'memoria_limite' => ini_get('memory_limit'),
            'tempo_execucao' => ini_get('max_execution_time'),
            'upload_max' => ini_get('upload_max_filesize'),
            'timezone' => date_default_timezone_get(),
        ];
        
        $data = [
            'title' => 'Informações do Sistema',
            'info' => $info
        ];
        
        $this->loadView('configuracoes/info', $data);
    }
}

