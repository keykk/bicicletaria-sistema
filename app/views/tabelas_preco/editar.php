<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-pencil"></i>
                Editar: <?= htmlspecialchars($tabela['nome']) ?>
            </h1>
            <div class="btn-group" role="group">
                <a href="/tabela-preco/copiar/<?= $tabela['id'] ?>" class="btn btn-outline-info">
                    <i class="bi bi-files"></i>
                    Copiar Tabela
                </a>
                <a href="/tabela-preco" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i>
                    Voltar
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Adicionar produto -->
    <div class="col-lg-4 mb-4">
        <div class="card h-100">
            <div class="card-header bg-success bg-opacity-10">
                <h6 class="card-title mb-0">
                    <i class="bi bi-plus-circle text-success"></i>
                    Adicionar Produto
                </h6>
            </div>
            <div class="card-body">
                <form method="POST" action="/tabela-preco/adicionar-produto/<?= $tabela['id'] ?>">
                    <div class="mb-3">
                        <label for="id_produto" class="form-label">Produto *</label>
                        <select class="form-select" id="id_produto" name="id_produto" required>
                            <option value="">Selecione um produto</option>
                            <?php foreach ($produtos as $produto): ?>
                                <option value="<?= $produto['id'] ?>" 
                                        data-preco="<?= $produto['preco_venda'] ?>">
                                    <?= htmlspecialchars($produto['nome']) ?> 
                                    (<?= htmlspecialchars($produto['categoria']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="preco" class="form-label">Preço na Tabela *</label>
                        <div class="input-group">
                            <span class="input-group-text">R$</span>
                            <input type="number" class="form-control" id="preco" name="preco" 
                                   step="0.01" min="0" required>
                        </div>
                        <div class="form-text" id="preco-original" style="display: none;">
                            Preço original: <span class="text-muted"></span>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-plus-circle"></i>
                        Adicionar à Tabela
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Atualização em massa -->
        <div class="card mt-3">
            <div class="card-header bg-warning bg-opacity-10">
                <h6 class="card-title mb-0">
                    <i class="bi bi-arrow-up-circle text-warning"></i>
                    Atualização em Massa
                </h6>
            </div>
            <div class="card-body">
                <form method="POST" action="/tabela-preco/atualizar-precos-em-massa/<?= $tabela['id'] ?>">
                    <div class="mb-3">
                        <label for="percentual" class="form-label">Percentual de Ajuste</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="percentual" name="percentual" 
                                   step="0.01" placeholder="Ex: 10 ou -5">
                            <span class="input-group-text">%</span>
                        </div>
                        <div class="form-text">
                            Use valores positivos para aumento e negativos para desconto
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-warning w-100" 
                            onclick="return confirm('Tem certeza que deseja atualizar todos os preços desta tabela?')">
                        <i class="bi bi-arrow-up-circle"></i>
                        Aplicar Ajuste
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Lista de produtos na tabela -->
    <div class="col-lg-8 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-list"></i>
                        Produtos na Tabela (<?= count($tabela['itens']) ?>)
                    </h6>
                    <?php if (!empty($tabela['itens'])): ?>
                        <small class="text-muted">
                            Criada em <?= date('d/m/Y H:i', strtotime($tabela['data_criacao'])) ?>
                        </small>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-body p-0">
                <?php if (empty($tabela['itens'])): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-inbox display-1 text-muted"></i>
                        <h5 class="mt-3">Nenhum produto adicionado</h5>
                        <p class="text-muted">Adicione produtos à tabela usando o formulário ao lado.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th>Categoria</th>
                                    <th>Preço Original</th>
                                    <th>Preço na Tabela</th>
                                    <th>Diferença</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tabela['itens'] as $item): ?>
                                    <?php 
                                    $precoOriginal = 0; // Buscar preço original do produto
                                    foreach ($produtos as $produto) {
                                        if ($produto['id'] == $item['id_produto']) {
                                            $precoOriginal = $produto['preco_venda'];
                                            break;
                                        }
                                    }
                                    $diferenca = $item['preco'] - $precoOriginal;
                                    $percentualDiferenca = $precoOriginal > 0 ? (($diferenca / $precoOriginal) * 100) : 0;
                                    ?>
                                    <tr>
                                        <td>
                                            <strong><?= htmlspecialchars($item['produto_nome']) ?></strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">
                                                <?= htmlspecialchars($item['categoria']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-muted">
                                                R$ <?= number_format($precoOriginal, 2, ',', '.') ?>
                                            </span>
                                        </td>
                                        <td>
                                            <strong class="text-primary">
                                                R$ <?= number_format($item['preco'], 2, ',', '.') ?>
                                            </strong>
                                        </td>
                                        <td>
                                            <?php if ($diferenca > 0): ?>
                                                <span class="text-success">
                                                    <i class="bi bi-arrow-up"></i>
                                                    +<?= number_format($percentualDiferenca, 1) ?>%
                                                </span>
                                            <?php elseif ($diferenca < 0): ?>
                                                <span class="text-danger">
                                                    <i class="bi bi-arrow-down"></i>
                                                    <?= number_format($percentualDiferenca, 1) ?>%
                                                </span>
                                            <?php else: ?>
                                                <span class="text-muted">
                                                    <i class="bi bi-dash"></i>
                                                    0%
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="/tabela-preco/remover-produto/<?= $tabela['id'] ?>/<?= $item['id_produto'] ?>" 
                                               class="btn btn-outline-danger btn-sm btn-delete"
                                               data-item="este produto da tabela"
                                               data-bs-toggle="tooltip" title="Remover">
                                                <i class="bi bi-trash"></i>
                                            </a>
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

<script>
$(document).ready(function() {
    // Mostrar preço original quando selecionar produto
    $('#id_produto').on('change', function() {
        var selectedOption = $(this).find('option:selected');
        var precoOriginal = selectedOption.data('preco');
        
        if (precoOriginal) {
            $('#preco').val(precoOriginal);
            $('#preco-original span').text('R$ ' + parseFloat(precoOriginal).toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));
            $('#preco-original').show();
        } else {
            $('#preco-original').hide();
        }
    });
});
</script>

