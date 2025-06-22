<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-box-seam"></i>
                <?= $produto ? 'Editar Produto' : 'Novo Produto' ?>
            </h1>
            <a href="<?php echo BASE_URL; ?>/produto" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
                Voltar
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-info-circle"></i>
                    Informações do Produto
                </h6>
            </div>
            <div class="card-body">
                <form method="POST" action="<?= $produto ? BASE_URL."/produto/atualizar/{$produto['id']}" : BASE_URL.'/produto/salvar' ?>">
                    <div class="row">
                        <!-- Informações básicas -->
                        <div class="col-md-12 mb-3">
                            <label for="nome" class="form-label">Nome do Produto *</label>
                            <input type="text" class="form-control" id="nome" name="nome" 
                                   value="<?= htmlspecialchars($produto['nome'] ?? '') ?>" required>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" id="descricao" name="descricao" rows="3"
                                      placeholder="Descrição detalhada do produto"><?= htmlspecialchars($produto['descricao'] ?? '') ?></textarea>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="categoria" class="form-label">Categoria *</label>
                            <select class="form-select" id="categoria" name="categoria" required>
                                <option value="">Selecione uma categoria</option>
                                <option value="Bicicletas" <?= ($produto['categoria'] ?? '') === 'Bicicletas' ? 'selected' : '' ?>>Bicicletas</option>
                                <option value="Peças" <?= ($produto['categoria'] ?? '') === 'Peças' ? 'selected' : '' ?>>Peças</option>
                                <option value="Acessórios" <?= ($produto['categoria'] ?? '') === 'Acessórios' ? 'selected' : '' ?>>Acessórios</option>
                                <option value="Serviços" <?= ($produto['categoria'] ?? '') === 'Serviços' ? 'selected' : '' ?>>Serviços</option>
                                <option value="Ferramentas" <?= ($produto['categoria'] ?? '') === 'Ferramentas' ? 'selected' : '' ?>>Ferramentas</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="unidade_medida" class="form-label">Unidade de Medida *</label>
                            <select class="form-select" id="unidade_medida" name="unidade_medida" required>
                                <option value="">Selecione</option>
                                <option value="unidade" <?= ($produto['unidade_medida'] ?? '') === 'unidade' ? 'selected' : '' ?>>Unidade</option>
                                <option value="par" <?= ($produto['unidade_medida'] ?? '') === 'par' ? 'selected' : '' ?>>Par</option>
                                <option value="metro" <?= ($produto['unidade_medida'] ?? '') === 'metro' ? 'selected' : '' ?>>Metro</option>
                                <option value="kg" <?= ($produto['unidade_medida'] ?? '') === 'kg' ? 'selected' : '' ?>>Quilograma</option>
                                <option value="litro" <?= ($produto['unidade_medida'] ?? '') === 'litro' ? 'selected' : '' ?>>Litro</option>
                                <option value="serviço" <?= ($produto['unidade_medida'] ?? '') === 'serviço' ? 'selected' : '' ?>>Serviço</option>
                            </select>
                        </div>
                        
                        <div class="col-md-12 mb-4">
                            <label for="preco_venda" class="form-label">Preço de Venda *</label>
                            <div class="input-group">
                                <span class="input-group-text">R$</span>
                                <input type="number" class="form-control" id="preco_venda" name="preco_venda" 
                                       step="0.01" min="0" value="<?= $produto['preco_venda'] ?? '' ?>" required>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Informações específicas para bicicletas -->
                    <div id="bike-fields" class="border-top pt-4" style="display: none;">
                        <h6 class="mb-3">
                            <i class="bi bi-bicycle"></i>
                            Informações Específicas (Bicicletas)
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="marca" class="form-label">Marca</label>
                                <input type="text" class="form-control" id="marca" name="marca" 
                                       value="<?= htmlspecialchars($produto['marca'] ?? '') ?>"
                                       placeholder="Ex: Caloi, Specialized, Trek">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="modelo" class="form-label">Modelo</label>
                                <input type="text" class="form-control" id="modelo" name="modelo" 
                                       value="<?= htmlspecialchars($produto['modelo'] ?? '') ?>"
                                       placeholder="Ex: Elite Carbon, Rockhopper">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="aro" class="form-label">Aro</label>
                                <select class="form-select" id="aro" name="aro">
                                    <option value="">Selecione o aro</option>
                                    <option value="12" <?= ($produto['aro'] ?? '') === '12' ? 'selected' : '' ?>>Aro 12</option>
                                    <option value="14" <?= ($produto['aro'] ?? '') === '14' ? 'selected' : '' ?>>Aro 14</option>
                                    <option value="16" <?= ($produto['aro'] ?? '') === '16' ? 'selected' : '' ?>>Aro 16</option>
                                    <option value="20" <?= ($produto['aro'] ?? '') === '20' ? 'selected' : '' ?>>Aro 20</option>
                                    <option value="24" <?= ($produto['aro'] ?? '') === '24' ? 'selected' : '' ?>>Aro 24</option>
                                    <option value="26" <?= ($produto['aro'] ?? '') === '26' ? 'selected' : '' ?>>Aro 26</option>
                                    <option value="27.5" <?= ($produto['aro'] ?? '') === '27.5' ? 'selected' : '' ?>>Aro 27.5</option>
                                    <option value="29" <?= ($produto['aro'] ?? '') === '29' ? 'selected' : '' ?>>Aro 29</option>
                                    <option value="700c" <?= ($produto['aro'] ?? '') === '700c' ? 'selected' : '' ?>>700c</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="tipo" class="form-label">Tipo</label>
                                <select class="form-select" id="tipo" name="tipo">
                                    <option value="">Selecione o tipo</option>
                                    <option value="Mountain Bike" <?= ($produto['tipo'] ?? '') === 'Mountain Bike' ? 'selected' : '' ?>>Mountain Bike</option>
                                    <option value="Speed" <?= ($produto['tipo'] ?? '') === 'Speed' ? 'selected' : '' ?>>Speed</option>
                                    <option value="Urbana" <?= ($produto['tipo'] ?? '') === 'Urbana' ? 'selected' : '' ?>>Urbana</option>
                                    <option value="BMX" <?= ($produto['tipo'] ?? '') === 'BMX' ? 'selected' : '' ?>>BMX</option>
                                    <option value="Infantil" <?= ($produto['tipo'] ?? '') === 'Infantil' ? 'selected' : '' ?>>Infantil</option>
                                    <option value="Elétrica" <?= ($produto['tipo'] ?? '') === 'Elétrica' ? 'selected' : '' ?>>Elétrica</option>
                                    <option value="Dobrável" <?= ($produto['tipo'] ?? '') === 'Dobrável' ? 'selected' : '' ?>>Dobrável</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between pt-4 border-top">
                        <a href="<?php echo BASE_URL; ?>/produto" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle"></i>
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i>
                            <?= $produto ? 'Atualizar' : 'Salvar' ?> Produto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
checkJQuery(function($) { 
    // Mostrar/esconder campos específicos para bicicletas
    function toggleBikeFields() {
        var categoria = $('#categoria').val();
        if (categoria === 'Bicicletas') {
            $('#bike-fields').show();
        } else {
            $('#bike-fields').hide();
        }
    }
    
    // Executar na inicialização
    toggleBikeFields();
    
    // Executar quando a categoria mudar
    $('#categoria').on('change', toggleBikeFields);
    
    // Formatação do preço
    $('#preco_venda').on('input', function() {
        var value = $(this).val();
        if (value < 0) {
            $(this).val(0);
        }
    });
    
});
</script>

