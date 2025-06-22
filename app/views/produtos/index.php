<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-box-seam"></i>
                Produtos
            </h1>
            <a href="<?php echo BASE_URL; ?>/produto/novo" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i>
                Novo Produto
            </a>
        </div>
    </div>
</div>

<!-- Filtros -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Buscar por nome</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="<?= htmlspecialchars($search) ?>" placeholder="Digite o nome do produto">
                    </div>
                    <div class="col-md-4">
                        <label for="categoria" class="form-label">Categoria</label>
                        <select class="form-select" id="categoria" name="categoria">
                            <option value="">Todas as categorias</option>
                            <?php foreach ($categorias as $cat): ?>
                                <option value="<?= htmlspecialchars($cat) ?>" 
                                        <?= $categoria_selecionada === $cat ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-outline-primary me-2">
                            <i class="bi bi-search"></i>
                            Buscar
                        </button>
                        <a href="<?php echo BASE_URL; ?>/produto" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle"></i>
                            Limpar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Lista de produtos -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-list"></i>
                    Lista de Produtos (<?= count($produtos) ?> encontrados)
                </h6>
            </div>
            <div class="card-body p-0">
                <?php if (empty($produtos)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-inbox display-1 text-muted"></i>
                        <h5 class="mt-3">Nenhum produto encontrado</h5>
                        <p class="text-muted">Tente ajustar os filtros ou cadastre um novo produto.</p>
                        <a href="<?php echo BASE_URL; ?>/produto/novo" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i>
                            Cadastrar Primeiro Produto
                        </a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Categoria</th>
                                    <th>Marca/Modelo</th>
                                    <th>Preço</th>
                                    <th>Estoque</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($produtos as $produto): ?>
                                    <tr>
                                        <td>
                                            <span class="badge bg-secondary">#<?= $produto['id'] ?></span>
                                        </td>
                                        <td>
                                            <div>
                                                <strong><?= htmlspecialchars($produto['nome']) ?></strong>
                                                <?php if (!empty($produto['descricao'])): ?>
                                                    <br>
                                                    <small class="text-muted text-truncate-2">
                                                        <?= htmlspecialchars($produto['descricao']) ?>
                                                    </small>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">
                                                <?= htmlspecialchars($produto['categoria']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if (!empty($produto['marca'])): ?>
                                                <strong><?= htmlspecialchars($produto['marca']) ?></strong>
                                                <?php if (!empty($produto['modelo'])): ?>
                                                    <br>
                                                    <small class="text-muted"><?= htmlspecialchars($produto['modelo']) ?></small>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <strong class="text-success">
                                                R$ <?= number_format($produto['preco_venda'], 2, ',', '.') ?>
                                            </strong>
                                            <br>
                                            <small class="text-muted">por <?= htmlspecialchars($produto['unidade_medida']) ?></small>
                                        </td>
                                        <td>
                                            <?php 
                                            $quantidade = $produto['quantidade'] ?? 0;
                                            $classe = $quantidade <= 5 ? 'text-danger' : ($quantidade <= 10 ? 'text-warning' : 'text-success');
                                            ?>
                                            <span class="<?= $classe ?>">
                                                <strong><?= $quantidade ?></strong>
                                            </span>
                                            <?php if ($quantidade <= 5): ?>
                                                <i class="bi bi-exclamation-triangle text-warning" 
                                                   data-bs-toggle="tooltip" title="Estoque baixo"></i>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="<?php echo BASE_URL; ?>/produto/editar/<?= $produto['id'] ?>" 
                                                   class="btn btn-outline-primary" 
                                                   data-bs-toggle="tooltip" title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="<?php echo BASE_URL; ?>/produto/excluir/<?= $produto['id'] ?>" 
                                                   class="btn btn-outline-danger btn-delete" 
                                                   data-item="o produto '<?= htmlspecialchars($produto['nome']) ?>'"
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

