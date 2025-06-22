<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-currency-dollar"></i>
                Nova Tabela de Preço
            </h1>
            <a href="<?php echo BASE_URL; ?>/tabelapreco" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
                Voltar
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-info-circle"></i>
                    Informações da Tabela
                </h6>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo BASE_URL; ?>/tabelapreco/salvar">
                    <div class="mb-4">
                        <label for="nome" class="form-label">Nome da Tabela *</label>
                        <input type="text" class="form-control" id="nome" name="nome" required
                               placeholder="Ex: Tabela Promocional, Preços Atacado, etc.">
                        <div class="form-text">
                            <i class="bi bi-info-circle"></i>
                            Escolha um nome descritivo para identificar facilmente esta tabela
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between pt-3 border-top">
                        <a href="<?php echo BASE_URL; ?>/tabelapreco" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle"></i>
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i>
                            Criar Tabela
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Próximos passos -->
        <div class="card mt-4">
            <div class="card-header bg-light">
                <h6 class="card-title mb-0">
                    <i class="bi bi-list-check"></i>
                    Próximos Passos
                </h6>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-start mb-3">
                    <div class="badge bg-primary rounded-circle me-3" style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">1</div>
                    <div>
                        <strong>Criar a tabela</strong>
                        <p class="text-muted mb-0">Defina um nome para sua nova tabela de preços</p>
                    </div>
                </div>
                <div class="d-flex align-items-start mb-3">
                    <div class="badge bg-secondary rounded-circle me-3" style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">2</div>
                    <div>
                        <strong>Adicionar produtos</strong>
                        <p class="text-muted mb-0">Selecione os produtos e defina os preços específicos</p>
                    </div>
                </div>
                <div class="d-flex align-items-start">
                    <div class="badge bg-secondary rounded-circle me-3" style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">3</div>
                    <div>
                        <strong>Usar nos orçamentos</strong>
                        <p class="text-muted mb-0">Aplique a tabela ao criar orçamentos personalizados</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

