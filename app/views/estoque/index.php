<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-boxes"></i>
                Controle de Estoque
            </h1>
            <div class="btn-group" role="group">
                <a href="<?php echo BASE_URL; ?>/estoque/entrada" class="btn btn-success">
                    <i class="bi bi-arrow-down-circle"></i>
                    Entrada
                </a>
                <a href="<?php echo BASE_URL; ?>/estoque/saida" class="btn btn-warning">
                    <i class="bi bi-arrow-up-circle"></i>
                    Saída
                </a>
                <a href="<?php echo BASE_URL; ?>/estoque/ajuste" class="btn btn-info">
                    <i class="bi bi-gear"></i>
                    Ajuste
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Alertas de estoque baixo -->
<?php if (!empty($estoque_baixo)): ?>
<div class="row mb-4">
    <div class="col-12">
        <div class="alert alert-warning border-start-warning" role="alert">
            <h6 class="alert-heading">
                <i class="bi bi-exclamation-triangle"></i>
                Atenção: Produtos com Estoque Baixo
            </h6>
            <p class="mb-2">Os seguintes produtos estão com estoque baixo (≤ 5 unidades):</p>
            <div class="row">
                <?php foreach ($estoque_baixo as $item): ?>
                    <div class="col-md-6 col-lg-4 mb-2">
                        <div class="d-flex align-items-center">
                            <span class="badge bg-danger me-2"><?= $item['quantidade'] ?></span>
                            <span class="text-truncate"><?= htmlspecialchars($item['nome']) ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <hr>
            <div class="mb-0">
                <a href="<?php echo BASE_URL; ?>/estoque/entrada" class="btn btn-warning btn-sm">
                    <i class="bi bi-plus-circle"></i>
                    Fazer Entrada de Estoque
                </a>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Relatório de estoque -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-list"></i>
                        Relatório de Estoque
                    </h6>
                    <div class="input-group" style="width: 300px;">
                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control search-input" 
                               data-target="#estoque-table" placeholder="Buscar produto...">
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <?php if (empty($relatorio)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-inbox display-1 text-muted"></i>
                        <h5 class="mt-3">Nenhum produto cadastrado</h5>
                        <p class="text-muted">Cadastre produtos para visualizar o relatório de estoque.</p>
                        <a href="<?php echo BASE_URL; ?>/produto/novo" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i>
                            Cadastrar Produto
                        </a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="estoque-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Produto</th>
                                    <th>Categoria</th>
                                    <th>Preço Unitário</th>
                                    <th>Quantidade</th>
                                    <th>Status</th>
                                    <th>Valor Total</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $valorTotalGeral = 0;
                                foreach ($relatorio as $item): 
                                    $valorTotalGeral += $item['valor_total_estoque'];
                                    $quantidade = $item['quantidade'];
                                    
                                    // Definir status e classe
                                    if ($quantidade == 0) {
                                        $status = 'Sem Estoque';
                                        $statusClass = 'bg-danger';
                                        $rowClass = 'table-danger';
                                    } elseif ($quantidade <= 5) {
                                        $status = 'Estoque Baixo';
                                        $statusClass = 'bg-warning';
                                        $rowClass = 'table-warning';
                                    } elseif ($quantidade <= 10) {
                                        $status = 'Estoque Médio';
                                        $statusClass = 'bg-info';
                                        $rowClass = '';
                                    } else {
                                        $status = 'Estoque OK';
                                        $statusClass = 'bg-success';
                                        $rowClass = '';
                                    }
                                ?>
                                    <tr class="<?= $rowClass ?>">
                                        <td>
                                            <span class="badge bg-secondary">#<?= $item['id'] ?></span>
                                        </td>
                                        <td>
                                            <strong><?= htmlspecialchars($item['nome']) ?></strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">
                                                <?= htmlspecialchars($item['categoria']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <strong>R$ <?= number_format($item['preco_venda'], 2, ',', '.') ?></strong>
                                        </td>
                                        <td>
                                            <span class="fs-5 fw-bold"><?= $quantidade ?></span>
                                            <?php if ($quantidade <= 5 && $quantidade > 0): ?>
                                                <i class="bi bi-exclamation-triangle text-warning ms-1" 
                                                   data-bs-toggle="tooltip" title="Estoque baixo"></i>
                                            <?php elseif ($quantidade == 0): ?>
                                                <i class="bi bi-x-circle text-danger ms-1" 
                                                   data-bs-toggle="tooltip" title="Sem estoque"></i>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge <?= $statusClass ?>"><?= $status ?></span>
                                        </td>
                                        <td>
                                            <strong class="text-success">
                                                R$ <?= number_format($item['valor_total_estoque'], 2, ',', '.') ?>
                                            </strong>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="<?php echo BASE_URL; ?>/estoque/entrada" class="btn btn-outline-success" 
                                                   data-bs-toggle="tooltip" title="Entrada">
                                                    <i class="bi bi-arrow-down-circle"></i>
                                                </a>
                                                <?php if ($quantidade > 0): ?>
                                                    <a href="<?php echo BASE_URL; ?>/estoque/saida" class="btn btn-outline-warning" 
                                                       data-bs-toggle="tooltip" title="Saída">
                                                        <i class="bi bi-arrow-up-circle"></i>
                                                    </a>
                                                <?php endif; ?>
                                                <a href="<?php echo BASE_URL; ?>/estoque/ajuste" class="btn btn-outline-info" 
                                                   data-bs-toggle="tooltip" title="Ajustar">
                                                    <i class="bi bi-gear"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="6" class="text-end">Total Geral do Estoque:</th>
                                    <th>
                                        <strong class="text-success fs-5">
                                            R$ <?= number_format($valorTotalGeral, 2, ',', '.') ?>
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

<!-- Resumo estatístico -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card text-center border-start-primary">
            <div class="card-body">
                <h5 class="card-title text-primary"><?= count($relatorio) ?></h5>
                <p class="card-text">Total de Produtos</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center border-start-success">
            <div class="card-body">
                <h5 class="card-title text-success">
                    <?= count(array_filter($relatorio, function($item) { return $item['quantidade'] > 10; })) ?>
                </h5>
                <p class="card-text">Com Estoque OK</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center border-start-warning">
            <div class="card-body">
                <h5 class="card-title text-warning">
                    <?= count(array_filter($relatorio, function($item) { return $item['quantidade'] > 0 && $item['quantidade'] <= 10; })) ?>
                </h5>
                <p class="card-text">Estoque Baixo/Médio</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center border-start-danger">
            <div class="card-body">
                <h5 class="card-title text-danger">
                    <?= count(array_filter($relatorio, function($item) { return $item['quantidade'] == 0; })) ?>
                </h5>
                <p class="card-text">Sem Estoque</p>
            </div>
        </div>
    </div>
</div>

