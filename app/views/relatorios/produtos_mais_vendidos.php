<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-trophy"></i>
                Produtos Mais Vendidos
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
                    <div class="col-md-3">
                        <label for="data_inicio" class="form-label">Data Início</label>
                        <input type="date" class="form-control" id="data_inicio" name="data_inicio" 
                               value="<?= $data_inicio ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="data_fim" class="form-label">Data Fim</label>
                        <input type="date" class="form-control" id="data_fim" name="data_fim" 
                               value="<?= $data_fim ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="categoria" class="form-label">Categoria</label>
                        <select class="form-select" id="categoria" name="categoria">
                            <option value="">Todas as categorias</option>
                            <option value="Bicicletas" <?= $categoria === 'Bicicletas' ? 'selected' : '' ?>>Bicicletas</option>
                            <option value="Peças" <?= $categoria === 'Peças' ? 'selected' : '' ?>>Peças</option>
                            <option value="Acessórios" <?= $categoria === 'Acessórios' ? 'selected' : '' ?>>Acessórios</option>
                            <option value="Serviços" <?= $categoria === 'Serviços' ? 'selected' : '' ?>>Serviços</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="bi bi-search"></i>
                            Filtrar
                        </button>
                        <a href="/relatorio/exportar-csv?tipo=produtos_vendidos&data_inicio=<?= $data_inicio ?>&data_fim=<?= $data_fim ?>&categoria=<?= $categoria ?>" 
                           class="btn btn-outline-success">
                            <i class="bi bi-download"></i>
                            CSV
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
                <h5 class="card-title text-primary"><?= count($produtos) ?></h5>
                <p class="card-text">Produtos Vendidos</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center border-start-success">
            <div class="card-body">
                <h5 class="card-title text-success"><?= $total_quantidade ?></h5>
                <p class="card-text">Unidades Vendidas</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center border-start-info">
            <div class="card-body">
                <h5 class="card-title text-info">R$ <?= number_format($total_valor, 2, ',', '.') ?></h5>
                <p class="card-text">Valor Total</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center border-start-warning">
            <div class="card-body">
                <h5 class="card-title text-warning"><?= $total_orcamentos ?></h5>
                <p class="card-text">Orçamentos</p>
            </div>
        </div>
    </div>
</div>

<!-- Gráfico dos top 10 produtos -->
<?php if (!empty($produtos)): ?>
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-bar-chart"></i>
                    Top 10 Produtos Mais Vendidos (Quantidade)
                </h6>
            </div>
            <div class="card-body">
                <canvas id="graficoProdutos" height="100"></canvas>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Ranking completo -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-list-ol"></i>
                    Ranking Completo de Produtos
                </h6>
            </div>
            <div class="card-body p-0">
                <?php if (empty($produtos)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-inbox display-1 text-muted"></i>
                        <h5 class="mt-3">Nenhum produto vendido</h5>
                        <p class="text-muted">Não há vendas de produtos no período selecionado.</p>
                        <a href="/orcamento/novo" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i>
                            Criar Orçamento
                        </a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th width="60">#</th>
                                    <th>Produto</th>
                                    <th>Categoria</th>
                                    <th width="120">Quantidade</th>
                                    <th width="120">Valor Unit.</th>
                                    <th width="140">Valor Total</th>
                                    <th width="100">Orçamentos</th>
                                    <th width="120">% do Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($produtos as $index => $produto): ?>
                                    <?php 
                                    $posicao = $index + 1;
                                    $percentual = $total_valor > 0 ? ($produto['valor_total'] / $total_valor) * 100 : 0;
                                    $badgeClass = '';
                                    if ($posicao <= 3) {
                                        $badgeClass = $posicao == 1 ? 'bg-warning' : ($posicao == 2 ? 'bg-secondary' : 'bg-success');
                                    } else {
                                        $badgeClass = 'bg-light text-dark';
                                    }
                                    ?>
                                    <tr>
                                        <td>
                                            <span class="badge <?= $badgeClass ?> fs-6">
                                                <?php if ($posicao == 1): ?>
                                                    <i class="bi bi-trophy"></i>
                                                <?php elseif ($posicao == 2): ?>
                                                    <i class="bi bi-award"></i>
                                                <?php elseif ($posicao == 3): ?>
                                                    <i class="bi bi-medal"></i>
                                                <?php else: ?>
                                                    <?= $posicao ?>º
                                                <?php endif; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div>
                                                <strong><?= htmlspecialchars($produto['nome']) ?></strong>
                                                <?php if (!empty($produto['descricao'])): ?>
                                                    <br>
                                                    <small class="text-muted">
                                                        <?= htmlspecialchars(substr($produto['descricao'], 0, 80)) ?>
                                                        <?= strlen($produto['descricao']) > 80 ? '...' : '' ?>
                                                    </small>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">
                                                <?= htmlspecialchars($produto['categoria']) ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <strong class="fs-5 text-primary">
                                                <?= number_format($produto['quantidade_vendida'], 0, ',', '.') ?>
                                            </strong>
                                            <br>
                                            <small class="text-muted"><?= $produto['unidade_medida'] ?></small>
                                        </td>
                                        <td class="text-end">
                                            R$ <?= number_format($produto['preco_medio'], 2, ',', '.') ?>
                                        </td>
                                        <td class="text-end">
                                            <strong class="text-success">
                                                R$ <?= number_format($produto['valor_total'], 2, ',', '.') ?>
                                            </strong>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-secondary">
                                                <?= $produto['total_orcamentos'] ?>
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <div class="d-flex align-items-center">
                                                <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                                    <div class="progress-bar bg-success" 
                                                         style="width: <?= min($percentual, 100) ?>%"></div>
                                                </div>
                                                <small class="text-muted">
                                                    <?= number_format($percentual, 1) ?>%
                                                </small>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="3" class="text-end">Totais:</th>
                                    <th class="text-center">
                                        <strong><?= number_format($total_quantidade, 0, ',', '.') ?></strong>
                                    </th>
                                    <th></th>
                                    <th class="text-end">
                                        <strong class="text-success">
                                            R$ <?= number_format($total_valor, 2, ',', '.') ?>
                                        </strong>
                                    </th>
                                    <th class="text-center">
                                        <strong><?= $total_orcamentos ?></strong>
                                    </th>
                                    <th class="text-end">
                                        <strong>100%</strong>
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($produtos)): ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('graficoProdutos').getContext('2d');
    
    const produtos = <?= json_encode(array_slice($produtos, 0, 10)) ?>;
    const labels = produtos.map(p => p.nome.length > 30 ? p.nome.substring(0, 30) + '...' : p.nome);
    const quantidades = produtos.map(p => parseInt(p.quantidade_vendida));
    const valores = produtos.map(p => parseFloat(p.valor_total));
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Quantidade Vendida',
                data: quantidades,
                backgroundColor: 'rgba(54, 162, 235, 0.8)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                yAxisID: 'y'
            }, {
                label: 'Valor Total (R$)',
                data: valores,
                type: 'line',
                borderColor: 'rgba(255, 99, 132, 1)',
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
                        text: 'Produtos'
                    }
                },
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Quantidade'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Valor (R$)'
                    },
                    grid: {
                        drawOnChartArea: false,
                    },
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            if (context.datasetIndex === 0) {
                                return 'Quantidade: ' + context.parsed.y.toLocaleString('pt-BR');
                            } else {
                                return 'Valor: R$ ' + context.parsed.y.toLocaleString('pt-BR', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });
                            }
                        }
                    }
                }
            }
        }
    });
});
</script>
<?php endif; ?>

