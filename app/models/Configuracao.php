<?php
/**
 * Modelo Configuracao
 * Sistema de Gestão de Bicicletaria
 */

//require_once 'BaseModel.php';

class Configuracao extends BaseModel {
    protected $table = 'configuracoes';
    
    /**
     * Obter configuração por chave
     */
    public function getConfig($chave, $valor_padrao = null) {
        try {
            $sql = "SELECT valor FROM {$this->table} WHERE chave = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$chave]);
            $resultado = $stmt->fetch();
            
            return $resultado ? $resultado['valor'] : $valor_padrao;
        } catch (Exception $e) {
            return $valor_padrao;
        }
    }
    
    /**
     * Definir configuração
     */
    public function setConfig($chave, $valor) {
        try {
            // Verificar se já existe
            $sql = "SELECT id FROM {$this->table} WHERE chave = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$chave]);
            
            if ($stmt->fetch()) {
                // Atualizar
                $sql = "UPDATE {$this->table} SET valor = ?, data_atualizacao = NOW() WHERE chave = ?";
                $stmt = $this->db->prepare($sql);
                return $stmt->execute([$valor, $chave]);
            } else {
                // Inserir
                $sql = "INSERT INTO {$this->table} (chave, valor, data_criacao, data_atualizacao) VALUES (?, ?, NOW(), NOW())";
                $stmt = $this->db->prepare($sql);
                return $stmt->execute([$chave, $valor]);
            }
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Obter múltiplas configurações
     */
    public function getConfigs($chaves) {
        try {
            $placeholders = str_repeat('?,', count($chaves) - 1) . '?';
            $sql = "SELECT chave, valor FROM {$this->table} WHERE chave IN ($placeholders)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute($chaves);
            
            $configs = [];
            while ($row = $stmt->fetch()) {
                $configs[$row['chave']] = $row['valor'];
            }
            
            return $configs;
        } catch (Exception $e) {
            return [];
        }
    }
    
    /**
     * Obter todas as configurações
     */
    public function getAllConfigs() {
        try {
            $sql = "SELECT chave, valor, descricao FROM {$this->table} ORDER BY chave";
            $stmt = $this->db->query($sql);
            
            $configs = [];
            while ($row = $stmt->fetch()) {
                $configs[$row['chave']] = [
                    'valor' => $row['valor'],
                    'descricao' => $row['descricao']
                ];
            }
            
            return $configs;
        } catch (Exception $e) {
            return [];
        }
    }
    
    /**
     * Configurações da empresa
     */
    public function getEmpresaConfig() {
        $chaves = [
            'empresa_nome',
            'empresa_telefone',
            'empresa_email',
            'empresa_endereco',
            'empresa_cnpj',
            'empresa_slogan',
            'empresa_logo'
        ];
        
        return $this->getConfigs($chaves);
    }
    
    /**
     * Salvar configurações da empresa
     */
    public function salvarEmpresaConfig($dados) {
        try {
            $this->db->beginTransaction();
            
            foreach ($dados as $chave => $valor) {
                if (strpos($chave, 'empresa_') === 0) {
                    $this->setConfig($chave, $valor);
                }
            }
            
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
    
    /**
     * Configurações do sistema
     */
    public function getSistemaConfig() {
        $chaves = [
            'sistema_timezone',
            'sistema_moeda',
            'sistema_formato_data',
            'sistema_formato_numero',
            'estoque_limite_baixo',
            'estoque_limite_critico',
            'orcamento_validade_dias',
            'orcamento_observacoes'
        ];
        
        return $this->getConfigs($chaves);
    }
    
    /**
     * Configurações de email
     */
    public function getEmailConfig() {
        $chaves = [
            'email_smtp_host',
            'email_smtp_port',
            'email_smtp_username',
            'email_smtp_password',
            'email_from_name',
            'email_from_address',
            'email_smtp_secure'
        ];
        
        return $this->getConfigs($chaves);
    }
    
    /**
     * Configurações de backup
     */
    public function getBackupConfig() {
        $chaves = [
            'backup_automatico',
            'backup_intervalo_horas',
            'backup_manter_arquivos',
            'backup_compressao',
            'backup_email_notificacao'
        ];
        
        $configs = $this->getConfigs($chaves);
        
        // Valores padrão
        $defaults = [
            'backup_automatico' => 'true',
            'backup_intervalo_horas' => '24',
            'backup_manter_arquivos' => '7',
            'backup_compressao' => 'true',
            'backup_email_notificacao' => 'false'
        ];
        
        foreach ($defaults as $chave => $valor_padrao) {
            if (!isset($configs[$chave])) {
                $configs[$chave] = $valor_padrao;
            }
        }
        
        return $configs;
    }
    
    /**
     * Inicializar configurações padrão
     */
    public function inicializarConfiguracoesPadrao() {
        $configuracoes_padrao = [
            // Empresa
            'empresa_nome' => 'Minha Bicicletaria',
            'empresa_telefone' => '(11) 99999-9999',
            'empresa_email' => 'contato@minhabicicletaria.com.br',
            'empresa_endereco' => 'Rua das Bicicletas, 123 - Centro',
            'empresa_cnpj' => '',
            'empresa_slogan' => 'Sua melhor pedalada começa aqui!',
            
            // Sistema
            'sistema_timezone' => 'America/Sao_Paulo',
            'sistema_moeda' => 'BRL',
            'sistema_formato_data' => 'd/m/Y',
            'sistema_formato_numero' => 'pt_BR',
            'estoque_limite_baixo' => '5',
            'estoque_limite_critico' => '2',
            'orcamento_validade_dias' => '30',
            'orcamento_observacoes' => json_encode([
                'Orçamento válido por 30 dias',
                'Preços sujeitos a alteração sem aviso prévio',
                'Produtos sujeitos à disponibilidade em estoque'
            ]),
            
            // Email
            'email_smtp_host' => '',
            'email_smtp_port' => '587',
            'email_smtp_username' => '',
            'email_smtp_password' => '',
            'email_from_name' => 'Minha Bicicletaria',
            'email_from_address' => 'noreply@minhabicicletaria.com.br',
            'email_smtp_secure' => 'tls',
            
            // Backup
            'backup_automatico' => 'true',
            'backup_intervalo_horas' => '24',
            'backup_manter_arquivos' => '7',
            'backup_compressao' => 'true',
            'backup_email_notificacao' => 'false'
        ];
        
        try {
            $this->db->beginTransaction();
            
            foreach ($configuracoes_padrao as $chave => $valor) {
                // Verificar se já existe
                $sql = "SELECT id FROM {$this->table} WHERE chave = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$chave]);
                
                if (!$stmt->fetch()) {
                    // Inserir apenas se não existir
                    $sql = "INSERT INTO {$this->table} (chave, valor, descricao, data_criacao, data_atualizacao) 
                            VALUES (?, ?, ?, NOW(), NOW())";
                    $stmt = $this->db->prepare($sql);
                    $stmt->execute([$chave, $valor, $this->getDescricaoConfig($chave)]);
                }
            }
            
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
    
    /**
     * Obter descrição da configuração
     */
    private function getDescricaoConfig($chave) {
        $descricoes = [
            'empresa_nome' => 'Nome da empresa/bicicletaria',
            'empresa_telefone' => 'Telefone principal da empresa',
            'empresa_email' => 'Email de contato da empresa',
            'empresa_endereco' => 'Endereço completo da empresa',
            'empresa_cnpj' => 'CNPJ da empresa',
            'empresa_slogan' => 'Slogan ou frase da empresa',
            'sistema_timezone' => 'Fuso horário do sistema',
            'sistema_moeda' => 'Moeda padrão do sistema',
            'sistema_formato_data' => 'Formato de exibição de datas',
            'sistema_formato_numero' => 'Formato de números e valores',
            'estoque_limite_baixo' => 'Limite para considerar estoque baixo',
            'estoque_limite_critico' => 'Limite para considerar estoque crítico',
            'orcamento_validade_dias' => 'Validade padrão dos orçamentos em dias',
            'orcamento_observacoes' => 'Observações padrão dos orçamentos',
            'email_smtp_host' => 'Servidor SMTP para envio de emails',
            'email_smtp_port' => 'Porta do servidor SMTP',
            'email_smtp_username' => 'Usuário do servidor SMTP',
            'email_smtp_password' => 'Senha do servidor SMTP',
            'email_from_name' => 'Nome do remetente dos emails',
            'email_from_address' => 'Email do remetente',
            'email_smtp_secure' => 'Tipo de segurança SMTP (tls/ssl)',
            'backup_automatico' => 'Ativar backup automático',
            'backup_intervalo_horas' => 'Intervalo entre backups em horas',
            'backup_manter_arquivos' => 'Quantidade de dias para manter backups',
            'backup_compressao' => 'Comprimir arquivos de backup',
            'backup_email_notificacao' => 'Enviar notificação por email após backup'
        ];
        
        return $descricoes[$chave] ?? '';
    }
    
    /**
     * Exportar configurações
     */
    public function exportarConfiguracoes() {
        try {
            $sql = "SELECT chave, valor FROM {$this->table} ORDER BY chave";
            $stmt = $this->db->query($sql);
            
            $configs = [];
            while ($row = $stmt->fetch()) {
                $configs[$row['chave']] = $row['valor'];
            }
            
            return json_encode($configs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Importar configurações
     */
    public function importarConfiguracoes($json_configs) {
        try {
            $configs = json_decode($json_configs, true);
            if (!$configs) {
                return false;
            }
            
            $this->db->beginTransaction();
            
            foreach ($configs as $chave => $valor) {
                $this->setConfig($chave, $valor);
            }
            
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
    
    /**
     * Resetar configurações para padrão
     */
    public function resetarConfiguracoes() {
        try {
            $sql = "DELETE FROM {$this->table}";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            
            return $this->inicializarConfiguracoesPadrao();
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Validar configuração de email
     */
    public function validarConfigEmail() {
        $config = $this->getEmailConfig();
        
        $obrigatorios = ['email_smtp_host', 'email_smtp_port', 'email_smtp_username', 'email_from_address'];
        
        foreach ($obrigatorios as $campo) {
            if (empty($config[$campo])) {
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * Obter estatísticas de configuração
     */
    public function getEstatisticas() {
        try {
            $sql = "SELECT 
                        COUNT(*) as total_configs,
                        COUNT(CASE WHEN valor != '' THEN 1 END) as configs_preenchidas,
                        MAX(data_atualizacao) as ultima_atualizacao
                    FROM {$this->table}";
            $stmt = $this->db->query($sql);
            return $stmt->fetch();
        } catch (Exception $e) {
            return [
                'total_configs' => 0,
                'configs_preenchidas' => 0,
                'ultima_atualizacao' => null
            ];
        }
    }
}

