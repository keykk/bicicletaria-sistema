<?php
/**
 * Modelo Usuário
 * Sistema de Gestão de Bicicletaria
 */

require_once 'BaseModel.php';

class Usuario extends BaseModel {
    protected $table = 'usuarios';
    
    /**
     * Busca usuário por nome de usuário
     * @param string $nomeUsuario
     * @return array|null
     */
    public function findByUsername($nomeUsuario) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE nome_usuario = ?");
            $stmt->execute([$nomeUsuario]);
            return $stmt->fetch();
        } catch (Exception $e) {
            return null;
        }
    }
    
    /**
     * Autentica um usuário
     * @param string $nomeUsuario
     * @param string $senha
     * @return array|null Dados do usuário ou null se falhou
     */
    public function authenticate($nomeUsuario, $senha) {
        try {
            $stmt = $this->db->prepare("
                SELECT id, nome_usuario, nivel_acesso 
                FROM {$this->table} 
                WHERE nome_usuario = ? AND senha = SHA2(?, 256)
            ");
            $stmt->execute([$nomeUsuario, $senha]);
            return $stmt->fetch();
        } catch (Exception $e) {
            return null;
        }
    }
    
    /**
     * Cria um novo usuário
     * @param array $data
     * @return int|false
     */
    public function createUser($data) {
        try {
            // Hash da senha
            $data['senha'] = hash('sha256', $data['senha']);
            return $this->insert($data);
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Atualiza senha do usuário
     * @param int $id
     * @param string $novaSenha
     * @return bool
     */
    public function updatePassword($id, $novaSenha) {
        try {
            $senhaHash = hash('sha256', $novaSenha);
            return $this->update($id, ['senha' => $senhaHash]);
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Verifica se o nome de usuário já existe
     * @param string $nomeUsuario
     * @param int $excludeId ID para excluir da verificação (para edição)
     * @return bool
     */
    public function usernameExists($nomeUsuario, $excludeId = null) {
        try {
            $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE nome_usuario = ?";
            $params = [$nomeUsuario];
            
            if ($excludeId) {
                $sql .= " AND id != ?";
                $params[] = $excludeId;
            }
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            $result = $stmt->fetch();
            
            return $result['total'] > 0;
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Valida os dados do usuário
     * @param array $data
     * @param bool $isEdit Se é edição (senha opcional)
     * @return array Erros de validação
     */
    public function validate($data, $isEdit = false) {
        $errors = [];
        
        if (empty($data['nome_usuario'])) {
            $errors[] = 'Nome de usuário é obrigatório';
        } elseif (strlen($data['nome_usuario']) < 3) {
            $errors[] = 'Nome de usuário deve ter pelo menos 3 caracteres';
        }
        
        if (!$isEdit && empty($data['senha'])) {
            $errors[] = 'Senha é obrigatória';
        } elseif (!empty($data['senha']) && strlen($data['senha']) < 6) {
            $errors[] = 'Senha deve ter pelo menos 6 caracteres';
        }
        
        if (empty($data['nivel_acesso'])) {
            $errors[] = 'Nível de acesso é obrigatório';
        } elseif (!in_array($data['nivel_acesso'], ['admin', 'gerente', 'vendedor'])) {
            $errors[] = 'Nível de acesso inválido';
        }
        
        return $errors;
    }
}

