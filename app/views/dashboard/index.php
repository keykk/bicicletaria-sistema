<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-speedometer2"></i>
                Dashboard
            </h1>
            <div class="text-muted">
                <i class="bi bi-calendar3"></i>
                <?= date('d/m/Y H:i') ?>
            </div>
        </div>
    </div>
</div>

<!-- Cards de estatísticas -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="dashboard-card">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <div class="card-value"><?= number_format($total_produtos) ?></div>
                    <div class="card-label">Total de Produtos</div>
                </div>
                <div class="card-icon">
                    <i class="bi bi-box-seam"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="dashboard-card warning">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <div class="card-value"><?= number_format($produtos_estoque_baixo) ?></div>
                    <div class="card-label">Estoque Baixo</div>
                </div>
                <div class="card-icon">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="dashboard-card success">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <div class="card-value"><?= number_format($total_vendas_mes) ?></div>
                    <div class="card-label">Vendas (Mês)</div>
                </div>
                <div class="card-icon">
                    <i class="bi bi-file-text"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="dashboard-card danger">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <div class="card-value">R$ <?= number_format($valor_total_vendas_mes, 2, ',', '.') ?></div>
                    <div class="card-label">Valor Total (Mês)</div>
                </div>
                <div class="card-icon">
                    <i class="bi bi-currency-dollar"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ações rápidas -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-lightning"></i>
                    Ações Rápidas
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="<?php echo BASE_URL; ?>/produto/novo" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                            <i class="bi bi-plus-circle fs-1 mb-2"></i>
                            <span>Novo Produto</span>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="<?php echo BASE_URL; ?>/orcamento/novo" class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                            <i class="bi bi-file-plus fs-1 mb-2"></i>
                            <span>Novo Orçamento</span>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="<?php echo BASE_URL; ?>/estoque/entrada" class="btn btn-outline-info w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                            <i class="bi bi-arrow-down-circle fs-1 mb-2"></i>
                            <span>Entrada Estoque</span>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="<?php echo BASE_URL; ?>/tabelapreco/nova" class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                            <i class="bi bi-tag fs-1 mb-2"></i>
                            <span>Nova Tabela Preço</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Alertas e informações -->
<div class="row">
    <?php if ($produtos_estoque_baixo > 0): ?>
    <div class="col-lg-6 mb-4">
        <div class="card border-start-warning">
            <div class="card-header bg-warning bg-opacity-10">
                <h6 class="card-title mb-0">
                    <i class="bi bi-exclamation-triangle text-warning"></i>
                    Atenção: Produtos com Estoque Baixo
                </h6>
            </div>
            <div class="card-body">
                <p class="mb-2">Existem <strong><?= $produtos_estoque_baixo ?></strong> produtos com estoque baixo que precisam de atenção.</p>
                <a href="<?php echo BASE_URL; ?>/estoque" class="btn btn-warning btn-sm">
                    <i class="bi bi-eye"></i>
                    Ver Relatório de Estoque
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <div class="col-lg-6 mb-4">
        <div class="card border-start-info">
            <div class="card-header bg-info bg-opacity-10">
                <h6 class="card-title mb-0">
                    <i class="bi bi-info-circle text-info"></i>
                    Resumo do Sistema
                </h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="bi bi-check-circle text-success"></i>
                        Sistema funcionando normalmente
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-person-circle text-primary"></i>
                        Usuário: <strong><?= $_SESSION['user_data']['nome_usuario'] ?></strong>
                    </li>
                    <li class="mb-0">
                        <i class="bi bi-shield-check text-success"></i>
                        Nível: <strong><?= ucfirst($_SESSION['user_data']['nivel_acesso']) ?></strong>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Links úteis -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-bookmark"></i>
                    Links Úteis
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <a href="<?php echo BASE_URL; ?>/produto" class="btn btn-link p-0">
                            <i class="bi bi-box-seam"></i>
                            Gerenciar Produtos
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="<?php echo BASE_URL; ?>/estoque" class="btn btn-link p-0">
                            <i class="bi bi-boxes"></i>
                            Controle de Estoque
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="<?php echo BASE_URL; ?>/pdv/vendas" class="btn btn-link p-0">
                            <i class="bi bi-file-text"></i>
                            Listar Vendas
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="<?php echo BASE_URL; ?>/tabelapreco" class="btn btn-link p-0">
                            <i class="bi bi-currency-dollar"></i>
                            Tabelas de Preço
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

