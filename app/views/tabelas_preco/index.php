<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-currency-dollar"></i>
                Tabelas de Preço
            </h1>
            <a href="/tabela-preco/nova" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i>
                Nova Tabela
            </a>
        </div>
    </div>
</div>

<!-- Lista de tabelas -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-list"></i>
                    Tabelas Cadastradas (<?= count($tabelas) ?>)
                </h6>
            </div>
            <div class="card-body p-0">
                <?php if (empty($tabelas)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-currency-dollar display-1 text-muted"></i>
                        <h5 class="mt-3">Nenhuma tabela de preço cadastrada</h5>
                        <p class="text-muted">Crie sua primeira tabela de preço para gerenciar diferentes valores.</p>
                        <a href="/tabela-preco/nova" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i>
                            Criar Primeira Tabela
                        </a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome da Tabela</th>
                                    <th>Data de Criação</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tabelas as $tabela): ?>
                                    <tr>
                                        <td>
                                            <span class="badge bg-primary">#<?= $tabela['id'] ?></span>
                                        </td>
                                        <td>
                                            <div>
                                                <strong><?= htmlspecialchars($tabela['nome']) ?></strong>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <strong><?= date('d/m/Y', strtotime($tabela['data_criacao'])) ?></strong>
                                                <br>
                                                <small class="text-muted"><?= date('H:i', strtotime($tabela['data_criacao'])) ?></small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="/tabela-preco/editar/<?= $tabela['id'] ?>" 
                                                   class="btn btn-outline-primary" 
                                                   data-bs-toggle="tooltip" title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="/tabela-preco/copiar/<?= $tabela['id'] ?>" 
                                                   class="btn btn-outline-info" 
                                                   data-bs-toggle="tooltip" title="Copiar">
                                                    <i class="bi bi-files"></i>
                                                </a>
                                                <a href="/tabela-preco/excluir/<?= $tabela['id'] ?>" 
                                                   class="btn btn-outline-danger btn-delete" 
                                                   data-item="a tabela '<?= htmlspecialchars($tabela['nome']) ?>'"
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

<!-- Informações sobre tabelas de preço -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card border-start-info">
            <div class="card-header bg-info bg-opacity-10">
                <h6 class="card-title mb-0">
                    <i class="bi bi-lightbulb text-info"></i>
                    Como usar as Tabelas de Preço
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Funcionalidades:</h6>
                        <ul class="mb-0">
                            <li><strong>Criar:</strong> Nova tabela com preços personalizados</li>
                            <li><strong>Editar:</strong> Adicionar/remover produtos e ajustar preços</li>
                            <li><strong>Copiar:</strong> Duplicar tabela existente para criar variações</li>
                            <li><strong>Atualização em massa:</strong> Aplicar percentual de aumento/desconto</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>Casos de uso:</h6>
                        <ul class="mb-0">
                            <li>Preços diferenciados para clientes especiais</li>
                            <li>Promoções e campanhas sazonais</li>
                            <li>Preços para atacado e varejo</li>
                            <li>Tabelas por categoria de cliente</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

