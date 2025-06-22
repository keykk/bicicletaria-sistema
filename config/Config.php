<?php
/**
 * Configurações Personalizadas do Sistema
 * Sistema de Gestão de Bicicletaria
 */

class Config {
    // Informações da empresa
    const EMPRESA_NOME = 'BikeSystem';
    const EMPRESA_SLOGAN = 'Sistema de Gestão de Bicicletaria';
    const EMPRESA_TELEFONE = '(11) 99999-9999';
    const EMPRESA_EMAIL = 'contato@bikesystem.com.br';
    const EMPRESA_ENDERECO = 'Rua das Bicicletas, 123 - São Paulo/SP';
    const EMPRESA_CNPJ = '00.000.000/0001-00';
    
    // Configurações do sistema
    const SISTEMA_VERSAO = '1.0.0';
    const SISTEMA_NOME = 'BikeSystem';
    
    // Configurações de estoque
    const ESTOQUE_LIMITE_BAIXO = 5;
    const ESTOQUE_LIMITE_CRITICO = 2;
    
    // Configurações de orçamento
    const ORCAMENTO_VALIDADE_DIAS = 30;
    const ORCAMENTO_OBSERVACOES = [
        'Este orçamento tem validade de 30 dias a partir da data de emissão',
        'Os preços estão sujeitos a alterações sem aviso prévio',
        'Para confirmar o pedido, entre em contato conosco',
        'Produtos sujeitos à disponibilidade em estoque',
        'Garantia conforme especificação do fabricante'
    ];
    
    // Configurações de email
    const EMAIL_SMTP_HOST = 'smtp.gmail.com';
    const EMAIL_SMTP_PORT = 587;
    const EMAIL_SMTP_USERNAME = '';
    const EMAIL_SMTP_PASSWORD = '';
    const EMAIL_FROM_NAME = 'BikeSystem';
    const EMAIL_FROM_ADDRESS = 'noreply@bikesystem.com.br';
    
    // Cores do tema
    const TEMA_COR_PRIMARIA = '#0d6efd';
    const TEMA_COR_SECUNDARIA = '#6c757d';
    const TEMA_COR_SUCESSO = '#198754';
    const TEMA_COR_PERIGO = '#dc3545';
    const TEMA_COR_AVISO = '#ffc107';
    const TEMA_COR_INFO = '#0dcaf0';
    
    // Configurações de backup
    const BACKUP_AUTOMATICO = true;
    const BACKUP_INTERVALO_HORAS = 24;
    const BACKUP_MANTER_ARQUIVOS = 7; // dias
    
    // Configurações de relatórios
    const RELATORIO_ITENS_POR_PAGINA = 50;
    const RELATORIO_FORMATO_DATA = 'd/m/Y';
    const RELATORIO_FORMATO_HORA = 'H:i';
    
    /**
     * Obtém uma configuração
     */
    public static function get($key, $default = null) {
        return defined("self::$key") ? constant("self::$key") : $default;
    }
    
    /**
     * Obtém informações da empresa
     */
    public static function getEmpresaInfo() {
        return [
            'nome' => self::EMPRESA_NOME,
            'slogan' => self::EMPRESA_SLOGAN,
            'telefone' => self::EMPRESA_TELEFONE,
            'email' => self::EMPRESA_EMAIL,
            'endereco' => self::EMPRESA_ENDERECO,
            'cnpj' => self::EMPRESA_CNPJ
        ];
    }
    
    /**
     * Obtém configurações do tema
     */
    public static function getTemaConfig() {
        return [
            'cor_primaria' => self::TEMA_COR_PRIMARIA,
            'cor_secundaria' => self::TEMA_COR_SECUNDARIA,
            'cor_sucesso' => self::TEMA_COR_SUCESSO,
            'cor_perigo' => self::TEMA_COR_PERIGO,
            'cor_aviso' => self::TEMA_COR_AVISO,
            'cor_info' => self::TEMA_COR_INFO
        ];
    }
    
    /**
     * Obtém configurações de email
     */
    public static function getEmailConfig() {
        return [
            'smtp_host' => self::EMAIL_SMTP_HOST,
            'smtp_port' => self::EMAIL_SMTP_PORT,
            'smtp_username' => self::EMAIL_SMTP_USERNAME,
            'smtp_password' => self::EMAIL_SMTP_PASSWORD,
            'from_name' => self::EMAIL_FROM_NAME,
            'from_address' => self::EMAIL_FROM_ADDRESS
        ];
    }
}

