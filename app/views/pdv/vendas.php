<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-list-ul"></i>
                Vendas Realizadas
            </h1>
            <div>
                <a href="<?= BASE_URL ?>/pdv" class="btn btn-primary">
                    <i class="bi bi-cash-register"></i>
                    Novo PDV
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Filtros -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-funnel"></i>
                    Filtros
                </h6>
            </div>
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label for="data_inicio" class="form-label">Data Início</label>
                        <input type="date" class="form-control" id="data_inicio" name="data_inicio" 
                               value="<?= htmlspecialchars($filtros['data_inicio']) ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="data_fim" class="form-label">Data Fim</label>
                        <input type="date" class="form-control" id="data_fim" name="data_fim" 
                               value="<?= htmlspecialchars($filtros['data_fim']) ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="forma_pagamento" class="form-label">Forma de Pagamento</label>
                        <select class="form-select" id="forma_pagamento" name="forma_pagamento">
                            <option value="">Todas</option>
                            <option value="dinheiro" <?= $filtros['forma_pagamento'] === 'dinheiro' ? 'selected' : '' ?>>Dinheiro</option>
                            <option value="cartao_debito" <?= $filtros['forma_pagamento'] === 'cartao_debito' ? 'selected' : '' ?>>Cartão de Débito</option>
                            <option value="cartao_credito" <?= $filtros['forma_pagamento'] === 'cartao_credito' ? 'selected' : '' ?>>Cartão de Crédito</option>
                            <option value="pix" <?= $filtros['forma_pagamento'] === 'pix' ? 'selected' : '' ?>>PIX</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="cliente" class="form-label">Cliente</label>
                        <input type="text" class="form-control" id="cliente" name="cliente" 
                               value="<?= htmlspecialchars($filtros['cliente']) ?>" placeholder="Nome do cliente">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i>
                            Filtrar
                        </button>
                        <a href="<?= BASE_URL ?>/pdv/vendas" class="btn btn-outline-secondary">
                            <i class="bi bi-x"></i>
                            Limpar
                        </a>
                        <button type="button" class="btn btn-outline-success" onclick="exportarVendas()">
                            <i class="bi bi-download"></i>
                            Exportar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Estatísticas -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-primary">
            <div class="card-body text-center">
                <h4 class="text-primary"><?= $estatisticas['total_vendas'] ?? 0 ?></h4>
                <p class="card-text">Total de Vendas</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-success">
            <div class="card-body text-center">
                <h4 class="text-success">R$ <?= number_format($estatisticas['valor_total'] ?? 0, 2, ',', '.') ?></h4>
                <p class="card-text">Valor Total</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-info">
            <div class="card-body text-center">
                <h4 class="text-info">R$ <?= number_format($estatisticas['ticket_medio'] ?? 0, 2, ',', '.') ?></h4>
                <p class="card-text">Ticket Médio</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-warning">
            <div class="card-body text-center">
                <div class="row">
                    <div class="col-6">
                        <small class="text-muted">Dinheiro</small>
                        <br>
                        <strong><?= $estatisticas['vendas_dinheiro'] ?? 0 ?></strong>
                    </div>
                    <div class="col-6">
                        <small class="text-muted">Cartão</small>
                        <br>
                        <strong><?= ($estatisticas['vendas_cartao_credito'] ?? 0) + ($estatisticas['vendas_cartao_debito'] ?? 0) ?></strong>
                    </div>
                </div>
                <p class="card-text mt-2">Por Forma de Pagamento</p>
            </div>
        </div>
    </div>
</div>

<!-- Lista de Vendas -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="card-title mb-0">
                    <i class="bi bi-table"></i>
                    Lista de Vendas
                </h6>
                <div class="btn-group btn-group-sm" role="group">
                    <button class="btn btn-outline-info" onclick="atualizarLista()">
                        <i class="bi bi-arrow-clockwise"></i>
                        Atualizar
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <?php if (empty($vendas)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-receipt display-1 text-muted"></i>
                        <h5 class="mt-3">Nenhuma venda encontrada</h5>
                        <p class="text-muted">Não há vendas para o período selecionado.</p>
                        <a href="<?= BASE_URL ?>/pdv" class="btn btn-primary">
                            <i class="bi bi-plus"></i>
                            Realizar Primeira Venda
                        </a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Data/Hora</th>
                                    <th>Cliente</th>
                                    <th>Forma de Pagamento</th>
                                    <th>Total</th>
                                    <th>Vendedor</th>
                                    <th>Status</th>
                                    <th width="120">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($vendas as $venda): ?>
                                    <tr>
                                        <td>
                                            <strong>#<?= $venda['id'] ?></strong>
                                        </td>
                                        <td>
                                            <?= date('d/m/Y H:i', strtotime($venda['data_venda'])) ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($venda['cliente_nome'])): ?>
                                                <strong><?= htmlspecialchars($venda['cliente_nome']) ?></strong>
                                                <?php if (!empty($venda['cliente_telefone'])): ?>
                                                    <br>
                                                    <small class="text-muted">
                                                        <i class="bi bi-telephone"></i>
                                                        <?= htmlspecialchars($venda['cliente_telefone']) ?>
                                                    </small>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="text-muted">Cliente não informado</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php
                                            $formas_pagamento = [
                                                'dinheiro' => '<span class="badge bg-success"><i class="bi bi-cash"></i> Dinheiro</span>',
                                                'cartao_debito' => '<span class="badge bg-primary"><i class="bi bi-credit-card"></i> Débito</span>',
                                                'cartao_credito' => '<span class="badge bg-warning"><i class="bi bi-credit-card-2-front"></i> Crédito</span>',
                                                'pix' => '<span class="badge bg-info"><i class="bi bi-qr-code"></i> PIX</span>'
                                            ];
                                            echo $formas_pagamento[$venda['forma_pagamento']] ?? $venda['forma_pagamento'];
                                            ?>
                                            
                                            <?php if ($venda['forma_pagamento'] === 'dinheiro' && $venda['troco'] > 0): ?>
                                                <br>
                                                <small class="text-muted">
                                                    Troco: R$ <?= number_format($venda['troco'], 2, ',', '.') ?>
                                                </small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <strong class="text-success">
                                                R$ <?= number_format($venda['total'], 2, ',', '.') ?>
                                            </strong>
                                            <?php if ($venda['desconto'] > 0): ?>
                                                <br>
                                                <small class="text-muted">
                                                    Desc: R$ <?= number_format($venda['desconto'], 2, ',', '.') ?>
                                                </small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <small><?= htmlspecialchars($venda['vendedor_nome'] ?? 'N/A') ?></small>
                                        </td>
                                        <td>
                                            <?php
                                            $status = $venda['status'] ?? 'finalizada';
                                            $status_badges = [
                                                'finalizada' => '<span class="badge bg-success">Finalizada</span>',
                                                'cancelada' => '<span class="badge bg-danger">Cancelada</span>',
                                                'pendente' => '<span class="badge bg-warning">Pendente</span>'
                                            ];
                                            echo $status_badges[$status] ?? $status;
                                            ?>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="<?= BASE_URL ?>/pdv/visualizar/<?= $venda['id'] ?>" 
                                                   class="btn btn-outline-primary" title="Visualizar">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <button class="btn btn-outline-secondary" 
                                                        onclick="imprimirCupom(<?= $venda['id'] ?>)" title="Imprimir">
                                                    <i class="bi bi-printer"></i>
                                                </button>
                                                <?php if (($venda['status'] ?? 'finalizada') === 'finalizada'): ?>
                                                    <button class="btn btn-outline-danger" 
                                                            onclick="cancelarVenda(<?= $venda['id'] ?>)" title="Cancelar">
                                                        <i class="bi bi-x"></i>
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Cancelamento -->
<div class="modal fade" id="modalCancelamento" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle"></i>
                    Cancelar Venda
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja cancelar a venda <strong>#<span id="venda-cancelar-id"></span></strong>?</p>
                <div class="mb-3">
                    <label for="motivo-cancelamento" class="form-label">Motivo do cancelamento:</label>
                    <textarea class="form-control" id="motivo-cancelamento" rows="3" 
                              placeholder="Descreva o motivo do cancelamento..."></textarea>
                </div>
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle"></i>
                    <strong>Atenção:</strong> Esta ação não pode ser desfeita. O estoque dos produtos será restaurado.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x"></i>
                    Cancelar
                </button>
                <button type="button" class="btn btn-danger" onclick="confirmarCancelamento()">
                    <i class="bi bi-check"></i>
                    Confirmar Cancelamento
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let vendaParaCancelar = null;

// Atualizar lista
function atualizarLista() {
    location.reload();
}

// Exportar vendas
function exportarVendas() {
    const params = new URLSearchParams(window.location.search);
    params.set('exportar', 'csv');
    window.open('<?= BASE_URL ?>/pdv/vendas?' + params.toString(), '_blank');
}

// Imprimir cupom
function imprimirCupom(vendaId) {
    window.open(`<?= BASE_URL ?>/pdv/cupom/${vendaId}`, '_blank');
}

// Cancelar venda
function cancelarVenda(vendaId) {
    vendaParaCancelar = vendaId;
    document.getElementById('venda-cancelar-id').textContent = vendaId;
    document.getElementById('motivo-cancelamento').value = '';
    
    const modal = new bootstrap.Modal(document.getElementById('modalCancelamento'));
    modal.show();
}

// Confirmar cancelamento
function confirmarCancelamento() {
    const motivo = document.getElementById('motivo-cancelamento').value.trim();
    
    if (!motivo) {
        alert('Por favor, informe o motivo do cancelamento');
        return;
    }
    
    if (!vendaParaCancelar) {
        alert('Erro: ID da venda não encontrado');
        return;
    }
    
    fetch('<?= BASE_URL ?>/pdv/cancelar', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            venda_id: vendaParaCancelar,
            motivo: motivo
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Venda cancelada com sucesso!');
            location.reload();
        } else {
            alert('Erro ao cancelar venda: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao cancelar venda');
    })
    .finally(() => {
        const modal = bootstrap.Modal.getInstance(document.getElementById('modalCancelamento'));
        modal.hide();
        vendaParaCancelar = null;
    });
}

// Atalhos de teclado
document.addEventListener('keydown', function(e) {
    // F5 - Atualizar lista
    if (e.key === 'F5') {
        e.preventDefault();
        atualizarLista();
    }
    
    // Ctrl+E - Exportar
    if (e.ctrlKey && e.key === 'e') {
        e.preventDefault();
        exportarVendas();
    }
});

// Auto-refresh a cada 30 segundos
setInterval(function() {
    // Verificar se não há modais abertos
    const modalsAbertos = document.querySelectorAll('.modal.show');
    if (modalsAbertos.length === 0) {
        // Atualizar apenas as estatísticas via AJAX para não perder a posição da página
        fetch(window.location.href + '&ajax=1')
            .then(response => response.text())
            .then(html => {
                // Atualizar apenas as estatísticas
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const novasEstatisticas = doc.querySelectorAll('.card.border-primary, .card.border-success, .card.border-info, .card.border-warning');
                const estatisticasAtuais = document.querySelectorAll('.card.border-primary, .card.border-success, .card.border-info, .card.border-warning');
                
                novasEstatisticas.forEach((nova, index) => {
                    if (estatisticasAtuais[index]) {
                        estatisticasAtuais[index].innerHTML = nova.innerHTML;
                    }
                });
            })
            .catch(error => {
                console.log('Erro no auto-refresh:', error);
            });
    }
}, 30000); // 30 segundos
</script>

<style>
.table-responsive {
    max-height: 600px;
}

.btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
}

.badge {
    font-size: 0.75rem;
}

.card.border-primary,
.card.border-success,
.card.border-info,
.card.border-warning {
    transition: all 0.3s ease;
}

.card.border-primary:hover,
.card.border-success:hover,
.card.border-info:hover,
.card.border-warning:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

@media (max-width: 768px) {
    .btn-group {
        flex-direction: column;
    }
    
    .btn-group .btn {
        border-radius: 0.375rem !important;
        margin-bottom: 2px;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
}
</style>

