<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-exclamation-triangle text-warning"></i>
                Relatório de Estoque Crítico
            </h1>
            <div>
                <a href="/relatorio" class="btn btn-outline-secondary me-2">
                    <i class="bi bi-arrow-left"></i>
                    Voltar aos Relatórios
                </a>
                <a href="/estoque/entrada" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i>
                    Entrada de Estoque
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Configurações de alerta -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-gear"></i>
                    Configurações de Alerta
                </h6>
            </div>
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label for="limite_baixo" class="form-label">Limite Estoque Baixo</label>
                        <input type="number" class="form-control" id="limite_baixo" name="limite_baixo" 
                               value="<?= $limite_baixo ?>" min="1" max="100">
                    </div>
                    <div class="col-md-3">
                        <label for="limite_critico" class="form-label">Limite Estoque Crítico</label>
                        <input type="number" class="form-control" id="limite_critico" name="limite_critico" 
                               value="<?= $limite_critico ?>" min="0" max="50">
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
                        <a href="/relatorio/exportar-csv?tipo=estoque_critico&limite_baixo=<?= $limite_baixo ?>&limite_critico=<?= $limite_critico ?>&categoria=<?= $categoria ?>" 
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
        <div class="card text-center border-start-danger">
            <div class="card-body">
                <h5 class="card-title text-danger"><?= $total_critico ?></h5>
                <p class="card-text">Estoque Crítico</p>
                <small class="text-muted">≤ <?= $limite_critico ?> unidades</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center border-start-warning">
            <div class="card-body">
                <h5 class="card-title text-warning"><?= $total_baixo ?></h5>
                <p class="card-text">Estoque Baixo</p>
                <small class="text-muted">≤ <?= $limite_baixo ?> unidades</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center border-start-info">
            <div class="card-body">
                <h5 class="card-title text-info">R$ <?= number_format($valor_total_critico, 2, ',', '.') ?></h5>
                <p class="card-text">Valor Imobilizado</p>
                <small class="text-muted">Produtos críticos</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center border-start-success">
            <div class="card-body">
                <h5 class="card-title text-success"><?= $total_produtos ?></h5>
                <p class="card-text">Total de Produtos</p>
                <small class="text-muted">No catálogo</small>
            </div>
        </div>
    </div>
</div>

<!-- Gráfico de distribuição por categoria -->
<?php if (!empty($produtos_criticos)): ?>
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-pie-chart"></i>
                    Distribuição por Categoria
                </h6>
            </div>
            <div class="card-body">
                <canvas id="graficoCategoria" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-bar-chart"></i>
                    Níveis de Criticidade
                </h6>
            </div>
            <div class="card-body">
                <canvas id="graficoNiveis" height="200"></canvas>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Lista de produtos com estoque crítico -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="card-title mb-0">
                    <i class="bi bi-list"></i>
                    Produtos com Estoque Crítico/Baixo (<?= count($produtos_criticos) ?>)
                </h6>
                <?php if (!empty($produtos_criticos)): ?>
                    <button class="btn btn-warning btn-sm" onclick="enviarAlertaEmail()">
                        <i class="bi bi-envelope"></i>
                        Enviar Alerta por Email
                    </button>
                <?php endif; ?>
            </div>
            <div class="card-body p-0">
                <?php if (empty($produtos_criticos)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-check-circle display-1 text-success"></i>
                        <h5 class="mt-3 text-success">Estoque em Bom Estado!</h5>
                        <p class="text-muted">Todos os produtos estão com estoque adequado.</p>
                        <div class="mt-3">
                            <a href="/produto" class="btn btn-primary me-2">
                                <i class="bi bi-box"></i>
                                Ver Produtos
                            </a>
                            <a href="/estoque" class="btn btn-outline-primary">
                                <i class="bi bi-clipboard-data"></i>
                                Relatório Completo
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Produto</th>
                                    <th>Categoria</th>
                                    <th width="120">Estoque Atual</th>
                                    <th width="120">Valor Unit.</th>
                                    <th width="140">Valor Total</th>
                                    <th width="150">Última Movimentação</th>
                                    <th width="120">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($produtos_criticos as $produto): ?>
                                    <?php 
                                    $status_class = '';
                                    $status_text = '';
                                    $status_icon = '';
                                    
                                    if ($produto['quantidade'] <= $limite_critico) {
                                        $status_class = 'danger';
                                        $status_text = 'CRÍTICO';
                                        $status_icon = 'exclamation-triangle';
                                    } elseif ($produto['quantidade'] <= $limite_baixo) {
                                        $status_class = 'warning';
                                        $status_text = 'BAIXO';
                                        $status_icon = 'exclamation-circle';
                                    }
                                    ?>
                                    <tr class="table-<?= $status_class === 'danger' ? 'danger' : 'warning' ?>">
                                        <td>
                                            <span class="badge bg-<?= $status_class ?> d-flex align-items-center">
                                                <i class="bi bi-<?= $status_icon ?> me-1"></i>
                                                <?= $status_text ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div>
                                                <strong><?= htmlspecialchars($produto['nome']) ?></strong>
                                                <?php if (!empty($produto['descricao'])): ?>
                                                    <br>
                                                    <small class="text-muted">
                                                        <?= htmlspecialchars(substr($produto['descricao'], 0, 60)) ?>
                                                        <?= strlen($produto['descricao']) > 60 ? '...' : '' ?>
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
                                            <div class="d-flex flex-column align-items-center">
                                                <strong class="fs-5 text-<?= $status_class ?>">
                                                    <?= number_format($produto['quantidade'], 0, ',', '.') ?>
                                                </strong>
                                                <small class="text-muted"><?= $produto['unidade_medida'] ?></small>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            R$ <?= number_format($produto['preco_venda'], 2, ',', '.') ?>
                                        </td>
                                        <td class="text-end">
                                            <strong>
                                                R$ <?= number_format($produto['quantidade'] * $produto['preco_venda'], 2, ',', '.') ?>
                                            </strong>
                                        </td>
                                        <td>
                                            <?php if (!empty($produto['ultima_movimentacao'])): ?>
                                                <div>
                                                    <small class="text-muted">
                                                        <?= date('d/m/Y', strtotime($produto['ultima_movimentacao'])) ?>
                                                    </small>
                                                    <br>
                                                    <small class="text-muted">
                                                        <?= date('H:i', strtotime($produto['ultima_movimentacao'])) ?>
                                                    </small>
                                                </div>
                                            <?php else: ?>
                                                <small class="text-muted">Sem movimentação</small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="/estoque/entrada?produto_id=<?= $produto['id'] ?>" 
                                                   class="btn btn-success" 
                                                   data-bs-toggle="tooltip" title="Entrada de Estoque">
                                                    <i class="bi bi-plus-circle"></i>
                                                </a>
                                                <a href="/produto/editar/<?= $produto['id'] ?>" 
                                                   class="btn btn-outline-primary" 
                                                   data-bs-toggle="tooltip" title="Editar Produto">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="5" class="text-end">Valor Total Imobilizado:</th>
                                    <th class="text-end">
                                        <strong class="text-danger fs-6">
                                            R$ <?= number_format($valor_total_critico, 2, ',', '.') ?>
                                        </strong>
                                    </th>
                                    <th colspan="2"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Sugestões de reposição -->
<?php if (!empty($produtos_criticos)): ?>
<div class="row mt-4">
    <div class="col-12">
        <div class="card border-info">
            <div class="card-header bg-info text-white">
                <h6 class="card-title mb-0">
                    <i class="bi bi-lightbulb"></i>
                    Sugestões de Reposição
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Produtos Críticos (Prioridade Alta)</h6>
                        <ul class="list-group list-group-flush">
                            <?php foreach (array_slice($produtos_criticos, 0, 5) as $produto): ?>
                                <?php if ($produto['quantidade'] <= $limite_critico): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong><?= htmlspecialchars($produto['nome']) ?></strong>
                                            <br>
                                            <small class="text-muted">Estoque: <?= $produto['quantidade'] ?> <?= $produto['unidade_medida'] ?></small>
                                        </div>
                                        <span class="badge bg-danger">Urgente</span>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>Dicas de Gestão</h6>
                        <ul class="list-unstyled">
                            <li><i class="bi bi-check-circle text-success"></i> Configure alertas automáticos por email</li>
                            <li><i class="bi bi-check-circle text-success"></i> Mantenha histórico de fornecedores</li>
                            <li><i class="bi bi-check-circle text-success"></i> Analise sazonalidade das vendas</li>
                            <li><i class="bi bi-check-circle text-success"></i> Defina estoque mínimo por produto</li>
                            <li><i class="bi bi-check-circle text-success"></i> Faça inventários regulares</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if (!empty($produtos_criticos)): ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gráfico de distribuição por categoria
    const ctxCategoria = document.getElementById('graficoCategoria').getContext('2d');
    const categorias = <?= json_encode($distribuicao_categoria) ?>;
    
    new Chart(ctxCategoria, {
        type: 'doughnut',
        data: {
            labels: Object.keys(categorias),
            datasets: [{
                data: Object.values(categorias),
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
    
    // Gráfico de níveis de criticidade
    const ctxNiveis = document.getElementById('graficoNiveis').getContext('2d');
    
    new Chart(ctxNiveis, {
        type: 'bar',
        data: {
            labels: ['Crítico', 'Baixo'],
            datasets: [{
                label: 'Quantidade de Produtos',
                data: [<?= $total_critico ?>, <?= $total_baixo ?>],
                backgroundColor: [
                    'rgba(220, 53, 69, 0.8)',
                    'rgba(255, 193, 7, 0.8)'
                ],
                borderColor: [
                    'rgba(220, 53, 69, 1)',
                    'rgba(255, 193, 7, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});

function enviarAlertaEmail() {
    if (confirm('Deseja enviar um alerta por email sobre os produtos com estoque crítico?')) {
        fetch('/relatorio/enviar-alerta-estoque', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                limite_baixo: <?= $limite_baixo ?>,
                limite_critico: <?= $limite_critico ?>
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Alerta enviado por email com sucesso!');
            } else {
                alert('Erro ao enviar alerta: ' + data.message);
            }
        })
        .catch(error => {
            alert('Erro ao enviar alerta: ' + error.message);
        });
    }
}
</script>
<?php endif; ?>

