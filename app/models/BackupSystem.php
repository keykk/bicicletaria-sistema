<?php
/**
 * Sistema de Backup Automático
 * Sistema de Gestão de Bicicletaria
 */

class BackupSystem {
    private $db;
    private $backupDir;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
        $this->backupDir = __DIR__ . '/../backups/';
        
        // Criar diretório de backup se não existir
        if (!is_dir($this->backupDir)) {
            mkdir($this->backupDir, 0755, true);
        }
    }
    
    /**
     * Criar backup do banco de dados
     */
    public function criarBackup() {
        try {
            $timestamp = date('Y-m-d_H-i-s');
            $filename = "backup_bikesystem_{$timestamp}.sql";
            $filepath = $this->backupDir . $filename;
            
            // Configurações do banco
            $host = DB_HOST;
            $database = DB_NAME;
            $username = DB_USER;
            $password = DB_PASS;
            
            // Comando mysqldump
            $command = "mysqldump --host={$host} --user={$username} --password={$password} {$database} > {$filepath}";
            
            // Executar backup
            exec($command, $output, $returnCode);
            
            if ($returnCode === 0 && file_exists($filepath)) {
                // Comprimir arquivo
                $this->comprimirBackup($filepath);
                
                // Limpar backups antigos
                $this->limparBackupsAntigos();
                
                return [
                    'success' => true,
                    'filename' => $filename,
                    'size' => filesize($filepath),
                    'message' => 'Backup criado com sucesso'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Erro ao criar backup'
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Comprimir arquivo de backup
     */
    private function comprimirBackup($filepath) {
        if (function_exists('gzencode')) {
            $data = file_get_contents($filepath);
            $compressed = gzencode($data, 9);
            
            $compressedFile = $filepath . '.gz';
            file_put_contents($compressedFile, $compressed);
            
            // Remover arquivo original
            unlink($filepath);
        }
    }
    
    /**
     * Limpar backups antigos
     */
    private function limparBackupsAntigos() {
        $files = glob($this->backupDir . 'backup_bikesystem_*.sql*');
        $maxFiles = Config::BACKUP_MANTER_ARQUIVOS;
        
        if (count($files) > $maxFiles) {
            // Ordenar por data de modificação
            usort($files, function($a, $b) {
                return filemtime($a) - filemtime($b);
            });
            
            // Remover arquivos mais antigos
            $filesToDelete = array_slice($files, 0, count($files) - $maxFiles);
            foreach ($filesToDelete as $file) {
                unlink($file);
            }
        }
    }
    
    /**
     * Listar backups disponíveis
     */
    public function listarBackups() {
        $files = glob($this->backupDir . 'backup_bikesystem_*.sql*');
        $backups = [];
        
        foreach ($files as $file) {
            $filename = basename($file);
            $backups[] = [
                'filename' => $filename,
                'size' => filesize($file),
                'date' => filemtime($file),
                'path' => $file
            ];
        }
        
        // Ordenar por data (mais recente primeiro)
        usort($backups, function($a, $b) {
            return $b['date'] - $a['date'];
        });
        
        return $backups;
    }
    
    /**
     * Restaurar backup
     */
    public function restaurarBackup($filename) {
        try {
            $filepath = $this->backupDir . $filename;
            
            if (!file_exists($filepath)) {
                return [
                    'success' => false,
                    'message' => 'Arquivo de backup não encontrado'
                ];
            }
            
            // Descomprimir se necessário
            if (pathinfo($filename, PATHINFO_EXTENSION) === 'gz') {
                $compressed = file_get_contents($filepath);
                $data = gzdecode($compressed);
                $tempFile = $this->backupDir . 'temp_restore.sql';
                file_put_contents($tempFile, $data);
                $filepath = $tempFile;
            }
            
            // Configurações do banco
            $host = DB_HOST;
            $database = DB_NAME;
            $username = DB_USER;
            $password = DB_PASS;
            
            // Comando mysql
            $command = "mysql --host={$host} --user={$username} --password={$password} {$database} < {$filepath}";
            
            // Executar restauração
            exec($command, $output, $returnCode);
            
            // Limpar arquivo temporário
            if (isset($tempFile) && file_exists($tempFile)) {
                unlink($tempFile);
            }
            
            if ($returnCode === 0) {
                return [
                    'success' => true,
                    'message' => 'Backup restaurado com sucesso'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Erro ao restaurar backup'
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Verificar se é hora de fazer backup automático
     */
    public function verificarBackupAutomatico() {
        if (!Config::BACKUP_AUTOMATICO) {
            return false;
        }
        
        $ultimoBackup = $this->getUltimoBackup();
        $intervaloHoras = Config::BACKUP_INTERVALO_HORAS;
        
        if (!$ultimoBackup || (time() - $ultimoBackup['date']) > ($intervaloHoras * 3600)) {
            return $this->criarBackup();
        }
        
        return false;
    }
    
    /**
     * Obter informações do último backup
     */
    private function getUltimoBackup() {
        $backups = $this->listarBackups();
        return !empty($backups) ? $backups[0] : null;
    }
    
    /**
     * Excluir backup
     */
    public function excluirBackup($filename) {
        $filepath = $this->backupDir . $filename;
        
        if (file_exists($filepath)) {
            unlink($filepath);
            return [
                'success' => true,
                'message' => 'Backup excluído com sucesso'
            ];
        }
        
        return [
            'success' => false,
            'message' => 'Arquivo não encontrado'
        ];
    }
    
    /**
     * Baixar backup
     */
    public function baixarBackup($filename) {
        $filepath = $this->backupDir . $filename;
        
        if (file_exists($filepath)) {
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Content-Length: ' . filesize($filepath));
            readfile($filepath);
            exit;
        }
        
        return false;
    }
}

