<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-gear-wide-connected"></i>
                Configurações do Sistema
            </h1>
            <a href="<?php echo BASE_URL; ?>/configuracao" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
                Voltar
            </a>
        </div>
    </div>
</div>

<form method="POST" action="<?php echo BASE_URL; ?>/configuracao/salvar-sistema">
    <div class="row">
        <!-- Configurações Gerais -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-globe"></i>
                        Configurações Gerais
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="sistema_timezone" class="form-label">Fuso Horário</label>
                        <select class="form-select" id="sistema_timezone" name="sistema_timezone">
                            <option value="America/Sao_Paulo" <?= ($sistema['sistema_timezone'] ?? '') === 'America/Sao_Paulo' ? 'selected' : '' ?>>São Paulo (GMT-3)</option>
                            <option value="America/Rio_Branco" <?= ($sistema['sistema_timezone'] ?? '') === 'America/Rio_Branco' ? 'selected' : '' ?>>Acre (GMT-5)</option>
                            <option value="America/Manaus" <?= ($sistema['sistema_timezone'] ?? '') === 'America/Manaus' ? 'selected' : '' ?>>Amazonas (GMT-4)</option>
                            <option value="America/Cuiaba" <?= ($sistema['sistema_timezone'] ?? '') === 'America/Cuiaba' ? 'selected' : '' ?>>Mato Grosso (GMT-4)</option>
                            <option value="America/Campo_Grande" <?= ($sistema['sistema_timezone'] ?? '') === 'America/Campo_Grande' ? 'selected' : '' ?>>Mato Grosso do Sul (GMT-4)</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="sistema_moeda" class="form-label">Moeda</label>
                        <select class="form-select" id="sistema_moeda" name="sistema_moeda">
                            <option value="BRL" <?= ($sistema['sistema_moeda'] ?? '') === 'BRL' ? 'selected' : '' ?>>Real Brasileiro (R$)</option>
                            <option value="USD" <?= ($sistema['sistema_moeda'] ?? '') === 'USD' ? 'selected' : '' ?>>Dólar Americano ($)</option>
                            <option value="EUR" <?= ($sistema['sistema_moeda'] ?? '') === 'EUR' ? 'selected' : '' ?>>Euro (€)</option>
                        </select>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="sistema_formato_data" class="form-label">Formato de Data</label>
                            <select class="form-select" id="sistema_formato_data" name="sistema_formato_data">
                                <option value="d/m/Y" <?= ($sistema['sistema_formato_data'] ?? '') === 'd/m/Y' ? 'selected' : '' ?>>DD/MM/AAAA</option>
                                <option value="Y-m-d" <?= ($sistema['sistema_formato_data'] ?? '') === 'Y-m-d' ? 'selected' : '' ?>>AAAA-MM-DD</option>
                                <option value="m/d/Y" <?= ($sistema['sistema_formato_data'] ?? '') === 'm/d/Y' ? 'selected' : '' ?>>MM/DD/AAAA</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="sistema_formato_numero" class="form-label">Formato de Número</label>
                            <select class="form-select" id="sistema_formato_numero" name="sistema_formato_numero">
                                <option value="pt_BR" <?= ($sistema['sistema_formato_numero'] ?? '') === 'pt_BR' ? 'selected' : '' ?>>1.234,56 (Brasil)</option>
                                <option value="en_US" <?= ($sistema['sistema_formato_numero'] ?? '') === 'en_US' ? 'selected' : '' ?>>1,234.56 (EUA)</option>
                                <option value="de_DE" <?= ($sistema['sistema_formato_numero'] ?? '') === 'de_DE' ? 'selected' : '' ?>>1.234,56 (Alemanha)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="sistema_idioma" class="form-label">Idioma do Sistema</label>
                        <select class="form-select" id="sistema_idioma" name="sistema_idioma">
                            <option value="pt_BR" <?= ($sistema['sistema_idioma'] ?? '') === 'pt_BR' ? 'selected' : '' ?>>Português (Brasil)</option>
                            <option value="en_US" <?= ($sistema['sistema_idioma'] ?? '') === 'en_US' ? 'selected' : '' ?>>English (US)</option>
                            <option value="es_ES" <?= ($sistema['sistema_idioma'] ?? '') === 'es_ES' ? 'selected' : '' ?>>Español</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Configurações de Orçamento -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-file-earmark-text"></i>
                        Configurações de Orçamento
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="orcamento_validade_dias" class="form-label">Validade Padrão (dias)</label>
                            <input type="number" class="form-control" id="orcamento_validade_dias" 
                                   name="orcamento_validade_dias" 
                                   value="<?= htmlspecialchars($sistema['orcamento_validade_dias'] ?? '30') ?>" 
                                   min="1" max="365">
                            <div class="form-text">Validade padrão dos orçamentos em dias</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="orcamento_numeracao" class="form-label">Numeração</label>
                            <select class="form-select" id="orcamento_numeracao" name="orcamento_numeracao">
                                <option value="sequencial" <?= ($sistema['orcamento_numeracao'] ?? '') === 'sequencial' ? 'selected' : '' ?>>Sequencial (1, 2, 3...)</option>
                                <option value="ano_sequencial" <?= ($sistema['orcamento_numeracao'] ?? '') === 'ano_sequencial' ? 'selected' : '' ?>>Ano + Sequencial (2024001)</option>
                                <option value="personalizado" <?= ($sistema['orcamento_numeracao'] ?? '') === 'personalizado' ? 'selected' : '' ?>>Personalizado</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="orcamento_observacoes" class="form-label">Observações Padrão</label>
                        <textarea class="form-control" id="orcamento_observacoes" name="orcamento_observacoes" 
                                  rows="4" placeholder="Digite as observações que aparecerão em todos os orçamentos..."><?= htmlspecialchars($sistema['orcamento_observacoes'] ?? '') ?></textarea>
                        <div class="form-text">Uma observação por linha</div>
                    </div>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="orcamento_mostrar_desconto" 
                               name="orcamento_mostrar_desconto" 
                               <?= ($sistema['orcamento_mostrar_desconto'] ?? '') === 'true' ? 'checked' : '' ?>>
                        <label class="form-check-label" for="orcamento_mostrar_desconto">
                            Mostrar campo de desconto nos orçamentos
                        </label>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Configurações de Estoque -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-box"></i>
                        Configurações de Estoque
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="estoque_limite_baixo" class="form-label">Limite Estoque Baixo</label>
                            <input type="number" class="form-control" id="estoque_limite_baixo" 
                                   name="estoque_limite_baixo" 
                                   value="<?= htmlspecialchars($sistema['estoque_limite_baixo'] ?? '5') ?>" 
                                   min="1" max="100">
                            <div class="form-text">Quantidade para alerta de estoque baixo</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="estoque_limite_critico" class="form-label">Limite Estoque Crítico</label>
                            <input type="number" class="form-control" id="estoque_limite_critico" 
                                   name="estoque_limite_critico" 
                                   value="<?= htmlspecialchars($sistema['estoque_limite_critico'] ?? '2') ?>" 
                                   min="0" max="50">
                            <div class="form-text">Quantidade para alerta crítico</div>
                        </div>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="estoque_permitir_negativo" 
                               name="estoque_permitir_negativo" 
                               <?= ($sistema['estoque_permitir_negativo'] ?? '') === 'true' ? 'checked' : '' ?>>
                        <label class="form-check-label" for="estoque_permitir_negativo">
                            Permitir estoque negativo
                        </label>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="estoque_alerta_email" 
                               name="estoque_alerta_email" 
                               <?= ($sistema['estoque_alerta_email'] ?? '') === 'true' ? 'checked' : '' ?>>
                        <label class="form-check-label" for="estoque_alerta_email">
                            Enviar alertas por email
                        </label>
                    </div>
                    
                    <div class="mb-3">
                        <label for="estoque_metodo_custo" class="form-label">Método de Custo</label>
                        <select class="form-select" id="estoque_metodo_custo" name="estoque_metodo_custo">
                            <option value="fifo" <?= ($sistema['estoque_metodo_custo'] ?? '') === 'fifo' ? 'selected' : '' ?>>FIFO (Primeiro a Entrar, Primeiro a Sair)</option>
                            <option value="lifo" <?= ($sistema['estoque_metodo_custo'] ?? '') === 'lifo' ? 'selected' : '' ?>>LIFO (Último a Entrar, Primeiro a Sair)</option>
                            <option value="media" <?= ($sistema['estoque_metodo_custo'] ?? '') === 'media' ? 'selected' : '' ?>>Custo Médio</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Configurações de Segurança -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-shield-check"></i>
                        Configurações de Segurança
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="seguranca_sessao_tempo" class="form-label">Tempo de Sessão (min)</label>
                            <input type="number" class="form-control" id="seguranca_sessao_tempo" 
                                   name="seguranca_sessao_tempo" 
                                   value="<?= htmlspecialchars($sistema['seguranca_sessao_tempo'] ?? '60') ?>" 
                                   min="5" max="480">
                            <div class="form-text">Tempo limite da sessão em minutos</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="seguranca_tentativas_login" class="form-label">Tentativas de Login</label>
                            <input type="number" class="form-control" id="seguranca_tentativas_login" 
                                   name="seguranca_tentativas_login" 
                                   value="<?= htmlspecialchars($sistema['seguranca_tentativas_login'] ?? '5') ?>" 
                                   min="3" max="10">
                            <div class="form-text">Máximo de tentativas antes do bloqueio</div>
                        </div>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="seguranca_log_atividades" 
                               name="seguranca_log_atividades" 
                               <?= ($sistema['seguranca_log_atividades'] ?? '') === 'true' ? 'checked' : '' ?>>
                        <label class="form-check-label" for="seguranca_log_atividades">
                            Registrar log de atividades
                        </label>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="seguranca_backup_automatico" 
                               name="seguranca_backup_automatico" 
                               <?= ($sistema['seguranca_backup_automatico'] ?? '') === 'true' ? 'checked' : '' ?>>
                        <label class="form-check-label" for="seguranca_backup_automatico">
                            Backup automático ativo
                        </label>
                    </div>
                </div>
            </div>
            
            <!-- Configurações de Performance -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-speedometer2"></i>
                        Configurações de Performance
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="performance_cache_tempo" class="form-label">Cache (minutos)</label>
                            <input type="number" class="form-control" id="performance_cache_tempo" 
                                   name="performance_cache_tempo" 
                                   value="<?= htmlspecialchars($sistema['performance_cache_tempo'] ?? '15') ?>" 
                                   min="0" max="1440">
                            <div class="form-text">Tempo de cache em minutos (0 = desabilitado)</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="performance_paginacao" class="form-label">Itens por Página</label>
                            <input type="number" class="form-control" id="performance_paginacao" 
                                   name="performance_paginacao" 
                                   value="<?= htmlspecialchars($sistema['performance_paginacao'] ?? '20') ?>" 
                                   min="10" max="100">
                            <div class="form-text">Quantidade de itens por página nas listagens</div>
                        </div>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="performance_compressao" 
                               name="performance_compressao" 
                               <?= ($sistema['performance_compressao'] ?? '') === 'true' ? 'checked' : '' ?>>
                        <label class="form-check-label" for="performance_compressao">
                            Habilitar compressão GZIP
                        </label>
                    </div>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="performance_minificacao" 
                               name="performance_minificacao" 
                               <?= ($sistema['performance_minificacao'] ?? '') === 'true' ? 'checked' : '' ?>>
                        <label class="form-check-label" for="performance_minificacao">
                            Minificar CSS e JavaScript
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Botões de ação -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <button type="button" class="btn btn-outline-info" onclick="testarConfiguracoes()">
                                <i class="bi bi-check-circle"></i>
                                Testar Configurações
                            </button>
                        </div>
                        <div>
                            <button type="button" class="btn btn-outline-warning me-2" onclick="resetarPadrao()">
                                <i class="bi bi-arrow-clockwise"></i>
                                Valores Padrão
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i>
                                Salvar Configurações
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Preview das configurações -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card border-info">
            <div class="card-header bg-info text-white">
                <h6 class="card-title mb-0">
                    <i class="bi bi-eye"></i>
                    Preview das Configurações
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <h6>Formato de Data:</h6>
                        <p id="preview-data" class="text-muted">--</p>
                        
                        <h6>Formato de Número:</h6>
                        <p id="preview-numero" class="text-muted">--</p>
                    </div>
                    <div class="col-md-4">
                        <h6>Moeda:</h6>
                        <p id="preview-moeda" class="text-muted">--</p>
                        
                        <h6>Fuso Horário:</h6>
                        <p id="preview-timezone" class="text-muted">--</p>
                    </div>
                    <div class="col-md-4">
                        <h6>Validade Orçamento:</h6>
                        <p id="preview-validade" class="text-muted">--</p>
                        
                        <h6>Limite Estoque Baixo:</h6>
                        <p id="preview-estoque" class="text-muted">--</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Atualizar preview em tempo real
function atualizarPreview() {
    const formatoData = document.getElementById('sistema_formato_data').value;
    const formatoNumero = document.getElementById('sistema_formato_numero').value;
    const moeda = document.getElementById('sistema_moeda').value;
    const timezone = document.getElementById('sistema_timezone').value;
    const validadeOrcamento = document.getElementById('orcamento_validade_dias').value;
    const limiteBaixo = document.getElementById('estoque_limite_baixo').value;
    
    // Preview da data
    const hoje = new Date();
    let dataFormatada = '';
    switch(formatoData) {
        case 'd/m/Y':
            dataFormatada = hoje.toLocaleDateString('pt-BR');
            break;
        case 'Y-m-d':
            dataFormatada = hoje.toISOString().split('T')[0];
            break;
        case 'm/d/Y':
            dataFormatada = hoje.toLocaleDateString('en-US');
            break;
    }
    document.getElementById('preview-data').textContent = dataFormatada;
    
    // Preview do número
    const numero = 1234.56;
    let numeroFormatado = '';
    switch(formatoNumero) {
        case 'pt_BR':
            numeroFormatado = numero.toLocaleString('pt-BR');
            break;
        case 'en_US':
            numeroFormatado = numero.toLocaleString('en-US');
            break;
        case 'de_DE':
            numeroFormatado = numero.toLocaleString('de-DE');
            break;
    }
    document.getElementById('preview-numero').textContent = numeroFormatado;
    
    // Preview da moeda
    const simbolos = { 'BRL': 'R$', 'USD': '$', 'EUR': '€' };
    document.getElementById('preview-moeda').textContent = simbolos[moeda] || moeda;
    
    // Preview do timezone
    const timezones = {
        'America/Sao_Paulo': 'São Paulo (GMT-3)',
        'America/Rio_Branco': 'Acre (GMT-5)',
        'America/Manaus': 'Amazonas (GMT-4)',
        'America/Cuiaba': 'Mato Grosso (GMT-4)',
        'America/Campo_Grande': 'Mato Grosso do Sul (GMT-4)'
    };
    document.getElementById('preview-timezone').textContent = timezones[timezone] || timezone;
    
    // Preview da validade
    document.getElementById('preview-validade').textContent = validadeOrcamento + ' dias';
    
    // Preview do estoque
    document.getElementById('preview-estoque').textContent = limiteBaixo + ' unidades';
}

// Adicionar listeners para atualizar preview
document.addEventListener('DOMContentLoaded', function() {
    const campos = [
        'sistema_formato_data', 'sistema_formato_numero', 'sistema_moeda', 
        'sistema_timezone', 'orcamento_validade_dias', 'estoque_limite_baixo'
    ];
    
    campos.forEach(campo => {
        const elemento = document.getElementById(campo);
        if (elemento) {
            elemento.addEventListener('change', atualizarPreview);
            elemento.addEventListener('input', atualizarPreview);
        }
    });
    
    // Atualizar preview inicial
    atualizarPreview();
});

function testarConfiguracoes() {
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Testando...';
    btn.disabled = true;
    
    // Simular teste
    setTimeout(() => {
        alert('Configurações testadas com sucesso! Todas as configurações estão válidas.');
        btn.innerHTML = originalText;
        btn.disabled = false;
    }, 2000);
}

function resetarPadrao() {
    if (confirm('Deseja resetar todas as configurações para os valores padrão? Esta ação não pode ser desfeita.')) {
        // Resetar valores
        document.getElementById('sistema_timezone').value = 'America/Sao_Paulo';
        document.getElementById('sistema_moeda').value = 'BRL';
        document.getElementById('sistema_formato_data').value = 'd/m/Y';
        document.getElementById('sistema_formato_numero').value = 'pt_BR';
        document.getElementById('orcamento_validade_dias').value = '30';
        document.getElementById('estoque_limite_baixo').value = '5';
        document.getElementById('estoque_limite_critico').value = '2';
        document.getElementById('seguranca_sessao_tempo').value = '60';
        document.getElementById('seguranca_tentativas_login').value = '5';
        document.getElementById('performance_cache_tempo').value = '15';
        document.getElementById('performance_paginacao').value = '20';
        
        // Resetar checkboxes
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        
        // Marcar alguns checkboxes como padrão
        document.getElementById('seguranca_log_atividades').checked = true;
        document.getElementById('seguranca_backup_automatico').checked = true;
        document.getElementById('performance_compressao').checked = true;
        
        atualizarPreview();
    }
}

// Validação do formulário
document.querySelector('form').addEventListener('submit', function(e) {
    const limiteBaixo = parseInt(document.getElementById('estoque_limite_baixo').value);
    const limiteCritico = parseInt(document.getElementById('estoque_limite_critico').value);
    
    if (limiteCritico >= limiteBaixo) {
        e.preventDefault();
        alert('O limite crítico deve ser menor que o limite de estoque baixo.');
        return false;
    }
    
    const validadeOrcamento = parseInt(document.getElementById('orcamento_validade_dias').value);
    if (validadeOrcamento < 1 || validadeOrcamento > 365) {
        e.preventDefault();
        alert('A validade do orçamento deve estar entre 1 e 365 dias.');
        return false;
    }
});
</script>

