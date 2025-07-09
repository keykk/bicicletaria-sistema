<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venda #<?= $venda['id'] ?> - BikeSystem</title>
    <style>
        @media print {
            body { margin: 0; }
            .no-print { display: none !important; }
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.4;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            border-bottom: 2px solid #0d6efd;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #0d6efd;
            margin-bottom: 10px;
        }
        
        .company-info {
            color: #666;
            font-size: 12px;
        }
        
        .orcamento-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        
        .cliente-info, .orcamento-details {
            flex: 1;
        }
        
        .orcamento-details {
            text-align: right;
        }
        
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #0d6efd;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        
        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }
        
        .info-table td {
            padding: 5px 0;
            vertical-align: top;
        }
        
        .info-table .label {
            font-weight: bold;
            width: 120px;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .items-table th,
        .items-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        
        .items-table th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
        }
        
        .items-table .text-center {
            text-align: center;
        }
        
        .items-table .text-right {
            text-align: right;
        }
        
        .total-section {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 30px;
        }
        
        .total-value {
            font-size: 24px;
            font-weight: bold;
            color: #198754;
            text-align: right;
        }
        
        .footer {
            border-top: 1px solid #ddd;
            padding-top: 20px;
            margin-top: 30px;
            font-size: 12px;
            color: #666;
        }
        
        .terms {
            margin-top: 20px;
        }
        
        .terms h4 {
            font-size: 14px;
            margin-bottom: 10px;
            color: #333;
        }
        
        .terms ul {
            margin: 0;
            padding-left: 20px;
        }
        
        .terms li {
            margin-bottom: 5px;
        }
        
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }
        
        @media print {
            .print-button { display: none; }
        }
    </style>
</head>
<body>
    <!-- Botão de impressão -->
    <button onclick="window.print()" class="print-button no-print" 
            style="background: #0d6efd; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">
        🖨️ Imprimir
    </button>

    <!-- Cabeçalho -->
    <div class="header">
        <div class="logo">🚲 <?= strtoupper($empresa['nome'] ?? 'BikeSystem'); ?></div>
        <div class="company-info">
            <?= $empresa['endereco'] ?><br/>
            <?= $empresa['cidade'] . ' - ' . $empresa['estado'] . ' | CEP: ' . $empresa['cep'] ?><br/>
            <i class="bi bi-whatsapp fs-5 text-success"></i> <?= $empresa['whatsapp'] ?? '(14) 99999-9999' ?> | 
            <i class="bi bi-envelope fs-5 text-primary"></i> <?= $empresa['email'] ?? 'contato@bikesystem.com.br'?>
        </div>
    </div>

    <!-- Informações do orçamento -->
    <div class="orcamento-info">
        <div class="cliente-info">
            <div class="section-title">Dados do Vendedor</div>
            <table class="info-table">
                <tr>
                    <td class="label">Nome:</td>
                    <td><?= htmlspecialchars($venda['vendedor_nome']) ?></td>
                </tr>
                <?php if (!empty($venda['telefone'])): ?>
                <tr>
                    <td class="label">Telefone:</td>
                    <td><?= htmlspecialchars($venda['telefone']) ?></td>
                </tr>
                <?php endif; ?>
                <?php if (!empty($venda['email'])): ?>
                <tr>
                    <td class="label">Email:</td>
                    <td><?= htmlspecialchars($venda['email']) ?></td>
                </tr>
                <?php endif; ?>
            </table>
        </div>
        
        <div class="orcamento-details">
            <div class="section-title">Detalhes</div>
            <table class="info-table">
                <tr>
                    <td class="label">Número:</td>
                    <td><strong>#<?= $venda['id'] ?></strong></td>
                </tr>
                <tr>
                    <td class="label">Data:</td>
                    <td><?= date('d/m/Y', strtotime($venda['data_venda'])) ?></td>
                </tr>
                <tr>
                    <td class="label">Hora:</td>
                    <td><?= date('H:i', strtotime($venda['data_venda'])) ?></td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Itens do orçamento -->
    <div class="section-title">Itens</div>
    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 50px;">Item</th>
                <th>Descrição do Produto</th>
                <th style="width: 80px;" class="text-center">Qtd</th>
                <th style="width: 100px;" class="text-right">Preço Unit.</th>
                <th style="width: 120px;" class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($venda['itens'] as $index => $item): ?>
                <tr>
                    <td class="text-center"><?= $index + 1 ?></td>
                    <td>
                        <strong><?= htmlspecialchars($item['produto_nome']) ?></strong>
                    </td>
                    <td class="text-center">
                        <?= $item['quantidade'] ?> <?= htmlspecialchars($item['unidade_medida']) ?>
                    </td>
                    <td class="text-right">
                        R$ <?= number_format($item['preco_unitario'], 2, ',', '.') ?>
                    </td>
                    <td class="text-right">
                        <strong>R$ <?= number_format($item['subtotal'], 2, ',', '.') ?></strong>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Total -->
    <div class="total-section">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <strong>Total de Itens: <?= count($venda['itens']) ?></strong>
            </div>
            <div class="total-value">
                TOTAL: R$ <?= number_format($venda['total'], 2, ',', '.') ?>
            </div>
        </div>
    </div>

    <!-- Rodapé -->
    <div class="footer">
        <div style="text-align: center;">
            <strong>Obrigado pela preferência!</strong><br>
            BikeSystem - Sistema de Gestão de Bicicletaria<br>
            Data da impressão <?= date('d/m/Y H:i') ?>
        </div>
    </div>

    <script>
        // Auto-imprimir quando abrir em nova aba
        window.onload = function() {
            if (window.location.search.includes('auto-print=1')) {
                setTimeout(function() {
                    window.print();
                }, 500);
            }
        };
    </script>
</body>
</html>

