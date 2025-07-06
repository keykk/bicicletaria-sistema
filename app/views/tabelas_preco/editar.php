<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-pencil"></i>
                Editar: <?= htmlspecialchars($tabela['nome']) ?>
            </h1>
            <div class="btn-group" role="group">
                <a href="<?php echo BASE_URL; ?>/tabelapreco/copiar/<?= $tabela['id'] ?>" class="btn btn-outline-info">
                    <i class="bi bi-files"></i>
                    Copiar Tabela
                </a>
                <a href="<?php echo BASE_URL; ?>/tabelapreco" class="btn btn-outline-secondary">
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
                <form method="POST" action="<?php echo BASE_URL; ?>/tabelapreco/adicionarproduto/<?= $tabela['id'] ?>">
                    <div class="mb-3">
                        <label for="id_produto" class="form-label">Produto *</label>
                        <select class="form-select select2-ajax" id="id_produto" name="id_produto" required>
                            <option value="">Digite para pesquisar...</option>
                        </select>
                    </div>
                    <!--<div class="mb-3">
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
                    </div>-->
                    
                    <div class="mb-3">
                        <label for="preco" class="form-label">Preço de Custo *</label>
                        <div class="input-group">
                            <span class="input-group-text">R$</span>
                            <input type="number" class="form-control" id="preco" name="preco" 
                                   step="0.01" min="0" required>
                        </div>
                        <div class="form-text" id="preco-original" style="display: none;">
                            Preço original: <span class="text-muted"></span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="modelo_lucratividade" class="form-label">Modelos e métodos para calcular a lucratividade</label>
                        <select class="form-select" id="modelo_lucratividade" name="modelo_lucratividade" required>
                            <option value="">Selecione um modelo</option>
                            <?php foreach ($modelo_lucratividade as $model): ?>
                                <option <?php if ($model['id'] ?? '0' == 1) echo 'Selected' ?> value="<?= $model['id'] ?>" >
                                    <?= htmlspecialchars($model['descricao']) ?> 
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="porc" class="form-label">Porcentual da lucratividade</label>
                        <div class="input-group">
                            <span class="input-group-text">%</span>
                            <input type="number" class="form-control" id="porc" name="porc" 
                                   step="0.01" min="0" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="valor_revenda" class="form-label">Valor de Revenda</label>
                        <div class="input-group">
                            <span class="input-group-text">R$</span>
                            <input type="number" class="form-control" id="valor_revenda" name="valor_revenda" 
                                   step="0.01" min="0" required>
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
                <form method="POST" action="<?php echo BASE_URL; ?>/tabelapreco/atualizarPrecosEmMassa/<?= $tabela['id'] ?>">
                    <div class="mb-3">
                        <label for="percentual" class="form-label">Percentual de Ajuste</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="percentual" name="percentual" 
                                   step="0.01">
                            <span class="input-group-text">%</span>
                        </div>
                        <div class="mb-3">
                            <label for="modelo_lucratividade1" class="form-label">Modelos e métodos para calcular a lucratividade</label>
                            <select class="form-select" id="modelo_lucratividade1" name="modelo_lucratividade1" required>
                                <option value="">Selecione um modelo</option>
                                <?php foreach ($modelo_lucratividade as $model): ?>
                                    <option <?php if ($model['id'] ?? '0' == 1) echo 'Selected' ?> value="<?= $model['id'] ?>" >
                                        <?= htmlspecialchars($model['descricao']) ?> 
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-text">
                            Alterar o percentual de todos os produtos desta tabela de preço.
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
                                    <th>Custo</th>
                                    <th>Revenda</th>
                                    <th>Modelo</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tabela['itens'] as $item): ?> 
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
                                                R$ <?= number_format($item['preco'], 2, ',', '.') ?>
                                            </span>
                                        </td>
                                        <td>
                                            <strong class="text-primary">
                                                R$ <?= number_format($item['valor_revenda'], 2, ',', '.') ?>
                                            </strong>
                                        </td>
                                        <td>
                                            <?php 
                                            if ($item['modelo_lucratividade'] == 1): // Markup
                                                ?>
                                                    <i class="bi bi-graph-up"></i> Margem
                                                <?php
                                            else: // Margem Bruta
                                                ?>
                                                    <i class="bi bi-tag"></i> Markup
                                            <?php
                                            endif;
                                            ?>
                                            <?php if ($item['porcentual_lucratividade'] > 0): ?>
                                                <span class="text-success">
                                                    <i class="bi bi-arrow-up"></i>
                                                    +<?= number_format($item['porcentual_lucratividade'], 1) ?>%
                                                </span>
                                            <?php elseif ($item['porcentual_lucratividade'] < 0): ?>
                                                <span class="text-danger">
                                                    <i class="bi bi-arrow-down"></i>
                                                    <?= number_format($item['porcentual_lucratividade'], 1) ?>%
                                                </span>
                                            <?php else: ?>
                                                <span class="text-muted">
                                                    <i class="bi bi-dash"></i>
                                                    0%
                                                </span>
                                            <?php endif; ?>
                                            
                                        </td>
                                        <td>
                                            <a href="<?php echo BASE_URL; ?>/tabelapreco/removerproduto/<?= $tabela['id'] ?>/<?= $item['id_produto'] ?>" 
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
checkJQuery(function($) { 
    var produtosPrecos = {};
    $('.select2-ajax').select2({
        theme: 'bootstrap-5',
        width: '100%',
        minimumInputLength: 2,
        ajax: {
            url: '<?= BASE_URL ?>/produto/api2',
            dataType: 'json',
            delay: 300,
            data: function(params) {
                //console.log('Parâmetros enviados:', params);
                return {
                    termo: params.term,
                    page: params.page || 1
                };
            },
            processResults: function(data, params) {
                //console.log('Resposta completa da API:', data);
                params.page = params.page || 1;
                return {
                    //results: data.produtos,
                    results: data.produtos.map(function(item) {
                        produtosPrecos[item.id] = item['data-preco'] || item.data_preco;
                        return {
                            id: item.id,
                            text: item.text || item.nome,
                            // Garanta que o preço está sendo incluído
                            'data-preco': item['data-preco'] || item.preco_venda || 5,
                            'preco': item['data-preco'] || item.preco_venda || 5
                        };
                    }),
                    pagination: {
                        more: (params.page * 20) < data.total_count
                    }
                };
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Erro na requisição AJAX:', {
                    status: textStatus,
                    error: errorThrown,
                    response: jqXHR.responseText
                });
                //alert('Erro ao carregar produtos. Verifique o console para detalhes.');
            },
            cache: true
        },
        placeholder: 'Digite o nome do produto...',
        language: {
            noResults: function() {
                return "Nenhum produto encontrado";
            },
            searching: function() {
                return "Pesquisando...";
            }
        }
    });

        // Mostrar preço original quando selecionar produto
    $('#id_produto').on('change', function() {
        var selectedOption = $(this).find(':selected');//$(this).find('option:selected');
        
        var productId = $(this).val();
        var preco = produtosPrecos[productId] || 0;

        var precoOriginal = selectedOption.data('preco') || preco;
        if (precoOriginal) {
            $('#preco').val(precoOriginal);
            $('#preco-original span').text('R$ ' + parseFloat(precoOriginal).toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));
            $('#preco-original').show();
            $('#porc').change();
        } else {
            $('#preco-original').hide();
        }
    });

    // Atualizar preço de custo ao selecionar modelo de lucratividade
    $('#modelo_lucratividade, #porc').on('change keyup', function(event) {
        
        var modelo = $('#modelo_lucratividade').val();
        var preco = parseFloat($('#preco').val()) || 0;
        var porc = parseFloat($('#porc').val()) || 0;
        var valorRevenda = 0;
        if (modelo == 0) { // Markup
            valorRevenda = preco * (1 + porc / 100);
        } else if (modelo == 1) { // Margem Bruta
            valorRevenda = preco / (1 - (porc / 100));
        }
        $('#valor_revenda').val(valorRevenda.toFixed(2));

        //$('#valor_revenda').trigger('input'); // Atualizar visualização

        //$('#valor_revenda').trigger('change'); // Atualizar visualização

    });

    // Atualizar porcentual de lucratividade ao alterar preço de custo
    $('#preco, #valor_revenda').on('change keyup', function(event) {
        var preco = parseFloat($('#preco').val()) || 0;
        var modelo = $('#modelo_lucratividade').val();
        var porc = parseFloat($('#porc').val()) || 0;
        var valorRevenda = parseFloat($('#valor_revenda').val()) || 0;
        if (modelo == 0 && preco > 0) { // Markup
            porc = ((valorRevenda / preco) - 1) * 100;
        } else if (modelo == 1 && valorRevenda > 0) { // Margem Bruta
            porc = (1 - (preco / valorRevenda)) * 100;
        }
        $('#porc').val(porc.toFixed(2));
    });

});
</script>

