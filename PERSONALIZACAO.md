# Instruções para Personalização Adicional
## Sistema BikeSystem - Guia de Customização

---

## 🎨 Personalização Visual

### Alterando Cores do Tema

Para personalizar as cores do sistema, edite o arquivo `public/css/style.css`:

```css
/* Cores principais do sistema */
:root {
    --primary-color: #0d6efd;      /* Azul principal */
    --secondary-color: #6c757d;    /* Cinza secundário */
    --success-color: #198754;      /* Verde sucesso */
    --danger-color: #dc3545;       /* Vermelho perigo */
    --warning-color: #ffc107;      /* Amarelo aviso */
    --info-color: #0dcaf0;         /* Azul informação */
}

/* Para alterar para cores da sua marca */
:root {
    --primary-color: #ff6b35;      /* Laranja personalizado */
    --secondary-color: #2c3e50;    /* Azul escuro */
    /* ... outras cores ... */
}
```

### Adicionando Logo da Empresa

1. Coloque o arquivo da logo em `public/img/logo.png`
2. Edite o arquivo `app/views/layout/header.php`:

```php
<!-- Substituir o texto por imagem -->
<a class="navbar-brand" href="/dashboard">
    <img src="/img/logo.png" alt="Logo" height="40">
    Sua Bicicletaria
</a>
```

### Personalizando Favicon

Substitua o arquivo `public/img/favicon.ico` pelo favicon da sua empresa.

---

## 🔧 Configurações Avançadas

### Configurações de Estoque

Edite `config/Config.php` para ajustar limites de estoque:

```php
// Configurações de estoque
const ESTOQUE_LIMITE_BAIXO = 5;     // Altere para seu limite
const ESTOQUE_LIMITE_CRITICO = 2;   // Estoque crítico
```

### Configurações de Orçamento

Personalize textos e configurações de orçamento:

```php
// Configurações de orçamento
const ORCAMENTO_VALIDADE_DIAS = 30;  // Dias de validade
const ORCAMENTO_OBSERVACOES = [
    'Orçamento válido por 30 dias',
    'Preços sujeitos a alteração',
    'Produtos sujeitos à disponibilidade',
    // Adicione suas observações personalizadas
];
```

---

## 📧 Configuração de Email Personalizada

### Template de Email para Orçamentos

Edite `app/models/EmailSystem.php` para personalizar o template:

```php
private function gerarCorpoOrcamento($orcamento) {
    $html = "
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            /* Seus estilos personalizados */
            .header { 
                background: #sua-cor-primaria; 
                color: white; 
            }
            /* ... */
        </style>
    </head>
    <body>
        <div class='header'>
            <h1>🚲 SUA BICICLETARIA</h1>
            <p>Seu slogan personalizado</p>
        </div>
        <!-- Resto do template -->
    </body>
    </html>";
    
    return $html;
}
```

### Configuração de Servidor SMTP Personalizado

Para usar seu próprio servidor de email:

```php
// config/Config.php
const EMAIL_SMTP_HOST = 'mail.seudominio.com.br';
const EMAIL_SMTP_PORT = 587;
const EMAIL_SMTP_USERNAME = 'sistema@suabicicletaria.com.br';
const EMAIL_SMTP_PASSWORD = 'sua-senha-segura';
const EMAIL_FROM_NAME = 'Sua Bicicletaria';
const EMAIL_FROM_ADDRESS = 'noreply@suabicicletaria.com.br';
```

---

## 🏪 Campos Específicos do Negócio

### Adicionando Campos Personalizados para Produtos

Para adicionar campos específicos da sua bicicletaria:

1. **Altere o banco de dados:**
```sql
ALTER TABLE produtos ADD COLUMN campo_personalizado VARCHAR(255);
ALTER TABLE produtos ADD COLUMN outro_campo DECIMAL(10,2);
```

2. **Atualize o modelo Produto.php:**
```php
public function create($data) {
    $sql = "INSERT INTO produtos (
        nome, descricao, categoria, preco_venda, unidade_medida,
        marca, modelo, aro, tipo, campo_personalizado, outro_campo
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    // Adicione os novos campos no array de execução
}
```

3. **Atualize o formulário em `app/views/produtos/form.php`:**
```html
<div class="col-md-6 mb-3">
    <label for="campo_personalizado" class="form-label">Campo Personalizado</label>
    <input type="text" class="form-control" id="campo_personalizado" 
           name="campo_personalizado" value="<?= htmlspecialchars($produto['campo_personalizado'] ?? '') ?>">
</div>
```

### Adicionando Categorias Personalizadas

Edite `app/views/produtos/form.php` para incluir suas categorias:

```html
<select class="form-select" id="categoria" name="categoria" required>
    <option value="">Selecione uma categoria</option>
    <option value="Bicicletas">Bicicletas</option>
    <option value="Peças">Peças</option>
    <option value="Acessórios">Acessórios</option>
    <option value="Serviços">Serviços</option>
    <!-- Suas categorias personalizadas -->
    <option value="Capacetes">Capacetes</option>
    <option value="Roupas Ciclismo">Roupas de Ciclismo</option>
    <option value="Suplementos">Suplementos</option>
</select>
```

---

## 🖨️ Integração com Impressora Térmica

### Configuração para Etiquetas de Produtos

Para imprimir etiquetas de produtos em impressora térmica:

1. **Crie o arquivo `public/js/impressora-termica.js`:**
```javascript
class ImpressoraTermica {
    static imprimirEtiqueta(produto) {
        // Configurações da impressora térmica
        const config = {
            width: 58, // mm
            height: 40, // mm
            dpi: 203
        };
        
        // Gerar comando ESC/POS
        let comando = '\x1B\x40'; // Inicializar impressora
        comando += '\x1B\x61\x01'; // Centralizar texto
        comando += produto.nome + '\n';
        comando += 'R$ ' + produto.preco + '\n';
        comando += 'Código: ' + produto.id + '\n';
        comando += '\x1D\x56\x00'; // Cortar papel
        
        // Enviar para impressora (via WebUSB ou driver)
        this.enviarComando(comando);
    }
    
    static enviarComando(comando) {
        // Implementar comunicação com impressora
        // Pode usar WebUSB, WebSerial ou driver específico
        console.log('Enviando para impressora:', comando);
    }
}
```

2. **Adicione botão de impressão na listagem de produtos:**
```html
<button onclick="ImpressoraTermica.imprimirEtiqueta(<?= json_encode($produto) ?>)" 
        class="btn btn-outline-secondary btn-sm">
    <i class="bi bi-printer"></i>
    Etiqueta
</button>
```

### Configuração de Impressora de Cupom

Para impressão de cupons de orçamento:

```javascript
class CupomTermico {
    static imprimirOrcamento(orcamento) {
        let cupom = '\x1B\x40'; // Reset
        cupom += '\x1B\x61\x01'; // Centralizar
        cupom += 'SUA BICICLETARIA\n';
        cupom += 'Tel: (11) 99999-9999\n';
        cupom += '================================\n';
        cupom += '\x1B\x61\x00'; // Alinhar esquerda
        cupom += 'ORÇAMENTO #' + orcamento.id + '\n';
        cupom += 'Cliente: ' + orcamento.cliente + '\n';
        cupom += 'Data: ' + orcamento.data + '\n';
        cupom += '--------------------------------\n';
        
        // Itens
        orcamento.itens.forEach(item => {
            cupom += item.nome + '\n';
            cupom += item.quantidade + 'x R$ ' + item.preco + ' = R$ ' + item.subtotal + '\n';
        });
        
        cupom += '--------------------------------\n';
        cupom += '\x1B\x61\x01'; // Centralizar
        cupom += 'TOTAL: R$ ' + orcamento.total + '\n';
        cupom += '\x1D\x56\x00'; // Cortar
        
        this.enviarParaImpressora(cupom);
    }
}
```

---

## 📊 Relatórios Personalizados

### Criando Relatório Personalizado

1. **Crie o controlador personalizado:**
```php
// app/controllers/RelatorioPersonalizadoController.php
class RelatorioPersonalizadoController extends BaseController {
    public function relatorioVendasPorVendedor() {
        // Sua lógica personalizada
        $sql = "SELECT 
                    u.nome as vendedor,
                    COUNT(o.id) as total_orcamentos,
                    SUM(o.valor_total) as valor_total
                FROM orcamentos o
                INNER JOIN usuarios u ON o.id_usuario = u.id
                WHERE MONTH(o.data) = MONTH(CURRENT_DATE())
                GROUP BY u.id, u.nome
                ORDER BY valor_total DESC";
        
        $stmt = $this->db->query($sql);
        $dados = $stmt->fetchAll();
        
        $this->loadView('relatorios/vendas_por_vendedor', ['dados' => $dados]);
    }
}
```

2. **Crie a view correspondente:**
```html
<!-- app/views/relatorios/vendas_por_vendedor.php -->
<div class="card">
    <div class="card-header">
        <h5>Vendas por Vendedor - <?= date('m/Y') ?></h5>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Vendedor</th>
                    <th>Orçamentos</th>
                    <th>Valor Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dados as $item): ?>
                <tr>
                    <td><?= $item['vendedor'] ?></td>
                    <td><?= $item['total_orcamentos'] ?></td>
                    <td>R$ <?= number_format($item['valor_total'], 2, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
```

---

## 🔌 Integrações Externas

### Integração com API de CEP

Para busca automática de endereços:

```javascript
// public/js/cep.js
async function buscarCEP(cep) {
    try {
        const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
        const data = await response.json();
        
        if (!data.erro) {
            document.getElementById('endereco').value = data.logradouro;
            document.getElementById('bairro').value = data.bairro;
            document.getElementById('cidade').value = data.localidade;
            document.getElementById('uf').value = data.uf;
        }
    } catch (error) {
        console.error('Erro ao buscar CEP:', error);
    }
}
```

### Integração com WhatsApp Business

Para envio de orçamentos via WhatsApp:

```php
// app/models/WhatsAppService.php
class WhatsAppService {
    private $apiUrl = 'https://api.whatsapp.com/send';
    
    public function enviarOrcamento($telefone, $orcamento) {
        $mensagem = "🚲 *Orçamento #{$orcamento['id']}*\n\n";
        $mensagem .= "Cliente: {$orcamento['cliente']}\n";
        $mensagem .= "Data: " . date('d/m/Y', strtotime($orcamento['data'])) . "\n\n";
        
        foreach ($orcamento['itens'] as $item) {
            $mensagem .= "• {$item['produto_nome']}\n";
            $mensagem .= "  {$item['quantidade']}x R$ " . number_format($item['preco'], 2, ',', '.') . "\n";
        }
        
        $mensagem .= "\n*Total: R$ " . number_format($orcamento['valor_total'], 2, ',', '.') . "*";
        
        $url = $this->apiUrl . '?phone=' . $telefone . '&text=' . urlencode($mensagem);
        
        return $url; // Retorna URL para abrir WhatsApp
    }
}
```

---

## 🔐 Configurações de Segurança Avançadas

### Configuração de SSL/HTTPS

Para forçar HTTPS em produção, adicione ao `.htaccess`:

```apache
# Forçar HTTPS
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# Cabeçalhos de segurança
Header always set X-Content-Type-Options nosniff
Header always set X-Frame-Options DENY
Header always set X-XSS-Protection "1; mode=block"
Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains"
```

### Configuração de Firewall de Aplicação

Adicione validações extras nos controladores:

```php
// app/controllers/BaseController.php
protected function validateCSRF() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $token = $_POST['csrf_token'] ?? '';
        if (!hash_equals($_SESSION['csrf_token'], $token)) {
            throw new Exception('Token CSRF inválido');
        }
    }
}

protected function rateLimiting($action, $limit = 10) {
    $key = $action . '_' . $_SERVER['REMOTE_ADDR'];
    $attempts = $_SESSION['rate_limit'][$key] ?? 0;
    
    if ($attempts >= $limit) {
        throw new Exception('Muitas tentativas. Tente novamente em alguns minutos.');
    }
    
    $_SESSION['rate_limit'][$key] = $attempts + 1;
}
```

---

## 📱 Configuração para PWA (Progressive Web App)

### Manifest.json

Crie `public/manifest.json`:

```json
{
    "name": "BikeSystem - Sua Bicicletaria",
    "short_name": "BikeSystem",
    "description": "Sistema de gestão para bicicletaria",
    "start_url": "/",
    "display": "standalone",
    "background_color": "#ffffff",
    "theme_color": "#0d6efd",
    "icons": [
        {
            "src": "/img/icon-192.png",
            "sizes": "192x192",
            "type": "image/png"
        },
        {
            "src": "/img/icon-512.png",
            "sizes": "512x512",
            "type": "image/png"
        }
    ]
}
```

### Service Worker

Crie `public/sw.js`:

```javascript
const CACHE_NAME = 'bikesystem-v1';
const urlsToCache = [
    '/',
    '/css/style.css',
    '/js/app.js',
    '/img/logo.png'
];

self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => cache.addAll(urlsToCache))
    );
});

self.addEventListener('fetch', event => {
    event.respondWith(
        caches.match(event.request)
            .then(response => response || fetch(event.request))
    );
});
```

---

## 🎯 Conclusão

Este guia fornece as principais opções de personalização do BikeSystem. Para customizações mais avançadas:

1. **Consulte a documentação técnica completa**
2. **Mantenha backups antes de fazer alterações**
3. **Teste todas as modificações em ambiente de desenvolvimento**
4. **Documente suas personalizações para futuras atualizações**

Para suporte adicional com personalizações, entre em contato através dos canais oficiais de suporte.

---

*Guia de Personalização - BikeSystem v1.0.0*  
*© 2024 - Todos os direitos reservados*

