<?php
/**
 * Perfil Controller
 * Sistema de Gestão de Bicicletaria
 */

//require_once 'BaseController.php';

class PerfilController extends BaseController {
    private $usuarioModel;
    
    public function __construct() {
        parent::__construct();
        $this->usuarioModel = new Usuario();
        
        // Verificar se o usuário está logado
        $this->requireLogin();
    }
    
    /**
     * Exibir perfil do usuário
     */
    public function index() {
        try {
            $this->requireLogin();
            $usuario_id = $this->getLoggedUser()['id'];
            $usuario = $this->usuarioModel->buscarPorId($usuario_id);
            
            // Buscar estatísticas do usuário
            $estatisticas = $this->obterEstatisticasUsuario($usuario_id);
            
            // Buscar atividades recentes
            $atividades_recentes = $this->obterAtividadesRecentes($usuario_id);
            
            $data =  [
                'usuario' => $usuario,
                'estatisticas' => $estatisticas,
                'atividades_recentes' => $atividades_recentes,
                'page_title' => 'Meu Perfil'
            ];

            $this->loadView('perfil/index', $data);
            
        } catch (Exception $e) {
            gravarLog('Erro ao carregar perfil: ' . $e->getMessage(), 'error');
        }
    }
    
    /**
     * Exibir formulário de edição do perfil
     */
    
    public function editar() {
        try {
            $this->requireLogin();
            $id = $this->getLoggedUser()['id'];
            $usuario = $this->usuarioModel->buscarPorId($id);
            
            $data = [
                'usuario' => $usuario,
                'page_title' => 'Editar Perfil'
            ];

            $this->loadView('perfil/editar', $data);
            
        } catch (Exception $e) {
            gravarLog('Erro ao carregar formulário de edição: ' . $e->getMessage(), 'error');
        }
    }
    
    /**
     * Atualizar dados do perfil
     */
    public function atualizar() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/perfil/editar');
            exit;
        }
        
        try {
            $this->requireLogin();
            $usuario_id = $this->getLoggedUser()['id'];
            
            // Validar dados
            $dados = $this->validarDadosPerfil($_POST);
            
            if (!$dados) {
                $this->redirect('/perfil/editar');
                exit;
            }
            
            // Processar upload de avatar se houver
            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                $avatar_path = $this->processarUploadAvatar($_FILES['avatar'], $usuario_id);
                if ($avatar_path) {
                    $dados['avatar'] = $avatar_path;
                }
            }
            
            // Atualizar dados
            $sucesso = $this->usuarioModel->atualizarPerfil($usuario_id, $dados);
            
            if ($sucesso) {
                // Atualizar dados da sessão
                $_SESSION['usuario_nome'] = $dados['nome'];
                $_SESSION['usuario_email'] = $dados['email'];
                
                $this->registrarAtividade($usuario_id, 'perfil_atualizado', 'Perfil atualizado com sucesso');
                
            } 
            
        } catch (Exception $e) {
            gravarLog('Erro ao atualizar perfil: ' . $e->getMessage(), 'error');
        }
        
        header('Location: /perfil');
        exit;
    }
    
    /**
     * Exibir formulário de alteração de senha
     */
    public function alterarSenha() {
        try {
            $this->requireLogin();
            $id = $this->getLoggedUser()['id'];
            $usuario = $this->usuarioModel->buscarPorId($id);
        
            $data = [
                'usuario' => $usuario,
                'page_title' => 'Alterar Senha'
            ];

            $this->loadView('perfil/alterar_senha', $data);
           
            
        } catch (Exception $e) {
            gravarLog('Erro ao carregar formulário de alteração de senha: ' . $e->getMessage(), 'error');
        }
    }
    
    /**
     * Processar alteração de senha
     */
    public function atualizarSenha() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /perfil/alterar-senha');
            exit;
        }
        
        try {
            $usuario_id = $_SESSION['usuario_id'];
            $senha_atual = $_POST['senha_atual'] ?? '';
            $nova_senha = $_POST['nova_senha'] ?? '';
            $confirmar_senha = $_POST['confirmar_senha'] ?? '';
            
            // Validações
            if (empty($senha_atual) || empty($nova_senha) || empty($confirmar_senha)) {
                
            }
            
            if ($nova_senha !== $confirmar_senha) {
                
            }
            
            if (strlen($nova_senha) < 6) {
                
            }
            
            // Verificar senha atual
            $usuario = $this->usuarioModel->buscarPorId($usuario_id);
            if (!password_verify($senha_atual, $usuario['senha'])) {
                
            }
            
            // Atualizar senha
            $sucesso = $this->usuarioModel->atualizarSenha($usuario_id, $nova_senha);
            
            if ($sucesso) {
               
            } else {
               
            }
            
        } catch (Exception $e) {
          
        }
        
        exit;
    }
    
    /**
     * Remover avatar do usuário
     */
    public function removerAvatar() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            //$this->jsonResponse(['success' => false, 'message' => 'Método não permitido']);
            return;
        }
        
        try {
            $usuario_id = $_SESSION['usuario_id'];
            $usuario = $this->usuarioModel->buscarPorId($usuario_id);
            
            if (!$usuario) {
               // $this->jsonResponse(['success' => false, 'message' => 'Usuário não encontrado']);
                return;
            }
            
            // Remover arquivo do avatar se existir
            if (!empty($usuario['avatar']) && file_exists($usuario['avatar'])) {
                unlink($usuario['avatar']);
            }
            
            // Atualizar banco de dados
            $sucesso = $this->usuarioModel->atualizarPerfil($usuario_id, ['avatar' => null]);
            
            if ($sucesso) {
                $this->registrarAtividade($usuario_id, 'avatar_removido', 'Avatar removido');
                //$this->jsonResponse(['success' => true, 'message' => 'Avatar removido com sucesso']);
            } else {
                //$this->jsonResponse(['success' => false, 'message' => 'Erro ao remover avatar']);
            }
            
        } catch (Exception $e) {
            //$this->jsonResponse(['success' => false, 'message' => 'Erro: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Obter atividades recentes do usuário
     */
    public function atividades() {
        try {
            $this->requireLogin();
            $usuario_id = $this->getLoggedUser()['id'];
            $pagina = $_GET['pagina'] ?? 1;
            $limite = $_GET['limite'] ?? 20;
            
            $atividades = $this->obterAtividadesRecentes($usuario_id, $limite, $pagina);
            $data = [
                'atividade' => $atividades,
                'pagina_atual' => $pagina,
                'page_title' => 'Minhas Atividades'
            ];
            $this->loadView('perfil/atividades', $data);
           
            
        } catch (Exception $e) {
            gravarLog('Erro ao carregar atividades: ' . $e->getMessage(), 'error');
        }
    }
    
    /**
     * Validar dados do perfil
     */
    private function validarDadosPerfil($dados) {
        $erros = [];
        
        // Nome obrigatório
        if (empty($dados['nome'])) {
            $erros[] = 'Nome é obrigatório';
        }
        
        // Email obrigatório e válido
        if (empty($dados['email'])) {
            $erros[] = 'Email é obrigatório';
        } elseif (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
            $erros[] = 'Email inválido';
        } else {
            // Verificar se email já existe (exceto para o próprio usuário)
            $usuario_existente = $this->usuarioModel->buscarPorEmail($dados['email']);
            if ($usuario_existente && $usuario_existente['id'] != $_SESSION['usuario_id']) {
                $erros[] = 'Este email já está sendo usado por outro usuário';
            }
        }
        
        // Telefone (opcional, mas se preenchido deve ter formato válido)
        if (!empty($dados['telefone'])) {
            $telefone_limpo = preg_replace('/\D/', '', $dados['telefone']);
            if (strlen($telefone_limpo) < 10 || strlen($telefone_limpo) > 11) {
                $erros[] = 'Telefone deve ter 10 ou 11 dígitos';
            }
        }
        
        if (!empty($erros)) {
            //$this->setFlashMessage(implode('<br>', $erros), 'error');
            return false;
        }
        
        return [
            'nome' => trim($dados['nome']),
            'email' => trim($dados['email']),
            'telefone' => trim($dados['telefone'] ?? ''),
            'endereco' => trim($dados['endereco'] ?? ''),
            'cpf' => trim($dados['cpf'] ?? '')
        ];
    }
    
    /**
     * Processar upload de avatar
     */
    private function processarUploadAvatar($arquivo, $usuario_id) {
        try {
            // Verificar tipo de arquivo
            $tipos_permitidos = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($arquivo['type'], $tipos_permitidos)) {
                //$this->setFlashMessage('Tipo de arquivo não permitido. Use JPG, PNG ou GIF.', 'error');
                return false;
            }
            
            // Verificar tamanho (máximo 2MB)
            if ($arquivo['size'] > 2 * 1024 * 1024) {
                //$this->setFlashMessage('Arquivo muito grande. Máximo 2MB.', 'error');
                return false;
            }
            
            // Criar diretório se não existir
            $upload_dir = '../public/uploads/avatars/';
            if (!is_dir($upload_dir)) {
                //mkdir($upload_dir, 0755, true);
            }
            
            // Gerar nome único para o arquivo
            $extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
            $nome_arquivo = 'avatar_' . $usuario_id . '_' . time() . '.' . $extensao;
            $caminho_completo = $upload_dir . $nome_arquivo;
            
            // Mover arquivo
            if (move_uploaded_file($arquivo['tmp_name'], $caminho_completo)) {
                // Remover avatar anterior se existir
                $usuario_atual = $this->usuarioModel->buscarPorId($usuario_id);
                if (!empty($usuario_atual['avatar']) && file_exists($usuario_atual['avatar'])) {
                    unlink($usuario_atual['avatar']);
                }
                
                return '/uploads/avatars/' . $nome_arquivo;
            } else {
                //$this->setFlashMessage('Erro ao fazer upload do arquivo.', 'error');
                return false;
            }
            
        } catch (Exception $e) {
            //$this->setFlashMessage('Erro no upload: ' . $e->getMessage(), 'error');
            return false;
        }
    }
    
    /**
     * Obter estatísticas do usuário
     */
    private function obterEstatisticasUsuario($usuario_id) {
        try {
            // Aqui você pode implementar estatísticas específicas baseadas no nível do usuário
            // Por exemplo: orçamentos criados, produtos cadastrados, etc.
            
            $estatisticas = [
                'orcamentos_criados' => 0,
                'produtos_cadastrados' => 0,
                'ultimo_login' => null,
                'total_logins' => 0,
                'dias_desde_cadastro' => 0
            ];
            
            // Buscar dados do usuário
            $usuario = $this->usuarioModel->buscarPorId($usuario_id);
            
            if ($usuario) {
                $estatisticas['ultimo_login'] = $usuario['ultimo_acesso'];
                $estatisticas['total_logins'] = $usuario['total_logins'] ?? 0;
                
                if ($usuario['dths_cadastro']) {
                    $data_criacao = new DateTime($usuario['dths_cadastro']);
                    $hoje = new DateTime();
                    $estatisticas['dias_desde_cadastro'] = $hoje->diff($data_criacao)->days;
                }
            }
            
            return $estatisticas;
            
        } catch (Exception $e) {
            return [
                'orcamentos_criados' => 0,
                'produtos_cadastrados' => 0,
                'ultimo_login' => null,
                'total_logins' => 0,
                'dias_desde_cadastro' => 0
            ];
        }
    }
    
    /**
     * Obter atividades recentes do usuário
     */
    private function obterAtividadesRecentes($usuario_id, $limite = 10, $pagina = 1) {
        try {
            // Implementar busca de atividades do usuário
            // Por enquanto, retornar array vazio
            return [];
            
        } catch (Exception $e) {
            return [];
        }
    }
    
    /**
     * Registrar atividade do usuário
     */
    private function registrarAtividade($usuario_id, $tipo, $descricao) {
        try {
            // Implementar log de atividades
            // Por enquanto, apenas um placeholder
            return true;
            
        } catch (Exception $e) {
            return false;
        }
    }
}

