<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-arrow-down-circle"></i>
                Entrada de Estoque
            </h1>
            <a href="<?php echo BASE_URL; ?>/estoque" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
                Voltar ao Estoque
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header bg-success bg-opacity-10">
                <h6 class="card-title mb-0">
                    <i class="bi bi-plus-circle text-success"></i>
                    Registrar Entrada de Produtos
                </h6>
            </div>
            <div class="card-body">
                <?php if (isset($success)): ?>
                    <div class="alert alert-success" role="alert">
                        <i class="bi bi-check-circle"></i>
                        <?= $success ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="<?php echo BASE_URL; ?>/estoque/processarEntrada">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="id_produto" class="form-label">Produto *</label>
                            <select class="form-select select2-ajax" id="id_produto" name="id_produto" required>
                                <option value="">Digite para pesquisar...</option>
                            </select>
                            <!--<select class="form-select" id="id_produto" name="id_produto" required>
                                <option value="">Selecione um produto</option>
                                <?php foreach ($produtos as $produto): ?>
                                    <option value="<?= $produto['id'] ?>" 
                                            data-preco="<?= $produto['preco_venda'] ?>"
                                            data-unidade="<?= htmlspecialchars($produto['unidade_medida']) ?>">
                                        <?= htmlspecialchars($produto['nome']) ?> 
                                        (<?= htmlspecialchars($produto['categoria']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>-->
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="quantidade" class="form-label">Quantidade *</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="quantidade" name="quantidade" 
                                       min="1" step="1" required>
                                <span class="input-group-text" id="unidade-display">unidade(s)</span>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Quantidade Atual</label>
                            <div class="form-control-plaintext" id="quantidade-atual">
                                <span class="text-muted">Selecione um produto</span>
                            </div>
                        </div>
                        
                        <div class="col-md-12 mb-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="bi bi-info-circle"></i>
                                        Informações do Produto
                                    </h6>
                                    <div id="produto-info">
                                        <p class="text-muted mb-0">Selecione um produto para ver as informações</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between pt-3 border-top">
                        <a href="<?php echo BASE_URL; ?>/estoque" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle"></i>
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i>
                            Registrar Entrada
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Instruções -->
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-lightbulb"></i>
                    Instruções
                </h6>
            </div>
            <div class="card-body">
                <ul class="mb-0">
                    <li>Selecione o produto que está sendo recebido</li>
                    <li>Informe a quantidade que está entrando no estoque</li>
                    <li>A quantidade será <strong>adicionada</strong> ao estoque atual</li>
                    <li>Verifique sempre se o produto selecionado está correto antes de confirmar</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<script>

// Usa a função para executar seu código
checkJQuery(function($) {

        $('#id_produto').on('change', function() {
            var produtoId = $(this).val();
            var selectedOption = $(this).find('option:selected');
            var unidade = selectedOption.data('unidade') || 'unidade(s)';
            var preco = selectedOption.data('preco') || produtosPrecos[produtoId] || 0;
            
            
            $('#unidade-display').text(unidade);
            
            if (produtoId) {
                // Buscar quantidade atual
                Estoque.buscarQuantidade(produtoId, function(quantidade) {
                    $('#quantidade-atual').html(
                        '<span class="badge bg-info fs-6">' + quantidade + ' ' + unidade + '</span>'
                    );
                }, '<?php echo BASE_URL; ?>');
                
                // Mostrar informações do produto
                var produtoNome = selectedOption.text();
                var precoFormatado = new Intl.NumberFormat('pt-BR', {
                    style: 'currency',
                    currency: 'BRL'
                }).format(preco);
                
                $('#produto-info').html(`
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Produto:</strong><br>
                            <span class="text-primary">${produtoNome}</span>
                        </div>
                        <div class="col-md-6">
                            <strong>Preço de Venda:</strong><br>
                            <span class="text-success">${precoFormatado}</span>
                        </div>
                    </div>
                `);
            } else {
                $('#quantidade-atual').html('<span class="text-muted">Selecione um produto</span>');
                $('#produto-info').html('<p class="text-muted mb-0">Selecione um produto para ver as informações</p>');
            }
        });
        
        $('#quantidade').on('input', function() {
            var value = parseInt($(this).val());
            if (value < 1) {
                $(this).val(1);
            }
        });
});
</script>