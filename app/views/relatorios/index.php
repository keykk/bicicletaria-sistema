<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-graph-up"></i>
                Relatórios
            </h1>
            <div class="text-muted">
                <i class="bi bi-calendar3"></i>
                <?= date('d/m/Y H:i') ?>
            </div>
        </div>
    </div>
</div>

<!-- Cards de relatórios -->
<div class="row">
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100 border-start-primary">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h5 class="card-title">
                            <i class="bi bi-graph-up text-primary"></i>
                            Relatório de Vendas
                        </h5>
                        <p class="card-text">Análise detalhada das vendas por período, incluindo gráficos e estatísticas.</p>
                        <a href="<?php echo BASE_URL; ?>/relatorio/vendas" class="btn btn-primary">
                            <i class="bi bi-eye"></i>
                            Visualizar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100 border-start-success">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h5 class="card-title">
                            <i class="bi bi-trophy text-success"></i>
                            Produtos Mais Vendidos
                        </h5>
                        <p class="card-text">Ranking dos produtos com maior volume de vendas no período selecionado.</p>
                        <a href="<?php echo BASE_URL; ?>/relatorio/produtosmaisvendidos" class="btn btn-success">
                            <i class="bi bi-eye"></i>
                            Visualizar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100 border-start-warning">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h5 class="card-title">
                            <i class="bi bi-exclamation-triangle text-warning"></i>
                            Estoque Crítico
                        </h5>
                        <p class="card-text">Produtos com estoque baixo que precisam de reposição urgente.</p>
                        <a href="<?php echo BASE_URL; ?>/relatorio/estoquecritico" class="btn btn-warning">
                            <i class="bi bi-eye"></i>
                            Visualizar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100 border-start-info">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h5 class="card-title">
                            <i class="bi bi-speedometer2 text-info"></i>
                            Dashboard Executivo
                        </h5>
                        <p class="card-text">Visão geral do negócio com indicadores-chave de performance.</p>
                        <a href="<?php echo BASE_URL; ?>/relatorio/dashboardexecutivo" class="btn btn-info">
                            <i class="bi bi-eye"></i>
                            Visualizar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100 border-start-secondary">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h5 class="card-title">
                            <i class="bi bi-boxes text-secondary"></i>
                            Relatório de Estoque
                        </h5>
                        <p class="card-text">Situação completa do estoque com valores e quantidades.</p>
                        <a href="<?php echo BASE_URL; ?>/estoque" class="btn btn-secondary">
                            <i class="bi bi-eye"></i>
                            Visualizar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100 border-start-dark">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h5 class="card-title">
                            <i class="bi bi-download text-dark"></i>
                            Exportar Dados
                        </h5>
                        <p class="card-text">Exporte relatórios em formato CSV para análise externa.</p>
                        <div class="btn-group w-100" role="group">
                            <a href="<?php echo BASE_URL; ?>/relatorio/exportarcsv?tipo=vendas" class="btn btn-outline-dark btn-sm">
                                <i class="bi bi-download"></i>
                                Vendas
                            </a>
                            <a href="<?php echo BASE_URL; ?>/relatorio/exportarcsv?tipo=estoque" class="btn btn-outline-dark btn-sm">
                                <i class="bi bi-download"></i>
                                Estoque
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ações rápidas -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-lightning"></i>
                    Ações Rápidas
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <a href="<?php echo BASE_URL; ?>/relatorio/vendas?data_inicio=<?= date('Y-m-01') ?>&data_fim=<?= date('Y-m-t') ?>" 
                           class="btn btn-outline-primary w-100">
                            <i class="bi bi-calendar-month"></i>
                            Vendas do Mês
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="<?php echo BASE_URL; ?>/relatorio/vendas?data_inicio=<?= date('Y-m-d', strtotime('-7 days')) ?>&data_fim=<?= date('Y-m-d') ?>" 
                           class="btn btn-outline-success w-100">
                            <i class="bi bi-calendar-week"></i>
                            Últimos 7 Dias
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="<?php echo BASE_URL; ?>/relatorio/estoquecritico?limite=5" 
                           class="btn btn-outline-warning w-100">
                            <i class="bi bi-exclamation-triangle"></i>
                            Estoque ≤ 5
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="<?php echo BASE_URL; ?>/relatorio/produtosmaisvendidos?data_inicio=<?= date('Y-m-01') ?>&data_fim=<?= date('Y-m-t') ?>" 
                           class="btn btn-outline-info w-100">
                            <i class="bi bi-trophy"></i>
                            Top Produtos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Informações sobre relatórios -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card border-start-info">
            <div class="card-header bg-info bg-opacity-10">
                <h6 class="card-title mb-0">
                    <i class="bi bi-info-circle text-info"></i>
                    Sobre os Relatórios
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Funcionalidades Disponíveis:</h6>
                        <ul class="mb-0">
                            <li>Filtros por período personalizável</li>
                            <li>Gráficos interativos e estatísticas</li>
                            <li>Exportação para CSV/Excel</li>
                            <li>Atualização em tempo real</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>Dicas de Uso:</h6>
                        <ul class="mb-0">
                            <li>Use os filtros para análises específicas</li>
                            <li>Exporte dados para análises externas</li>
                            <li>Monitore regularmente o estoque crítico</li>
                            <li>Acompanhe tendências de vendas</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

