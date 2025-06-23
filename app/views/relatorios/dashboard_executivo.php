<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-speedometer2"></i>
                Dashboard Executivo
            </h1>
            <div>
                <button class="btn btn-outline-primary me-2" onclick="atualizarDados()">
                    <i class="bi bi-arrow-clockwise"></i>
                    Atualizar
                </button>
                <a href="/relatorio" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i>
                    Voltar aos Relatórios
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Filtro de período -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label for="periodo" class="form-label">Período de Análise</label>
                        <select class="form-select" id="periodo" name="periodo" onchange="this.form.submit()">
                            <option value="7" <?= $periodo == 7 ? 'selected' : '' ?>>Últimos 7 dias</option>
                            <option value="30" <?= $periodo == 30 ? 'selected' : '' ?>>Últimos 30 dias</option>
                            <option value="90" <?= $periodo == 90 ? 'selected' : '' ?>>Últimos 90 dias</option>
                            <option value="365" <?= $periodo == 365 ? 'selected' : '' ?>>Último ano</option>
                        </select>
                    </div>
                    <div class="col-md-9">
                        <div class="text-muted">
                            <small>
                                <i class="bi bi-info-circle"></i>
                                Dados atualizados em tempo real • Última atualização: <?= date('d/m/Y H:i:s') ?>
                            </small>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- KPIs Principais -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-start-primary border-start-4">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted mb-1">Faturamento</h6>
                        <h4 class="text-primary mb-0">R$ <?= number_format($kpis['faturamento'], 2, ',', '.') ?></h4>
                        <small class="text-muted">Últimos <?= $periodo ?> dias</small>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-currency-dollar text-primary" style="font-size: 2rem;"></i>
                    </div>
                </div>
                <div class="mt-2">
                    <span class="badge bg-<?= $kpis['crescimento_faturamento'] >= 0 ? 'success' : 'danger' ?>">
                        <i class="bi bi-<?= $kpis['crescimento_faturamento'] >= 0 ? 'arrow-up' : 'arrow-down' ?>"></i>
                        <?= abs($kpis['crescimento_faturamento']) ?>%
                    </span>
                    <small class="text-muted ms-1">vs período anterior</small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-start-success border-start-4">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted mb-1">Orçamentos</h6>
                        <h4 class="text-success mb-0"><?= $kpis['total_orcamentos'] ?></h4>
                        <small class="text-muted">Últimos <?= $periodo ?> dias</small>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-file-earmark-text text-success" style="font-size: 2rem;"></i>
                    </div>
                </div>
                <div class="mt-2">
                    <span class="badge bg-<?= $kpis['crescimento_orcamentos'] >= 0 ? 'success' : 'danger' ?>">
                        <i class="bi bi-<?= $kpis['crescimento_orcamentos'] >= 0 ? 'arrow-up' : 'arrow-down' ?>"></i>
                        <?= abs($kpis['crescimento_orcamentos']) ?>%
                    </span>
                    <small class="text-muted ms-1">vs período anterior</small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-start-info border-start-4">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted mb-1">Ticket Médio</h6>
                        <h4 class="text-info mb-0">R$ <?= number_format($kpis['ticket_medio'], 2, ',', '.') ?></h4>
                        <small class="text-muted">Por orçamento</small>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-graph-up text-info" style="font-size: 2rem;"></i>
                    </div>
                </div>
                <div class="mt-2">
                    <span class="badge bg-<?= $kpis['crescimento_ticket'] >= 0 ? 'success' : 'danger' ?>">
                        <i class="bi bi-<?= $kpis['crescimento_ticket'] >= 0 ? 'arrow-up' : 'arrow-down' ?>"></i>
                        <?= abs($kpis['crescimento_ticket']) ?>%
                    </span>
                    <small class="text-muted ms-1">vs período anterior</small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-start-warning border-start-4">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted mb-1">Produtos Críticos</h6>
                        <h4 class="text-warning mb-0"><?= $kpis['produtos_criticos'] ?></h4>
                        <small class="text-muted">Estoque baixo</small>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-exclamation-triangle text-warning" style="font-size: 2rem;"></i>
                    </div>
                </div>
                <div class="mt-2">
                    <?php if ($kpis['produtos_criticos'] > 0): ?>
                        <a href="/relatorio/estoque-critico" class="btn btn-warning btn-sm">
                            <i class="bi bi-eye"></i>
                            Ver Detalhes
                        </a>
                    <?php else: ?>
                        <span class="badge bg-success">
                            <i class="bi bi-check-circle"></i>
                            Tudo OK
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Gráficos principais -->
<div class="row mb-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-graph-up"></i>
                    Evolução de Vendas (Últimos <?= $periodo ?> dias)
                </h6>
            </div>
            <div class="card-body">
                <canvas id="graficoVendas" height="100"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-pie-chart"></i>
                    Vendas por Categoria
                </h6>
            </div>
            <div class="card-body">
                <canvas id="graficoCategoria" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Top produtos e análises -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="card-title mb-0">
                    <i class="bi bi-trophy"></i>
                    Top 5 Produtos Mais Vendidos
                </h6>
                <a href="/relatorio/produtos-mais-vendidos" class="btn btn-outline-primary btn-sm">
                    Ver Todos
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50">#</th>
                                <th>Produto</th>
                                <th width="80">Qtd</th>
                                <th width="100">Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($top_produtos as $index => $produto): ?>
                                <tr>
                                    <td>
                                        <span class="badge bg-<?= $index == 0 ? 'warning' : ($index == 1 ? 'secondary' : 'success') ?>">
                                            <?= $index + 1 ?>º
                                        </span>
                                    </td>
                                    <td>
                                        <div>
                                            <strong><?= htmlspecialchars(substr($produto['nome'], 0, 30)) ?></strong>
                                            <?php if (strlen($produto['nome']) > 30): ?>
                                                <small class="text-muted">...</small>
                                            <?php endif; ?>
                                            <br>
                                            <small class="text-muted"><?= $produto['categoria'] ?></small>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <strong><?= $produto['quantidade_vendida'] ?></strong>
                                    </td>
                                    <td class="text-end">
                                        <strong class="text-success">
                                            R$ <?= number_format($produto['valor_total'], 0, ',', '.') ?>
                                        </strong>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-clock-history"></i>
                    Orçamentos Recentes
                </h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Data</th>
                                <th width="100">Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orcamentos_recentes as $orcamento): ?>
                                <tr>
                                    <td>
                                        <span class="badge bg-primary">#<?= $orcamento['id'] ?></span>
                                    </td>
                                    <td>
                                        <strong><?= htmlspecialchars(substr($orcamento['cliente'], 0, 20)) ?></strong>
                                        <?php if (strlen($orcamento['cliente']) > 20): ?>
                                            <small class="text-muted">...</small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <small><?= date('d/m H:i', strtotime($orcamento['data'])) ?></small>
                                    </td>
                                    <td class="text-end">
                                        <strong class="text-success">
                                            R$ <?= number_format($orcamento['valor_total'], 0, ',', '.') ?>
                                        </strong>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Métricas adicionais -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-calendar-week"></i>
                    Performance Semanal
                </h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <h5 class="text-primary"><?= $metricas['vendas_semana'] ?></h5>
                        <small class="text-muted">Vendas esta semana</small>
                    </div>
                    <div class="col-6">
                        <h5 class="text-success">R$ <?= number_format($metricas['faturamento_semana'], 0, ',', '.') ?></h5>
                        <small class="text-muted">Faturamento</small>
                    </div>
                </div>
                <hr>
                <div class="row text-center">
                    <div class="col-6">
                        <h6 class="text-info"><?= $metricas['vendas_ontem'] ?></h6>
                        <small class="text-muted">Vendas ontem</small>
                    </div>
                    <div class="col-6">
                        <h6 class="text-warning"><?= $metricas['vendas_hoje'] ?></h6>
                        <small class="text-muted">Vendas hoje</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-box"></i>
                    Status do Estoque
                </h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <h5 class="text-success"><?= $estoque['produtos_ok'] ?></h5>
                        <small class="text-muted">Estoque OK</small>
                    </div>
                    <div class="col-6">
                        <h5 class="text-warning"><?= $estoque['produtos_baixo'] ?></h5>
                        <small class="text-muted">Estoque Baixo</small>
                    </div>
                </div>
                <hr>
                <div class="text-center">
                    <h6 class="text-info">R$ <?= number_format($estoque['valor_total'], 0, ',', '.') ?></h6>
                    <small class="text-muted">Valor total em estoque</small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-tools"></i>
                    Serviços
                </h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <h5 class="text-primary"><?= $servicos['em_andamento'] ?></h5>
                        <small class="text-muted">Em andamento</small>
                    </div>
                    <div class="col-6">
                        <h5 class="text-success"><?= $servicos['concluidos_mes'] ?></h5>
                        <small class="text-muted">Concluídos no mês</small>
                    </div>
                </div>
                <hr>
                <div class="text-center">
                    <h6 class="text-info">R$ <?= number_format($servicos['faturamento_mes'], 0, ',', '.') ?></h6>
                    <small class="text-muted">Faturamento serviços</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Alertas e notificações -->
<?php if (!empty($alertas)): ?>
<div class="row">
    <div class="col-12">
        <div class="card border-warning">
            <div class="card-header bg-warning text-dark">
                <h6 class="card-title mb-0">
                    <i class="bi bi-bell"></i>
                    Alertas e Notificações
                </h6>
            </div>
            <div class="card-body">
                <?php foreach ($alertas as $alerta): ?>
                    <div class="alert alert-<?= $alerta['tipo'] ?> alert-dismissible fade show" role="alert">
                        <i class="bi bi-<?= $alerta['icone'] ?>"></i>
                        <strong><?= $alerta['titulo'] ?>:</strong> <?= $alerta['mensagem'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gráfico de evolução de vendas
    const ctxVendas = document.getElementById('graficoVendas').getContext('2d');
    const dadosVendas = <?= json_encode($grafico_vendas) ?>;
    
    new Chart(ctxVendas, {
        type: 'line',
        data: {
            labels: dadosVendas.labels,
            datasets: [{
                label: 'Faturamento (R$)',
                data: dadosVendas.valores,
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.1,
                fill: true
            }, {
                label: 'Quantidade',
                data: dadosVendas.quantidades,
                borderColor: 'rgb(255, 99, 132)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                tension: 0.1,
                yAxisID: 'y1'
            }]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Período'
                    }
                },
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Faturamento (R$)'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Quantidade'
                    },
                    grid: {
                        drawOnChartArea: false,
                    },
                }
            }
        }
    });
    
    // Gráfico de vendas por categoria
    const ctxCategoria = document.getElementById('graficoCategoria').getContext('2d');
    const dadosCategoria = <?= json_encode($grafico_categoria) ?>;
    
    new Chart(ctxCategoria, {
        type: 'doughnut',
        data: {
            labels: dadosCategoria.labels,
            datasets: [{
                data: dadosCategoria.valores,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 205, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(153, 102, 255, 0.8)'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});

function atualizarDados() {
    location.reload();
}

// Auto-refresh a cada 5 minutos
setInterval(function() {
    const alertDiv = document.createElement('div');
    alertDiv.className = 'alert alert-info alert-dismissible fade show position-fixed';
    alertDiv.style.top = '20px';
    alertDiv.style.right = '20px';
    alertDiv.style.zIndex = '9999';
    alertDiv.innerHTML = `
        <i class="bi bi-arrow-clockwise"></i>
        Dados atualizados automaticamente
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(alertDiv);
    
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.parentNode.removeChild(alertDiv);
        }
    }, 3000);
    
    atualizarDados();
}, 300000); // 5 minutos
</script>

