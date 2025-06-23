<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-graph-up"></i>
                Relatório de Vendas
            </h1>
            <a href="/relatorio" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
                Voltar aos Relatórios
            </a>
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
                    Filtros de Período
                </h6>
            </div>
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label for="data_inicio" class="form-label">Data Início</label>
                        <input type="date" class="form-control" id="data_inicio" name="data_inicio" 
                               value="<?= $data_inicio ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="data_fim" class="form-label">Data Fim</label>
                        <input type="date" class="form-control" id="data_fim" name="data_fim" 
                               value="<?= $data_fim ?>">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="bi bi-search"></i>
                            Filtrar
                        </button>
                        <a href="/relatorio/exportar-csv?tipo=vendas&data_inicio=<?= $data_inicio ?>&data_fim=<?= $data_fim ?>" 
                           class="btn btn-outline-success">
                            <i class="bi bi-download"></i>
                            Exportar CSV
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Estatísticas resumidas -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center border-start-primary">
            <div class="card-body">
                <h5 class="card-title text-primary"><?= $total_orcamentos ?></h5>
                <p class="card-text">Total de Orçamentos</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center border-start-success">
            <div class="card-body">
                <h5 class="card-title text-success">R$ <?= number_format($valor_total, 2, ',', '.') ?></h5>
                <p class="card-text">Valor Total</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center border-start-info">
            <div class="card-body">
                <h5 class="card-title text-info">R$ <?= number_format($valor_medio, 2, ',', '.') ?></h5>
                <p class="card-text">Valor Médio</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center border-start-warning">
            <div class="card-body">
                <h5 class="card-title text-warning">
                    <?= count($vendas_por_dia) ?>
                </h5>
                <p class="card-text">Dias com Vendas</p>
            </div>
        </div>
    </div>
</div>

<!-- Gráfico de vendas por dia -->
<?php if (!empty($vendas_por_dia)): ?>
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-bar-chart"></i>
                    Vendas por Dia
                </h6>
            </div>
            <div class="card-body">
                <canvas id="graficoVendas" height="100"></canvas>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Lista detalhada de orçamentos -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-list"></i>
                    Orçamentos do Período (<?= count($orcamentos) ?>)
                </h6>
            </div>
            <div class="card-body p-0">
                <?php if (empty($orcamentos)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-inbox display-1 text-muted"></i>
                        <h5 class="mt-3">Nenhum orçamento encontrado</h5>
                        <p class="text-muted">Não há orçamentos no período selecionado.</p>
                        <a href="/orcamento/novo" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i>
                            Criar Primeiro Orçamento
                        </a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Data</th>
                                    <th>Cliente</th>
                                    <th>Contato</th>
                                    <th>Valor</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orcamentos as $orcamento): ?>
                                    <tr>
                                        <td>
                                            <span class="badge bg-primary">#<?= $orcamento['id'] ?></span>
                                        </td>
                                        <td>
                                            <div>
                                                <strong><?= date('d/m/Y', strtotime($orcamento['data'])) ?></strong>
                                                <br>
                                                <small class="text-muted"><?= date('H:i', strtotime($orcamento['data'])) ?></small>
                                            </div>
                                        </td>
                                        <td>
                                            <strong><?= htmlspecialchars($orcamento['cliente']) ?></strong>
                                        </td>
                                        <td>
                                            <div>
                                                <?php if (!empty($orcamento['telefone'])): ?>
                                                    <div>
                                                        <i class="bi bi-telephone text-muted"></i>
                                                        <?= htmlspecialchars($orcamento['telefone']) ?>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (!empty($orcamento['email'])): ?>
                                                    <div>
                                                        <i class="bi bi-envelope text-muted"></i>
                                                        <?= htmlspecialchars($orcamento['email']) ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <strong class="text-success fs-6">
                                                R$ <?= number_format($orcamento['valor_total'], 2, ',', '.') ?>
                                            </strong>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="/orcamento/visualizar/<?= $orcamento['id'] ?>" 
                                                   class="btn btn-outline-primary" 
                                                   data-bs-toggle="tooltip" title="Visualizar">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="/orcamento/imprimir/<?= $orcamento['id'] ?>" 
                                                   class="btn btn-outline-success" 
                                                   data-bs-toggle="tooltip" title="Imprimir"
                                                   target="_blank">
                                                    <i class="bi bi-printer"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="4" class="text-end">Total do Período:</th>
                                    <th>
                                        <strong class="text-success fs-5">
                                            R$ <?= number_format($valor_total, 2, ',', '.') ?>
                                        </strong>
                                    </th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($vendas_por_dia)): ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('graficoVendas').getContext('2d');
    
    const dados = <?= json_encode($vendas_por_dia) ?>;
    const labels = Object.keys(dados).map(data => {
        const d = new Date(data);
        return d.toLocaleDateString('pt-BR');
    });
    const valores = Object.values(dados).map(item => item.valor);
    const quantidades = Object.values(dados).map(item => item.quantidade);
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Valor (R$)',
                data: valores,
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.1,
                yAxisID: 'y'
            }, {
                label: 'Quantidade',
                data: quantidades,
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
                        text: 'Data'
                    }
                },
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Valor (R$)'
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
});
</script>
<?php endif; ?>

