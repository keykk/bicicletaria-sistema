<?php
/**
 * Classe Base Controller
 * Sistema de Gestão de Bicicletaria
 */

class BaseController {
    protected $db;
    
    public function __construct() {
        //$database = new Database();
        //$this->db = $database->connect();
        $this->db = Database::connect(); // Usando o singleton para obter a conexão
    }
    
    /**
     * Carrega uma view
     * @param string $view Nome da view
     * @param array $data Dados para passar para a view
     */
    protected function loadView($view, $data = []) {
        // Extrair dados para variáveis
        extract($data);
        
        // Incluir o header
        include APP_PATH . '/views/layout/header.php';
        
        // Incluir a view específica
        $viewFile = APP_PATH . '/views/' . $view . '.php';
        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            echo "View '$view' não encontrada";
        }
        
        // Incluir o footer
        include APP_PATH . '/views/layout/footer.php';
    }
    
    /**
     * Redireciona para uma URL
     * @param string $url URL de destino
     */
    protected function redirect($url) {
        $url2 = BASE_URL . $url;
        header("Location: $url2");
        exit();
    }
    
    /**
     * Retorna JSON
     * @param array $data Dados para retornar
     */
    protected function json($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
    
    /**
     * Verifica se o usuário está logado
     * @return bool
     */
    protected function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    /**
     * Verifica se o usuário selecionou uma empresa
     * @return bool
     */
    protected function isEmpresaSelected() {
        return isset($_SESSION['empresa_id']) && !empty($_SESSION['empresa_id']);
    }

    /**
     * Requer que o usuário tenha uma empresa selecionada
     */
    protected function requireEmpresaSelected() {
        if (!$this->isEmpresaSelected()) {
            $this->redirect('/empresa');
        }
    }
    
    /**
     * Requer que o usuário esteja logado
     */
    protected function requireLogin() {
        if (!$this->isLoggedIn()) {
            $this->redirect('/login');
        }
       $this->requireEmpresaSelected(); // Verifica se a empresa está selecionada
    }

    /**
     * Requer que o usuário esteja logado
     * funçãodiferente para EmpresaController
     */
    protected function requireLogin_empresa() {
        if (!$this->isLoggedIn()) {
            $this->redirect('/login');
        }
    }
    
    /**
     * Obtém o usuário logado
     * @return array|null
     */
    protected function getLoggedUser() {
        if ($this->isLoggedIn()) {
            return $_SESSION['user_data'] ?? null;
        }
        return null;
    }

    /**
     * Obtém a empresa selecionada
     * @return array|null
     */         
    protected function getSelectedEmpresa() {
        if ($this->isEmpresaSelected()) {
            return $_SESSION['empresa_data'] ?? null;
        }
        return null;    
    }

}

