<?php
/**
 * Modelo Usuário
 * Sistema de Gestão de Bicicletaria
 */

//require_once 'BaseModel.php';

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

    /*
    
    Testes
    
    */

/**
 * Extensão do Modelo Usuario para funcionalidades de perfil
 * Sistema de Gestão de Bicicletaria
 */

// Adicionar estes métodos à classe Usuario existente

/**
 * Atualizar perfil do usuário
 */
    public function buscarPorId($id){
        $usuario = $this->findById($id);
        return $usuario;
    }
    public function atualizarPerfil($id, $dados) {
        try {
            $campos = [];
            $valores = [];
            
            foreach ($dados as $campo => $valor) {
                if ($valor !== null) {
                    $campos[] = "$campo = ?";
                    $valores[] = $valor;
                }
            }
            
            if (empty($campos)) {
                return false;
            }
            
            $valores[] = $id;
            
            $sql = "UPDATE usuarios SET " . implode(', ', $campos) . ", data_atualizacao = NOW() WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            
            return $stmt->execute($valores);
            
        } catch (Exception $e) {
            error_log("Erro ao atualizar perfil: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Atualizar senha do usuário
     */
    public function atualizarSenha($id, $nova_senha) {
        try {
            $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
            
            $sql = "UPDATE usuarios SET senha = ?, data_atualizacao = NOW() WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            
            return $stmt->execute([$senha_hash, $id]);
            
        } catch (Exception $e) {
            error_log("Erro ao atualizar senha: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Buscar usuário por email (para validação)
     */
    public function buscarPorEmail($email) {
        try {
            $sql = "SELECT * FROM usuarios WHERE email = ? LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$email]);
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (Exception $e) {
            error_log("Erro ao buscar usuário por email: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Atualizar último acesso do usuário
     */
    public function atualizarUltimoAcesso($id, $ip = null) {
        try {
            $ip = $ip ?: $_SERVER['REMOTE_ADDR'] ?? 'unknown';
            
            $sql = "UPDATE usuarios SET 
                    ultimo_acesso = NOW(), 
                    ultimo_ip = ?,
                    total_logins = COALESCE(total_logins, 0) + 1
                    WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            
            return $stmt->execute([$ip, $id]);
            
        } catch (Exception $e) {
            error_log("Erro ao atualizar último acesso: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Obter estatísticas do usuário
     */
    public function obterEstatisticasUsuario($id) {
        try {
            $sql = "SELECT 
                        u.data_criacao,
                        u.ultimo_acesso,
                        u.total_logins,
                        (SELECT COUNT(*) FROM orcamentos WHERE usuario_id = u.id) as orcamentos_criados,
                        (SELECT COUNT(*) FROM produtos WHERE usuario_criacao = u.id) as produtos_cadastrados
                    FROM usuarios u 
                    WHERE u.id = ?";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($resultado) {
                // Calcular dias desde o cadastro
                if ($resultado['data_criacao']) {
                    $data_criacao = new DateTime($resultado['data_criacao']);
                    $hoje = new DateTime();
                    $resultado['dias_desde_cadastro'] = $hoje->diff($data_criacao)->days;
                } else {
                    $resultado['dias_desde_cadastro'] = 0;
                }
            }
            
            return $resultado ?: [
                'orcamentos_criados' => 0,
                'produtos_cadastrados' => 0,
                'ultimo_acesso' => null,
                'total_logins' => 0,
                'dias_desde_cadastro' => 0
            ];
            
        } catch (Exception $e) {
            error_log("Erro ao obter estatísticas do usuário: " . $e->getMessage());
            return [
                'orcamentos_criados' => 0,
                'produtos_cadastrados' => 0,
                'ultimo_acesso' => null,
                'total_logins' => 0,
                'dias_desde_cadastro' => 0
            ];
        }
    }

    /**
     * Registrar atividade do usuário
     */
    public function registrarAtividade($usuario_id, $tipo, $descricao, $dados_extras = null) {
        try {
            $sql = "INSERT INTO atividades_usuarios (usuario_id, tipo, descricao, dados_extras, data_criacao) 
                    VALUES (?, ?, ?, ?, NOW())";
            
            $stmt = $this->db->prepare($sql);
            
            return $stmt->execute([
                $usuario_id,
                $tipo,
                $descricao,
                $dados_extras ? json_encode($dados_extras) : null
            ]);
            
        } catch (Exception $e) {
            error_log("Erro ao registrar atividade: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Obter atividades recentes do usuário
     */
    public function obterAtividadesRecentes($usuario_id, $limite = 20, $pagina = 1) {
        try {
            $offset = ($pagina - 1) * $limite;
            
            $sql = "SELECT * FROM atividades_usuarios 
                    WHERE usuario_id = ? 
                    ORDER BY data_criacao DESC 
                    LIMIT ? OFFSET ?";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$usuario_id, $limite, $offset]);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (Exception $e) {
            error_log("Erro ao obter atividades recentes: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Validar senha atual do usuário
     */
    public function validarSenhaAtual($id, $senha) {
        try {
            $usuario = $this->findById($id);
            
            if (!$usuario) {
                return false;
            }
            
            return password_verify($senha, $usuario['senha']);
            
        } catch (Exception $e) {
            error_log("Erro ao validar senha: " . $e->getMessage());
            return false;
        }
    }

}

