<?php
/**
 * Sistema de Email
 * Sistema de Gestão de Bicicletaria
 */

class EmailSystem {
    private $config;
    
    public function __construct() {
        $this->config = Config::getEmailConfig();
    }
    
    /**
     * Enviar orçamento por email
     */
    public function enviarOrcamento($orcamento, $destinatario) {
        $assunto = "Orçamento #{$orcamento['id']} - " . Config::EMPRESA_NOME;
        
        $corpo = $this->gerarCorpoOrcamento($orcamento);
        
        return $this->enviarEmail($destinatario, $assunto, $corpo);
    }
    
    /**
     * Gerar corpo do email para orçamento
     */
    private function gerarCorpoOrcamento($orcamento) {
        $empresaInfo = Config::getEmpresaInfo();
        
        $html = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .header { background: #0d6efd; color: white; padding: 20px; text-align: center; }
                .content { padding: 20px; }
                .footer { background: #f8f9fa; padding: 15px; text-align: center; font-size: 12px; }
                table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
                th { background: #f8f9fa; }
                .total { font-size: 18px; font-weight: bold; color: #198754; }
            </style>
        </head>
        <body>
            <div class='header'>
                <h1>🚲 {$empresaInfo['nome']}</h1>
                <p>{$empresaInfo['slogan']}</p>
            </div>
            
            <div class='content'>
                <h2>Orçamento #{$orcamento['id']}</h2>
                
                <p>Olá <strong>{$orcamento['cliente']}</strong>,</p>
                
                <p>Segue em anexo o orçamento solicitado:</p>
                
                <table>
                    <tr>
                        <td><strong>Data:</strong></td>
                        <td>" . date('d/m/Y H:i', strtotime($orcamento['data'])) . "</td>
                    </tr>
                    <tr>
                        <td><strong>Validade:</strong></td>
                        <td>" . date('d/m/Y', strtotime($orcamento['data'] . ' +30 days')) . "</td>
                    </tr>
                </table>
                
                <h3>Itens do Orçamento:</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Quantidade</th>
                            <th>Preço Unit.</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>";
        
        foreach ($orcamento['itens'] as $item) {
            $html .= "
                        <tr>
                            <td>{$item['produto_nome']}</td>
                            <td>{$item['quantidade']} {$item['unidade_medida']}</td>
                            <td>R$ " . number_format($item['preco'], 2, ',', '.') . "</td>
                            <td>R$ " . number_format($item['subtotal'], 2, ',', '.') . "</td>
                        </tr>";
        }
        
        $html .= "
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan='3'>Total Geral:</th>
                            <th class='total'>R$ " . number_format($orcamento['valor_total'], 2, ',', '.') . "</th>
                        </tr>
                    </tfoot>
                </table>
                
                <h3>Observações:</h3>
                <ul>";
        
        foreach (Config::ORCAMENTO_OBSERVACOES as $obs) {
            $html .= "<li>$obs</li>";
        }
        
        $html .= "
                </ul>
                
                <p>Para confirmar o pedido ou esclarecer dúvidas, entre em contato conosco:</p>
                <ul>
                    <li><strong>Telefone:</strong> {$empresaInfo['telefone']}</li>
                    <li><strong>Email:</strong> {$empresaInfo['email']}</li>
                </ul>
                
                <p>Obrigado pela preferência!</p>
            </div>
            
            <div class='footer'>
                <p>{$empresaInfo['nome']} - {$empresaInfo['endereco']}</p>
                <p>Email enviado automaticamente pelo sistema em " . date('d/m/Y H:i') . "</p>
            </div>
        </body>
        </html>";
        
        return $html;
    }
    
    /**
     * Enviar email genérico
     */
    public function enviarEmail($destinatario, $assunto, $corpo, $isHtml = true) {
        // Configurar headers
        $headers = [
            'MIME-Version: 1.0',
            'Content-type: ' . ($isHtml ? 'text/html' : 'text/plain') . '; charset=UTF-8',
            'From: ' . $this->config['from_name'] . ' <' . $this->config['from_address'] . '>',
            'Reply-To: ' . $this->config['from_address'],
            'X-Mailer: PHP/' . phpversion()
        ];
        
        // Tentar enviar email
        try {
            $resultado = mail($destinatario, $assunto, $corpo, implode("\r\n", $headers));
            
            if ($resultado) {
                return [
                    'success' => true,
                    'message' => 'Email enviado com sucesso'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Erro ao enviar email'
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
     * Testar configuração de email
     */
    public function testarEmail($destinatario) {
        $assunto = 'Teste de Email - ' . Config::EMPRESA_NOME;
        $corpo = "
        <h2>Teste de Email</h2>
        <p>Este é um email de teste do sistema " . Config::SISTEMA_NOME . ".</p>
        <p>Se você recebeu este email, a configuração está funcionando corretamente.</p>
        <p>Data/Hora: " . date('d/m/Y H:i:s') . "</p>
        ";
        
        return $this->enviarEmail($destinatario, $assunto, $corpo);
    }
    
    /**
     * Enviar notificação de estoque baixo
     */
    public function notificarEstoqueBaixo($produtos, $destinatario) {
        $assunto = 'Alerta: Produtos com Estoque Baixo - ' . Config::EMPRESA_NOME;
        
        $corpo = "
        <h2>🚨 Alerta de Estoque Baixo</h2>
        <p>Os seguintes produtos estão com estoque baixo e precisam de reposição:</p>
        <table border='1' style='border-collapse: collapse; width: 100%;'>
            <thead>
                <tr style='background: #f8f9fa;'>
                    <th style='padding: 10px;'>Produto</th>
                    <th style='padding: 10px;'>Categoria</th>
                    <th style='padding: 10px;'>Quantidade</th>
                </tr>
            </thead>
            <tbody>";
        
        foreach ($produtos as $produto) {
            $corpo .= "
                <tr>
                    <td style='padding: 10px;'>{$produto['nome']}</td>
                    <td style='padding: 10px;'>{$produto['categoria']}</td>
                    <td style='padding: 10px; color: red; font-weight: bold;'>{$produto['quantidade']}</td>
                </tr>";
        }
        
        $corpo .= "
            </tbody>
        </table>
        <p>Acesse o sistema para fazer a reposição do estoque.</p>
        <p>Data/Hora: " . date('d/m/Y H:i:s') . "</p>
        ";
        
        return $this->enviarEmail($destinatario, $assunto, $corpo);
    }
}

