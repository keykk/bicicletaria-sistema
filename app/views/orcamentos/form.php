<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-file-plus"></i>
                Novo Orçamento
            </h1>
            <a href="<?php echo BASE_URL; ?>/orcamento" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
                Voltar
            </a>
        </div>
    </div>
</div>

<form method="POST" action="<?php echo BASE_URL; ?>/orcamento/salvar" id="orcamento-form">
    <div class="row">
        <!-- Dados do cliente -->
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-person"></i>
                        Dados do Cliente
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="cliente" class="form-label">Nome do Cliente *</label>
                        <input type="text" class="form-control" id="cliente" name="cliente" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="tel" class="form-control phone" id="telefone" name="telefone" 
                               placeholder="(00) 00000-0000">
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               placeholder="cliente@email.com">
                        <div class="form-text">
                            <i class="bi bi-info-circle"></i>
                            Necessário para envio por email
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Itens do orçamento -->
        <div class="col-lg-8 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="card-title mb-0">
                            <i class="bi bi-list"></i>
                            Itens do Orçamento
                        </h6>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="Orcamento.adicionarItem('<?php echo BASE_URL;?>')">
                            <i class="bi bi-plus-circle"></i>
                            Adicionar Item
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="itens-orcamento">
                       
                    </div>
                    
                    <!-- Total -->
                    <div class="border-top pt-3">
                        <div class="row">
                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h6 class="card-title">Valor Total</h6>
                                        <h4 class="text-success mb-0" id="valor-total">R$ 0,00</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Ações -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <a href="<?php echo BASE_URL; ?>/orcamento" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle"></i>
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i>
                            Salvar Orçamento
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Template para novos itens -->
<template id="item-template">
    <div class="orcamento-item border rounded p-3 mb-3">
        <div class="row">
            <div class="col-md-5 mb-2">
                <label class="form-label">Produto *</label>
                <select class="form-select produto-select" name="produtos[]" required>
                    <option value="">Selecione um produto</option>
                    <?php foreach ($produtos as $produto): ?>
                        <option value="<?= $produto['id'] ?>" 
                                data-preco="<?= $produto['preco_venda'] ?>"
                                data-unidade="<?= htmlspecialchars($produto['unidade_medida']) ?>">
                            <?= htmlspecialchars($produto['nome']) ?> 
                            (<?= htmlspecialchars($produto['categoria']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2 mb-2">
                <label class="form-label">Qtd *</label>
                <input type="number" class="form-control quantidade" name="quantidades[]" 
                       min="1" step="1" required>
            </div>
            <div class="col-md-2 mb-2">
                <label class="form-label">Preço *</label>
                <input type="number" class="form-control preco" name="precos[]" 
                       step="0.01" min="0" required>
            </div>
            <div class="col-md-2 mb-2">
                <label class="form-label">Subtotal</label>
                <div class="form-control-plaintext subtotal fw-bold text-success">
                    R$ 0,00
                </div>
            </div>
            <div class="col-md-1 mb-2 d-flex align-items-end">
                <button type="button" class="btn btn-outline-danger btn-sm btn-remove-item" 
                        onclick="Orcamento.removerItem(this)">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<script>


checkJQuery(function($) {  
    // Validação do formulário
    $('#orcamento-form').on('submit', function(e) {
       
        var temItens = $('.orcamento-item').length > 0;
        var temProdutosSelecionados = $('.produto-select').filter(function() {
            return $(this).val() !== '';
        }).length > 0;
        
        if (!temItens || !temProdutosSelecionados) {
            e.preventDefault();
            BikeSystem.showToast('Adicione pelo menos um item ao orçamento', 'danger');
            return false;
        }
        
        // Verificar se todos os itens têm quantidade e preço
        var itensValidos = true;
        $('.orcamento-item').each(function() {
            var produto = $(this).find('.produto-select').val();
            var quantidade = $(this).find('.quantidade').val();
            var preco = $(this).find('.preco').val();
            
            if (produto && (!quantidade || quantidade <= 0 || !preco || preco <= 0)) {
                itensValidos = false;
                return false;
            }
        });
        
        if (!itensValidos) {
            e.preventDefault();
            BikeSystem.showToast('Todos os itens devem ter quantidade e preço válidos', 'danger');
            return false;
        }
    });
 })
</script>

