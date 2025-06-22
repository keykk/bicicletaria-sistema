<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-file-text"></i>
                Orçamentos
            </h1>
            <a href="/orcamento/novo" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i>
                Novo Orçamento
            </a>
        </div>
    </div>
</div>

<!-- Estatísticas -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center border-start-primary">
            <div class="card-body">
                <h5 class="card-title text-primary"><?= number_format($estatisticas['total_orcamentos']) ?></h5>
                <p class="card-text">Total (Mês)</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center border-start-success">
            <div class="card-body">
                <h5 class="card-title text-success">R$ <?= number_format($estatisticas['valor_total'], 2, ',', '.') ?></h5>
                <p class="card-text">Valor Total</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center border-start-info">
            <div class="card-body">
                <h5 class="card-title text-info">R$ <?= number_format($estatisticas['valor_medio'], 2, ',', '.') ?></h5>
                <p class="card-text">Valor Médio</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center border-start-warning">
            <div class="card-body">
                <h5 class="card-title text-warning">R$ <?= number_format($estatisticas['maior_valor'], 2, ',', '.') ?></h5>
                <p class="card-text">Maior Valor</p>
            </div>
        </div>
    </div>
</div>

<!-- Filtros -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="periodo" class="form-label">Período</label>
                        <select class="form-select" id="periodo" name="periodo">
                            <option value="mes_atual" <?= $periodo_selecionado === 'mes_atual' ? 'selected' : '' ?>>
                                Mês Atual
                            </option>
                            <option value="todos" <?= $periodo_selecionado === 'todos' ? 'selected' : '' ?>>
                                Todos os Orçamentos
                            </option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="bi bi-funnel"></i>
                            Filtrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Lista de orçamentos -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-list"></i>
                    Lista de Orçamentos (<?= count($orcamentos) ?> encontrados)
                </h6>
            </div>
            <div class="card-body p-0">
                <?php if (empty($orcamentos)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-file-text display-1 text-muted"></i>
                        <h5 class="mt-3">Nenhum orçamento encontrado</h5>
                        <p class="text-muted">Crie seu primeiro orçamento para começar.</p>
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
                                    <th>Cliente</th>
                                    <th>Contato</th>
                                    <th>Data</th>
                                    <th>Valor Total</th>
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
                                                <strong><?= htmlspecialchars($orcamento['cliente']) ?></strong>
                                            </div>
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
                                                <?php if (empty($orcamento['telefone']) && empty($orcamento['email'])): ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <strong><?= date('d/m/Y', strtotime($orcamento['data'])) ?></strong>
                                                <br>
                                                <small class="text-muted"><?= date('H:i', strtotime($orcamento['data'])) ?></small>
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
                                                <?php if (!empty($orcamento['email'])): ?>
                                                    <a href="/orcamento/enviar-email/<?= $orcamento['id'] ?>" 
                                                       class="btn btn-outline-info" 
                                                       data-bs-toggle="tooltip" title="Enviar por Email">
                                                        <i class="bi bi-envelope"></i>
                                                    </a>
                                                <?php endif; ?>
                                                <a href="/orcamento/excluir/<?= $orcamento['id'] ?>" 
                                                   class="btn btn-outline-danger btn-delete" 
                                                   data-item="o orçamento #<?= $orcamento['id'] ?> de <?= htmlspecialchars($orcamento['cliente']) ?>"
                                                   data-bs-toggle="tooltip" title="Excluir">
                                                    <i class="bi bi-trash"></i>
                                                </a>
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

<!-- Dicas -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card border-start-info">
            <div class="card-header bg-info bg-opacity-10">
                <h6 class="card-title mb-0">
                    <i class="bi bi-lightbulb text-info"></i>
                    Dicas
                </h6>
            </div>
            <div class="card-body">
                <ul class="mb-0">
                    <li><strong>Visualizar:</strong> Veja todos os detalhes do orçamento</li>
                    <li><strong>Imprimir:</strong> Gere uma versão para impressão em papel A4</li>
                    <li><strong>Enviar por Email:</strong> Disponível apenas para orçamentos com email cadastrado</li>
                    <li><strong>Excluir:</strong> Remove permanentemente o orçamento do sistema</li>
                </ul>
            </div>
        </div>
    </div>
</div>

