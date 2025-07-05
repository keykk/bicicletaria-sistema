<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cupom Fiscal - Venda #<?= $venda['id'] ?></title>
    <style>
        @media print {
            body { margin: 0; }
            .no-print { display: none; }
        }
        
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            line-height: 1.2;
            margin: 0;
            padding: 10px;
            max-width: 300px;
        }
        
        .cupom {
            border: 1px dashed #000;
            padding: 10px;
            margin: 0 auto;
        }
        
        .header {
            text-align: center;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        
        .empresa-nome {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .empresa-info {
            font-size: 10px;
            margin-bottom: 2px;
        }
        
        .venda-info {
            margin-bottom: 10px;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
        }
        
        .item {
            margin-bottom: 5px;
            border-bottom: 1px dotted #ccc;
            padding-bottom: 3px;
        }
        
        .item-nome {
            font-weight: bold;
        }
        
        .item-detalhes {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
        }
        
        .totais {
            border-top: 1px dashed #000;
            padding-top: 10px;
            margin-top: 10px;
        }
        
        .total-linha {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }
        
        .total-final {
            font-weight: bold;
            font-size: 14px;
            border-top: 1px solid #000;
            padding-top: 5px;
            margin-top: 5px;
        }
        
        .pagamento {
            border-top: 1px dashed #000;
            padding-top: 10px;
            margin-top: 10px;
        }
        
        .footer {
            text-align: center;
            border-top: 1px dashed #000;
            padding-top: 10px;
            margin-top: 10px;
            font-size: 10px;
        }
        
        .cliente-info {
            margin-bottom: 10px;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
        }
        
        .observacoes {
            margin-top: 10px;
            font-size: 10px;
            font-style: italic;
        }
        
        .no-print {
            text-align: center;
            margin: 20px 0;
        }
        
        @media screen {
            body {
                background-color: #f5f5f5;
                padding: 20px;
            }
            
            .cupom {
                background-color: white;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
            }
        }
    </style>
</head>
<body>
    <div class="no-print">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="bi bi-printer"></i> Imprimir Cupom
        </button>
        <button onclick="window.close()" class="btn btn-secondary">
            <i class="bi bi-x"></i> Fechar
        </button>
    </div>

    <div class="cupom">
        <!-- Cabeçalho da Empresa -->
        <div class="header">
            <div class="empresa-nome">BIKESYSTEM</div>
            <div class="empresa-info">Sistema de Gestão de Bicicletaria</div>
            <div class="empresa-info">Rua das Bicicletas, 123 - Centro</div>
            <div class="empresa-info">Tel: (11) 99999-9999</div>
            <div class="empresa-info">CNPJ: 00.000.000/0001-00</div>
        </div>

        <!-- Informações da Venda -->
        <div class="venda-info">
            <div class="total-linha">
                <span>CUPOM FISCAL:</span>
                <span>#<?= str_pad($venda['id'], 6, '0', STR_PAD_LEFT) ?></span>
            </div>
            <div class="total-linha">
                <span>DATA/HORA:</span>
                <span><?= date('d/m/Y H:i:s', strtotime($venda['data_venda'])) ?></span>
            </div>
            <div class="total-linha">
                <span>VENDEDOR:</span>
                <span><?= htmlspecialchars($venda['vendedor_nome'] ?? 'N/A') ?></span>
            </div>
        </div>

        <!-- Informações do Cliente (se informado) -->
        <?php if (!empty($venda['cliente_nome'])): ?>
        <div class="cliente-info">
            <div class="total-linha">
                <span>CLIENTE:</span>
                <span><?= htmlspecialchars($venda['cliente_nome']) ?></span>
            </div>
            <?php if (!empty($venda['cliente_telefone'])): ?>
            <div class="total-linha">
                <span>TELEFONE:</span>
                <span><?= htmlspecialchars($venda['cliente_telefone']) ?></span>
            </div>
            <?php endif; ?>
            <?php if (!empty($venda['cliente_email'])): ?>
            <div class="total-linha">
                <span>EMAIL:</span>
                <span><?= htmlspecialchars($venda['cliente_email']) ?></span>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- Itens da Venda -->
        <div class="itens">
            <?php foreach ($venda['itens'] as $item): ?>
            <div class="item">
                <div class="item-nome"><?= htmlspecialchars($item['produto_nome']) ?></div>
                <div class="item-detalhes">
                    <span>Cód: <?= htmlspecialchars($item['produto_codigo']) ?></span>
                </div>
                <div class="item-detalhes">
                    <span><?= number_format($item['quantidade'], 2, ',', '.') ?> x R$ <?= number_format($item['preco_unitario'], 2, ',', '.') ?></span>
                    <span>R$ <?= number_format($item['subtotal'], 2, ',', '.') ?></span>
                </div>
                <?php if ($item['desconto_item'] > 0): ?>
                <div class="item-detalhes">
                    <span>Desconto item:</span>
                    <span>-R$ <?= number_format($item['desconto_item'], 2, ',', '.') ?></span>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Totais -->
        <div class="totais">
            <div class="total-linha">
                <span>SUBTOTAL:</span>
                <span>R$ <?= number_format($venda['subtotal'], 2, ',', '.') ?></span>
            </div>
            
            <?php if ($venda['desconto'] > 0): ?>
            <div class="total-linha">
                <span>DESCONTO:</span>
                <span>-R$ <?= number_format($venda['desconto'], 2, ',', '.') ?></span>
            </div>
            <?php endif; ?>
            
            <div class="total-linha total-final">
                <span>TOTAL:</span>
                <span>R$ <?= number_format($venda['total'], 2, ',', '.') ?></span>
            </div>
        </div>

        <!-- Forma de Pagamento -->
        <div class="pagamento">
            <div class="total-linha">
                <span>FORMA PAGAMENTO:</span>
                <span>
                    <?php
                    $formas = [
                        'dinheiro' => 'DINHEIRO',
                        'cartao_debito' => 'CARTÃO DÉBITO',
                        'cartao_credito' => 'CARTÃO CRÉDITO',
                        'pix' => 'PIX'
                    ];
                    echo $formas[$venda['forma_pagamento']] ?? strtoupper($venda['forma_pagamento']);
                    ?>
                </span>
            </div>
            
            <?php if ($venda['forma_pagamento'] === 'dinheiro'): ?>
            <div class="total-linha">
                <span>VALOR PAGO:</span>
                <span>R$ <?= number_format($venda['valor_pago'], 2, ',', '.') ?></span>
            </div>
            
            <?php if ($venda['troco'] > 0): ?>
            <div class="total-linha">
                <span>TROCO:</span>
                <span>R$ <?= number_format($venda['troco'], 2, ',', '.') ?></span>
            </div>
            <?php endif; ?>
            <?php endif; ?>
        </div>

        <!-- Observações -->
        <?php if (!empty($venda['observacoes'])): ?>
        <div class="observacoes">
            <strong>Observações:</strong><br>
            <?= nl2br(htmlspecialchars($venda['observacoes'])) ?>
        </div>
        <?php endif; ?>

        <!-- Rodapé -->
        <div class="footer">
            <div>*** CUPOM NÃO FISCAL ***</div>
            <div>Obrigado pela preferência!</div>
            <div>Volte sempre!</div>
            <div style="margin-top: 10px;">
                Sistema: BikeSystem v1.0<br>
                <?= date('d/m/Y H:i:s') ?>
            </div>
        </div>
    </div>

    <script>
        // Auto-imprimir se for chamado com parâmetro print
        if (window.location.search.includes('print=1')) {
            window.onload = function() {
                window.print();
            };
        }
        
        // Fechar janela após impressão
        window.onafterprint = function() {
            if (window.location.search.includes('print=1')) {
                window.close();
            }
        };
    </script>
</body>
</html>

