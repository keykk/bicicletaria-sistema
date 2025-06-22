<?php
/**
 * Login Controller
 * Sistema de Gestão de Bicicletaria
 */

require_once 'BaseController.php';

class LoginController extends BaseController {
    
    public function index() {
        // Se já estiver logado, redirecionar para o dashboard
        if ($this->isLoggedIn()) {
            $this->redirect('/dashboard');
        }
        
        $data = [
            'title' => 'Login - Sistema de Gestão',
            'error' => $_SESSION['login_error'] ?? null
        ];
        
        // Limpar erro da sessão
        unset($_SESSION['login_error']);
        
        $this->loadView('login/index', $data);
    }
    
    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/login');
        }
        
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if (empty($username) || empty($password)) {
            $_SESSION['login_error'] = 'Usuário e senha são obrigatórios';
            $this->redirect('/login');
        }
        
        try {
            $stmt = $this->db->prepare("
                SELECT id, nome_usuario, nivel_acesso, senha 
                FROM usuarios 
                WHERE nome_usuario = ?
            ");
            $stmt->execute([$username]);
            $user = $stmt->fetch();
            
            if ($user) {
                // Verifica se a senha está correta
                if(password_verify($password, $user['senha'])) { 
                    // Login bem-sucedido
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_data'] = $user;
                
                    $this->redirect('/dashboard');
                } else {
                    // Senha incorreta
                    $_SESSION['login_error'] = 'Senha incorreta';
                    $this->redirect('/login');
                }
            } else {
                // Login falhou
                $_SESSION['login_error'] = 'Usuário não encontrado';
                $this->redirect('/login');
            }
        } catch (Exception $e) {
            $_SESSION['login_error'] = 'Erro interno do sistema';
            $this->redirect('/login');
        }
    }
    
    public function logout() {
        session_destroy();
        $this->redirect('/login');
    }
}

